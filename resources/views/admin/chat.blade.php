@extends('layouts.admin')
@section('content')
<div class="container text-white">
<a href="/admin/bookings" class="btn btn-outline-light me-2">
Atpakaļ
</a>
<h4 class="mb-3">
💬 Atbildēt klientam
</h4>
<div class="card bg-secondary text-white p-3 mb-3">
<b>👤 Klients:</b> {{ $request->name ?? '-' }} <br>
<b>📧 E-pasts:</b> {{ $request->email ?? '-' }} <br>
<b>📍 Galamērķis:</b> {{ $request->destination ?? $request->tour_title ?? '-' }} <br>
<b>📝 Apraksts:</b> {{ $request->description ?? '-' }}
</div>
<div class="card bg-dark text-white p-3 mb-2"
    style="max-height:300px; overflow-y:auto;"
    id="chat-box">
@if(!empty($messages) && count($messages) > 0)
@foreach($messages as $m)
@if($m->sender == 'admin')
<div class="mb-2 text-end">
<div class="d-inline-block p-2 rounded bg-success" style="max-width:70%;">
{{ $m->message }}
<br>
<small class="text-light">
{{ $m->created_at }}
</small>
</div>
</div>
@else
<div class="mb-2 text-start">
<div class="d-inline-block p-2 rounded bg-secondary" style="max-width:70%;">
{{ $m->message }}
<br>
<small class="text-light">
{{ $m->created_at }}
</small>
</div>
</div>
       @endif
   @endforeach
@else
<div class="text-center text-muted">
Nav ziņu
</div>
@endif
</div>
<form method="POST" action="/admin/chat/{{ $request->token }}" class="mt-2">
@csrf
<div class="input-group">
<input type="text"
      name="message"
      class="form-control"
      placeholder="Raksti ziņu..."
      required>
<button class="btn btn-success">
   Sūtīt
</button>
</div>
</form>
</div>
<script>
let chatBox = document.getElementById('chat-box');
chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endsection