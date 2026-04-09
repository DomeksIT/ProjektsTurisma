<!DOCTYPE html>
<html>
<head>
<title>Čats</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
   background: #0f172a;
   color: white;
}
#chat-box {
   height: 70vh;
   overflow-y: auto;
   background: #1e293b;
   padding: 15px;
   border-radius: 10px;
}
.msg {
   max-width: 70%;
   padding: 10px 15px;
   border-radius: 15px;
   margin-bottom: 10px;
   word-wrap: break-word;
}
.client {
   background: #3b82f6;
   margin-left: auto;
   text-align: right;
}
.admin {
   background: #374151;
   margin-right: auto;
}
</style>
</head>
<body>
<div class="container mt-3">
<h4 class="mb-3">💬 Čats</h4>
@if(!$requestData)
<div class="alert alert-danger">
       Čats nav atrasts (nepareizs links vai token)
</div>
@endif
<div id="chat-box">
   @foreach($messages as $m)
<div class="msg {{ $m->sender == 'admin' ? 'admin' : 'client' }}">
<small>
               {{ $m->sender == 'admin' ? 'Administrators' : 'Jūs' }}
</small>
<div>{{ $m->message }}</div>
</div>
   @endforeach
</div>
@if($requestData)
<form method="POST" action="/chat/{{ $requestData->token }}">
   @csrf
<div class="input-group mt-3">
<input
type="text"
name="message"
class="form-control"
placeholder="Rakstīt ziņu..."
required
>
<button class="btn btn-success">
Sūtīt
</button>
</div>
</form>
@endif
</div>
<script>
function updateChat() {
fetch(window.location.href + '?t=' + new Date().getTime())
.then(res => res.text())
.then(html => {
let parser = new DOMParser();
let doc = parser.parseFromString(html, 'text/html');
let newMessages = doc.querySelector('#chat-box')?.innerHTML;
let chatBox = document.querySelector('#chat-box');
if (newMessages && chatBox) {
chatBox.innerHTML = newMessages;
chatBox.scrollTop = chatBox.scrollHeight;
}
});
}
setInterval(updateChat, 2000);
window.onload = () => {
let chatBox = document.querySelector('#chat-box');
if (chatBox) {
chatBox.scrollTop = chatBox.scrollHeight;
}
}
</script>
</body>
</html>