<!DOCTYPE html>
<html lang="lv">
<head>
<style>
.text-truncate-custom {
max-width: 250px;
max-height: 60px;
overflow: hidden;
display: -webkit-box;
-webkit-line-clamp: 3; 
-webkit-box-orient: vertical;
}
</style>
<meta charset="UTF-8">
<title>Admin panelis</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
   background: radial-gradient(circle at top, #0f1b35, #0b1220);
   color:white;
   min-height:100vh;
}
.admin-header{
   display:flex;
   justify-content:center;
   align-items:center;
   padding:25px;
   position:relative;
}
.btn-back{
   position:absolute;
   left:20px;
   background: white(255,255,255,0.05);
   backdrop-filter: blur(10px);
   border:1px solid rgba(255,255,255,0.2);
   color:#ffffff;
   padding:10px 16px;
   border-radius:10px;
   text-decoration:none;
   font-weight:500;
   transition:0.2s;
}
.btn-back:hover{
   background:#22c55e;
   color:black;
}
</style>
</head>
<body>
<div class="admin-header">
<a href="/" class="btn-back">
Atpakaļ uz mājaslapu
</a>
<h4>Admin panelis</h4>
</div>
<div class="container mt-4">
   @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>