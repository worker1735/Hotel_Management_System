<?php
session_start();
include "db.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rooms | HotelIQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{ background:#111; color:white; }
        .room-card{ background:white; color:black; border-radius:15px; padding:20px; margin-bottom:20px; transition:0.3s; }
        .room-card:hover{ transform: translateY(-5px); }
        .btn-book{ background:#2b1b0f; color:#d4af37; text-decoration:none; padding:10px; display:block; text-align:center; border-radius:8px; font-weight:bold; }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-5">Available Rooms</h2>
    <div class="row">
        <?php
        // Database se sirf Available status uthao
        $query = "SELECT * FROM rooms WHERE status = 'Available'";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
        ?>
        <div class="col-md-4">
            <div class="room-card">
                <h4 class="fw-bold"><?php echo $row['room_type']; ?></h4>
                <p>Room No: <b><?php echo $row['room_number']; ?></b></p>
                <p>Bed: <?php echo $row['bed_size']; ?></p>
                <p>Price: <span class="text-success fw-bold">Rs. <?php echo number_format($row['price_per_night'], 2); ?></span></p>
                <a href="reservation.php?room_id=<?php echo $row['id']; ?>" class="btn-book">Book Now</a>
            </div>
        </div>
        <?php 
            } 
        } else {
            echo "<div class='text-center w-100'><h3>Koi room khali nahi hai!</h3><p>Sab booked hain ya database mein status update nahi hai.</p></div>";
        }
        ?>
    </div>
</div>
</body>
</html>