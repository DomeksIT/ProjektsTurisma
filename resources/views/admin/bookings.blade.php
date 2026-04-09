@extends('layouts.admin')
@section('content')
<!-- <style>
    .btn:hover {
transform: none !important;
transition: background-color 0.2s !important;
}
</style> -->
<div class="container">
<h2 class="text-white mb-4">Saņemtie pieteikumi</h2>
<div class="mb-4">
<a href="/admin/categories" class="btn btn-outline-light">📂 Kategorijas</a>
<a href="/admin/tours" class="btn btn-outline-light">📍 Ceļojumi</a>
<a href="/admin/chats" class="btn btn-outline-light">
Sarakste ar klientiem
</a>
</div>
<table class="table table-dark table-hover">
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
<div class="d-flex gap-1">
@if($booking->status=='Jauns')
<a href="/admin/bookings/{{ $booking->id }}/done" class="btn btn-success btn-sm">
Izpildīt
</a>
<a href="/admin/bookings/{{ $booking->id }}/cancel" class="btn btn-danger btn-sm">
Atcelt
</a>
<a href="/admin/email/{{ $booking->token }}" class="btn btn-outline-light btn-sm">
💬 E-pasts
</a>
</div>
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
<td style="max-width: 300px; overflow-wrap: break-word; word-break: break-word;">
<div class="text-truncate-custom">
{{ $r->description }}
</div>
@if(strlen($r->description) > 100)
<button class="btn btn-sm btn-outline-info mt-1"
data-bs-toggle="modal"
data-bs-target="#modal{{ $r->id }}">
Skatīt
</button>
@endif
</td>
</td>
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
<div class="d-flex gap-1">
<a href="/admin/requests/{{ $r->id }}/done" class="btn btn-success btn-sm me-2 py-1">
Izpildīt
</a>
<a href="/admin/requests/{{ $r->id }}/cancel" class="btn btn-danger btn-sm py-1">
Atcelt
</a>
<a href="/admin/email/{{ $r->token }}" class="btn btn-sm btn-outline-light py-1">
💬 E-pasts
</a>
</div>
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
@foreach($requests as $r)
<div class="modal fade" id="modal{{ $r->id }}" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content bg-dark text-white">
<div class="modal-header">
<h5 class="modal-title">Apraksts</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body" style="word-break: break-word;">
{{ $r->description }}
</div>
<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">
Aizvērt
</button>
</div>
</div>
</div>
</div>
<script>
@endforeach
function updateBookings() {
   fetch(window.location.href + '?t=' + new Date().getTime())
       .then(res => res.text())
       .then(html => {
           let parser = new DOMParser();
           let doc = parser.parseFromString(html, 'text/html');
           let newContent = doc.querySelector('.container').innerHTML;
           document.querySelector('.container').innerHTML = newContent;
       });
}
setInterval(updateBookings, 3000); 
</script>