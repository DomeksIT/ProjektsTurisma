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
<div style="width:450px;">
<h3 class="text-center text-white mb-4">
Jauns ceļojums
</h3>
<div class="card bg-dark p-4 form-dark">
<form method="POST" action="/admin/tours/store" enctype="multipart/form-data">
@csrf
<div class="mb-3">
<input type="text" name="title" class="form-control" placeholder="Nosaukums" required maxlength="50">
</div>
<div class="mb-3">
<input type="number" name="price" class="form-control" placeholder="Cena" required>
</div>
<div class="mb-3">
<label class="text-white-50">Kategorija</label>
<select name="category_id" class="form-control">
<option value="">Nav kategorijas</option>
@foreach($categories as $category)
<option value="{{ $category->id }}">
{{ $category->name }}
</option>
@endforeach
</select>
</div>
<div class="mb-3">
<label class="text-white-50">Sākuma datums</label>
<input type="date" name="start_date" class="form-control" required>
</div>
<div class="mb-3">
<label class="text-white-50">Beigu datums</label>
<input type="date" name="end_date" class="form-control" required>
</div>
<div class="mb-3">
<textarea name="description" class="form-control" rows="3" placeholder="Apraksts" required maxlength="50"></textarea>
</div>
<div class="mb-4">
<label class="text-white-50">Bilde</label>
<input type="file" name="image" class="form-control" accept="image/*" required>
</div>
<button type="submit" class="btn btn-success w-100">
Pievienot tūri
</button>
</form>
<a href="/admin/tours" class="btn btn-outline-light w-100 mt-3">
Atpakaļ
</a>
</div>
</div>
</div>
@endsection