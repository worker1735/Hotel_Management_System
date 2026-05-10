<?php
// Database Connection
$conn = mysqli_connect("localhost", "root", "", "hotel_db");

if (!$conn) {
    die("<div style='color:red; text-align:center;'>Database Connection Failed: " . mysqli_connect_error() . "</div>");
}

// Logic to Add Room
if (isset($_POST['add_room'])) {
    $room_no   = mysqli_real_escape_string($conn, $_POST['room_no']);
    $room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
    $bed_size  = mysqli_real_escape_string($conn, $_POST['bed_size']);
    $price     = mysqli_real_escape_string($conn, $_POST['price']);
    $status    = mysqli_real_escape_string($conn, $_POST['status']);
    $desc      = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "INSERT INTO rooms (room_number, room_type, bed_size, price_per_night, status, description) 
            VALUES ('$room_no', '$room_type', '$bed_size', '$price', '$status', '$desc')";
    
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Room Added Successfully!'); window.location='manage-rooms.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms | Admin Dashboard</title>
    <style>
        :root {
            --primary-brown: #4E342E; /* Deep Coffee Brown */
            --accent-brown: #8D6E63;
            --black-bg: #1A1A1A;
            --white: #FFFFFF;
            --light-gray: #F8F9FA;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: var(--light-gray);
            margin: 0;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background-color: var(--black-bg);
            color: var(--white);
            padding: 20px;
            border-radius: 8px 8px 0 0;
            border-bottom: 4px solid var(--primary-brown);
            margin-bottom: 30px;
        }

        .header h1 { margin: 0; font-weight: 300; letter-spacing: 1px; }

        /* Form Section */
        .section-card {
            background: var(--white);
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        h3 { color: var(--primary-brown); margin-top: 0; border-left: 4px solid var(--primary-brown); padding-left: 10px; }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            outline: none;
        }

        .form-group input:focus { border-color: var(--accent-brown); }

        .btn-submit {
            background-color: var(--primary-brown);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
            margin-top: 20px;
        }

        .btn-submit:hover { background-color: var(--black-bg); }

        /* Table Section */
        .table-responsive {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background-color: var(--primary-brown);
            color: white;
            padding: 15px;
            text-align: left;
            text-transform: uppercase;
            font-size: 13px;
        }

        table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            color: #444;
        }

        table tr:nth-child(even) { background-color: #fcfcfc; }
        table tr:hover { background-color: #f5f5f5; }

        .badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-Available { background: #E8F5E9; color: #2E7D32; }
        .status-Booked { background: #FFEBEE; color: #C62828; }
        .status-Maintenance { background: #FFF3E0; color: #E65100; }

    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="header">
        <h1>Hotel Admin Panel</h1>
    </div>

    <!-- Form Area -->
    <div class="section-card">
        <h3>Add New Room Details</h3>
        <form action="" method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label>Room Number</label>
                    <input type="text" name="room_no" placeholder="Room 101" required>
                </div>
                <div class="form-group">
                    <label>Room Type</label>
                    <select name="room_type" required>
                        <option value="Standard">Standard</option>
                        <option value="Executive">Executive</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="Suite">Suite</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bed Size</label>
                    <select name="bed_size" required>
                        <option value="Single Bed">Single Bed</option>
                        <option value="Double Bed">Double Bed</option>
                        <option value="Queen Size">Queen Size</option>
                        <option value="King Size">King Size</option>
                        <option value="Twin Bed">Twin Bed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Price / Night (PKR)</label>
                    <input type="number" name="price" placeholder="5000" required>
                </div>
                <div class="form-group">
                    <label>Initial Status</label>
                    <select name="status">
                        <option value="Available">Available</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                </div>
            </div>
            <div class="form-group" style="margin-top:15px;">
                <label>Room Description</label>
                <textarea name="description" rows="2" placeholder="Describe room view, facilities etc..."></textarea>
            </div>
            <button type="submit" name="add_room" class="btn-submit">Register Room</button>
        </form>
    </div>

    <!-- Inventory Area -->
    <div class="section-card">
        <h3>Room Inventory List</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Room No</th>
                        <th>Type</th>
                        <th>Bed Size</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM rooms ORDER BY id DESC";
                    $res = mysqli_query($conn, $query);
                    
                    if(mysqli_num_rows($res) > 0) {
                        while($row = mysqli_fetch_assoc($res)) {
                            ?>
                            <tr>
                                <td><strong><?php echo $row['room_number']; ?></strong></td>
                                <td><?php echo $row['room_type']; ?></td>
                                <td><?php echo $row['bed_size']; ?></td>
                                <td>Rs. <?php echo number_format($row['price_per_night']); ?></td>
                                <td><span class="badge status-<?php echo $row['status']; ?>"><?php echo $row['status']; ?></span></td>
                                <td><small><?php echo $row['description']; ?></small></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center;'>No rooms found in database.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>