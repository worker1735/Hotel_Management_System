<?php
session_start();
include "db.php"; // Ensure karein ke db.php mein database 'hotel_db' hi select hai

$msg = "";

// 1. Agar pehle se admin login hai to seedha dashboard bhejen
if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
    header("Location: admin-dashboard.php");
    exit();
}

if(isset($_POST['login']))
{
    // Inputs ko clean karein
    $username = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    // 2. 'admin' table se data fetch karein
    $sql = "SELECT * FROM admin WHERE username='$username'";
    $q = mysqli_query($conn, $sql);

    if(mysqli_num_rows($q) > 0)
    {
        $admin = mysqli_fetch_assoc($q);

        // 3. Password match karein (Database record: admin123)
        if($password == $admin['password'])
        {
            // Session variables set karein
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_user'] = $admin['username'];
            $_SESSION['role'] = 'admin'; // Ye redirect filter ke liye zaroori hai

            header("Location: admin-dashboard.php");
            exit();
        }
        else{
            $msg = "❌ Incorrect Password!";
        }
    }
    else{
        $msg = "❌ No Admin found with this email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Luxury Stay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #1e3c72, #2a5298);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }
        .card-box {
            width: 400px;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        }
        .btn-login {
            background: #2a5298;
            color: white;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
            border: none;
            transition: 0.3s;
        }
        .btn-login:hover {
            background: #1e3c72;
            transform: translateY(-2px);
        }
        h3 {
            text-align: center;
            margin-bottom: 25px;
            color: #2a5298;
            font-weight: 800;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<div class="card-box">
    <h3>Admin Portal</h3>

    <?php if($msg != ""): ?>
        <div class="alert alert-danger py-2 text-center" style="font-size: 14px;">
            <?php echo $msg; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label small fw-bold">Admin Email</label>
            <input type="email" name="email" class="form-control" placeholder="admin@gmail.com" required>
        </div>

        <div class="mb-4">
            <label class="form-label small fw-bold">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" name="login" class="btn btn-login shadow-sm">
            Access Dashboard
        </button>
    </form>
</div>

</body>
</html>