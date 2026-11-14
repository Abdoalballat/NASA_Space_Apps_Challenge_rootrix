<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NasaPowerService
{
    /**
     * جلب وتحليل البيانات المناخية من NASA POWER API
     */
public function getClimateReport(float $lat, float $lng): ?array
    {
        $endYear = now()->subYear()->year;
        $startYear = $endYear - 9;

        $response = Http::timeout(15)->get('https://power.larc.nasa.gov/api/temporal/monthly/point', [
            'parameters' => 'T2M,PRECTOTCORR,GWETROOT',
            'community'  => 'AG',
            'longitude'  => $lng,
            'latitude'   => $lat,
            'start'      => $startYear,
            'end'        => $endYear,
            'format'     => 'JSON'
        ]);

        if ($response->failed()) {
            Log::error("NASA API Failed for Lat: $lat, Lng: $lng");
            return null; 
        }

        $data = $response->json('properties.parameter');

        // حساب القيم الأساسية
        $precipitation = $this->calculateAnnualPrecipitation($data['PRECTOTCORR'] ?? []);
        $tempAnomaly   = $this->calculateTemperatureAnomaly($data['T2M'] ?? []);
        $soilMoisture  = $this->calculateAvgSoilMoisture($data['GWETROOT'] ?? []);

        return [
            'precipitation_mm'       => $precipitation,
            'avg_temp_anomaly'       => $tempAnomaly,
            'soil_moisture_index'    => $soilMoisture,
            // ⚠️ التعديل الجديد: استنتاج الإجهاد النباتي وشهور التربة العارية رياضياً ⚠️
            'ndvi_vegetation_stress' => $this->calculateVegetationStress($tempAnomaly, $precipitation), 
            'bare_soil_months'       => $this->estimateBareSoilMonths($data['PRECTOTCORR'] ?? [], $data['T2M'] ?? []) 
        ];
    }

    /**
     * حساب متوسط هطول الأمطار السنوي (بالمليمتر)
     */
    private function calculateAnnualPrecipitation(array $precipData): float
    {
        if (empty($precipData)) return 0;
        
        // البيانات تأتي كمتوسط يومي لكل شهر، نجمعها لنحصل على الإجمالي الشهري ثم السنوي
        // للتبسيط في الهاكاثون: نأخذ متوسط هطول المطر الشهري في السنة * 12
        $validMonths = array_filter($precipData, fn($val) => $val !== -999.0); // -999 تعني بيانات مفقودة في ناسا
        $monthlyAverage = count($validMonths) > 0 ? (array_sum($validMonths) / count($validMonths)) : 0;
        
        // ناسا تعطي المعدل بـ mm/day، نضربه في 30 يوم * 12 شهر = معدل سنوي تقريبي
        return round($monthlyAverage * 360, 2); 
    }

    /**
     * حساب الشذوذ الحراري (هل المكان بيسخن بمرور السنين؟)
     */
    private function calculateTemperatureAnomaly(array $tempData): float
    {
        if (empty($tempData)) return 0;

        $validTemps = array_filter($tempData, fn($val) => $val !== -999.0);
        $tempsOnly = array_values($validTemps);
        $totalRecords = count($tempsOnly);

        if ($totalRecords < 24) return 0; // نحتاج داتا كافية للمقارنة

        // نقسم الداتا لنصفين: قديم (أول 5 سنين) وجديد (آخر 5 سنين)
        $half = (int)($totalRecords / 2);
        
        $oldTemps = array_slice($tempsOnly, 0, $half);
        $recentTemps = array_slice($tempsOnly, $half);

        $oldAvg = array_sum($oldTemps) / count($oldTemps);
        $recentAvg = array_sum($recentTemps) / count($recentTemps);

        // الفرق بين متوسط آخر 5 سنين وأول 5 سنين
        return round($recentAvg - $oldAvg, 2); 
    }

    /**
     * حساب متوسط رطوبة التربة في منطقة الجذور
     */
    private function calculateAvgSoilMoisture(array $moistureData): float
    {
        if (empty($moistureData)) return 0;

        $validMoisture = array_filter($moistureData, fn($val) => $val !== -999.0);
        
        if (count($validMoisture) === 0) return 0;

        $avgMoisture = array_sum($validMoisture) / count($validMoisture);
        
        return round($avgMoisture, 2); // رقم من 0 إلى 1 (مثلاً 0.40)
    }
    private function calculateVegetationStress(float $tempAnomaly, float $precipitation): float
    {
        $baseHealth = 0.8; // نفترض أن النبات صحي مبدئياً

        // إذا كانت الأمطار نادرة (أقل من 200 مم)، يفقد النبات 30% من صحته بسبب العطش
        if ($precipitation < 200) {
            $baseHealth -= 0.3;
        } elseif ($precipitation < 400) {
            $baseHealth -= 0.15;
        }

        // إذا كان هناك شذوذ حراري واحتباس (أكثر من 0.5 درجة)، يفقد 20% بسبب الإجهاد الحراري
        if ($tempAnomaly > 0.5) {
            $baseHealth -= 0.2;
        }

        // التأكد أن القيمة لا تقل عن 0.1 ولا تزيد عن 1.0
        return max(0.1, min(1.0, round($baseHealth, 2)));
    }

    /**
     * استنتاج الشهور التي تُترك فيها التربة عارية بناءً على قسوة المناخ
     * (نبحث عن الأشهر الأكثر حرارة والأقل أمطاراً تاريخياً)
     */
    private function estimateBareSoilMonths(array $precipData, array $tempData): array
    {
        if (empty($precipData) || empty($tempData)) return [];

        $monthlyScores = [];
        
        // تجميع متوسطات الشهور من 1 إلى 12 (يناير إلى ديسمبر) على مدار السنوات
        for ($month = 1; $month <= 12; $month++) {
            $monthStr = str_pad($month, 2, '0', STR_PAD_LEFT);
            $monthPrecip = [];
            $monthTemp = [];

            foreach ($precipData as $date => $val) {
                if (str_ends_with($date, $monthStr) && $val !== -999.0) $monthPrecip[] = $val;
            }
            foreach ($tempData as $date => $val) {
                if (str_ends_with($date, $monthStr) && $val !== -999.0) $monthTemp[] = $val;
            }

            $avgP = count($monthPrecip) > 0 ? (array_sum($monthPrecip) / count($monthPrecip)) : 0;
            $avgT = count($monthTemp) > 0 ? (array_sum($monthTemp) / count($monthTemp)) : 0;

            // إذا كان المطر شبه معدوم والحرارة فوق 30 درجة، فهذا شهر قاسي يصعب الزراعة فيه بدون ري مكثف
            if ($avgP < 1 && $avgT > 30) {
                $monthlyScores[] = $month; // أضف رقم الشهر (مثلاً 7 ليوليو، 8 لأغسطس)
            }
        }

        // إرجاع أرقام الشهور القاسية بدون تكرار
        return array_values(array_unique($monthlyScores));
    }
}