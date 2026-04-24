@extends('layouts.admin')
@section('content')
<style>
.action-btn {
    width: 110px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    padding: 0 8px;
    border-radius: 6px;
}
.form-dark {
    background: linear-gradient(145deg, #0f172a, #020617);
    border: 1px solid #1e293b;
    color: #e2e8f0;
    border-radius: 12px;
    padding: 10px 14px;
    transition: 0.2s;
}

.form-dark::placeholder {
    color: #64748b;
}

.form-dark:focus {
    background: #020617;
    border-color: #22c55e;
    box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.25);
    color: #fff;
    outline: none;

}
.form-control.form-dark {
    background: linear-gradient(145deg, #0f172a, #020617) !important;
    color: #e2e8f0 !important;
    border: 1px solid #1e293b !important;

}
</style>

<div class="container">
<h2 class="text-white mb-4">Saņemtie pieteikumi</h2>
<form method="GET" id="form_main" class="mb-3">
<input type="text"
id="search_main"
name="search_main"
class="form-control form-dark"
placeholder="🔍 Meklēt pēc vārda, e-pasta, telefona vai tūres"
value="{{ request('search_main') }}">
</form>
<div class="mb-4">
<a href="/admin/categories" class="btn btn-outline-light">📂 Kategorijas</a>
<a href="/admin/tours" class="btn btn-outline-light">📍 Ceļojumi</a>
<a href="/admin/chats" class="btn btn-outline-light">Sarakste ar klientiem</a>
</div>
<table id="bookings-table" class="table table-dark table-hover">
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
<div class="d-flex gap-1 flex-wrap">
<a href="/admin/bookings/{{ $booking->id }}/done" class="btn btn-success btn-sm action-btn">Izpildīt</a>
<a href="/admin/bookings/{{ $booking->id }}/cancel" class="btn btn-danger btn-sm action-btn">Atcelt</a>
<a href="/admin/email/{{ $booking->token }}" class="btn btn-outline-light btn-sm action-btn">💬 E-pasts</a>
</div>
@else
<a href="/admin/bookings/{{ $booking->id }}/delete"
class="btn btn-danger btn-sm action-btn"
onclick="return confirm('Dzēst šo pieteikumu?')">
🗑 Dzēst
</a>
@endif
</td>
</tr>
@endforeach
</tbody>
</table>
<hr class="my-5">
<h4 class="text-white mb-3">Individuālie pieprasījumi</h4>
<form method="GET" id="form_custom" class="mb-3">
<input type="text" id="search_custom" name="search_custom" class="form-control form-dark" placeholder="🔍 Meklēt individuālos pēc vārda, e-pasta, telefona vai tūres"
value="{{ request('search_custom') }}">
</form>
<table id="requests-table" class="table table-dark table-hover">
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
<td style="max-width: 300px; word-break: break-word;">
<div>
{{ \Illuminate\Support\Str::limit($r->description, 20) }}
</div>
@if(strlen($r->description) > 20)
<button class="btn btn-sm btn-outline-info mt-1"
data-bs-toggle="modal"
data-bs-target="#modal{{ $r->id }}">
Skatīt
</button>
@endif

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
<a href="/admin/requests/{{ $r->id }}/done" class="btn btn-success btn-sm action-btn">Izpildīt</a>
<a href="/admin/requests/{{ $r->id }}/cancel" class="btn btn-danger btn-sm action-btn">Atcelt</a>
<a href="/admin/email/{{ $r->token }}" class="btn btn-sm btn-outline-light action-btn">💬 E-pasts</a>
</div>
@else
<a href="/admin/requests/{{ $r->id }}/delete"
  class="btn btn-danger btn-sm action-btn"
  onclick="return confirm('Dzēst šo pieteikumu?')">
  🗑 Dzēst
</a>
@endif
</td>
</tr>
@endforeach
</tbody>
</table>
</div>

@foreach($requests as $r)
<div class="modal fade" id="modal{{ $r->id }}" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content bg-dark text-white">
<div class="modal-header">
<h5 class="modal-title">Apraksts</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body"  style=" word-break: break-word;" >
{{ $r->description }}
</div>
<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal" >Aizvērt</button>
</div>
</div>
</div>
</div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function () {
 let timeout;
 function liveSearch() {
 let params = new URLSearchParams();
 const main = document.getElementById('search_main').value;
 const custom = document.getElementById('search_custom').value;
 if (main) params.append('search_main', main);
if (custom) params.append('search_custom', custom);
 fetch(window.location.pathname + '?' + params.toString())
 .then(res => res.text())
 .then(html => {
let parser = new DOMParser();
 let doc = parser.parseFromString(html, 'text/html');
let newBookings = doc.querySelector('#bookings-table tbody');
let newRequests = doc.querySelector('#requests-table tbody');
 if (newBookings) {
 document.querySelector('#bookings-table tbody').innerHTML = newBookings.innerHTML;
 }

if (newRequests) {
 document.querySelector('#requests-table tbody').innerHTML = newRequests.innerHTML;
 }
});
}
 document.getElementById('search_main').addEventListener('input', function () {
 clearTimeout(timeout);
 timeout = setTimeout(liveSearch, 500);
});
document.getElementById('search_custom').addEventListener('input', function () {
clearTimeout(timeout);
timeout = setTimeout(liveSearch, 500);
});
});
</script>
@endsection