<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rootrix | لوحة النتائج والاستراتيجيات</title>
<link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* CSS الثابت */
:root { --primary: #002F37; --blue: #167208; --light: #F4FFEC; --olive: #167208; --sage: #7EDE56; --white: #ffffff; --bg: #F4FFEC; --border: #e9ece8; --danger: #e74c3c; --warning: #f1c40f; --success: #167208; }
* { margin: 0; padding: 0; box-sizing: border-box; }
body { background: var(--bg); color: var(--primary); font-family: 'Alexandria', sans-serif; min-height: 100vh; display: flex; flex-direction: column; }
a { text-decoration: none; color: inherit; } button { font-family: inherit; cursor: pointer; }
.container { width: min(1400px, 95%); margin: auto; }
header { padding-top: 16px; margin-bottom: 30px; }
.navbar { height: 78px; background: rgba(255,255,255,.96); border: 1px solid var(--border); border-radius: 60px; padding: 0 35px; display: flex; align-items: center; justify-content: space-between; direction: ltr; box-shadow: 0 5px 25px #002F3708; }
.logo { font-size: 25px; font-weight: 800; letter-spacing: -1.5px; color: var(--primary); } .logo span { color: var(--sage); }
.nav-actions { direction: rtl; display: flex; gap: 10px;}
.outline-btn { background: white; border: 1px solid #e2e5e1; color: var(--primary); padding: 10px 20px; border-radius: 40px; font-size: 13px; font-weight: 700; transition: .3s; } .outline-btn:hover { border-color: var(--olive); color: var(--olive); }
.map-btn { background: var(--primary); color: var(--white); border: none; padding: 10px 20px; border-radius: 40px; font-size: 13px; font-weight: 700; transition: .3s; } .map-btn:hover { background: var(--sage); color: var(--primary); }
main { flex: 1; padding-bottom: 60px; }
.summary-header { background: var(--white); padding: 30px 40px; border-radius: 20px; border: 1px solid var(--border); margin-bottom: 40px; box-shadow: 0 10px 30px #002F3705; display: flex; justify-content: space-between; align-items: center; gap: 30px; }
.summary-info h1 { font-size: 26px; margin-bottom: 8px; } .summary-info p { color: #666; font-size: 14px; } .summary-info p strong { color: var(--primary); }
.nasa-stats-grid { display: flex; gap: 15px; } .nasa-stat-box { background: #fdfcf9; border: 1px solid #f2ece4; padding: 15px 20px; border-radius: 12px; text-align: center; min-width: 110px; } .nasa-stat-box i { font-size: 18px; color: var(--olive); margin-bottom: 8px; } .nasa-stat-box.alert-box { background: #fff5f5; border-color: #ffe3e3; } .nasa-stat-box.alert-box i { color: var(--danger); } .nasa-stat-box h4 { font-size: 20px; font-weight: 800; margin-bottom: 3px; direction: ltr; } .nasa-stat-box span { font-size: 11px; color: #7f8c8d; font-weight: 600; }
.strategies-title { font-size: 24px; margin: 0 0 25px; font-weight: 800; } .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; }
.strategy-card { background: var(--white); border: 1px solid var(--border); border-radius: 20px; padding: 35px 30px; position: relative; transition: 0.3s; display: flex; flex-direction: column; } .strategy-card:hover { border-color: var(--sage); transform: translateY(-5px); box-shadow: 0 15px 35px #002F370a; }
.card-badge { position: absolute; top: 25px; left: 25px; padding: 6px 15px; border-radius: 30px; font-size: 11px; font-weight: 700; } .badge-current { background: #f1f2f6; color: #57606f; } .badge-income { background: #fef9e7; color: #f39c12; } .badge-water { background: #e0f7fa; color: #0097a7; } .badge-soil { background: #eafaf1; color: #167208; } .badge-balanced { background: #f3eefc; color: #7d5ba6; }
.card-icon { font-size: 35px; color: var(--primary); margin-bottom: 20px; } .strategy-card h3 { font-size: 20px; margin-bottom: 10px; line-height: 1.4; } .strategy-card > p { font-size: 13px; color: #666; line-height: 1.8; margin-bottom: 25px; flex-grow: 1; }
.cycle-box { background: #f8f9fa; padding: 15px 20px; border-radius: 12px; border: 1px dashed #dcdde1; margin-bottom: 25px; } .cycle-box span { display: block; font-size: 12px; color: #7f8c8d; margin-bottom: 5px; } .cycle-box strong { font-size: 15px; color: var(--primary); font-weight: 700;} .cycle-arrow { color: var(--sage); margin: 0 8px; display: inline !important; }
.pros-cons ul { list-style: none; } .pros-cons li { font-size: 13px; margin-bottom: 10px; display: flex; align-items: flex-start; gap: 10px; line-height: 1.6;} .pros-cons li::before { content: '\f00c'; font-family: 'Font Awesome 6 Free'; font-weight: 900; color: var(--success); font-size: 14px;} .pros-cons li.con::before { content: '\f071'; color: var(--warning); } .pros-cons li.gap::before { content: '\f059'; color: #3498db; }
.select-btn { width: 100%; margin-top: auto; padding: 16px; border: 1px solid var(--primary); background: transparent; color: var(--primary); border-radius: 40px; font-weight: 700; font-size: 14px; transition: 0.3s; } .select-btn:hover, .strategy-card.recommended .select-btn { background: var(--primary); color: var(--white); }
.pros-cons { margin-bottom: 30px; }
.strategy-card.recommended { border: 2px solid var(--sage); background-color: #fafdf9; } .recommended-tag { position: absolute; top: -14px; right: 30px; background: var(--sage); color: var(--primary); padding: 6px 18px; border-radius: 20px; font-size: 12px; font-weight: 800; box-shadow: 0 4px 10px rgba(126, 222, 86, 0.3); }
@media(max-width: 992px) { .grid-3 { grid-template-columns: repeat(2, 1fr); } } @media(max-width: 768px) { .grid-3 { grid-template-columns: 1fr; } .summary-header { flex-direction: column; text-align: right; align-items: flex-start; padding: 20px; } .nasa-stats-grid { flex-wrap: wrap; width: 100%; } .nasa-stat-box { flex: 1; min-width: 45%; } .navbar { height: auto; min-height: 65px; padding: 12px 20px; border-radius: 25px; } .nav-actions { gap: 8px; } .outline-btn, .map-btn { padding: 8px 14px; font-size: 11px; } }
@media(max-width: 480px) { .navbar { flex-direction: column; gap: 12px; border-radius: 20px; padding: 15px; } .nav-actions { width: 100%; justify-content: center; } }
</style>
</head>
<body>

<header class="container">
  <nav class="navbar">
    <a href="{{ route('home') }}" class="logo">Rootrix</a>
    <div class="nav-actions">
      <a href="{{ route('assessment.index') }}" class="outline-btn">تعديل البيانات</a>
      <a href="{{ route('map.index') }}" class="map-btn">عرض خريطة الأقمار 🛰️</a>
    </div>
  </nav>
</header>

<main class="container">
  <section id="dashboard">
    <div class="summary-header">
      <div class="summary-info">
        <h1>تقرير المناخ الذكي</h1>
        <p>بناءً على موقع أرضك والمحصول الحالي (<strong>{{ $analysisData['current_crop_name'] ?? 'غير محدد' }}</strong>)</p>
      </div>

      <div class="nasa-stats-grid">
        <div class="nasa-stat-box">
          <i class="fa-solid fa-cloud-rain"></i>
          <h4>{{ $analysisData['rainfall'] ?? 'N/A' }}</h4>
          <span>معدل الأمطار (مم)</span>
        </div>
        <div class="nasa-stat-box">
          <i class="fa-solid fa-temperature-half"></i>
          <h4>{{ $analysisData['temp_anomaly'] ?? 'N/A' }}</h4>
          <span>الشذوذ الحراري</span>
        </div>
        <div class="nasa-stat-box alert-box">
          <i class="fa-solid fa-leaf"></i>
          <h4>{{ $analysisData['ndvi'] ?? 'N/A' }}</h4>
          <span>إجهاد النبات NDVI</span>
        </div>
        <div class="nasa-stat-box alert-box">
          <i class="fa-solid fa-sun"></i>
          <h4>{{ $analysisData['drought_months'] ?? 'N/A' }}</h4>
          <span>شهور الجفاف</span>
        </div>
      </div>
    </div>

    <h2 class="strategies-title">البدائل الاستراتيجية المقترحة</h2>

    @php
      // شكل كل كارت بيتحدد من الأولوية اللي الاستراتيجية اتبنت عليها فعلاً
      $metaForPriority = function (?string $priority) {
          $priority = $priority ?? '';
          return match (true) {
              str_contains($priority, 'Income') => ['label' => 'تعظيم الدخل',  'badge' => 'badge-income',   'icon' => 'fa-coins',         'title' => 'دورة المحاصيل النقدية'],
              str_contains($priority, 'Water')  => ['label' => 'توفير المياه',  'badge' => 'badge-water',    'icon' => 'fa-droplet',       'title' => 'دورة تحمل الجفاف'],
              str_contains($priority, 'Soil')   => ['label' => 'خصوبة التربة', 'badge' => 'badge-soil',     'icon' => 'fa-seedling',      'title' => 'دورة تجديد التربة'],
              default                            => ['label' => 'دورة متوازنة', 'badge' => 'badge-balanced', 'icon' => 'fa-scale-balanced', 'title' => 'دورة زراعية متوازنة'],
          };
      };

      $currentMeta = ['label' => 'الوضع القائم', 'badge' => 'badge-current', 'icon' => 'fa-clock-rotate-left', 'title' => 'الاستمرار في المألوف لديك'];
    @endphp

    <div class="grid-3" id="strategies-container">

      @foreach (['current', 'alt_1', 'alt_2'] as $type)
        @php $strategy = $strategies->firstWhere('strategy_type', $type); @endphp
        @continue(!$strategy)

        @php
          $meta = $type === 'current'
              ? $currentMeta
              : $metaForPriority($strategyPriority[$type] ?? null);
        @endphp

        <div class="strategy-card {{ $type === 'alt_1' ? 'recommended' : '' }}">

          @if ($type === 'alt_1')
            <div class="recommended-tag"><i class="fa-solid fa-star"></i> يطابق أولويتك الأولى</div>
          @endif

          <div class="card-badge {{ $meta['badge'] }}">{{ $meta['label'] }}</div>
          <div class="card-icon"><i class="fa-solid {{ $meta['icon'] }}"></i></div>
          <h3>{{ $meta['title'] }}</h3>
          <p>{{ $strategy->why_suggested }}</p>

          <div class="cycle-box">
            <span>{{ $type === 'current' ? 'الدورة المعتادة:' : 'الدورة المقترحة:' }}</span>
            <strong>
              @forelse ($strategy->crops as $crop)
                {{ $crop->name }}
                @if (!$loop->last)
                  <span class="cycle-arrow">←</span>
                @endif
              @empty
                لم يتم تحديد محصول
              @endforelse
            </strong>
          </div>

          <div class="pros-cons">
            <ul>
              <li>{{ $strategy->expected_benefits }}</li>
              <li class="con">{{ $strategy->local_review_risks }}</li>
              <li class="gap">{{ $strategy->information_gaps }}</li>
            </ul>
          </div>

          <!-- <button class="select-btn">
            {{ $type === 'current' ? 'متابعة الوضع الحالي' : 'اعتماد هذه الاستراتيجية' }}
          </button> -->
        </div>
      @endforeach

    </div>
  </section>
</main>
</body>
</html>