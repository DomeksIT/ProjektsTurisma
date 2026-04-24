@extends('layouts.admin')
@section('content')
<div class="container-fluid px-5">
<div class="d-flex justify-content-center">
<div style="max-width: 500px; width: 100%;">
<div class="d-flex justify-content-between align-items-center mb-3">
<h4 class="text-white mb-0">Kategorijas</h4>
<div>
<a href="/admin/bookings" class="btn btn-outline-light btn-sm me-2">
Pieteikumi
</a>
<a href="/admin/categories/create" class="btn btn-success btn-sm">
Pievienot kategoriju
</a>
</div>
</div>
<table class="table table-dark table-striped table-sm">
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
class="btn btn-warning btn-sm me-1">
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
</div>
</div>
@endsection