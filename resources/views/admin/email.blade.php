@extends('layouts.admin')
@section('content')
<div class="container text-white" style="max-width: 700px;">
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
<div class="card bg-dark text-white p-4 mb-3" style="max-height:450px;overflow-y:auto; border-radius:21" id="chat-box">
@if($messages && count($messages))
@foreach($messages as $m)
<div class="mb-2 text-end">
<div class="d-inline-block p-2 rounded bg-success" style="max-width:70%">
{{ $m->message }}
@if($m->file)
<br>
<a href="{{ asset('storage/'.$m->file) }}" target="_blank" class="text-white text-decoration-underline">📎 fails</a>
@endif
<br>
<small class="text-light">{{ $m->created_at }}</small>
</div>
</div>
@endforeach
@else
<div class="text-center text-white">Nav nosūtītu ziņu</div>
@endif
</div>
<form method="POST" action="/admin/email/{{ $data->token }}" enctype="multipart/form-data" class="mt-2">
@csrf
<input type="text" name="message" class="form-control mb-2" placeholder="Raksti ziņu..." required>
<input type="file" name="file" class="form-control mb-2" accept=".pdf, .doc, .docx">
<button type="submit" class="btn btn-success w-100">Sūtīt</button>
</form>
</div>
<script>
let chatBox=document.getElementById('chat-box');
chatBox.scrollTop=chatBox.scrollHeight;
</script>
@endsection
