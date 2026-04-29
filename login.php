<?php
session_start();
include "db.php";

$msg = "";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit();
        }else{
            $msg = "Wrong Password";
        }
    }else{
        $msg = "User Not Found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>HotelIQ Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    padding:0;
    background:#f5f5f5;
    font-family:Arial, Helvetica, sans-serif;
}

.main-box{
    height:100vh;
}

.left-side{
    background:url('hotel.jpg');
    background-size:cover;
    background-position:center;
    position:relative;
}

.overlay{
    background:rgba(0,0,0,0.65);
    width:100%;
    height:100%;
    color:white;
    padding:60px;
}

.logo{
    font-size:30px;
    font-weight:bold;
    color:#d4af37;
}

.welcome{
    margin-top:120px;
}

.welcome h1{
    font-size:42px;
    font-weight:bold;
}

.right-side{
    background:white;
    display:flex;
    justify-content:center;
    align-items:center;
}

.login-box{
    width:380px;
}

.login-box h2{
    font-weight:bold;
    margin-bottom:10px;
}

.btn-gold{
    background:#d4af37;
    color:white;
    border:none;
}

.btn-gold:hover{
    background:#b8952f;
}

a{
    text-decoration:none;
}

small{
    color:red;
}
</style>

</head>
<body>

<div class="container-fluid">
<div class="row main-box">

    <!-- Left Side -->
    <div class="col-md-6 left-side d-none d-md-block">
        <div class="overlay">
            <div class="logo">HotelIQ</div>

            <div class="welcome">
                <h1>Welcome Back!</h1>
                <p>Please login to continue your hotel journey.</p>
            </div>
        </div>
    </div>

    <!-- Right Side -->
    <div class="col-md-6 right-side">
        <div class="login-box">

            <h2>Login to your account</h2>
            <p class="text-muted">Enter your details below</p>

            <?php if($msg!=""){ ?>
                <div class="alert alert-danger"><?php echo $msg; ?></div>
            <?php } ?>

            <form method="POST">

                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                </div>

                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <input type="checkbox"> Remember Me
                    </div>

                    <a href="#">Forgot Password?</a>
                </div>

                <button type="submit" name="login" class="btn btn-gold w-100">
                    Login
                </button>

            </form>

            <p class="text-center mt-3">
                Don't have account?
                <a href="register.php">Register</a>
            </p>

        </div>
    </div>

</div>
</div>

</body>
</html>