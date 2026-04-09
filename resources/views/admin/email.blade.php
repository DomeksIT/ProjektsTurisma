@extends('layouts.admin')
@section('content')
<div class="container text-white">
<a href="/admin/bookings" class="btn btn-outline-light mb-3">Atpakaļ</a>
<h4 class="mb-3">✉️ Atbildēt klientam</h4>
<div class="card bg-secondary text-white p-3 mb-3">
<b>👤 Klients:</b> {{ $data->name ?? '-' }} <br>
<b>📧 E-pasts:</b> {{ $data->email ?? '-' }}<br>
<b>📞 Telefons:</b> {{ $data->phone ?? '-' }} <br>
@if(isset($data->destination))
<b>📍 Galamērķis:</b> {{ $data->destination }} <br>
@endif
@if(isset($data->description))
<b>📝 Apraksts:</b> {{ $data->description }} <br>
@endif

@if(isset($data->dates))
<b>📅 Datumi:</b> {{ $data->dates }}
@endif
</div>
</div>
<div class="card bg-dark text-white p-3 mb-2"
 style="max-height:300px; overflow-y:auto;" id="chat-box">
@if(!empty($messages) && count($messages) > 0)
@foreach($messages as $m)
<div class="mb-2 text-end">
<div class="d-inline-block p-2 rounded bg-success" style="max-width:70%;">
{{ $m->message }}
<br>
<small class="text-light">
{{ $m->created_at }}
</small>
</div>
</div>
        @endforeach
    @else
<div class="text-center text-muted">
            Nav nosūtītu ziņu
</div>
    @endif
</div>
<form method="POST" action="/admin/email/{{ $data->token }}" class="mt-2">
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
 