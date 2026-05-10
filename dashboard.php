<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$userQuery = mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($userQuery);
$email = $user['email'];
$fullname = $user['fullname'];

/* --- PAYMENT LOGIC (SANDBOX) --- */
if(isset($_GET['pay_id']) && isset($_GET['amount'])){
    $p_id = $_GET['pay_id'];
    $paid_amt = $_GET['amount'];
    
    // Yahan hum status ko 'Paid' update kar rahe hain
    // Aap is amount ko kisi payment table mein bhi save kar sakti hain agar zaroorat ho
    mysqli_query($conn, "UPDATE roombook SET stat='Paid' WHERE id='$p_id' AND Email='$email'");
    
    header("Location: dashboard.php?msg=paid");
    exit();
}

/* --- CANCEL LOGIC --- */
if(isset($_GET['cancel_id'])){
    $c_id = $_GET['cancel_id'];
    $getRoom = mysqli_query($conn, "SELECT TRoom, Bed FROM roombook WHERE id='$c_id'");
    if(mysqli_num_rows($getRoom) > 0){
        $rData = mysqli_fetch_assoc($getRoom);
        $troom = $rData['TRoom'];
        $bed = $rData['Bed'];
        mysqli_query($conn, "UPDATE rooms SET status='Available' WHERE room_type='$troom' AND bed_size='$bed' LIMIT 1");
        mysqli_query($conn, "DELETE FROM roombook WHERE id='$c_id' AND Email='$email'");
    }
    header("Location: dashboard.php");
    exit();
}

$price_logic = "(room_price + meal_price) * nodays";
$totalQuery = mysqli_query($conn,"SELECT COUNT(*) as total FROM roombook WHERE Email='$email'");
$total = mysqli_fetch_assoc($totalQuery)['total'];

$amountQuery = mysqli_query($conn,"SELECT SUM($price_logic) as total_bill FROM roombook WHERE Email='$email'");
$total_bill = mysqli_fetch_assoc($amountQuery)['total_bill'] ?? 0;

$allBookings = mysqli_query($conn,"SELECT *, ($price_logic) as calculated_price FROM roombook WHERE Email='$email' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | HotelIQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{ background:#f8f9fa; }
        .sidebar{ height:100vh; background:#2b1b0f; color:white; padding:20px; position:fixed; width:230px; }
        .sidebar a{ display:block; color:white; padding:12px; text-decoration:none; margin-bottom:10px; border-radius:10px; }
        .sidebar a:hover{ background:#d4af37; color:black; }
        .main{ margin-left:230px; padding:30px; }
        .card-box{ border:none; border-radius:18px; box-shadow:0 0 15px rgba(0,0,0,.08); background: white; }
    </style>
</head>
<body>
<div class="sidebar">
    <h3>HotelIQ</h3>
    <a href="dashboard.php" style="background:#d4af37; color:black;">Dashboard</a>
    <a href="rooms.php">Rooms</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
    <h2>Welcome, <?php echo $fullname; ?></h2>

    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'paid'): ?>
        <div class="alert alert-success">Payment Successful! Status updated to Paid.</div>
    <?php endif; ?>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card card-box p-4 text-center">
                <h6>Total Reservations</h6>
                <h2><?php echo $total; ?></h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-box p-4 text-center">
                <h6>Total Bill</h6>
                <h2 style="color:#d4af37;">Rs. <?php echo number_format($total_bill, 2); ?></h2>
            </div>
        </div>
    </div>

    <div class="card card-box p-4 mt-4">
        <h4>My Bookings</h4>
        <table class="table mt-3 align-middle">
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Check-In</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($allBookings)){ ?>
                <tr>
                    <td><?php echo $row['TRoom']; ?><br><small><?php echo $row['Bed']; ?></small></td>
                    <td><?php echo $row['cin']; ?></td>
                    <td>Rs. <?php echo number_format($row['calculated_price'], 2); ?></td>
                    <td>
                        <?php if($row['stat'] == 'Paid'): ?>
                            <span class="badge bg-success">Paid</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark"><?php echo $row['stat']; ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($row['stat'] != 'Paid'): ?>
                            <button onclick="payNow(<?php echo $row['id']; ?>, <?php echo $row['calculated_price']; ?>)" class="btn btn-sm btn-success">Pay Now</button>
                            
                            <a href="dashboard.php?cancel_id=<?php echo $row['id']; ?>" 
                               onclick="return confirm('Cancel karein?')" 
                               class="btn btn-sm btn-outline-danger">Cancel</a>
                        <?php else: ?>
                            <button class="btn btn-sm btn-secondary" disabled>Completed</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function payNow(bookingId, totalAmount) {
    let amount = prompt("Enter payment amount (Total: Rs. " + totalAmount + "):", totalAmount);
    
    if (amount != null && amount != "") {
        if (parseFloat(amount) >= totalAmount) {
            alert("Payment of Rs. " + amount + " received! Updating status...");
            window.location.href = "dashboard.php?pay_id=" + bookingId + "&amount=" + amount;
        } else {
            alert("Amount is less than total bill. Please pay full amount.");
        }
    }
}
</script>

</body>
</html>