<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* USER DATA */
$userQuery = mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($userQuery);

/* UPCOMING BOOKINGS */
$upcomingQuery = mysqli_query($conn,"
SELECT COUNT(*) total 
FROM bookings 
WHERE user_id='$user_id' 
AND checkin >= CURDATE()
");
$upcoming = mysqli_fetch_assoc($upcomingQuery)['total'];

/* COMPLETED BOOKINGS */
$completedQuery = mysqli_query($conn,"
SELECT COUNT(*) total 
FROM bookings 
WHERE user_id='$user_id' 
AND checkout < CURDATE()
");
$completed = mysqli_fetch_assoc($completedQuery)['total'];

/* TOTAL SPENT */
$spentQuery = mysqli_query($conn,"
SELECT SUM(total_price) total 
FROM bookings 
WHERE user_id='$user_id' 
AND status='Confirmed'
");
$spent = mysqli_fetch_assoc($spentQuery)['total'];

if($spent == ""){
    $spent = 0;
}

/* LOYALTY POINTS */
$points = $completed * 50;

/* NEXT BOOKING */
$nextBooking = mysqli_query($conn,"
SELECT bookings.*, rooms.room_name, rooms.image
FROM bookings
JOIN rooms ON bookings.room_id = rooms.id
WHERE bookings.user_id='$user_id'
AND bookings.checkin >= CURDATE()
ORDER BY bookings.checkin ASC
LIMIT 1
");

$booking = mysqli_fetch_assoc($nextBooking);
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
background:#f8f9fa;
font-family:Arial;
}

.sidebar{
height:100vh;
background:#0b1d35;
color:white;
padding:20px;
position:fixed;
width:220px;
}

.sidebar a{
display:block;
color:white;
padding:12px;
text-decoration:none;
margin-bottom:8px;
border-radius:8px;
transition:0.3s;
}

.sidebar a:hover{
background:#d4af37;
}

.main{
margin-left:220px;
padding:30px;
}

.card-box{
border:none;
border-radius:15px;
box-shadow:0 0 10px rgba(0,0,0,.08);
}

.quick a{
text-decoration:none;
display:block;
padding:10px;
background:#f1f1f1;
margin-bottom:10px;
border-radius:8px;
color:#000;
}

.quick a:hover{
background:#d4af37;
color:white;
}
</style>

</head>
<body>

<div class="sidebar">

<h3 class="text-warning">HotelIQ</h3>

<a href="dashboard.php">Dashboard</a>
<a href="rooms.php">My Bookings</a>
<a href="profile.php">Profile</a>
<a href="payments.php">Payments</a>
<a href="feedback.php">Feedback</a>
<a href="logout.php">Logout</a>

</div>

<div class="main">

<h2>
Welcome Back, <?php echo $user['fullname']; ?> 👋
</h2>

<div class="row mt-4">

<div class="col-md-3">
<div class="card card-box p-3">
<h6>Upcoming Bookings</h6>
<h2><?php echo $upcoming; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card card-box p-3">
<h6>Completed Stays</h6>
<h2><?php echo $completed; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card card-box p-3">
<h6>Total Spent</h6>
<h2>$<?php echo $spent; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card card-box p-3">
<h6>Loyalty Points</h6>
<h2><?php echo $points; ?></h2>
</div>
</div>

</div>

<div class="row mt-4">

<div class="col-md-8">

<div class="card card-box p-3">

<h5>Upcoming Booking</h5>

<?php if($booking){ ?>

<img src="<?php echo $booking['image']; ?>" class="img-fluid rounded">

<h5 class="mt-3">
<?php echo $booking['room_name']; ?>
</h5>

<p>
<?php echo $booking['checkin']; ?>
 -
<?php echo $booking['checkout']; ?>
 |
<?php echo $booking['guests']; ?> Guests
</p>

<a href="room-details.php?id=<?php echo $booking['room_id']; ?>" class="btn btn-warning">
View Details
</a>

<?php } else { ?>

<p class="text-muted mt-3">No upcoming bookings found.</p>

<a href="rooms.php" class="btn btn-warning">
Book Room
</a>

<?php } ?>

</div>

</div>

<div class="col-md-4">

<div class="card card-box p-3">

<h5>Quick Actions</h5>

<div class="quick">
<a href="rooms.php">Book Room</a>
<a href="payments.php">Make Payment</a>
<a href="profile.php">Update Profile</a>
</div>

</div>

</div>

</div>

</div>

</body>
</html>