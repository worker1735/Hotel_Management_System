<?php
session_start();
include "db.php";

$user=$_SESSION['user_id'];
$room=$_GET['room'];

$r=mysqli_query($conn,"SELECT * FROM rooms WHERE id='$room'");
$data=mysqli_fetch_assoc($r);

if(isset($_POST['book']))
{
$checkin=$_POST['checkin'];
$checkout=$_POST['checkout'];
$guests=$_POST['guests'];

$total=$data['price'];

mysqli_query($conn,"INSERT INTO bookings(user_id,room_id,checkin,checkout,guests,total_price,status)
VALUES('$user','$room','$checkin','$checkout','$guests','$total','Pending')");

header("Location: payment.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Booking</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<div class="row">

<div class="col-md-7">
<div class="card p-4 shadow">

<h3>Guest Information</h3>

<form method="POST">

<input type="date" name="checkin" class="form-control mb-3" required>

<input type="date" name="checkout" class="form-control mb-3" required>

<input type="number" name="guests" class="form-control mb-3" placeholder="Guests" required>

<button name="book" class="btn btn-warning w-100">
Proceed To Payment
</button>

</form>

</div>
</div>

<div class="col-md-5">
<div class="card p-4 shadow">

<h4>Booking Summary</h4>

<img src="<?php echo $data['image']; ?>" class="img-fluid rounded">

<h5 class="mt-3"><?php echo $data['room_name']; ?></h5>

<h3 class="text-warning"><?php echo $data['price']; ?></h3>

</div>
</div>

</div>
</div>

</body>
</html>