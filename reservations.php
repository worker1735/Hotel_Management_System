<?php
session_start();
include "db.php";

/* 🔐 ADMIN CHECK (Security ke liye) */
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

// Query: Jo 'Accepted' hain YA 'Paid' hain, unhe fetch karo
$query = "SELECT * FROM roombook WHERE stat IN ('Accepted', 'Paid') ORDER BY id DESC";
$confirmed = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirmed Reservations | HotelIQ</title>
    <meta http-equiv="refresh" content="30"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Arial; }
        .sidebar { height:100vh; background:#0d1b2a; padding:25px; color:white; position:fixed; width:230px; }
        .sidebar a { display:block; padding:12px; color:white; text-decoration:none; margin-bottom:10px; border-radius:10px; }
        .sidebar a:hover { background:#d4af37; color:black; }
        .main { margin-left:230px; padding:30px; }
        .table-container { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .badge-paid { background-color: #2ecc71; color: white; }
        .badge-accepted { background-color: #3498db; color: white; }
    </style>
</head>
<body>

<div class="sidebar">
    <h3 class="mb-4">HotelIQ</h3>
    <a href="admin-dashboard.php">📊 Dashboard</a>
    <a href="reservations.php" style="background:#d4af37; color:black;">📅 Reservations</a>
    <a href="manage-rooms.php">🏨 Manage Rooms</a>
    <hr>
    <a href="logout.php" class="text-danger">Logout</a>
</div>

<div class="main">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Confirmed Reservations</h2>
        <span class="badge bg-info text-dark">Auto-Sync Active</span>
    </div>

    <div class="table-container">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Guest Name</th>
                    <th>Room Type</th>
                    <th>Check-In</th>
                    <th>Total Bill</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($confirmed) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($confirmed)) { 
                        // Bill calculate karne ki logic
                        $price = ($row['room_price'] + $row['meal_price']) * $row['nodays'];
                        
                        // Status styling
                        $status = $row['stat'];
                        $badgeClass = ($status == 'Paid') ? 'badge-paid' : 'badge-accepted';
                        $statusText = ($status == 'Paid') ? '✔ PAID' : 'Accepted (Unpaid)';
                    ?>
                    <tr>
                        <td class="fw-bold"><?php echo htmlspecialchars($row['FName']." ".$row['LName']); ?></td>
                        <td><?php echo htmlspecialchars($row['TRoom']); ?></td>
                        <td><?php echo $row['cin']; ?></td>
                        <td class="fw-bold text-success">Rs. <?php echo number_format($price); ?></td>
                        <td><span class="badge <?php echo $badgeClass; ?> p-2 px-3"><?php echo $statusText; ?></span></td>
                    </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Abhi tak koi confirmed reservation nahi hai.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="mt-3">
        <a href="admin-dashboard.php" class="btn btn-outline-secondary">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>