@extends('layouts.app', ['title'=>'Ceļojumi-Selena L'])
@section('content')
<div id="celojumi" class="d-flex align-items-end justify-content-between mb-4">
<div>
<h2 class="text-white fw-bold mb-1">Ceļojumi</h2>
<div class="text-white-50">Izvēlies savu nākamo galamērķi</div>
</div>
</div>
@if($tours->count()==0)
<div class="alert alert-warning">
   Ceļojumu nav
</div>
@endif
<div class="row g-4">
@foreach ($tours as $tour)
@php
$img = asset('storage/'.$tour->image);
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
@endsection