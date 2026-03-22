<!DOCTYPE html>
<html lang="lv">
<head>
<meta charset="UTF-8">
<title>{{ $tour->title }}</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>

body{
background:#0b1220;
color:white;
font-family:system-ui;
min-height:100vh;
display:flex;
justify-content:center;
}
.container-box{
width:800px;
padding:50px 20px;
}
.card{
background:#111927;
border:none;
border-radius:12px;
}
label{
color:#ffffff;
font-weight:500;
margin-bottom:6px;
display:block;
}
.form-control{
background:#020617;
border:1px solid #1e293b;
color:white;
}
.form-control::placeholder{
color:#94a3b8;
}
.form-control:focus{
background:#020617;
color:white;
border:1px solid #22c55e;
box-shadow:none;
}
.is-invalid{
border:1px solid #ef4444 !important;
}
.invalid-feedback{
color:#ef4444;
font-size:14px;
margin-top:5px;
display:block;
}
</style>
</head>
<body>
<div class="container-box">
<a href="/tours" class="btn btn-outline-light mb-4">
Atpakaļ uz katalogu
</a>
<h1 class="mb-3">{{ $tour->title }}</h1>
<div class="text-info mb-2">
Kategorija: {{ $tour->category ?? 'Nav kategorijas' }}
</div>
<div class="mb-2">
<b>Cena:</b> {{ $tour->price }} {{ $tour->currency }}
</div>
<div class="mb-3">
<b>Datumi:</b> {{ $tour->start_date }} - {{ $tour->end_date }}
</div>
<div class="mb-4">
<b>Apraksts:</b><br>
{{ $tour->description }}
</div>
<hr class="mb-5">
@if(session('ok'))
<div class="alert alert-success">
{{ session('ok') }}
</div>
@endif
<h2 class="mb-4">Pieteikšanās</h2>
<div class="card p-4">
<form method="POST" action="/tours/{{ $tour->id }}/apply">
@csrf
<div class="mb-3">
<label>Vārds un uzvārds</label>
<input
type="text"
name="name"
value="{{ old('name') }}"
class="form-control @error('name') is-invalid @enderror"
placeholder="Ievadiet vārdu un uzvārdu">
<small class="text-white">Tikai burti, vismaz 3 simboli</small>
@error('name')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror
</div>
<div class="mb-3">
<label>E-pasts</label>
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
<div class="mb-3">
<label>Telefons</label>
<input
type="text"
name="phone"
value="{{ old('phone') }}"
class="form-control @error('phone') is-invalid @enderror"
placeholder="+371 20000000">
<small class="text-white">
Var izmantot + un ciparus (8-15 cipari)
</small>
@error('phone')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror
</div>
<button class="btn btn-success w-100">
Pieteikties
</button>
</form>
</div>
</div>
</body>
</html>
 