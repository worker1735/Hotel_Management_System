<?php
session_start();
include "db.php";

$data=mysqli_query($conn,"
SELECT bookings.*, users.fullname, rooms.room_name
FROM bookings
JOIN users ON bookings.user_id=users.id
JOIN rooms ON bookings.room_id=rooms.id
ORDER BY bookings.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Reservations</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>All Reservations</h2>

<table class="table table-bordered mt-4">

<tr>
<th>ID</th>
<th>User</th>
<th>Room</th>
<th>Checkin</th>
<th>Checkout</th>
<th>Status</th>
</tr>

<?php while($row=mysqli_fetch_assoc($data)){ ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['fullname']; ?></td>
<td><?php echo $row['room_name']; ?></td>
<td><?php echo $row['checkin']; ?></td>
<td><?php echo $row['checkout']; ?></td>
<td><?php echo $row['status']; ?></td>
</tr>

<?php } ?>

</table>

</div>
</body>
</html>