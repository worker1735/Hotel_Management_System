<?php
session_start();
include "db.php";

// login check
if(!isset($_SESSION['email'])){
    echo "Login required";
    exit;
}

// room id check (GET use hoga)
if(!isset($_GET['room_id'])){
    echo "Invalid request";
    exit;
}

$room_id = $_GET['room_id'];
$user_email = $_SESSION['email'];

// room fetch
$room = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rooms WHERE id='$room_id'"));

if(!$room){
    echo "Room not found";
    exit;
}

// insert into roombook (tumhari original table)
$query = "INSERT INTO roombook 
(FName, Email, TRoom, Bed, NRoom, cin, cout, stat, status)
VALUES 
('User', '$user_email', '".$room['room_type']."', '".$room['bed_size']."', 1, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 DAY), 'Pending', 'Pending')";

if(mysqli_query($conn, $query)){
    header("Location: user-dashboard.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>