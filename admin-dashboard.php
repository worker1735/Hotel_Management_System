<?php
session_start();
include "db.php";

/* 🔐 ADMIN CHECK */
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

/* ⚡ ACTIONS */
if(isset($_GET['action']) && isset($_GET['id'])){
    $id = intval($_GET['id']);
    
    if($_GET['action'] == 'accept'){
        mysqli_query($conn, "UPDATE roombook SET stat='Accepted' WHERE id=$id");
    }
    
    if($_GET['action'] == 'reject'){
        mysqli_query($conn, "UPDATE roombook SET stat='Rejected' WHERE id=$id");
    }

    header("Location: admin-dashboard.php?msg=success");
    exit();
}

/* 📊 STATS CALCULATIONS */
$roomsCount = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM rooms"))['total'];

// 1. Pending: Jo bilkul naye hain (NULL ya empty)
$pendingQuery = mysqli_query($conn, "SELECT * FROM roombook WHERE stat IS NULL OR stat='' OR stat='not conform' ORDER BY id DESC");

// 2. Accepted but Unpaid: Jo accept ho gaye magar status 'Paid' nahi hua
$acceptedUnpaidQuery = mysqli_query($conn, "SELECT * FROM roombook WHERE stat='Accepted' ORDER BY id DESC");

// Counts for Cards
$pendingCount = mysqli_num_rows($pendingQuery);
$acceptedUnpaidCount = mysqli_num_rows($acceptedUnpaidQuery);

// Revenue (Sirf confirmed payments)
$revenueSql = "SELECT IFNULL(SUM((room_price + meal_price) * nodays),0) as total FROM roombook WHERE stat = 'Paid'";
$revenueCount = mysqli_fetch_assoc(mysqli_query($conn, $revenueSql))['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | HotelIQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Arial; }
        .sidebar { height:100vh; background:#0d1b2a; padding:25px; color:white; position:fixed; width:230px; }
        .sidebar a { display:block; padding:12px; color:white; text-decoration:none; margin-bottom:10px; border-radius:10px; transition: 0.3s; }
        .sidebar a:hover { background:#d4af37; color:black; }
        .main { margin-left:230px; padding:30px; }
        .stat-card { border:none; border-radius:15px; padding:20px; background:white; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .table-container { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 30px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h3 class="mb-4">HotelIQ</h3>
    <a href="admin-dashboard.php" style="background:#d4af37; color:black;">📊 Dashboard</a>
    <a href="reservations.php">📅 Reservations (Paid)</a>
    <a href="manage-rooms.php">🏨 Manage Rooms</a>
    <hr>
    <a href="logout.php" class="text-danger">Logout</a>
</div>

<div class="main">
    <h2>Admin Control Panel</h2>

    <div class="row g-3 mt-3">
        <div class="col-md-4">
            <div class="stat-card border-start border-warning border-4">
                <small class="text-muted">New Requests (Pending)</small>
                <h3 class="text-warning"><?php echo $pendingCount; ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card border-start border-primary border-4">
                <small class="text-muted">Accepted (Awaiting Payment)</small>
                <h3 class="text-primary"><?php echo $acceptedUnpaidCount; ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-dark text-white">
                <small class="text-secondary">Confirmed Revenue (Paid)</small>
                <h3>Rs. <?php echo number_format($revenueCount); ?></h3>
            </div>
        </div>
    </div>

    <div class="table-container mt-5">
        <h5 class="mb-4 text-danger">Step 1: New Requests (Action Needed)</h5>
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Check-In</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($pendingCount > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($pendingQuery)): ?>
                    <tr>
                        <td><b><?php echo $row['FName']; ?></b></td>
                        <td><?php echo $row['TRoom']; ?></td>
                        <td><?php echo $row['cin']; ?></td>
                        <td>
                            <a href="?action=accept&id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Accept</a>
                            <a href="?action=reject&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Reject</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center text-muted">No new requests.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <h5 class="mb-4 text-primary">Step 2: Accepted but Unpaid (Awaiting User Payment)</h5>
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Total Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if($acceptedUnpaidCount > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($acceptedUnpaidQuery)): 
                        $total = ($row['room_price'] + $row['meal_price']) * $row['nodays'];
                    ?>
                    <tr>
                        <td><?php echo $row['FName']; ?></td>
                        <td><?php echo $row['TRoom']; ?></td>
                        <td>Rs. <?php echo number_format($total); ?></td>
                        <td><span class="badge bg-info text-dark">Accepted - Unpaid</span></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center text-muted">No unpaid accepted bookings.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>