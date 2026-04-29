<?php
session_start();
include "db.php";

if(isset($_POST['add']))
{
$name=$_POST['name'];
$price=$_POST['price'];

mysqli_query($conn,"
INSERT INTO rooms(room_name,price,image,guests,beds,wifi,status)
VALUES('$name','$price','room1.jpg','2 Guests','1 Bed','Free Wifi','Available')
");
}

if(isset($_GET['del']))
{
$id=$_GET['del'];
mysqli_query($conn,"DELETE FROM rooms WHERE id='$id'");
}

$data=mysqli_query($conn,"SELECT * FROM rooms");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Rooms</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Manage Rooms</h2>

<form method="POST" class="row mt-4">

<div class="col-md-5">
<input type="text" name="name" class="form-control" placeholder="Room Name">
</div>

<div class="col-md-5">
<input type="text" name="price" class="form-control" placeholder="Price">
</div>

<div class="col-md-2">
<button name="add" class="btn btn-warning w-100">Add</button>
</div>

</form>

<table class="table table-bordered mt-4">

<tr>
<th>ID</th>
<th>Name</th>
<th>Price</th>
<th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($data)){ ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['room_name']; ?></td>
<td><?php echo $row['price']; ?></td>
<td>
<a href="?del=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
</td>
</tr>

<?php } ?>

</table>

</div>
</body>
</html>