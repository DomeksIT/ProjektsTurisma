<!DOCTYPE html>
<html lang="lv">
<head>
<meta charset="UTF-8">
<title>Admin panelis</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<Style>
body{
background:#0b1220;
color:white;
}
.admin-header{
    background:#111927;
    padding:15px;
}
</Style>
</head>
<body>
<div class="admin-header d-flex justify-content-between align-items-center">
<h4 class="m-0">Admin panelis</h4>
<a href="{{url('/')}}" class="btn btn-outline-light btn-sm">
Atpakaļ uz mājaslapu
</a>
</div>
<div class="container mt-4">
@yield('content')
</div>
</body>
</html>

