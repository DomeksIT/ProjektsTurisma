<!DOCTYPE html>
<html lang="lv">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $title ?? 'Domeks - Ceļojumi' }}</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
html {
   scroll-behavior: smooth;
}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark nav-glass sticky-top">
<div class="container">
<div class="d-flex align-items-center gap-2">
<img src="{{ asset('images/tours/logo.png') }}"
            style="height:40px; border-radius:8px;">
<div>
<div class="fw-bold">Domeks Travel</div>
<div class="small text-white-50">Tūrisma aģentūra</div>
</div>
</div>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="nav">
<ul class="navbar-nav ms-auto gap-lg-2">
<li class="nav-item">
<a class="nav-link" href="#celojumi">
Ceļojumi
</a>
</li>
<li class="nav-item">
<a class="nav-link" href="#kontakti">
Kontakti
</a>
</li>
<li class="nav-item">
<a class="nav-link" href="/admin/login">
🔐 Admin
</a>
</li>
</ul>
</div>
</div>
</nav>
<header class="hero">
<div class="container py-5 position-relative">
<div class="row align-items-center g-4">
<div class="col-lg-7">
<div class="hero-tags mb-3">
<span>🔒 Droši</span>
<span>⚡ Ātri</span>
<span>👌 Ērti</span>
</div>
<h1 class="display-5 fw-bold text-white mb-3">
Ceļojumi, kas izskatās kā sapnis
</h1>
<p class="lead text-white-50 mb-4">
Izvēlies galamērķi, apskati cenas un piesakies tiešsaistē.
Mēs visu sakārtosim.
</p>
<div class="hero-stats mt-4 d-flex gap-4">
<div class="stat">
<div class="num">10+</div>
<div class="lbl">Galamērķi</div>
</div>
<div class="stat">
<div class="num">24/7</div>
<div class="lbl">Atbalsts</div>
</div>
<div class="stat">
<div class="num">100%</div>
<div class="lbl">Pieteikumi DB</div>
</div>
</div>
</div>
<div class="col-lg-5">
<div class="glass-card p-4">
<div class="text-white-50 small">
Ātra pieteikšanās
</div>
<div class="text-white fs-5 fw-semibold mt-1">
Atstāj kontaktus un mēs piezvanīsim
</div>
<div class="text-white-50 mt-2 small">
Darba laiks: 10:00-17:00
</div>
<a href="/request" class="btn btn-accent w-100 mt-3">
Sākt izvēli
</a>
</div>
</div>
</div>
</div>
</header>
<main class="container my-5">
   @yield('content')
</main>
<footer id="kontakti" class="footer">
<div class="container py-5">
<div class="row g-4">
<div class="col-lg-4">
<div class="h5 text-white fw-semibold mb-3">
               Kontakti
</div>
<div class="text-white-50">
    Rēzekne, Noliktavu iela<br>
    Tālr.: +371xxxxx<br>
    E-pasts: xxxxx@domeks.lv<br>
    Ārkārtas gadījumos: (371) xxxxxxxx
</div>
</div>
<div class="col-lg-4">
<div class="h5 text-white fw-semibold mb-3">
    Darba laiks
</div>
<div class="text-white-50">
    P.-Pk.: 10:00-17:00<br>
    S.-Sv.: Brīvdiena
</div>
</div>
<div class="col-lg-4">
<div class="h5 text-white fw-semibold mb-3">
               Atrašanas vieta
</div>
<div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
<iframe
   src="https://www.google.com/maps?q=56.5254707,27.3726608&output=embed"
   width="100%"
   height="250"
   style="border:0;"
   allowfullscreen=""
   loading="lazy">
</iframe>
</div>
</div>
</div>
<hr class="border-light opacity-25 my-4">
<div class="text-white-50 small">
       Domeks © {{ date('Y') }}
</div>
</div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/lv.js"></script>
</body>
</html>