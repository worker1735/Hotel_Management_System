<?php
include "db.php";
$msg = "";

if(isset($_POST['register'])){

    $fullname = mysqli_real_escape_string($conn,$_POST['fullname']);
    $email    = mysqli_real_escape_string($conn,$_POST['email']);
    $password = $_POST['password'];
    $cpass    = $_POST['cpassword'];

    if($password != $cpass){
        $msg = "Passwords match nahi karte";
    }
    else{

        $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

        if(mysqli_num_rows($check) > 0){
            $msg = "Email already registered";
        }
        else{

            $hash = password_hash($password,PASSWORD_DEFAULT);

            $insert = mysqli_query($conn,"INSERT INTO users(fullname,email,password)
            VALUES('$fullname','$email','$hash')");

            if($insert){
                header("Location: login.php");
                exit();
            }else{
                $msg = "Registration Failed";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f4f4;
}

.main{
    height:100vh;
}

.left{
    background:url('hotel.jpg');
    background-size:cover;
    background-position:center;
}

.overlay{
    background:rgba(0,0,0,0.65);
    color:white;
    height:100%;
    padding:60px;
}

.logo{
    font-size:32px;
    color:#d4af37;
    font-weight:bold;
}

.right{
    background:white;
    display:flex;
    justify-content:center;
    align-items:center;
}

.box{
    width:400px;
}

.btn-gold{
    background:#d4af37;
    color:white;
}
</style>

</head>
<body>

<div class="container-fluid">
<div class="row main">

<div class="col-md-6 left d-none d-md-block">
<div class="overlay">
<div class="logo">HotelIQ</div>

<h1 class="mt-5">Create Account</h1>
<p>Join HotelIQ and enjoy smart booking system.</p>
</div>
</div>

<div class="col-md-6 right">

<div class="box">

<h2>Create Account</h2>
<p class="text-muted">Fill details below</p>

<?php if($msg!=""){ ?>
<div class="alert alert-danger"><?php echo $msg; ?></div>
<?php } ?>

<form method="POST">

<div class="mb-3">
<input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
</div>

<div class="mb-3">
<input type="email" name="email" class="form-control" placeholder="Email Address" required>
</div>

<div class="mb-3">
<input type="password" name="password" class="form-control" placeholder="Password" required>
</div>

<div class="mb-3">
<input type="password" name="cpassword" class="form-control" placeholder="Confirm Password" required>
</div>

<button type="submit" name="register" class="btn btn-gold w-100">
Register
</button>

</form>

<p class="mt-3 text-center">
Already have account?
<a href="login.php">Login</a>
</p>

</div>

</div>
</div>
</div>

</body>
</html>