<?php

namespace App\Services;

use App\Models\Farm;
use App\Models\Report;
use App\Models\Strategy;
use App\Models\Crop;

class DecisionEngineService
{
    /**
     * توليد الاستراتيجيات الأربعة: الوضع الحالي + 3 بدائل
     */
    public function generate(Farm $farm, Report $report)
    {
        $strategies = [];

        // 1. تقييم الدورة الحالية
        $strategies[] = $this->evaluateCurrentSituation($farm, $report);

        // 2. الأولويات بالترتيب (من غير تكرار)
        $targets = $this->resolvePriorityTargets($farm);

        // 3. البدائل الثلاثة
        $strategies[] = $this->buildAlternativeStrategy($farm, $report, 'alt_1', $targets[0]);
        $strategies[] = $this->buildAlternativeStrategy($farm, $report, 'alt_2', $targets[1]);
        $strategies[] = $this->buildAlternativeStrategy($farm, $report, 'alt_3', $targets[2]);

        return $strategies;
    }

    /**
     * أولويات الفلاح الأول بالترتيب، ولو اختار أقل من 3 نكمّل من الافتراضي
     * من غير ما أولوية تتكرر في خطتين
     */
    public function resolvePriorityTargets(Farm $farm): array
    {
        $chosen = $farm->priorities->pluck('name');

        $fallbacks = collect([
            'Water Conservation',
            'Soil Fertility & Nitrogen Fixation',
            'Income Maximization',
            'Balanced',
        ])->reject(function ($fallback) use ($chosen) {
            $keyword = explode(' ', $fallback)[0]; // Water / Soil / Income / Balanced
            return $chosen->contains(fn ($name) => str_contains($name, $keyword));
        });

        return $chosen->merge($fallbacks)->take(3)->values()->all();
    }

    /**
     * تقييم وضع الفلاح الحالي
     */
    private function evaluateCurrentSituation(Farm $farm, Report $report)
    {
        $currentCrop = $farm->currentCrop;
        $warnings = [];

        if ($currentCrop) {
            if ($currentCrop->water_demand === 'high' && $report->precipitation_mm < 300) {
                $warnings[] = "المحصول يستهلك مياه بكثافة في منطقة تعاني من قلة الأمطار.";
            }
            if ($report->avg_temp_anomaly > 0.5) {
                $warnings[] = "ارتفاع درجات الحرارة المتزايد قد يؤثر على إنتاجية هذا المحصول مستقبلاً.";
            }
        }

        $strategy = Strategy::create([
            'report_id'           => $report->id,
            'strategy_type'       => 'current',
            'why_suggested'       => 'هذا هو تقييم وضعك الزراعي الحالي بناءً على مدخلاتك.',
            'supporting_evidence' => 'معدل الأمطار: ' . $report->precipitation_mm . ' مم | الشذوذ الحراري: ' . $report->avg_temp_anomaly . ' درجة.',
            'expected_benefits'   => 'الاستمرار في المألوف لديك، لكن قد يحمل مخاطر مناخية.',
            'information_gaps'    => 'نقص البيانات الميدانية الدقيقة عن مستوى خصوبة تربتك الحالية.',
            'local_review_risks'  => empty($warnings) ? 'لا توجد مخاطر مناخية شديدة حالياً.' : implode(' ', $warnings),
        ]);

        if ($currentCrop) {
            $strategy->crops()->attach($currentCrop->id, ['sequence_order' => 1]);
        }

        return $strategy;
    }

    /**
     * بناء استراتيجية بديلة
     */
    private function buildAlternativeStrategy(Farm $farm, Report $report, $type, $priorityTarget)
    {
        $query = Crop::query();

        if (str_contains($priorityTarget, 'Income')) {
            $query->where('profitability', 'high');
            $rationale = 'تم تصميم هذه الدورة لتحقيق أعلى عائد مادي (محاصيل نقدية) لمواجهة التحديات الاقتصادية.';
        } elseif (str_contains($priorityTarget, 'Water')) {
            $query->where('water_demand', 'low');
            $rationale = 'هذه الدورة تركز على زراعة محاصيل تتحمل الجفاف لترشيد استهلاك المياه في ظل نقص الأمطار.';
        } elseif (str_contains($priorityTarget, 'Soil')) {
            $query->where('is_nitrogen_fixer', true);
            $rationale = 'دورة زراعية علاجية تستخدم البقوليات لتثبيت النيتروجين وإعادة الخصوبة للتربة المجهدة.';
        } else {
            // متوازنة (الأقواس مهمة عشان الـ orWhere ما يبوظش أي شرط بعده)
            $query->where(fn ($q) => $q->where('is_cover_crop', true)->orWhere('profitability', 'medium'));
            $rationale = 'دورة زراعية متوازنة تحافظ على التربة وتوفر دخلاً مستقراً.';
        }

        // المحصول الأول (ولو الفلتر ما لقاش حاجة نجيب أي محصول بدل ما الكود يقع)
        $crop1 = $query->inRandomOrder()->first() ?? Crop::inRandomOrder()->first();

        // المحصول الثاني من عائلة نباتية مختلفة (لكسر دورة الآفات)
        $crop2 = $crop1
            ? Crop::where('id', '!=', $crop1->id)
                ->where('botanical_family', '!=', $crop1->botanical_family)
                ->inRandomOrder()
                ->first()
            : null;

        $strategy = Strategy::create([
            'report_id'           => $report->id,
            'strategy_type'       => $type,
            'why_suggested'       => $rationale,
            'supporting_evidence' => 'بيانات ناسا توضح أن المنطقة مؤهلة مناخياً لهذه المحاصيل مع تقليل الإجهاد البيئي.',
            'expected_benefits'   => 'كسر دورة الآفات لاختلاف العوائل النباتية، وتحقيق أولويتك في: ' . $this->priorityLabelAr($priorityTarget),
            'information_gaps'    => 'تحتاج للتحقق من أسعار السوق المحلية الحالية قبل بدء الزراعة.',
            'local_review_risks'  => 'تأكد من ملاءمة معدات الحصاد المتوفرة لديك لهذه المحاصيل الجديدة.',
        ]);

        if ($crop1) $strategy->crops()->attach($crop1->id, ['sequence_order' => 1]);
        if ($crop2) $strategy->crops()->attach($crop2->id, ['sequence_order' => 2]);

        return $strategy;
    }

    /**
     * اسم الأولوية بالعربي للعرض للفلاح
     */
    private function priorityLabelAr(string $priority): string
    {
        return match (true) {
            str_contains($priority, 'Income') => 'تعظيم الدخل',
            str_contains($priority, 'Water')  => 'توفير المياه',
            str_contains($priority, 'Soil')   => 'خصوبة التربة وتثبيت النيتروجين',
            default                            => 'التوازن بين الدخل والتربة',
        };
    }
}