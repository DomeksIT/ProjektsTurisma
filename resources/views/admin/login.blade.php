<!DOCTYPE html>
<html  lang="lv">
<head>
<meta charset="UTF-8">
<title>Admin pieslegšanas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
height:100vh;
margin:0;
display:flex;
align-items:center;
justify-content:center;
font-family:system-ui;
background:linear-gradient(135deg,#020617, #0f172a, #020617);
}
.login-card{
background:#111827;
padding:70px;
border-radius:20px;
width: 520px;
box-shadow: 0  30px 80px rgba(0,0,0,0.7);
color:white;
}
.title{
text-align:center;
font-size:28px;
font-weight:600;
margin-bottom:40px;
}
.input-group-text{
background:#020617;
border:1px solid  #1e293b;
color:white;
padding:16px;
font-size:16px;
}
.form-control{
background: #020617;
border:1px   solid #1e293b;
color:white;
padding:16px;
font-size:16px;
}
.form-control::placeholder{
color:#94a3b8;
}
.form-control:focus{
background:#020617;
border:1px solid #22c55e;
color:white;
box-shadow:none;
}
.btn-login{
background:#22c55e;
border:none;
font-weight:600;
padding:16px;
margin-top:20px;
font-size:16px;
}
.btn-login:hover{
background:#16a34a;
}
.btn-home{
margin-top:20px;
padding:12px;
}
.alert {
   white-space: normal !important;
   overflow: visible !important;
   text-overflow: unset !important;
}
</style>
</head>
<body>
<div class="login-card">
<div  class="title">
🔐Admin pieslēgšanās
</div>
@if(session('error'))
<div class="alert alert-danger"  style="white-space: normal; overflow: visible;">
{{ session('error') }}  
</div>
@endif
<form method="POST" action="/admin/login">
@csrf
<div  class="input-group mb-4">
<span class="input-group-text">👤</span>
<input type="text" name="email" class="form-control"placeholder="Lietotājvārds" required>
</div>
<div class="input-group  mb-4">
<span class="input-group-text">🔑</span>
<input  type="password" name="password" class="form-control"placeholder="Parole" required>
</div>
<button class="btn btn-login w-100">
Ienākt sistēmā
</button>
</form>
<a href="/tours" class="btn btn-outline-light w-100 btn-home">
Atpakaļ uz mājaslapu
</a>
</div>
</body>
</html>