<?php
session_start();
include "db.php";

$id=$_SESSION['user_id'];

$data=mysqli_query($conn,"SELECT * FROM users WHERE id='$id'");
$user=mysqli_fetch_assoc($data);

if(isset($_POST['update']))
{
$name=$_POST['name'];

mysqli_query($conn,"UPDATE users SET fullname='$name' WHERE id='$id'");

header("Location: profile.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<div class="col-md-5 mx-auto card p-4 shadow">

<h2>My Profile</h2>

<form method="POST">

<input type="text" name="name" class="form-control mb-3"
value="<?php echo $user['fullname']; ?>">

<input type="email" class="form-control mb-3"
value="<?php echo $user['email']; ?>" readonly>

<button name="update" class="btn btn-warning w-100">
Update
</button>

</form>

</div>

</div>

</body>
</html>