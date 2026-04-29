<?php
session_start();
include "db.php";

$msg = "";

// 🔥 If already logged in, send to dashboard
if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'){
    header("Location: admin-dashboard.php");
    exit();
}

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    // get user by email
    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($q) > 0)
    {
        $user = mysqli_fetch_assoc($q);

        // simple password check (because password is stored as plain text)
        if($password == $user['password'])
        {
            // session set
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = 'admin';

            // redirect to dashboard
            header("Location: admin-dashboard.php");
            exit();
        }
        else{
            $msg = "❌ Wrong Password";
        }
    }
    else{
        $msg = "❌ User not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(120deg, #1e3c72, #2a5298);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card-box{
    width:380px;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
}

.btn-login{
    background:#2a5298;
    color:white;
    width:100%;
    border-radius:10px;
}

.btn-login:hover{
    background:#1e3c72;
}

h3{
    text-align:center;
    margin-bottom:20px;
    color:#2a5298;
    font-weight:bold;
}

.msg{
    text-align:center;
    font-weight:bold;
}
</style>

</head>
<body>

<div class="card-box">

<h3>Admin Login</h3>

<p class="msg text-danger"><?php echo $msg; ?></p>

<form method="POST">

<input type="email" name="email" class="form-control mb-3" placeholder="Enter Email" required>

<input type="password" name="password" class="form-control mb-3" placeholder="Enter Password" required>

<button type="submit" name="login" class="btn btn-login">
Login
</button>

</form>

</div>

</body>
</html>