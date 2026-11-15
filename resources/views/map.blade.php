<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rootrix | خريطة الأقمار الصناعية</title>
<link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
/* CSS الثابت */
:root { --primary: #002F37; --blue: #167208; --light: #F4FFEC; --olive: #167208; --sage: #7EDE56; --white: #ffffff; --bg: #F4FFEC; --border: #e9ece8; }
* { margin: 0; padding: 0; box-sizing: border-box; }
body { background: var(--bg); color: var(--primary); font-family: 'Alexandria', sans-serif; min-height: 100vh; display: flex; flex-direction: column; }
a { text-decoration: none; color: inherit; } button { font-family: inherit; cursor: pointer; }
.container { width: min(1200px, 95%); margin: auto; }
header { padding-top: 16px; margin-bottom: 25px; z-index: 1000; position: relative; }
.navbar { height: 70px; background: rgba(255,255,255,.96); border: 1px solid var(--border); border-radius: 40px; padding: 0 30px; display: flex; align-items: center; justify-content: space-between; direction: ltr; box-shadow: 0 5px 20px #002F3708; }
.logo { font-size: 24px; font-weight: 800; letter-spacing: -1.5px; color: var(--primary); } .logo span { color: var(--sage); }
.nav-actions { direction: rtl; } .outline-btn { background: white; border: 1px solid #e2e5e1; color: var(--primary); padding: 10px 20px; border-radius: 40px; font-size: 13px; font-weight: 700; transition: .3s; } .outline-btn:hover { border-color: var(--olive); color: var(--olive); }
main { flex: 1; display: flex; align-items: center; justify-content: center; padding-bottom: 40px; }
.map-wrapper { position: relative; width: 100%; height: 650px; background: var(--white); border-radius: 20px; border: 1px solid var(--border); box-shadow: 0 15px 40px rgba(0, 47, 55, 0.08); overflow: hidden; }
#map { width: 100%; height: 100%; background: #000; z-index: 1; }
.map-panel { position: absolute; top: 20px; right: 20px; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); padding: 20px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,47,55,0.15); border: 1px solid rgba(255, 255, 255, 0.5); z-index: 500; width: 280px; }
.map-panel h3 { font-size: 15px; margin-bottom: 15px; border-bottom: 1px solid #e0e0e0; padding-bottom: 10px; color: var(--primary); font-weight: 800; }
.layer-option { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; cursor: pointer; padding: 10px; border-radius: 10px; transition: 0.3s; } .layer-option:hover { background: rgba(126, 222, 86, 0.15); } .layer-option input[type="radio"] { accent-color: var(--olive); transform: scale(1.2); } .layer-icon { font-size: 16px; color: var(--olive); width: 20px; text-align: center; } .layer-label { font-size: 14px; font-weight: 700; display: block; color: var(--primary); margin-bottom: 2px;} .layer-desc { font-size: 11px; color: #666; }
.map-legend { position: absolute; bottom: 30px; left: 20px; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); padding: 15px 20px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,47,55,0.15); border: 1px solid rgba(255, 255, 255, 0.5); z-index: 500; } .legend-title { font-size: 13px; font-weight: 800; margin-bottom: 12px; color: var(--primary); } .legend-scale { display: flex; height: 12px; width: 220px; border-radius: 6px; background: linear-gradient(to right, #4a6344, #738f6b, #b5c4b5); margin-bottom: 8px; } .legend-labels { display: flex; justify-content: space-between; font-size: 11px; font-weight: 600; color: #444; direction: ltr; }
@media(max-width: 768px) { .map-wrapper { height: 450px; } .map-panel { top: 10px; right: 10px; width: 175px; padding: 12px; } .map-legend { bottom: 15px; left: 10px; width: 190px; } }
</style>
</head>
<body>
<header class="container">
  <nav class="navbar">
    <a href="{{ route('home') }}" class="logo">Rootrix</a>
    <div class="nav-actions">
      <!-- لو حاببها ترجع للرئيسية خليها route('home') -->
      <a href="{{ route('assessment.index') }}" class="outline-btn">← العودة للخلف</a>
    </div>
  </nav>
</header>

<main class="container">
  <div class="map-wrapper">
    <div id="map"></div>
    <div class="map-panel">
      <h3>طبقات الأقمار الصناعية 🛰️</h3>
      <label class="layer-option">
        <input type="radio" name="mapLayer" value="base" checked onchange="changeLayer('base')">
        <i class="fa-solid fa-satellite layer-icon"></i><div><span class="layer-label">الخريطة الأساسية</span><span class="layer-desc">عرض القمر الصناعي العادي</span></div>
      </label>
      <label class="layer-option">
        <input type="radio" name="mapLayer" value="smap" onchange="changeLayer('smap')">
        <i class="fa-solid fa-droplet layer-icon" style="color: #3498db;"></i><div><span class="layer-label">رطوبة التربة (SMAP)</span><span class="layer-desc">تحليل المياه في الطبقات السطحية</span></div>
      </label>
      <label class="layer-option">
        <input type="radio" name="mapLayer" value="modis" onchange="changeLayer('modis')">
        <i class="fa-solid fa-temperature-half layer-icon" style="color: #e74c3c;"></i><div><span class="layer-label">الإجهاد الحراري (MODIS)</span><span class="layer-desc">قياس حرارة الغطاء النباتي</span></div>
      </label>
    </div>
    <div class="map-legend">
      <div class="legend-title" id="legendTitle">الرؤية الطبيعية (Landsat)</div>
      <div class="legend-scale" id="legendScale"></div>
      <div class="legend-labels" id="legendLabels"><span>الطبيعة</span><span>النباتات</span><span>المياه</span></div>
    </div>
  </div>
</main>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  let map = L.map('map', { zoomControl: false, center: [26.8206, 30.8025], zoom: 5, minZoom: 2, maxZoom: 12 });
  L.control.zoom({ position: 'topleft' }).addTo(map);
  let baseLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { attribution: 'Tiles &copy; Esri', maxZoom: 18 });
  let currentLayer = baseLayer; map.addLayer(currentLayer);

  function changeLayer(layerType) {
    if (currentLayer !== baseLayer) map.removeLayer(currentLayer);
    if (!map.hasLayer(baseLayer)) map.addLayer(baseLayer);
    
    const d = new Date(); d.setDate(d.getDate() - 2); const dateStr = d.toISOString().split('T')[0];
    const lgTitle = document.getElementById('legendTitle'), lgScale = document.getElementById('legendScale'), lgLabels = document.getElementById('legendLabels');

    if (layerType === 'base') {
      currentLayer = baseLayer; 
      lgTitle.textContent = "الرؤية الطبيعية (Landsat)"; lgScale.style.background = "linear-gradient(to right, #4a6344, #738f6b, #b5c4b5)"; lgLabels.innerHTML = `<span>الطبيعة</span><span>النباتات</span><span>المياه</span>`;
    } else if (layerType === 'smap') {
      currentLayer = L.tileLayer(`https://gibs.earthdata.nasa.gov/wmts/epsg3857/best/SMAP_L4_Active_Passive_Surface_Soil_Moisture/default/${dateStr}/GoogleMapsCompatible_Level6/{z}/{y}/{x}.png`, { opacity: 0.8, attribution: 'NASA GIBS', maxZoom: 6 }).addTo(map);
      lgTitle.textContent = "مؤشر رطوبة التربة (SMAP)"; lgScale.style.background = "linear-gradient(to right, #d32f2f, #fbc02d, #388e3c, #1976d2)"; lgLabels.innerHTML = `<span>منخفض</span><span>معتدل</span><span>مرتفع</span>`;
    } else if (layerType === 'modis') {
      currentLayer = L.tileLayer(`https://gibs.earthdata.nasa.gov/wmts/epsg3857/best/MODIS_Terra_Land_Surface_Temp_Day/default/${dateStr}/GoogleMapsCompatible_Level7/{z}/{y}/{x}.png`, { opacity: 0.7, attribution: 'NASA GIBS', maxZoom: 7 }).addTo(map);
      lgTitle.textContent = "الإجهاد الحراري (MODIS)"; lgScale.style.background = "linear-gradient(to right, #1976d2, #388e3c, #fbc02d, #d32f2f)"; lgLabels.innerHTML = `<span>بارد</span><span>معتدل</span><span>حار جداً</span>`;
    }
  }
</script>
</body>
</html>