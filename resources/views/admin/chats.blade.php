@extends('layouts.admin')
@section('content')
<div class="mb-3">
<a href="/admin/chats" class="btn btn-outline-light me-2">
Visi
</a>
<a href="/admin/chats?unread=1" class="btn btn-warning">
Neizlasītie
</a>
<a href="/admin/bookings" class="btn btn-outline-light">
       Atpakaļ uz sarakstu
</a>
</div>
<h2>Sarakste ar klientiem</h2>
<table class="table table-dark table-hover">
<thead>
<tr>
<th>ID</th>
<th>Email</th>
<th>Telefons</th>
<th>Tips</th>
<th>Galamērķis</th>
<th>Čats</th>
</tr>
</thead>
<tbody>
@foreach($chats as $chat)
<tr>
<td>{{ $chat->id }}</td>
<td>{{ $chat->email }}</td>
<td>{{ $chat->phone ?? '-' }}</td>
<td>
@if($chat->type == 'Individuālais')
<span class="badge bg-info">Individuālais</span>
@else
<span class="badge bg-primary">Saņemtais pieteikums</span>
 @endif
</td>
<td>{{ $chat->destination }}</td>
<td>
<a href="/admin/livechat/{{ $chat->type == 'Individuālais' ? 'request' : 'booking' }}/{{ $chat->id }}" class="btn btn-warning btn-sm">
 Atvērt
 @if($chat->unread>0)
 <span class="badge bg-danger">{{ $chat->unread }}</span>
  @endif
</a>
</td>
</tr>
@endforeach
</tbody>
</table>
<script>
function updateChats() {
   fetch(window.location.href + '?t=' + new Date().getTime())
       .then(res => res.text())
       .then(html => {
           let parser = new DOMParser();
           let doc = parser.parseFromString(html, 'text/html');
           let newTable = doc.querySelector('table').innerHTML;
           document.querySelector('table').innerHTML = newTable;
       });
}
setInterval(updateChats, 2000); 
</script>
@endsection