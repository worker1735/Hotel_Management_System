<?php
session_start();
include "db.php";

$book=mysqli_query($conn,"SELECT * FROM bookings ORDER BY id DESC LIMIT 1");
$b=mysqli_fetch_assoc($book);

if(isset($_POST['pay']))
{
$method=$_POST['method'];

mysqli_query($conn,"INSERT INTO payments(booking_id,method,amount,status)
VALUES('$b[id]','$method','$b[total_price]','Paid')");

mysqli_query($conn,"UPDATE bookings SET status='Confirmed' WHERE id='$b[id]'");

header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<div class="row">

<div class="col-md-7">
<div class="card p-4 shadow">

<h3>Payment Method</h3>

<form method="POST">

<input type="radio" name="method" value="Card" required> Card <br><br>
<input type="radio" name="method" value="JazzCash"> JazzCash <br><br>
<input type="radio" name="method" value="EasyPaisa"> EasyPaisa <br><br>

<button name="pay" class="btn btn-warning w-100">
Pay Now
</button>

</form>

</div>
</div>

<div class="col-md-5">
<div class="card p-4 shadow">

<h4>Payment Summary</h4>

<p>Booking ID: <?php echo $b['id']; ?></p>
<p>Total Amount:</p>

<h2 class="text-warning"><?php echo $b['total_price']; ?></h2>

</div>
</div>

</div>
</div>

</body>
</html>