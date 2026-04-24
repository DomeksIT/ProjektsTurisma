@extends('layouts.admin')
@section('content')
<style>
.form-dark input,
.form-dark textarea,
.form-dark select {
   background: #1e1e2f !important;
   border: 1px solid #333 !important;
   color: #fff !important;
}
.form-dark input::placeholder,
.form-dark textarea::placeholder {
   color: #aaa;
}
.form-dark input:focus,
.form-dark textarea:focus,
.form-dark select:focus {
   background: #1e1e2f !important;
   color: #fff !important;
   border-color: #28a745 !important;
   box-shadow: none !important;
}
</style>
<div class="d-flex justify-content-center align-items-center" style="min-height:70vh;">
<div style="width:420px">
<h3 class="text-center text-white mb-4">
Rediģēt tūri
</h3>
<div class="card bg-dark p-4 form-dark">
<form method="POST" action="/admin/tours/update/{{ $tour->id }}" enctype="multipart/form-data">
@csrf
<input class="form-control mb-3" name="title" value="{{ old('title', $tour->title) }}" placeholder="Nosaukums" maxlength="50">
@error('title')
<div style="color:red">{{ $message}}</div>
@enderror
<input class="form-control mb-3" type="number" name="price" value="{{ old('price', $tour->price) }}" placeholder="Cena">
@error('price')
<div style="color:red">{{ $message}}</div>
@enderror
<div class="mb-3">
<label class="text-white-50">Kategorija</label>
<select name="category_id" class="form-control">
<option value="">Nav kategorijas</option>
@foreach($categories as $category)
<option value="{{ $category->id }}"
@if($tour->category_id == $category->id) selected @endif>
{{ $category->name }}
</option>
@endforeach
</select>
</div>
<label class="text-white-50">
Sākuma datums
</label>
<input class="form-control mb-3" type="date" name="start_date" value="{{ old('start_date', $tour->start_date) }}">
@error('start_date')
<div style="color:red">{{ $message}}</div>
@enderror
<label class="text-white-50">
Beigu datums
</label>
<input class="form-control mb-3" type="date" name="end_date" value="{{old('end_date', $tour->end_date) }}">
@error('end_date')
<div style="color:red">{{ $message}}</div>
@enderror
<textarea class="form-control mb-3" name="description" rows="3" placeholder="Apraksts" maxlength="50">{{ old('description',$tour->description) }}</textarea>
@error('description')
<div style="color:red">{{ $message}}</div>
@enderror
<label class="text-white-50">
Mainīt bildi
</label>
<input class="form-control mb-4" type="file" name="image">
<button class="btn btn-success w-100">
Saglabāt
</button>
</form>
<a href="/admin/tours" class="btn btn-outline-light w-100 mt-3">
Atpakaļ
</a>
</div>
</div>
</div>
@endsection