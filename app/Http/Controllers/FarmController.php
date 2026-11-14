<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\Report;
use App\Models\Strategy;
use App\Services\NasaPowerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\DecisionEngineService;

class FarmController extends Controller
{
protected $nasaService;
protected $decisionEngine;

public function __construct(NasaPowerService $nasaService, DecisionEngineService $decisionEngine)
{
    $this->nasaService = $nasaService;
    $this->decisionEngine = $decisionEngine;
}

    public function analyze(Request $request)
    {
        // 1. التحقق من البيانات القادمة من الفرونت إند (Validation)
        $validated = $request->validate([
            'session_uuid'    => 'required|string', // المعرف الخاص بالمتصفح
            'latitude'        => 'required|numeric',
            'longitude'       => 'required|numeric',
            'area'            => 'required|numeric',
            'irrigation_type' => 'required|in:flood,drip,sprinkler,rainfed',
            'current_crop_id' => 'nullable|exists:crops,id',
            'priorities'      => 'required|array', // مصفوفة بأرقام الأولويات
            'priorities.*'    => 'exists:priorities,id',
        ]);

        // نستخدم Transaction عشان لو حصل أي خطأ في النص (زي إن ناسا تقع)، الداتا بيز ترجع سليمة ومتسجلش نص داتا
        return DB::transaction(function () use ($validated) {
            
            // 2. تسجيل المزرعة في جدول farms
            $farm = Farm::create([
                'session_uuid'    => $validated['session_uuid'],
                'latitude'        => $validated['latitude'],
                'longitude'       => $validated['longitude'],
                'area'            => $validated['area'],
                'irrigation_type' => $validated['irrigation_type'],
                'current_crop_id' => $validated['current_crop_id'] ?? null,
            ]);

            // 3. ربط الأولويات بالمزرعة في جدول farm_priority
            // دالة attach بتروح للجدول الوسيط وتحط id المزرعة مع كل id أولوية الفلاح اختاره
            $farm->priorities()->attach($validated['priorities']);

            // 4. استدعاء السيرفيس لجلب بيانات ناسا للإحداثيات دي
            $climateData = $this->nasaService->getClimateReport($farm->latitude, $farm->longitude);

            if (!$climateData) {
                return response()->json(['error' => 'تعذر الاتصال بخوادم NASA POWER حالياً'], 500);
            }

            // 5. حفظ التقرير المناخي في جدول reports وربطه بالمزرعة
            $report = Report::create(array_merge(
                ['farm_id' => $farm->id],
                $climateData
            ));

            // 6. ⚠️ محرك اتخاذ القرار (Decision Engine) ⚠️
            // هنا هيجي دور الكلاس اللي عليه الدور المرة الجاية، واللي هياخد $farm و $report ويطلع الخطط.
            $strategies = $this->decisionEngine->generate($farm, $report);
            $fullStrategies = Strategy::with('crops')->where('report_id', $report->id)->get();
            // 7. الرد المؤقت للفرونت إند (إثبات نجاح العملية حتى الآن)
            return response()->json([
                'status'     => 'success',
                'farm_id'    => $farm->id,
                'report'     => $report,
                'strategies' => $fullStrategies
            ]);
        });
    }
}