@extends('layouts.admin')
@section('content')
<div class="container">
<h2 class="text-white mb-4">Saņemtie pieteikumi</h2>
<div class="mb-4">
<a href="/admin/categories" class="btn btn-outline-light">📂 Kategorijas</a>
<a href="/admin/tours" class="btn btn-outline-light">📍 Ceļojumi</a>
</div>
<table class="table table-dark table-striped">
<thead>
<tr>
<th>ID</th>
<th>Tūre</th>
<th>Vārds Uzvārds</th>
<th>E-pasts</th>
<th>Telefons</th>
<th>Datums</th>
<th>Statuss</th>
<th>Darbības</th>
</tr>
</thead>
<tbody>
@foreach($bookings as $booking)
<tr>
<td>{{ $booking->id }}</td>
<td>{{ $booking->tour_title }}</td>
<td>{{ $booking->name }}</td>
<td>{{ $booking->email }}</td>
<td>{{ $booking->phone }}</td>
<td>{{ $booking->created_at }}</td>
<td>
@if($booking->status=='Jauns')
<span class="badge bg-warning text-dark">Jauns</span>
@elseif($booking->status=='done')
<span class="badge bg-success">Izpildīts</span>
@elseif($booking->status=='canceled')
<span class="badge bg-danger">Atcelts</span>
@endif
</td>
<td>
@if($booking->status=='Jauns')
<a href="/admin/bookings/{{ $booking->id }}/done" class="btn btn-success btn-sm me-2">
Izpildīt
</a>
<a href="/admin/bookings/{{ $booking->id }}/cancel" class="btn btn-danger btn-sm">
Atcelt
</a>
@else
<span class="text-muted">-</span>
@endif
</td>
</tr>
@endforeach
</tbody>
</table>
<hr class="my-5">
<h4 class="text-white mb-3">Individuālie pieprasījumi</h4>
<table class="table table-dark table-hover">
<thead>
<tr>
<th>ID</th>
<th>Vārds Uzvārds</th>
<th>Telefons</th>
<th>E-pasts</th>
<th>Galamērķis</th>
<th>Datumi</th>
<th>Apraksts</th>
<th>Datums</th>
<th>Statuss</th>
<th>Darbības</th>
</tr>
</thead>
<tbody>
@foreach($requests as $r)
<tr>
<td>{{ $r->id }}</td>
<td>{{ $r->name }}</td>
<td>{{ $r->phone ?? '-' }}</td>
<td>{{ $r->email }}</td>
<td>{{ $r->destination }}</td>
<td>{{ $r->dates }}</td>
<td>{{ $r->description }}</td>
<td>{{ $r->created_at }}</td>
<td>
@if($r->status=='Jauns')
<span class="badge bg-warning text-dark">Jauns</span>
@elseif($r->status=='done')
<span class="badge bg-success">Izpildīts</span>
@elseif($r->status=='canceled')
<span class="badge bg-danger">Atcelts</span>
@endif
</td>
<td>
@if($r->status=='Jauns')
<a href="/admin/requests/{{ $r->id }}/done" class="btn btn-success btn-sm me-2">
Izpildīt
</a>
<a href="/admin/requests/{{ $r->id }}/cancel" class="btn btn-danger btn-sm">
Atcelt
</a>
@else
<span class="text-muted">-</span>
@endif
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endsection