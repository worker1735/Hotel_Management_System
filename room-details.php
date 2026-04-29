<?php
include "db.php";

$id=$_GET['id'];

$data=mysqli_query($conn,"SELECT * FROM rooms WHERE id='$id'");
$row=mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Room Details</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<div class="row">

<div class="col-md-6">
<img src="<?php echo $row['image']; ?>" class="img-fluid rounded shadow">
</div>

<div class="col-md-6">

<h2><?php echo $row['room_name']; ?></h2>
<h3 class="text-warning"><?php echo $row['price']; ?>/night</h3>

<p><?php echo $row['guests']; ?></p>
<p><?php echo $row['beds']; ?></p>
<p><?php echo $row['wifi']; ?></p>

<a href="booking.php" class="btn btn-warning">
Book Now
</a>

</div>

</div>
</div>

</body>
</html>