@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
<h2 class="text-white">Ceļojumi</h2>
<div>
<a href="/admin/bookings" class="btn btn-outline-light me-2">
Pieteikumi
</a>
<a href="/admin/tours/create" class="btn btn-success">
Pievienot tūri
</a>
</div>
</div>
<div class="row g-4">
@foreach($tours as $tour)
<div class="col-md-4">
<div class="card bg-dark text-white">
<img src="{{ asset('storage/'.$tour->image) }}"
style="height:200px;object-fit:cover;width:100%">
<div class="p-3">
<h5>{{ $tour->title }}</h5>
<div class="text-white-50 mb-2">
{{ $tour->start_date }} - {{ $tour->end_date }}
</div>
<div class="mb-3">
<strong>{{ $tour->price }}€</strong>
</div>
<div class="d-flex gap-2">
<a href="/admin/tours/edit/{{ $tour->id }}"
class="btn btn-warning w-100">
✏ Labot
</a>
<a href="/admin/tours/delete/{{ $tour->id }}"
class="btn btn-danger w-100"
onclick="return confirm('Dzēst tūri?')">
🗑 Dzēst
</a>
</div>
</div>
</div>
</div>
@endforeach
</div>
@endsection