<?php
include "db.php";
$data = mysqli_query($conn,"SELECT * FROM rooms");
?>

<!DOCTYPE html>
<html>
<head>
<title>Rooms</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    padding:0;

    /* ✅ FIXED BACKGROUND IMAGE */
    background-image: url("https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1400&q=80");
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}

/* dark overlay */
.overlay{
    background: rgba(0,0,0,0.65);
    min-height: 100vh;
    padding: 40px 0;
}

h2{
    color:white;
    font-weight:bold;
}

/* cards */
.card{
    border-radius:15px;
    overflow:hidden;
    transition:0.3s;
}

.card:hover{
    transform: scale(1.03);
}

.card-body{
    background:white;
}

.btn-warning{
    font-weight:bold;
}
</style>

</head>

<body>

<div class="overlay">

<div class="container">

<h2 class="text-center mb-5">Our Luxury Rooms</h2>

<div class="row">

<?php while($row=mysqli_fetch_assoc($data)){ ?>

<div class="col-md-4 mb-4">

<div class="card shadow">

<img src="<?php echo $row['image']; ?>" height="220" style="object-fit:cover;">

<div class="card-body">

<h4><?php echo $row['room_name']; ?></h4>

<h5 class="text-warning">
<?php echo $row['price']; ?>/night
</h5>

<p><?php echo $row['guests']; ?></p>

<a href="room-details.php?id=<?php echo $row['id']; ?>" class="btn btn-warning w-100">
View Details
</a>

</div>

</div>

</div>

<?php } ?>

</div>

</div>

</div>

</body>
</html>