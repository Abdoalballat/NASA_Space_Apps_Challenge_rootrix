<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Farm;
use App\Models\Priority;
use App\Models\Report;
use App\Models\Strategy;
use App\Services\DecisionEngineService;
use App\Services\NasaPowerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AssessmentController extends Controller
{
    public function __construct(
        protected NasaPowerService $nasaService,
        protected DecisionEngineService $decisionEngine
    ) {}

    // 1. عرض الفورم مع المحاصيل والأولويات
    public function index()
    {
        $crops = Crop::select('id', 'name','name_ar')->get();
        $priorities = Priority::select('id', 'name')->get();

        return view('assessment', compact('crops', 'priorities'));
    }

    // 2. استلام الفورم ← ناسا ← محرك القرار ← صفحة النتائج
public function analyze(Request $request)
{
    $validated = $request->validate([
        'lat'            => 'required|numeric|between:-90,90',
        'lng'            => 'required|numeric|between:-180,180',
        'areaSize'       => 'required|numeric|min:0.1',
        'currentCrop'    => 'nullable|exists:crops,id',
        'irrigationType' => 'required|in:flood,drip,sprinkler,rainfed',
        'waterAvail'     => 'required|string',
        'priorities'     => 'required|array|min:1',
        'priorities.*'   => 'exists:priorities,id',
    ]);

    // أ) نجيب بيانات ناسا الأول، قبل ما نسجل أي حاجة في الداتا بيز
    $climateData = $this->nasaService->getClimateReport(
        (float) $validated['lat'],
        (float) $validated['lng']
    );

    if (!$climateData) {
        return back()->withInput()
            ->withErrors(['nasa' => 'تعذر الاتصال بخوادم NASA POWER حالياً، حاول تاني.']);
    }

    // ب) نسجل المزرعة والتقرير ونولّد الاستراتيجيات
    [$farm, $report] = DB::transaction(function () use ($validated, $climateData) {
        $farm = Farm::create([
            'session_uuid'    => $this->getFarmerUuid(),
            'latitude'        => $validated['lat'],
            'longitude'       => $validated['lng'],
            'area'            => $validated['areaSize'],
            'irrigation_type' => $validated['irrigationType'],
            'current_crop_id' => $validated['currentCrop'] ?? null,
        ]);

        $farm->priorities()->attach($validated['priorities']);

        $report = Report::create(['farm_id' => $farm->id] + $climateData);

        $this->decisionEngine->generate($farm, $report);

        return [$farm, $report];
    });

    // ج) نجهز الداتا لصفحة النتائج
    $strategies = Strategy::with('crops')->where('report_id', $report->id)->get();
    $alt1 = $strategies->firstWhere('strategy_type', 'alt_1');
    $alt2 = $strategies->firstWhere('strategy_type', 'alt_2');

    $analysisData = [
        'rainfall'          => $report->precipitation_mm,
        'temp_anomaly'      => $report->avg_temp_anomaly,
        'ndvi'              => $report->ndvi_vegetation_stress,
        'drought_months'    => implode(' , ', $climateData['bare_soil_months']) ?: 'لا يوجد',
        'recommended_crop'  => $alt1?->crops->first()?->display_name ?? '—',
        'alternative_crop'  => $alt2?->crops->first()?->display_name ?? '—',
        'current_crop_name' => $farm->currentCrop?->display_name ?? 'غير محدد',
    ];

    // د) كل خطة اتبنت على أنهي أولوية (نفس اللي استعمله محرك القرار بالظبط)
    $priorityNames = $farm->priorities->pluck('name')->values();

$targets = $this->decisionEngine->resolvePriorityTargets($farm);

$strategyPriority = [
    'alt_1' => $targets[0],
    'alt_2' => $targets[1],
    'alt_3' => $targets[2],
];

    return view('results', compact('analysisData', 'strategies', 'strategyPriority'));
}
    // عمود session_uuid في جدول farms نوعه uuid، و session()->getId() مش uuid
    // فبنعمل uuid حقيقي ونحفظه في السيشن عشان يفضل ثابت لنفس الفلاح
    private function getFarmerUuid(): string
    {
        if (!session()->has('farmer_uuid')) {
            session()->put('farmer_uuid', (string) Str::uuid());
        }

        return session('farmer_uuid');
    }
}