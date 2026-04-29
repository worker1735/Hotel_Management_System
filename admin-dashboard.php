<?php
session_start();
include "db.php";

/* 🔒 SESSION CHECK */
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

/* 📊 LIVE DATA */
$totalUsers = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) AS total FROM users")
)['total'];

$totalBookings = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) AS total FROM bookings")
)['total'];

$totalRooms = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) AS total FROM rooms")
)['total'];

$totalRevenue = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT IFNULL(SUM(amount),0) AS total FROM payments")
)['total'];

/* UPCOMING BOOKINGS */
$upcoming = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) AS total 
FROM bookings 
WHERE checkin >= CURDATE()
")
)['total'];

/* RECENT BOOKINGS */
$recent = mysqli_query($conn,"
SELECT bookings.*, users.fullname, rooms.room_name
FROM bookings
JOIN users ON bookings.user_id = users.id
JOIN rooms ON bookings.room_id = rooms.id
ORDER BY bookings.id DESC
LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
background:#f4f6f9;
font-family:Arial;
}

/* SIDEBAR */
.sidebar{
height:100vh;
background:#0d1b2a;
padding:25px;
color:white;
position:fixed;
width:230px;
}

.sidebar h3{
color:#d4af37;
margin-bottom:25px;
font-weight:bold;
}

.sidebar a{
display:block;
padding:12px;
color:white;
text-decoration:none;
margin-bottom:10px;
border-radius:10px;
transition:0.3s;
}

.sidebar a:hover{
background:#d4af37;
color:#000;
}

/* MAIN */
.main{
margin-left:230px;
padding:30px;
}

/* CARD */
.card-box{
border:none;
border-radius:18px;
box-shadow:0 8px 18px rgba(0,0,0,.07);
transition:0.3s;
}

.card-box:hover{
transform:translateY(-6px);
}

.top-title{
font-weight:bold;
}

.small{
font-size:14px;
color:gray;
}

.table td, .table th{
vertical-align:middle;
}

.badge-status{
padding:8px 12px;
border-radius:20px;
font-size:13px;
}

.green{
background:#d1fae5;
color:#065f46;
}

.orange{
background:#fef3c7;
color:#92400e;
}

.blue-box{
background:linear-gradient(to right,#0d1b2a,#1f4068);
color:white;
border-radius:18px;
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">

<h3>HotelIQ</h3>

<a href="admin-dashboard.php">📊 Dashboard</a>
<a href="reservations.php">📅 Reservations</a>
<a href="manage-rooms.php">🏨 Manage Rooms</a>
<a href="payments.php">💳 Payments</a>
<a href="role-selection.php">🚪 Logout</a>

</div>

<!-- MAIN CONTENT -->
<div class="main">

<div class="d-flex justify-content-between align-items-center">
<div>
<h2 class="top-title">Welcome Admin 👋</h2>
<p class="small">Manage your hotel system in real time</p>
</div>

<div>
<a href="manage-rooms.php" class="btn btn-warning">
+ Add Room
</a>
</div>
</div>

<!-- TOP STATS -->
<div class="row mt-4">

<div class="col-md-3 mb-3">
<div class="card card-box p-4 text-center">
<p class="small">Total Users</p>
<h2><?php echo $totalUsers; ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card card-box p-4 text-center">
<p class="small">Bookings</p>
<h2><?php echo $totalBookings; ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card card-box p-4 text-center">
<p class="small">Rooms</p>
<h2><?php echo $totalRooms; ?></h2>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card card-box p-4 text-center">
<p class="small">Revenue</p>
<h2>$<?php echo $totalRevenue; ?></h2>
</div>
</div>

</div>

<!-- SECOND ROW -->
<div class="row">

<div class="col-md-8 mb-4">

<div class="card card-box p-4">

<div class="d-flex justify-content-between">
<h5>Recent Reservations</h5>
<a href="reservations.php">View All</a>
</div>

<table class="table mt-3">

<tr>
<th>User</th>
<th>Room</th>
<th>Checkin</th>
<th>Status</th>
</tr>

<?php while($row=mysqli_fetch_assoc($recent)){ ?>

<tr>
<td><?php echo $row['fullname']; ?></td>
<td><?php echo $row['room_name']; ?></td>
<td><?php echo $row['checkin']; ?></td>
<td>
<span class="badge-status green">
<?php echo $row['status']; ?>
</span>
</td>
</tr>

<?php } ?>

</table>

</div>

</div>

<div class="col-md-4 mb-4">

<div class="card blue-box p-4">

<h5>Upcoming Check-ins</h5>
<p class="small text-white">Bookings arriving soon</p>

<h1 class="mt-3"><?php echo $upcoming; ?></h1>

<a href="reservations.php" class="btn btn-light mt-3">
Manage Bookings
</a>

</div>

<br>

<div class="card card-box p-4">

<h5>Quick Actions</h5>

<div class="mt-3 d-grid gap-2">

<a href="manage-rooms.php" class="btn btn-outline-dark">
Add New Room
</a>

<a href="reservations.php" class="btn btn-outline-warning">
View Reservations
</a>

<a href="payments.php" class="btn btn-outline-success">
Check Payments
</a>

</div>

</div>

</div>

</div>

</div>

</body>
</html>