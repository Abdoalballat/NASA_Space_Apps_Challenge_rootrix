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
        // تحديد النطاق الزمني (آخر 10 سنوات للحصول على داتا تاريخية دقيقة)
        $endYear = now()->subYear()->year; // العام الماضي (لضمان اكتمال داتا السنة)
        $startYear = $endYear - 9; // 10 سنوات إجمالاً

        // 1. الاتصال بـ NASA API
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
            return null; // سيتم التعامل مع هذا في الكنترولر (مثلاً إرجاع داتا افتراضية أو رسالة خطأ)
        }

        $data = $response->json('properties.parameter');

        // 2. تحليل البيانات واستخراج الحقول المطلوبة لجدول Reports
        return [
            'precipitation_mm'       => $this->calculateAnnualPrecipitation($data['PRECTOTCORR'] ?? []),
            'avg_temp_anomaly'       => $this->calculateTemperatureAnomaly($data['T2M'] ?? []),
            'soil_moisture_index'    => $this->calculateAvgSoilMoisture($data['GWETROOT'] ?? []),
            // سنضيف NDVI لاحقاً أو نحسبه تقديرياً
            'ndvi_vegetation_stress' => 0.5, //-------------------------------هنا هنعدل تاني
            'bare_soil_months'       => []  //-------------------------------هنا هنعدل تاني
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
}