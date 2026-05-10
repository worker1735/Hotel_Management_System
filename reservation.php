<?php
session_start();
include('db.php');

// Database connection (Using your config)
$con = mysqli_connect("localhost", "root", "", "hotel_db");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$login_user_id = $_SESSION['user_id'];
$user_res = mysqli_query($con, "SELECT * FROM users WHERE id = '$login_user_id'");
$user_data = mysqli_fetch_assoc($user_res);

$session_fname = $user_data['fullname'];
$session_email = $user_data['email'];

$r_id = isset($_GET['room_id']) ? $_GET['room_id'] : '';

// 1. Room table se room ki price aur details uthana
$room_info = mysqli_query($con, "SELECT * FROM rooms WHERE id = '$r_id'");
$room_data = mysqli_fetch_assoc($room_info);

// Room ki price per night
$room_price_per_night = $room_data['price_per_night'] ?? 0;

if(isset($_POST['submit'])) {

    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);

    $troom = $room_data['room_type'];
    $bed = $room_data['bed_size'];

    $nroom = 1;
    $meal = mysqli_real_escape_string($con, $_POST['meal']);
    $cin = mysqli_real_escape_string($con, $_POST['cin']);
    $cout = mysqli_real_escape_string($con, $_POST['cout']);
    $target_room_id = mysqli_real_escape_string($con, $_POST['target_room_id']);

    // --- PRICING CALCULATION ---
    
    // 2. Meal Price set karna
    $meal_price = 0;
    if($meal == "Breakfast") { $meal_price = 500; }
    else if($meal == "Full Board") { $meal_price = 1500; }

    // 3. Days calculate karna
    $date1 = new DateTime($cin);
    $date2 = new DateTime($cout);
    $diff = $date1->diff($date2);
    $days = $diff->days;
    if($days <= 0) { $days = 1; } // Kam az kam 1 din ka charge

    // 4. Total Price Calculate karna
    $total_bill = ($room_price_per_night + $meal_price) * $days;

    $status = "Not Conform";

    // 5. Database mein data insert karna (Updated with pricing columns)
    $newUser = "INSERT INTO `roombook`
    (`Title`, `FName`, `LName`, `Email`, `National`, `Country`, `Phone`, `TRoom`, `Bed`, `NRoom`, `Meal`, `meal_price`, `room_price`, `cin`, `cout`, `stat`, `nodays`, `total_price`)
    VALUES
    ('', '$fname', '$lname', '$email', 'Foreigner', '$country', '$phone', '$troom', '$bed', '$nroom', '$meal', '$meal_price', '$room_price_per_night', '$cin', '$cout', '$status', '$days', '$total_bill')";

    if (mysqli_query($con, $newUser)) {
        // Room status update
        $updateRoom = "UPDATE rooms SET status = 'Booked' WHERE id = '$target_room_id'";
        mysqli_query($con, $updateRoom);

        echo "<script>alert('Booking Successful! Total Amount: Rs. $total_bill'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Booking Failed: " . mysqli_error($con) . "')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>RESERVATION | HotelIQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1a1a1a; color: #ffffff; font-family: 'Segoe UI', sans-serif; }
        .page-header { color: #d4a373; border-bottom: 2px solid #3d2b1f; padding-bottom: 10px; font-weight: bold; }
        .panel { background: #ffffff; color: #333; border-radius: 12px; border: 4px solid #5e4033; }
        .panel-heading { background-color: #3d2b1f; color: #d4a373; padding: 15px; font-weight: bold; }
        .panel-body { padding: 25px; }
        .form-label { font-weight: 600; color: #5e4033; }
        .btn-reserve { background-color: #5e4033; color: white; border: none; padding: 12px 40px; font-weight: bold; transition: 0.3s; }
        .btn-reserve:hover { background-color: #d4a373; color: #3d2b1f; }
        .well { background: #2a2a2a; padding: 30px; border-radius: 10px; border: 1px solid #3d2b1f; }
        .room-summary { background: #fdf5f2; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #5e4033; color: #333; }
    </style>
</head>

<body>

<div class="container mt-5">
    <h2 class="page-header text-center mb-4">Complete Your Reservation</h2>

    <form method="post">
        <input type="hidden" name="target_room_id" value="<?php echo $r_id; ?>">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel shadow mb-4">
                    <div class="panel-heading">BOOKING DETAILS & PERSONAL INFO</div>

                    <div class="panel-body">

                        <div class="room-summary">
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong>Selected Room:</strong> <?php echo $room_data['room_type']; ?> <br>
                                    <strong>Bedding:</strong> <?php echo $room_data['bed_size']; ?>
                                </div>
                                <div class="col-sm-6 text-sm-end">
                                    <h5 class="text-brown">Price: Rs. <?php echo number_format($room_price_per_night); ?> / Night</h5>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input name="fname" class="form-control" value="<?php echo $session_fname; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input name="lname" class="form-control" placeholder="Enter Last Name" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input name="email" type="email" class="form-control" value="<?php echo $session_email; ?>" readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input name="phone" type="tel" class="form-control" placeholder="03XXXXXXXXX" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meal Plan</label>
                                <select name="meal" class="form-select">
                                    <option value="Room only">Room Only (Rs. 0)</option>
                                    <option value="Breakfast">Breakfast (+ Rs. 500)</option>
                                    <option value="Full Board">Full Board (+ Rs. 1500)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Check-In</label>
                                <input name="cin" type="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Check-Out</label>
                                <input name="cout" type="date" class="form-control" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select name="country" class="form-select">
                                <option value="Pakistan">Pakistan</option>
                                <option value="UAE">UAE</option>
                                <option value="USA">USA</option>
                                <option value="UK">UK</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="text-center well">
            <button type="submit" name="submit" class="btn btn-reserve btn-lg me-3 shadow">CONFIRM BOOKING</button>
            <a href="rooms.php" class="btn btn-outline-light btn-lg">CANCEL</a>
        </div>

    </form>
</div>

</body>
</html>