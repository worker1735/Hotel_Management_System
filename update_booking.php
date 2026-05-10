<?php
include 'db_config.php';

if(isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];
    
    // Status update logic
    $newStatus = ($action == 'Accept') ? 'Confirmed' : 'Cancelled';
    
    $updateQuery = "UPDATE reservations SET status = '$newStatus' WHERE id = $id";
    
    if(mysqli_query($conn, $updateQuery)) {
        header("Location: admin-dashboard.php?msg=Success");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>