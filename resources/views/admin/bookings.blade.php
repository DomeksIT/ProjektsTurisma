@extends('layouts.admin')
@section('content')
<div class="container">
<h2 class="text-white mb-4">
Saņemtie pieteikumi
</h2>
<div class="mb-4">
<a href="/admin/tours" class="btn btn-outline-light">
📍 Ceļojumi
</a>
</div>
<table class="table table-dark table-striped">
<thead>
<tr>
<th>ID</th>
<th>Tūre</th>
<th>Vārds Uzvārds</th>
<th>E-pasts</th>
<th>Telefons</th>
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
<td>
@if($booking->status=='Jauns')
<span class="badge bg-warning text-dark">
Jauns
</span>
@elseif($booking->status=='done')
<span class="badge bg-success">
Izpildīts
</span>
@elseif($booking->status=='canceled')
<span class="badge bg-danger">
Atcelts
</span>
@else
<span class="text-muted">-</span>
@endif
</td>
<td>
@if($booking->status=='Jauns')
<a href="/admin/bookings/{{ $booking->id }}/done"
class="btn btn-success btn-sm me-2">
Izpildīt
</a>
<a href="/admin/bookings/{{ $booking->id }}/cancel"
class="btn btn-danger btn-sm">
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