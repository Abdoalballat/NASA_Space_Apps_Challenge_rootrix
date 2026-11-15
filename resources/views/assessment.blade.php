<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rootrix | تقييم المزرعة</title>
<link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<style>
/* CSS ثابت بدون تغيير */
:root { --primary: #002F37; --blue: #167208; --light: #F4FFEC; --olive: #167208; --sage: #7EDE56; --white: #ffffff; --bg: #F4FFEC; --gray: #89918a; --border: #e9ece8; --danger: #e74c3c; }
* { margin: 0; padding: 0; box-sizing: border-box; }
body { background: var(--bg); color: var(--primary); font-family: 'Alexandria', sans-serif; min-height: 100vh; display: flex; flex-direction: column; }
a { text-decoration: none; color: inherit; } button { font-family: inherit; cursor: pointer; }
.container { width: min(1400px, 95%); margin: auto; }
header { padding-top: 16px; margin-bottom: 40px; }
.navbar { height: 78px; background: rgba(255,255,255,.96); border: 1px solid var(--border); border-radius: 60px; padding: 0 35px; display: flex; align-items: center; justify-content: space-between; direction: ltr; box-shadow: 0 5px 25px #002F3708; }
.logo { font-size: 25px; font-weight: 800; letter-spacing: -1.5px; color: var(--primary); } .logo span { color: var(--olive); }
.nav-actions { direction: rtl; } .outline-btn { background: white; border: 1px solid #e2e5e1; color: var(--primary); padding: 10px 20px; border-radius: 40px; font-size: 12px; font-weight: 700; transition: .3s; } .outline-btn:hover { border-color: var(--olive); color: var(--olive); }
main { flex: 1; display: flex; align-items: center; justify-content: center; padding-bottom: 50px; }
.wizard-card { background: var(--white); width: min(850px, 100%); border-radius: 20px; padding: 50px 60px; box-shadow: 0 15px 40px #002F3710; border: 1px solid var(--border); }
.progress-container { margin-bottom: 35px; } .progress-bar { display: flex; justify-content: space-between; position: relative; } .progress-bar::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 3px; background: var(--light); z-index: 1; transform: translateY(-50%); } .progress-line { position: absolute; top: 50%; right: 0; height: 3px; background: var(--sage); z-index: 2; transform: translateY(-50%); transition: width 0.4s ease; width: 0%; }
.progress-error-msg { color: var(--danger); font-size: 13px; font-weight: 700; text-align: center; min-height: 20px; margin-bottom: 15px; opacity: 0; transition: opacity 0.3s ease; } .progress-error-msg.show { opacity: 1; }
.step-indicator { width: 35px; height: 35px; border-radius: 50%; background: var(--white); border: 3px solid var(--light); display: grid; place-items: center; font-weight: 700; font-size: 14px; color: var(--gray); z-index: 3; transition: 0.3s; } .step-indicator.active { border-color: var(--sage); background: var(--sage); color: var(--primary); } .step-indicator.completed { border-color: var(--olive); background: var(--olive); color: var(--white); }
.step-content { display: none; animation: fadeIn 0.5s ease; } .step-content.active { display: block; } @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
.step-header { margin-bottom: 30px; text-align: center; } .step-header h2 { font-size: 26px; font-weight: 800; margin-bottom: 10px; } .step-header p { font-size: 14px; color: var(--gray); }
.form-group { margin-bottom: 20px; } .form-label { display: block; font-size: 14px; font-weight: 700; margin-bottom: 10px; } .form-label span.required { color: var(--danger); margin-right: 3px; }
.form-control { width: 100%; padding: 16px 20px; border: 1px solid var(--border); border-radius: 12px; font-family: inherit; font-size: 15px; background: #fafbfa; color: var(--primary); transition: 0.3s; } .form-control:focus { outline: none; border-color: var(--sage); background: var(--white); }
.gps-btn { width: 100%; padding: 18px; background: #f7f9f7; border: 2px dashed #b5c4b5; color: var(--primary); border-radius: 12px; font-size: 15px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 25px; transition: 0.3s; } .gps-btn:hover { background: var(--light); border-color: var(--sage); color: var(--olive); }
.or-divider { text-align: center; font-size: 13px; color: var(--gray); margin-bottom: 25px; }
#picker-map { height: 400px; width: 100%; border-radius: 15px; border: 1px solid var(--border); z-index: 1; }
.leaflet-control-geocoder { border: none !important; border-radius: 30px !important; background-color: #ffffff !important; box-shadow: 0 4px 15px rgba(0,0,0,0.15) !important; display: flex !important; align-items: center !important; padding: 8px 15px !important; margin-top: 20px !important; margin-left: 20px !important; min-width: 280px !important; } .leaflet-control-geocoder-form input { border: none !important; outline: none !important; background: transparent !important; font-family: 'Alexandria', sans-serif !important; font-size: 15px !important; padding: 5px 10px !important; width: 100% !important; }
.options-grid { display: grid; gap: 15px; } .option-card { position: relative; border: 1px solid var(--border); border-radius: 12px; padding: 18px 25px; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 20px; } .option-card:hover { border-color: var(--sage); background: var(--light); } .option-card input { width: 20px; height: 20px; accent-color: var(--olive); cursor: pointer; } .option-label { flex: 1; } .option-label strong { display: block; font-size: 15px; margin-bottom: 5px; } .option-label small { color: var(--gray); font-size: 13px; }
.wizard-actions { display: flex; gap: 20px; margin-top: 45px; padding-top: 25px; border-top: 1px solid var(--border); } .btn-primary { flex: 1; background: var(--primary); color: var(--white); border: none; padding: 18px; border-radius: 40px; font-size: 15px; font-weight: 700; transition: .3s; } .btn-primary:hover { background: var(--olive); transform: translateY(-2px); } .btn-secondary { flex: 1; background: transparent; color: var(--primary); border: 1px solid var(--border); padding: 18px; border-radius: 40px; font-size: 15px; font-weight: 700; transition: .3s; } .btn-secondary:hover { background: var(--light); border-color: var(--sage); }
.choices { position: relative; z-index: 10 !important; } .choices.is-open { z-index: 999 !important; } .choices__list--dropdown { z-index: 9999 !important; background-color: #ffffff !important; }
@media(max-width: 768px) { .wizard-card { padding: 30px 20px; border-radius: 0; border-left: 0; border-right: 0; } .step-header h2 { font-size: 22px; } #picker-map { height: 300px; } .btn-primary, .btn-secondary { padding: 15px; font-size: 14px; } .form-control { padding: 14px 18px; font-size: 14px; } .option-card { padding: 15px 20px; } }
</style>
</head>
<body>

<header class="container">
  <nav class="navbar">
    <a href="{{ route('home') }}" class="logo">Rootrix</a>
    <div class="nav-actions">
      <a href="{{ route('home') }}" class="outline-btn">← العودة للرئيسية</a>
    </div>
  </nav>
</header>

<main class="container">
  <!-- Laravel Form Request -->
  <form id="assessmentForm" class="wizard-card" action="{{ route('assessment.analyze') }}" method="POST">
    @csrf
    
    <!-- حقول مخفية للإحداثيات -->
    <input type="hidden" name="lat" id="hidden_lat" value="{{ old('lat') }}">
    <input type="hidden" name="lng" id="hidden_lng" value="{{ old('lng') }}">
    @error('lat') <div class="progress-error-msg show" style="margin-top: 10px;">{{ $message }}</div> @enderror

    <!-- شريط التقدم -->
    <div class="progress-container">
      <div id="progressError" class="progress-error-msg"></div> 
      <div class="progress-bar">
        <div class="progress-line" id="progressLine"></div>
        <div class="step-indicator active" id="ind-1">1</div>
        <div class="step-indicator" id="ind-2">2</div>
        <div class="step-indicator" id="ind-3">3</div>
        <div class="step-indicator" id="ind-4">4</div>
      </div>
    </div>

    <!-- خطوة 1: الموقع -->
    <div class="step-content active" id="step-1">
      <div class="step-header"><h2>أرضك فين ؟</h2><p>نحتاج للموقع الدقيق لربطه ببيانات الأقمار الصناعية (SMAP/MODIS).</p></div>
      <button class="gps-btn" id="gpsBtn" type="button" onclick="getLocation()"><span id="gps-icon">📍</span><span id="gps-text">تحديد موقعي تلقائياً (عبر GPS)</span></button>
      <div class="or-divider">أو ابحث وحدد موقع أرضك على الخريطة بدقة</div>
      <div id="picker-map"></div>
      <p id="selected-coords" style="font-size: 13px; color: var(--olive); margin-top: 15px; text-align: center; font-weight: 700; height: 18px;"></p>
    </div>

    <!-- خطوة 2: الوضع الحالي -->
    <div class="step-content" id="step-2">
      <div class="step-header"><h2>وضع ارضك ايه</h2><p>لتتمكن المنصة من مقارنة الوضع الحالي بالاستراتيجيات البديلة.</p></div>
      <div class="form-group">
        <label class="form-label">مساحة الأرض (بالفدان) <span class="required">*</span></label>
        <input type="number" class="form-control" name="areaSize" id="areaSize" value="{{ old('areaSize') }}" placeholder="مثال: 5">
        @error('areaSize') <span style="color: var(--danger); font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
      </div>
      <div class="form-group">
        <label class="form-label">المحصول المزروع حالياً (اختياري)</label>
        <select class="form-control" name="currentCrop" id="currentCrop">
          <option value="">اختر المحصول أو ابحث عنه...</option>
          <!-- DB Loop -->
          @if(isset($crops))
            @foreach($crops as $crop)
              <option value="{{ $crop->id }}" {{ old('currentCrop') == $crop->id ? 'selected' : '' }}>{{ $crop->display_name  }}</option>
            @endforeach
          @endif
        </select>
        @error('currentCrop') <span style="color: var(--danger); font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
      </div>
    </div>

    <!-- خطوة 3: الري والموارد -->
    <div class="step-content" id="step-3">
      <div class="step-header"><h2>هتسقى أرضك إزاى </h2><p>يساعدنا في ترشيح المحاصيل المناسبة لمواردك المائية.</p></div>
      <div class="form-group">
        <label class="form-label">نوع نظام الري <span class="required">*</span></label>
        <select class="form-control" name="irrigationType" id="irrigationType">
          <option value="">اختر النظام...</option>
          <option value="flood" {{ old('irrigationType') == 'flood' ? 'selected' : '' }}>ري بالغمر (تقليدي)</option>
          <option value="drip" {{ old('irrigationType') == 'drip' ? 'selected' : '' }}>ري بالتنقيط</option>
          <option value="sprinkler" {{ old('irrigationType') == 'sprinkler' ? 'selected' : '' }}>ري بالرش</option>
        </select>
        @error('irrigationType') <span style="color: var(--danger); font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
      </div>
      <div class="form-group">
        <label class="form-label">مدى توفر المياه حالياً <span class="required">*</span></label>
        <div class="options-grid">
          <label class="option-card">
            <input type="radio" name="waterAvail" value="high" {{ old('waterAvail', 'high') == 'high' ? 'checked' : '' }}>
            <div class="option-label"><strong>مستقر وجيد</strong><small>لا توجد مشاكل في نوبات الري</small></div>
          </label>
          <label class="option-card">
            <input type="radio" name="waterAvail" value="low" {{ old('waterAvail') == 'low' ? 'checked' : '' }}>
            <div class="option-label"><strong>محدود أو متقطع</strong><small>نواجه نقص في نوبات الري احياناً</small></div>
          </label>
        </div>
        @error('waterAvail') <span style="color: var(--danger); font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
      </div>
    </div>

    <!-- خطوة 4: الأولويات -->
    <div class="step-content" id="step-4">
      <div class="step-header"><h2> عايز ايه من ارضك </h2><p>سنقوم بتخصيص الاستراتيجيات بناءً على أولوياتك.</p></div>
      <div class="options-grid" id="prioritiesGroup">
        <!-- DB Priorities Loop or Static Checkboxes retaining old values -->
        <label class="option-card"><input type="checkbox" name="priorities[]" class="priority-check" value="1" {{ (is_array(old('priorities')) && in_array(1, old('priorities'))) ? 'checked' : '' }}><div class="option-label"><strong>توفير المياه</strong><small>محاصيل تتحمل الجفاف وتستهلك مياه أقل</small></div></label>
        <label class="option-card"><input type="checkbox" name="priorities[]" class="priority-check" value="2" {{ (is_array(old('priorities')) && in_array(2, old('priorities'))) ? 'checked' : '' }}><div class="option-label"><strong>تحسين خصوبة التربة</strong><small>دورة زراعية لتعويض إجهاد التربة</small></div></label>
        <label class="option-card"><input type="checkbox" name="priorities[]" class="priority-check" value="3" {{ (is_array(old('priorities')) && in_array(3, old('priorities'))) ? 'checked' : '' }}><div class="option-label"><strong>مكافحة التعرية</strong><small>مكافحة التعرية</small></div></label>
        <label class="option-card"><input type="checkbox" name="priorities[]" class="priority-check" value="4" {{ (is_array(old('priorities')) && in_array(4, old('priorities'))) ? 'checked' : '' }}><div class="option-label"><strong>عائد اقتصادي سريع</strong><small>محاصيل نقدية ذات ربحية عالية</small></div></label>
      </div>
      @error('priorities') <span style="color: var(--danger); font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
    </div>

    <!-- أزرار التنقل والإرسال -->
    <div class="wizard-actions">
      <button type="button" class="btn-secondary" id="prevBtn" style="display: none;" onclick="changeStep(-1)">السابق</button>
      <button type="button" class="btn-primary" id="nextBtn" onclick="changeStep(1)">التالي</button>
    </div>
  </form>
</main>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
  let pickerMap, mapMarker;
  document.addEventListener("DOMContentLoaded", function() {
    // الخريطة تسترجع موقع لو حصل Error في الفورم واحتفظ بـ old('lat')
    let startLat = document.getElementById("hidden_lat").value || 26.8206;
    let startLng = document.getElementById("hidden_lng").value || 30.8025;
    let startZoom = document.getElementById("hidden_lat").value ? 14 : 5;

    pickerMap = L.map('picker-map').setView([startLat, startLng], startZoom);
    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { attribution: '© Esri' }).addTo(pickerMap);
    L.Control.geocoder({ defaultMarkGeocode: false, placeholder: "ابحث عن قريتك أو مدينتك...", collapsed: false }).on('markgeocode', function(e) { 
      pickerMap.setView(e.geocode.center, 14); placeMarker(e.geocode.center); 
    }).addTo(pickerMap);
    
    pickerMap.on('click', function(e) { placeMarker(e.latlng); });
    setTimeout(() => { pickerMap.invalidateSize(); }, 500);

    if (document.getElementById("hidden_lat").value) { placeMarker({lat: startLat, lng: startLng}); }

    new Choices('#currentCrop', { searchEnabled: true, itemSelectText: '', noResultsText: 'لا يوجد محصول بهذا الاسم' });
  });

  function placeMarker(latlng) {
    if (mapMarker) pickerMap.removeLayer(mapMarker);
    mapMarker = L.marker(latlng).addTo(pickerMap);
    document.getElementById("hidden_lat").value = latlng.lat;
    document.getElementById("hidden_lng").value = latlng.lng;
    document.getElementById("selected-coords").innerText = "✓ تم تحديد موقع أرضك بنجاح";
  }

  function getLocation() {
    if (navigator.geolocation) {
      document.getElementById("gps-text").innerText = "جاري التحديد...";
      navigator.geolocation.getCurrentPosition((pos) => {
          let latlng = { lat: pos.coords.latitude, lng: pos.coords.longitude };
          placeMarker(latlng); pickerMap.setView(latlng, 14);
          document.getElementById("gps-text").innerText = "✓ تم التحديد بنجاح";
        }, () => { document.getElementById("gps-text").innerText = "فشل التحديد"; }
      );
    }
  }

  // التحكم في واجهة الـ Wizard فقط (بدون أي تخزين بيانات)
  let currentStep = 1; const totalSteps = 4;
  function changeStep(n) {
    if (n === 1 && currentStep === totalSteps) {
      document.getElementById("nextBtn").innerText = "جاري المعالجة...";
      document.getElementById('assessmentForm').submit(); // إرسال الفورم للكنترولر
      return;
    }
    document.getElementById(`step-${currentStep}`).classList.remove("active");
    currentStep += n;
    document.getElementById(`step-${currentStep}`).classList.add("active");
    
    document.getElementById("prevBtn").style.display = currentStep === 1 ? "none" : "block";
    document.getElementById("nextBtn").innerText = currentStep === totalSteps ? "تحليل البيانات" : "التالي";
    document.getElementById("progressLine").style.width = (((currentStep - 1) / (totalSteps - 1)) * 100) + "%";
    for (let i = 1; i <= totalSteps; i++) {
      let ind = document.getElementById(`ind-${i}`); ind.className = "step-indicator";
      if (i < currentStep) ind.classList.add("completed"); if (i === currentStep) ind.classList.add("active");
    }
  }
</script>
</body>
</html>