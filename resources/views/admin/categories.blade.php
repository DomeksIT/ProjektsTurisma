@extends('layouts.admin')
@section('content')
<div class="container">
<div class="d-flex justify-content-between mb-4">
<h2 class="text-white">Kategorijas</h2>
<a href="/admin/bookings" class="btn btn-outline-light me-2">
Pieteikumi
</a>
<a href="/admin/categories/create" class="btn btn-success">
Pievienot kategoriju
</a>
</div>
<table class="table table-dark table-striped">
<thead>
<tr>
<th>ID</th>
<th>Nosaukums</th>
<th>Darbības</th>
</tr>
</thead>
<tbody>
@foreach($categories as $category)
<tr>
<td>{{ $category->id }}</td>
<td>{{ $category->name }}</td>
<td>
<a href="/admin/categories/edit/{{ $category->id }}"
class="btn btn-warning btn-sm">
✏ Labot
</a>
<a href="/admin/categories/delete/{{ $category->id }}"
class="btn btn-danger btn-sm"
onclick="return confirm('Dzēst kategoriju?')">
🗑 Dzēst
</a>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endsection