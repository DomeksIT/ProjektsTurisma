<!DOCTYPE html>
<html lang="lv">
<head>
<meta charset="UTF-8">
<title>Individuālais pieprasījums</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
body {
   background: radial-gradient(circle at top, #0f1b35, #0b1220);
   min-height: 100vh;
   display: flex;
   align-items: center;
   justify-content: center;
}
.btn-back {
   position: absolute;
   top: 20px;
   left: 20px;
   padding: 8px 14px;
   background: rgba(255,255,255,0.05);
   border-radius: 12px;
   border: 1px solid rgba(255,255,255,0.1);
   color: white;
   text-decoration: none;
}
.btn-back:hover {
   background: #22c55e;
   color: black;
}
.glass-card {
   background: rgba(255,255,255,0.05);
   backdrop-filter: blur(14px);
   border-radius: 18px;
   border: 1px solid rgba(255,255,255,0.08);
}
.form-control {
   background: #0b1220;
   border: 1px solid rgba(255,255,255,0.08);
   color: #fff;
}
.form-control::placeholder {
   color: #ccc;
}
.form-control:focus {
   background: #0b1220;
   color: #fff;
   border-color: #22c55e;
}
.form-text {
   color: #ffffff !important;
}
.invalid-feedback {
   color: #ff6b6b;
}
.btn-accent {
   background: linear-gradient(90deg, #22c55e, #4ade80);
   border: none;
   color: black;
   font-weight: 600;
}
.input-group-text {
   background: #0b1220;
   border: 1px solid rgba(255,255,255,0.08);
   color: #22c55e;
   cursor: pointer;
}
</style>
</head>
<body>
<a href="/" class="btn-back">Atpakaļ</a>
<div class="col-lg-4">
<h3 class="text-white text-center mb-4">
   Individuālais pieprasījums
</h3>
<div class="glass-card p-4">
@if(session('success'))
<div class="alert alert-success">
   {{ session('success') }}
</div>
@endif
<form method="POST" action="/request">
@csrf
<div class="mb-3">
<label class="text-white">Vārds un uzvārds</label>
<input type="text"
class="form-control @error('name') is-invalid @enderror"
name="name"
value="{{ old('name') }}"
placeholder="Ievadiet vārdu un uzvārdu">
<div class="form-text">
   Tikai burti, vismaz 3 simboli
</div>
@error('name')
<div class="invalid-feedback d-block">
   {{ $message }}
</div>
@enderror
</div>
<div class="mb-3">
<label class="text-white">Telefons</label>
<input type="text"
class="form-control @error('phone') is-invalid @enderror"
name="phone"
value="{{ old('phone') }}"
placeholder="+371 20000000">
<div class="form-text">
   Var izmantot +, ciparus (8–15 simboli)
</div>
@error('phone')
<div class="invalid-feedback d-block">
   {{ $message }}
</div>
@enderror
<div class="mb-3">
<label class="text-white">E-pasts</label>
<input
type="email"
name="email"
value="{{ old('email') }}"
class="form-control @error('email') is-invalid @enderror"
placeholder="piemers@email.com">
@error('email')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror
</div>
</div>
<div class="mb-3">
<label class="text-white">Vēlamais galamērķis</label>
<input type="text"
class="form-control @error('destination') is-invalid @enderror"
name="destination"
value="{{ old('destination') }}"
placeholder="Kur vēlaties doties?">
@error('destination')
<div class="invalid-feedback d-block">
   {{ $message }}
</div>
@enderror
</div>
<div class="mb-3">
<label class="text-white">Datumi (no – līdz)</label>
<div class="input-group">
<input id="dates"
class="form-control @error('dates') is-invalid @enderror"
name="dates"
value="{{ old('dates') }}"
placeholder="Izvēlieties datumus">
<span class="input-group-text" id="calendar-btn">📅</span>
</div>
@error('dates')
<div class="invalid-feedback d-block">
   {{ $message }}
</div>
@enderror
</div>
<div class="mb-3">
<label class="text-white">Apraksts</label>
<textarea
class="form-control @error('description') is-invalid @enderror"
name="description"
placeholder="Papildus informācija...">{{ old('description') }}</textarea>
@error('description')
<div class="invalid-feedback d-block">
   {{ $message }}
</div>
@enderror
</div>
<button class="btn btn-accent w-100">
   Nosūtīt pieprasījumu
</button>
</form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/lv.js"></script>
<script>
const picker = flatpickr("#dates", {
   mode: "range",
   dateFormat: "Y-m-d",
   locale: "lv"
});
document.getElementById("calendar-btn").addEventListener("click", function () {
   picker.open();
});
</script>
</body>
</html>