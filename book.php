<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

if(isset($_POST['room_id'])){
    $user_id = $_SESSION['user_id'];
    $room_id = $_POST['room_id'];

    $checkin = date("Y-m-d");
    $checkout = date("Y-m-d", strtotime("+1 day"));

    $query = "INSERT INTO bookings (user_id, room_id, checkin, checkout, guests, total_price)
              VALUES ('$user_id','$room_id','$checkin','$checkout','1','0')";

    if(mysqli_query($conn,$query)){
        echo "<script>alert('Room Booked Successfully'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>