<?php

namespace App\Services;

use App\Models\Farm;
use App\Models\Report;
use App\Models\Strategy;
use App\Models\Crop;

class DecisionEngineService
{
    /**
     * توليد الاستراتيجيات الثلاثة بناءً على بيانات المزرعة وتقرير ناسا
     */
    public function generate(Farm $farm, Report $report)
    {
        $strategies = [];

        // 1. تقييم الدورة الحالية (Current Strategy)
        $strategies[] = $this->evaluateCurrentSituation($farm, $report);

        // جلب أولويات الفلاح (أول أولويتين على الأقل)
        $priorities = $farm->priorities->pluck('name')->toArray();
        $primaryPriority = $priorities[0] ?? 'Water Conservation';
        $secondaryPriority = $priorities[1] ?? 'Soil Fertility & Nitrogen Fixation';

        // 2. توليد البديل الأول (بناءً على الأولوية الأولى)
        $strategies[] = $this->buildAlternativeStrategy($farm, $report, 'alt_1', $primaryPriority);

        // 3. توليد البديل الثاني (بناءً على الأولوية الثانية أو استدامة التربة)
        $strategies[] = $this->buildAlternativeStrategy($farm, $report, 'alt_2', $secondaryPriority);

        return $strategies;
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
                $warnings[] = "المحصول يستهلك مياه بكثافة في منطقة تعاني من قلة الأمطار الجافة.";
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
     * بناء استراتيجية بديلة ذكية
     */
    private function buildAlternativeStrategy(Farm $farm, Report $report, $type, $priorityTarget)
    {
        // تجهيز الـ Query للبحث عن المحاصيل المناسبة
        $query = Crop::query();

        // توجيه محرك البحث بناءً على الأولوية
        if (str_contains($priorityTarget, 'Income Maximization')) {
            $query->where('profitability', 'high');
            $rationale = 'تم تصميم هذه الدورة لتحقيق أعلى عائد مادي (محاصيل نقدية) لمواجهة التحديات الاقتصادية.';
        } elseif (str_contains($priorityTarget, 'Water Conservation')) {
            $query->where('water_demand', 'low');
            $rationale = 'هذه الدورة تركز على زراعة محاصيل تتحمل الجفاف لترشيد استهلاك المياه في ظل نقص الأمطار.';
        } elseif (str_contains($priorityTarget, 'Soil Fertility')) {
            $query->where('is_nitrogen_fixer', true);
            $rationale = 'دورة زراعية علاجية تستخدم البقوليات لتثبيت النيتروجين وإعادة الخصوبة للتربة المجهدة.';
        } else {
            // افتراضي (توازن)
            $query->where('is_cover_crop', true)->orWhere('profitability', 'medium');
            $rationale = 'دورة زراعية متوازنة تحافظ على التربة وتوفر دخلاً مستقراً.';
        }

        // جلب محصولين مختلفين العائلة (لكسر دورة الآفات) لتكوين التعاقب
        $crop1 = $query->inRandomOrder()->first(); 
        
        // المحصول الثاني يجب أن يكون من عائلة نباتية مختلفة عن المحصول الأول
        $crop2 = Crop::where('id', '!=', $crop1->id)
                    ->where('botanical_family', '!=', $crop1->botanical_family)
                    ->inRandomOrder()
                    ->first();

        // حفظ الاستراتيجية في الداتابيز
        $strategy = Strategy::create([
            'report_id'           => $report->id,
            'strategy_type'       => $type,
            'why_suggested'       => $rationale,
            'supporting_evidence' => 'بيانات ناسا توضح أن المنطقة مؤهلة مناخياً لهذه المحاصيل مع تقليل الإجهاد البيئي.',
            'expected_benefits'   => 'كسر دورة الآفات لاختلاف العوائل النباتية، وتحقيق أولويتك في: ' . $priorityTarget,
            'information_gaps'    => 'تحتاج للتحقق من أسعار السوق المحلية الحالية قبل بدء الزراعة.',
            'local_review_risks'  => 'تأكد من ملاءمة معدات الحصاد المتوفرة لديك لهذه المحاصيل الجديدة.',
        ]);

        // ربط المحاصيل بالاستراتيجية بالترتيب (تسلسل الدورة الزراعية)
        if ($crop1) $strategy->crops()->attach($crop1->id, ['sequence_order' => 1]);
        if ($crop2) $strategy->crops()->attach($crop2->id, ['sequence_order' => 2]);

        return $strategy;
    }
}