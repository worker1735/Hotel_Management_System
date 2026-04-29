<!DOCTYPE html>
<html>
<head>
<title>Select Role</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
background:linear-gradient(to right,#0b1d35,#1c355e);
height:100vh;
display:flex;
justify-content:center;
align-items:center;
}

.box{
background:white;
padding:50px;
border-radius:20px;
width:500px;
text-align:center;
box-shadow:0 0 20px rgba(0,0,0,.2);
}

.btn-role{
padding:15px;
font-size:20px;
margin-top:15px;
}
</style>

</head>
<body>

<div class="box">

<h1 class="mb-4">HotelIQ Portal</h1>

<a href="admin-login.php" class="btn btn-dark w-100 btn-role">
Admin Login
</a>

<a href="login.php" class="btn btn-warning w-100 btn-role">
User Login
</a>

<a href="register.php" class="btn btn-outline-primary w-100 btn-role">
New User Register
</a>

</div>

</body>
</html>