@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-center align-items-center">
<div style="width:420px">
<h3 class="text-center text-white mb-4">
Rediģēt tūri
</h3>
<div class="card bg-dark p-4 shadow">
<form method="POST"
action="/admin/tours/update/{{ $tour->id }}"
enctype="multipart/form-data">
@csrf
<input
class="form-control mb-3"
name="title"
value="{{ $tour->title }}"
placeholder="Nosaukums">
<input
class="form-control mb-3"
type="number"
name="price"
value="{{ $tour->price }}"
placeholder="Cena">
<label class="text-white-50">
Sākuma datums
</label>
<input
class="form-control mb-3"
type="date"
name="start_date"
value="{{ $tour->start_date }}">
<label class="text-white-50">
Beigu datums
</label>
<input
class="form-control mb-3"
type="date"
name="end_date"
value="{{ $tour->end_date }}">
<textarea
class="form-control mb-3"
name="description"
rows="3"
placeholder="Apraksts">{{ $tour->description }}</textarea>
<label class="text-white-50">
Mainīt bildi
</label>
<input
class="form-control mb-4"
type="file"
name="image">
<button class="btn btn-success w-100">
Saglabāt
</button>
</form>
<a href="/admin/tours"
class="btn btn-outline-light w-100 mt-3">
Atpakaļ
</a>
</div>
</div>
</div>
@endsection