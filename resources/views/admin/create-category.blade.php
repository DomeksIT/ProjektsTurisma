@extends('layouts.admin')
@section('content')
<div class="container">
<h2 class="text-white mb-4">Jauna kategorija</h2>
<div class="card bg-dark p-4">
<form method="POST" action="/admin/categories/store">
@csrf
<input type="text"name="name"class="form-control mb-3"placeholder="Kategorijas nosaukums"required>
<button class="btn btn-success w-100">
Pievienot
</button>
</form>
</div>
</div>
@endsection