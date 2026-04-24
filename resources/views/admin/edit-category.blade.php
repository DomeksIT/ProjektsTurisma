@extends('layouts.admin')
@section('content')
<style>
.form-dark {
   background: rgba(255,255,255,0.05);
   border-radius: 12px;
   padding: 20px;
   max-width: 500px;
   margin: 40px auto;
}
.form-dark input {
   background: #1e1e2f !important;
   border: 1px solid #333 !important;
   color: #fff !important;
}
.form-dark input::placeholder {
   color: #aaa;
}
.form-dark input:focus {
   background: #1e1e2f !important;
   color: #fff !important;
   border-color: #28a745 !important;
   box-shadow: none !important;
}
</style>
<div class="container">
<h2 class="text-white text-center mb-4">Rediģēt kategoriju</h2>
<div class="form-dark">
<a href="/admin/categories" class="btn btn-outline-light btn-sm mb-3">
Atpakaļ
</a>
<form method="POST" action="/admin/categories/update/{{ $category->id }}">
@csrf
<input type="text" name="name" value="{{ $category->name }}" class="form-control mb-3" placeholder="Kategorijas nosaukums" maxlength="50" required>
<button class="btn btn-success w-100">
Saglabāt
</button>
</form>
</div>
</div>
@endsection