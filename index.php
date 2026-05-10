<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HotelIQ | Smart Management</title>

<style>
/* Global Styles & Smooth Scroll */
html {
    scroll-behavior: smooth;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Poppins', sans-serif;
}

body{
    color:#fff;
    background: #121212;
    line-height: 1.6;
}

/* NAVBAR */
.navbar{
    position:fixed;
    width:100%;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 80px;
    z-index:100;
    background: rgba(0,0,0,0.7);
    backdrop-filter: blur(10px);
}

.logo{
    font-size:24px;
    font-weight:700;
    color: #d4a64a;
    letter-spacing: 1px;
}

.nav-links{
    display:flex;
    gap:35px;
}

.nav-links a{
    color:#eee;
    text-decoration:none;
    font-size:15px;
    font-weight: 500;
    transition: 0.3s;
}

.nav-links a:hover{
    color: #d4a64a;
}

.nav-btn{
    background:#d4a64a;
    border:none;
    padding:10px 22px;
    border-radius:5px;
    color:#fff;
    font-weight: 600;
    cursor:pointer;
    transition: 0.3s;
}

.nav-btn:hover{
    background: #b88d3a;
}

/* HERO SECTION */
.hero{
    height:100vh;
    background:
    linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
    url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1200');
    background-size:cover;
    background-position:center;
    display:flex;
    flex-direction: column;
    justify-content: center;
    align-items:center;
    text-align: center;
    padding:0 20px;
}

.hero h1{
    font-size:60px;
    font-weight:700;
    margin-bottom:15px;
    letter-spacing: 2px;
}

.hero p{
    font-size: 20px;
    color:#ddd;
    max-width: 700px;
}

/* SECTION COMMON STYLING */
.section {
    padding: 100px 80px;
    min-height: 80vh;
}

.section h2 {
    font-size: 40px;
    color: #d4a64a;
    margin-bottom: 30px;
    text-align: center;
}

.section-desc {
    text-align: center;
    color: #ccc;
    max-width: 800px;
    margin: 0 auto 50px auto;
    font-size: 17px;
}

/* FACILITIES GRID */
.facilities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
}

.facility-card {
    background: #1e1e1e;
    border-radius: 12px;
    overflow: hidden;
    transition: 0.4s;
    border: 1px solid #333;
}

.facility-card:hover {
    transform: translateY(-10px);
    border-color: #d4a64a;
}

.facility-card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
}

.facility-card h3 {
    padding: 20px;
    font-size: 20px;
    color: #fff;
    text-align: center;
}

/* ABOUT & CONTACT */
#about { background: #181818; }
#contact { background: #121212; }

.contact-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    gap: 30px;
    margin-top: 40px;
}

.contact-item {
    text-align: center;
    background: #1e1e1e;
    padding: 30px;
    border-radius: 10px;
    width: 300px;
}

.contact-item strong {
    display: block;
    color: #d4a64a;
    font-size: 20px;
    margin-bottom: 10px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .navbar { padding: 20px; }
    .nav-links { display: none; }
    .hero h1 { font-size: 35px; }
    .section { padding: 60px 20px; }
}
</style>

</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">HotelIQ</div>

    <div class="nav-links">
        <a href="#">Home</a>
        <a href="#facilities">Facilities</a>
        <a href="#about">About Us</a>
        <a href="#contact">Contact</a>
    </div>

    <button class="nav-btn" onclick="goLogin()">Login / Register</button>
</div>

<!-- HERO -->
<div class="hero">
    <h1>Smart & Intelligent</h1>
    <p>Experience the perfect blend of comfort and cutting-edge technology.</p>
</div>

<!-- FACILITIES SECTION -->
<div id="facilities" class="section">
    <h2>Our Facilities</h2>
    <p class="section-desc">We offer a wide range of premium facilities to ensure your stay is comfortable and memorable.</p>
    
    <div class="facilities-grid">
        <div class="facility-card">
            <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?q=80&w=600" alt="High Speed Wi-Fi">
            <h3>Free High-Speed Wi-Fi</h3>
        </div>

        <div class="facility-card">
            <!-- New Spa Image Link -->
            <img src="https://images.unsplash.com/photo-1595871151608-bc7abd1caca3?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTl8fGJlYXV0eSUyMHNwYXxlbnwwfHwwfHx8MA%3D%3D" alt="Spa and Wellness">
            <h3>Spa & Wellness</h3>
        </div>

        <div class="facility-card">
            <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=600" alt="Swimming Pool">
            <h3>Infinity Pool</h3>
        </div>

        <div class="facility-card">
            <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=600" alt="Gym">
            <h3>Smart Gym</h3>
        </div>

        <div class="facility-card">
            <img src="https://images.unsplash.com/photo-1590073844006-33379778ae09?q=80&w=600" alt="Dining">
            <h3>Fine Dining</h3>
        </div>

        <div class="facility-card">
            <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=600" alt="Room Service">
            <h3>24/7 Room Service</h3>
        </div>
    </div>
</div>

<!-- ABOUT SECTION -->
<div id="about" class="section">
    <h2>About Us</h2>
    <p class="section-desc">HotelIQ is a modern hospitality solution that integrates advanced technology with premium service. Our goal is to make your hotel experience seamless, intelligent, and truly exceptional.</p>
</div>

<!-- CONTACT SECTION -->
<div id="contact" class="section">
    <h2>Contact Us</h2>
    <p class="section-desc">Have any questions? We are here to help you 24/7.</p>
    
    <div class="contact-container">
        <div class="contact-item">
            <strong>Email</strong>
            <p>support@hoteliq.com</p>
        </div>
        <div class="contact-item">
            <strong>Phone</strong>
            <p>+92 300 1234567</p>
        </div>
        <div class="contact-item">
            <strong>Address</strong>
            <p>Hotel IQ, lahore, Pakistan</p>
        </div>
    </div>
</div>

<script>
function goLogin(){
    window.location.href = "role-selection.php";
}
</script>

</body>
</html>