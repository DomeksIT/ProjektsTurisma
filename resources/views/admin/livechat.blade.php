@extends('layouts.admin')
@section('content')
<div class="container text-white">
<div class="mb-3">
<a href="/admin/chats" class="btn btn-outline-light">
Atpakaļ uz sarakstu
</a>
</div>
<h3 class="mb-4">💬 Tiešsaistes saruna</h3>
<div id="chat-box" style="height:400px; overflow-y:auto; background:#1e293b; padding:15px; border-radius:10px;">
   @foreach($messages as $m)
<div class="mb-2">
<strong>
@if($m->sender == 'admin')
Administrators:
@else
Klients:
@endif
</strong>
{{ $m->message }}
</div>
   @endforeach
</div>
<form method="POST" action="/admin/livechat/{{ $type }}/{{ $data->id }}" class="mt-3">
@csrf
<div class="input-group">
<input type="text" name="message" class="form-control" placeholder="Rakstīt ziņu..." required>
<button class="btn btn-success">Sūtīt</button>
</div>
</form>
</div>
<script>
function updateChat() {
fetch(window.location.href)
.then(res => res.text())
.then(html => {
let parser = new DOMParser();
let doc = parser.parseFromString(html, 'text/html');
let newMessages = doc.querySelector('#chat-box').innerHTML;
document.querySelector('#chat-box').innerHTML = newMessages;
});
}
setInterval(updateChat, 2000);
</script>
@endsection