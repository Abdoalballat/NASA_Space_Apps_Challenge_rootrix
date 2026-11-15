<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rootrix | Smart Agriculture</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root { --primary: #002F37; --blue: #167208; --light: #F4FFEC; --olive: #167208; --sage: #7EDE56; --white: #ffffff; --bg: #F4FFEC; }
* { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }
body { background: var(--bg); color: var(--primary); font-family: 'Alexandria', sans-serif; overflow-x: hidden; }
a { text-decoration: none; color: inherit; }
button { font-family: inherit; cursor: pointer; }
.container { width: min(1240px, 92%); margin: auto; }
header { padding-top: 16px; }
.navbar { height: 78px; background: rgba(255,255,255,.96); border: 1px solid #e9ece8; border-radius: 60px; padding: 0 35px; display: flex; align-items: center; justify-content: space-between; direction: ltr; box-shadow: 0 5px 25px #002F3708; }
.logo { font-size: 25px; font-weight: 800; letter-spacing: -1.5px; color: var(--primary); white-space: nowrap; }
.logo span { color: var(--olive); }
.nav-links { display: flex; align-items: center; gap: 34px; direction: rtl; }
.nav-links a { color: #555e59; font-size: 13px; font-weight: 600; transition: .3s; }
.nav-links a:hover { color: var(--olive); }
.nav-actions { display: flex; align-items: center; gap: 12px; }
.outline-btn { background: white; border: 1px solid #e2e5e1; color: var(--primary); padding: 12px 22px; border-radius: 40px; font-size: 12px; font-weight: 700; }
.nav-cta { background: var(--olive); color: white; border: none; padding: 13px 25px; border-radius: 40px; font-size: 12px; font-weight: 700; transition: .3s; }
.nav-cta:hover { background: var(--primary); }
.menu-toggle { display: none; border: 0; background: transparent; font-size: 25px; color: var(--primary); }
.hero { min-height: 650px; display: grid; grid-template-columns: 1fr 1fr; align-items: center; gap: 55px; padding: 65px 0 85px; }
.hero-content { animation: appear .8s ease both; }
.eyebrow { display: inline-flex; align-items: center; gap: 9px; padding: 10px 17px; border-radius: 40px; background: #e8ede5; color: var(--olive); font-size: 11px; font-weight: 700; margin-bottom: 25px; }
.dot { width: 8px; height: 8px; border-radius: 50%; background: var(--olive); }
h1 { font-size: clamp(37px, 4.3vw, 59px); line-height: 1.6; font-weight: 800; margin-bottom: 20px; color: var(--primary); }
h1 span { color: var(--olive); }
.hero-desc { max-width: 510px; color: #778078; font-size: 14px; line-height: 2.3; margin-bottom: 30px; }
.hero-actions { display: flex; gap: 13px; flex-wrap: wrap; max-width: 510px; }
.primary-btn { border: none; background: var(--primary); color: white; padding: 16px 26px; border-radius: 40px; font-size: 14px; font-weight: 700; transition: .3s; width: 100%; cursor: pointer; }
.primary-btn:hover { background: var(--olive); transform: translateY(-3px); }
.ai-disclaimer { display: flex; align-items: flex-start; gap: 15px; background-color: #fffaf0; border: 1px solid #fde4c8; border-right: 4px solid #f39c12; padding: 16px 20px; border-radius: 12px; margin-top: 30px; box-shadow: 0 5px 15px rgba(0, 47, 55, 0.03); }
.disclaimer-icon { font-size: 22px; line-height: 1; }
.disclaimer-text { font-size: 12px; color: var(--primary); line-height: 1.8; }
.disclaimer-text strong { color: #d35400; margin-left: 5px; }
.hero-visual { height: 475px; position: relative; }
.hero-image { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; display: block; }
.image-shade { position: absolute; inset: 0; background: linear-gradient(180deg, transparent 50%, #002F3770 100%); pointer-events: none; }
.image-tag { position: absolute; top: 20px; left: 20px; direction: ltr; background: white; border-radius: 30px; padding: 12px 17px; font-size: 10px; font-weight: 700; color: var(--primary); }
.image-tag span { color: var(--olive); margin-right: 5px; }
.floating-card { position: absolute; bottom: 25px; right: -25px; background: white; border-radius: 8px; padding: 20px 24px; box-shadow: 0 15px 40px #002F3720; min-width: 190px; }
.floating-card small { font-size: 10px; color: #89918a; }
.floating-card h3 { font-size: 27px; font-weight: 800; direction: ltr; text-align: right; margin: 5px 0; }
.floating-card p { color: var(--olive); font-size: 10px; font-weight: 700; }
.stats { display: grid; grid-template-columns: repeat(3,1fr); background: white; padding: 30px 15px; border-radius: 12px; border: 1px solid #e9ede7; margin-bottom: 110px; }
.stat { text-align: center; border-left: 1px solid #e9ede7; }
.stat:last-child { border: none; }
.stat h2 { font-size: 28px; color: var(--olive); font-weight: 800; }
.stat p { color: #879087; font-size: 11px; margin-top: 6px; }
.how { padding-bottom: 110px; }
.section-heading { text-align: center; margin-bottom: 45px; }
.section-heading .label { color: var(--olive); font-size: 11px; letter-spacing: 2px; font-weight: 800; }
.section-heading h2 { font-size: 31px; margin: 13px 0; }
.section-heading p { color: #89918a; font-size: 12px; }
.steps { display: grid; grid-template-columns: repeat(3,1fr); gap: 22px; }
.step-card { background: white; border: 1px solid #e8ece6; padding: 32px 27px; border-radius: 12px; transition: .3s; }
.step-card:hover { transform: translateY(-7px); border-color: var(--sage); box-shadow: 0 15px 35px #002F370c; }
.step-number { color: var(--blue); font-size: 11px; font-weight: 700; direction: ltr; text-align: left; }
.step-icon { width: 58px; height: 58px; background: var(--light); color: var(--primary); display: grid; place-items: center; border-radius: 12px; font-size: 26px; margin: 25px 0 20px; }
.step-card:nth-child(2) .step-icon { background: #e8ebef; }
.step-card:nth-child(3) .step-icon { background: #e8ede5; }
.step-card h3 { font-size: 16px; margin-bottom: 12px; }
.step-card p { font-size: 12px; color: #89918a; line-height: 2.2; }
.cta { background: var(--primary); color: white; border-radius: 12px; padding: 65px 25px; text-align: center; margin-bottom: 90px; position: relative; overflow: hidden; }
.cta h2 { font-size: 30px; margin-bottom: 14px; }
.cta p { font-size: 12px; color: #c4cec5; margin-bottom: 28px; }
.cta button { background: var(--sage); color: var(--primary); padding: 15px 27px; border: none; border-radius: 40px; font-size: 12px; font-weight: 800; }
.cta::before { content: ""; position: absolute; width: 250px; height: 250px; border: 1px solid #ffffff18; border-radius: 50%; top: -150px; right: -50px; }
footer { border-top: 1px solid #e3e8e0; padding: 28px 0; }
.footer-content { display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap; }
.footer-content p { color: #8b938b; font-size: 10px; }
.reveal { opacity: 0; transform: translateY(25px); transition: .7s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }
@keyframes appear { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

@media(max-width: 900px) { .nav-links { gap: 15px; } .navbar { padding: 0 22px; } .hero { gap: 25px; } .hero-visual { height: 390px; } }
@media(max-width: 680px) {
  header { padding-top: 10px; } .navbar { height: 67px; padding: 0 18px; } .logo { font-size: 21px; } .menu-toggle { display: block; }
  .nav-links { display: none; position: absolute; top: 85px; right: 4%; left: 4%; background: white; padding: 22px; border-radius: 15px; flex-direction: column; align-items: stretch; z-index: 20; box-shadow: 0 15px 30px #002F3718; }
  .nav-links.active { display: flex; } .nav-actions .outline-btn { display: none; } .nav-cta { padding: 10px 16px; font-size: 10px; }
  .hero { grid-template-columns: 1fr; padding: 45px 0 65px; } .hero-content { order: 1; } .hero-visual { order: 2; height: 310px; }
  h1 { font-size: 36px; } .hero-desc { font-size: 12px; } .floating-card { right: 12px; bottom: 12px; }
  .stats { padding: 23px 5px; margin-bottom: 75px; } .stat h2 { font-size: 20px; } .stat p { font-size: 9px; }
  .section-heading h2 { font-size: 23px; } .steps { grid-template-columns: 1fr; } .cta { padding: 45px 18px; } .cta h2 { font-size: 23px; }
  .footer-content { justify-content: center; text-align: center; }
}
</style>
</head>
<body>

<header class="container">
  <nav class="navbar">
    <a href="{{ route('home') }}" class="logo">Rootrix</a>
    <div class="nav-links" id="navLinks">
      <a href="{{ route('home') }}">الرئيسية</a>
      <a href="#how">كيف يعمل النظام</a>
      <a href="#about">عن المنصة</a>
      <a href="#contact">تواصل معنا</a>
    </div>
    <div class="nav-actions">
      <button class="nav-cta" onclick="startAssessment()">ابدأ التحليل</button>
      <button class="menu-toggle" id="menuToggle">☰</button>
    </div>
  </nav>
</header>

<main>
<section class="container hero">
  <div class="hero-content">
    <div class="eyebrow"><span class="dot"></span> مستقبل الزراعة يبدأ من أرضك</div>
    <h1>افهم أرضك،<br><span>واختر مستقبلها.</span></h1>
    <p class="hero-desc">اكتشف الإمكانيات الحقيقية لأرضك من خلال بيانات الأقمار الصناعية والتحليل المناخي. احصل على استراتيجيات زراعية ذكية تساعدك على توفير المياه، تحسين التربة، وزيادة إنتاجية محاصيلك.</p>
    <div class="hero-actions"><button class="primary-btn" onclick="startAssessment()">شيك على أرضك ←</button></div>
    <div class="ai-disclaimer">
      <div class="disclaimer-icon">💡</div>
      <div class="disclaimer-text"><strong>ملاحظة هامة:</strong> هذه الأداة تعتمد على الذكاء الاصطناعي لدعم اتخاذ القرار، وقد تحتمل التوصيات الصواب أو الخطأ. يرجى مراجعتها مع المهندس الزراعي.</div>
    </div>
  </div>
  <div class="hero-visual">
    <!-- الصورة باستخدام asset -->
    <img class="hero-image" src="{{ asset('95ce00793924fa45823b4ea002a0853b.jpg') }}" alt="Agricultural landscape">
    <div class="image-shade"></div>
    <div class="image-tag"><span>●</span> EARTH OBSERVATION</div>
    <div class="floating-card"><small>Smart Field Analysis</small><h3>94.8%</h3><p>Field Suitability Score</p></div>
  </div>
</section>

<section class="container stats reveal">
  <div class="stat"><h2>NASA</h2><p>بيانات رصد الأرض</p></div>
  <div class="stat"><h2>AI</h2><p>تحليل وتوصيات ذكية</p></div>
  <div class="stat"><h2>24/7</h2><p>متابعة الظروف المناخية</p></div>
</section>

<section class="container how" id="how">
  <div class="section-heading reveal">
    <span class="label">HOW IT WORKS</span><h2>من أرضك إلى القرار الصحيح</h2><p>ثلاث خطوات بسيطة لفهم أرضك واختيار أفضل استراتيجية زراعية.</p>
  </div>
  <div class="steps">
    <article class="step-card reveal">
      <div class="step-number">01 / INPUT</div><div class="step-icon"><i class="fa-solid fa-map-pin" style="color: rgb(230, 25, 25);"></i></div>
      <h3>حدد بيانات مزرعتك</h3><p>أدخل موقع الأرض ومساحتها والمحصول الحالي ونظام الري والموارد المتاحة.</p>
    </article>
    <article class="step-card reveal">
      <div class="step-number">02 / ANALYSIS</div><div class="step-icon">🛰️</div>
      <h3>حلل بيانات الأرض</h3><p>نستخدم بيانات الأقمار الصناعية والمناخ لفهم ظروف الأرض وتقييم المخاطر.</p>
    </article>
    <article class="step-card reveal">
      <div class="step-number">03 / RESULTS</div><div class="step-icon">🌳</div>
      <h3>اكتشف أفضل المحاصيل</h3><p>احصل على دورات زراعية مقترحة ومقارنة واضحة للفوائد والمخاطر.</p>
    </article>
  </div>
</section>

<section class="container" id="about">
  <div class="cta reveal" id="contact">
    <h2>كل قرار زراعي يبدأ بفهم الأرض.</h2><p>ابدأ رحلتك نحو زراعة أكثر ذكاءً واستدامة.</p>
    <button onclick="startAssessment()">شيك على ارضك←</button>
  </div>
</section>
</main>

<footer>
  <div class="container footer-content">
    <a href="{{ route('home') }}" class="logo">Rootrix</a>
    <p>© 2026 Rootrix Intelligence. All Rights Reserved.</p>
    <p>Earth Data. Smarter Decisions.</p>
  </div>
</footer>

<script>
const menuToggle = document.getElementById("menuToggle");
const navLinks = document.getElementById("navLinks");
menuToggle.addEventListener("click", () => { navLinks.classList.toggle("active"); menuToggle.textContent = navLinks.classList.contains("active") ? "✕" : "☰"; });
navLinks.querySelectorAll("a").forEach(link => { link.addEventListener("click", () => { navLinks.classList.remove("active"); menuToggle.textContent = "☰"; }); });

const observer = new IntersectionObserver(entries => { entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add("visible"); observer.unobserve(entry.target); }}); }, { threshold: 0.15 });
document.querySelectorAll(".reveal").forEach(element => { observer.observe(element); });

function startAssessment() { window.location.href = "{{ route('assessment.index') }}"; }
</script>
</body>
</html>