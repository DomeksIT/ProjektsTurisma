@extends('layouts.app', ['title'=>'Ceļojumi-Selena L'])
@section('content')
<div id="celojumi" class="d-flex align-items-end justify-content-between mb-4">
<div>
<h2 class="text-white fw-bold mb-1">Ceļojumi</h2>
<div class="text-white-50">Izvēlies savu nākamo galamērķi</div>
</div>
</div>
<div class="card bg-dark border-0 p-3 mb-4">
    <div class="mb-3">
<div class="text-white fw-semibold">
🔎 Meklē un filtrē ceļojumus
</div>
<div class="text-white-50 small">
Izmanto meklēšanu vai filtrus, lai ātri atrastu sev piemērotu ceļojumu
</div>
</div>
<form method="GET" id="filterForm">
<div class="row g-2 align-items-end">
<div class="col-md-3">
<input type="text" name="search" class="form-control form-dark" placeholder="🔍 Meklēt..." value="{{ request('search') }}">
</div>
<div class="col-md-2">
<input type="number" name="price_min" class="form-control form-dark" placeholder="No €" value="{{ request('price_min') }}">
</div>
<div class="col-md-2">
<input type="number" name="price_max" class="form-control form-dark" placeholder="Līdz €" value="{{ request('price_max') }}">
</div>
<div class="col-md-3">
<select name="category_id" class="form-control form-dark">
<option value="">📂 Visas kategorijas</option>
@foreach($categories as $cat)
<option value="{{ $cat->id }}"
{{ request('category_id') == $cat->id ? 'selected' : '' }}>
{{ $cat->name }}
</option>
@endforeach
</select>
</div>
<div class="col-md-2 d-flex gap-2">
<button class="btn btn-success w-100">
🔍
</button>
<a href="/tours" class="btn btn-danger w-100">
✖
</a>
</div>
</div>
</form>
</div>
@if($tours->count()==0)
<div class="alert alert-warning">
Ceļojumu nav
</div>
@endif
<div class="row g-4">
@foreach ($tours as $tour)
@php
$img = asset('storage/tours/thumbs/' . basename($tour->image));
@endphp
<div class="col-md-6 col-lg-4">
<div class="card-tour h-100">
<div class="position-relative">
<img src="{{ $img }}"
class="w-100"
style="height:220px; object-fit:cover;"
onerror="this.src='{{ asset('images/tours/default.png') }}';"
alt="{{ $tour->title }}">
<div class="price-badge">
{{ $tour->price }} {{ $tour->currency }}
</div>
</div>
<div class="p-4">
<h5 class="text-white fw-bold">
{{ $tour->title }}
</h5>
<div class="text-info small mb-1">
{{ $tour->category ?? 'Nav kategorijas' }}
</div>
<div class="text-white-50 small mb-3">
{{ $tour->start_date }} - {{ $tour->end_date }}
</div>
<a class="btn btn-accent w-100"
href="/tours/{{ $tour->id }}">
Skatīt tūri
</a>
</div>
</div>
</div>
@endforeach
</div>
<div class="mt-5 d-flex justify-content-center">
{{ $tours->links() }}
</div>
<script>
let timeout = null;
const mainInput = document.getElementById('search_main');
mainInput.addEventListener('input', function () {
   clearTimeout(timeout);
   timeout = setTimeout(() => {
       let params = new URLSearchParams(window.location.search);
       if (mainInput.value) {
           params.set('search_main', mainInput.value);
       } else {
           params.delete('search_main');
       }
       window.location.href = window.location.pathname + '?' + params.toString();
   }, 400);
});
const customInput = document.getElementById('search_custom');
customInput.addEventListener('input', function () {
   clearTimeout(timeout);
   timeout = setTimeout(() => {
       let params = new URLSearchParams(window.location.search);
       if (customInput.value) {
           params.set('search_custom', customInput.value);
       } else {
           params.delete('search_custom');
       }
       window.location.href = window.location.pathname + '?' + params.toString();
   }, 400);
});
</script>
 
@endsection