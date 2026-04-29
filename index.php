<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HotelIQ</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Poppins', sans-serif;
}

body{
    color:#fff;
}

/* NAVBAR */
.navbar{
    position:absolute;
    width:100%;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 80px;
    z-index:10;
}

.logo{
    font-size:22px;
    font-weight:600;
}

.nav-links{
    display:flex;
    gap:35px;
}

.nav-links a{
    color:#eee;
    text-decoration:none;
    font-size:14px;
}

.nav-btn{
    background:#d4a64a;
    border:none;
    padding:8px 18px;
    border-radius:5px;
    color:#fff;
    cursor:pointer;
}

/* HERO */
.hero{
    height:100vh;
    background:
    linear-gradient(rgba(40,25,10,0.55), rgba(40,25,10,0.55)),
    url('https://images.unsplash.com/photo-1566073771259-6a8506099945');
    background-size:cover;
    background-position:center;
    display:flex;
    align-items:center;
    padding:0 80px;
}

.hero-content{
    max-width:600px;
}

.hero h1{
    font-size:50px;
    font-weight:600;
    margin-bottom:15px;
}

.hero p{
    color:#ddd;
    margin-bottom:25px;
}

.btn-primary{
    background:#d4a64a;
    padding:12px 26px;
    border:none;
    border-radius:6px;
    color:#fff;
    cursor:pointer;
}

/* BOOKING BAR */
.booking-bar{
    position:absolute;
    bottom:40px;
    left:50%;
    transform:translateX(-50%);
    background:rgba(255,255,255,0.95);
    padding:20px 25px;
    border-radius:12px;
    display:flex;
    gap:25px;
    align-items:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}

.field{
    display:flex;
    flex-direction:column;
}

.field label{
    font-size:12px;
    color:#555;
    margin-bottom:5px;
}

.field input, .field select{
    padding:8px 10px;
    border:1px solid #ccc;
    border-radius:5px;
    min-width:140px;
}

.search-btn{
    background:#d4a64a;
    border:none;
    padding:12px 22px;
    color:#fff;
    border-radius:6px;
    cursor:pointer;
}
</style>

</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">HotelIQ</div>

    <div class="nav-links">
        <a href="#">Home</a>
        <a href="rooms.php">Rooms</a>
        <a href="#">Facilities</a>
        <a href="#">About Us</a>
        <a href="#">Contact</a>
    </div>

    <button class="nav-btn" onclick="goLogin()">Login / Register</button>
</div>

<!-- HERO -->
<div class="hero">
    <div class="hero-content">
        <h1>Smart & Intelligent Hotel Management</h1>
        <p>Experience the perfect blend of comfort and technology.</p>
        <button class="btn-primary">Book Your Stay</button>
    </div>
</div>

<!-- BOOKING BAR -->
<div class="booking-bar">

    <div class="field">
        <label>Check-in</label>
        <input type="date" id="checkin">
    </div>

    <div class="field">
        <label>Check-out</label>
        <input type="date" id="checkout">
    </div>

    <div class="field">
        <label>Guests</label>
        <select>
            <option>2 Guests, 1 Room</option>
            <option>1 Guest, 1 Room</option>
            <option>3 Guests, 1 Room</option>
        </select>
    </div>

    <button class="search-btn" onclick="searchRooms()">Search Rooms</button>

</div>

<script>
function goLogin(){
    window.location.href = "role-selection.php";
}

function searchRooms(){
    let checkin = document.getElementById("checkin").value;
    let checkout = document.getElementById("checkout").value;

    if(checkin === "" || checkout === ""){
        alert("Select dates first");
        return;
    }

    window.location.href = "rooms.php";
}
</script>

</body>
</html>