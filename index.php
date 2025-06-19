<?php
include_once("db_conn.php");

// Fetch dormitories data from the database
$sql = "SELECT dorm_id, dorm_name, lat, lng FROM dormitories";
$result = $conn->query($sql);

$dormitoriesData = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dormitoriesData[] = array(
            'dorm_id' => $row['dorm_id'],
            'dorm_name' => $row['dorm_name'],
            'lat' => $row['lat'],
            'lng' => $row['lng'],
        );
    }
}

// Close the database connection
$conn->close();

?>


<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Get Started</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">

</head>
    
    <body>
    
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->
    
    
    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="#" class="logo">
                            <img src="assets/images/header.png"/>
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="u-dashboard.php">Find a Dorm</a></li>
                            <li><a href="#maps">Maps</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="#web-features">Features</a></li>
                            <li><a href="#dorms">Dorms</a></li>
                            <li><a href="#developers">Developers</a></li>
                            <li><a href="#contact-us">Contact Us</a></li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header><br><br>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Maps Start ***** -->
    <section class="section colored">
    <div class="header-text">
        <div class="offset-xl-3 col-xl-6 offset-lg-2 col-lg-8 col-md-12 col-sm-12">
            <strong><h1>Dorm<span class="ease" style="color:#6D6D6D;">Ease</span></h1></strong>
            <p>Welcome to <strong>DormEase</strong>, your ultimate companion for navigating the Cavite State University's Indang 
                campus dormitories! Our project focuses on the development and design of a user-friendly 
                2D Dormitory Map Directory tailored specifically for CvSU students in Indang, Cavite.</p>
        </div>
        </div>
    </section>
    <section class="waves-feature">
    <img class="waves1" src="assets/images/waves1.svg">
</section>
    <section class="section" id="maps">
        <div class="container">
    
            <!-- ***** Section Title Start ***** -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="center-heading">
                        <h2 class="section-title">Map of Indang, Cavite</h2>
                        <div id="map" style="height: 400px; width: 100%;">
                        <script src="assets/js/index.js"></script>
                        
                        </div>
                    </div>
                </div>
            </div>
            <!-- ***** Section Title End ***** -->
            </div>
    </section>
    <!-- ***** Maps End ***** -->

    <!-- ***** Features Big Item Start ***** -->
    <section class="section colored padding-top-70 padding-bottom-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-12 col-sm-12 align-self-center" data-scroll-reveal="enter left move 30px over 0.6s after 0.4s">
                    <img src="assets/images/left.svg" class="rounded img-fluid d-block mx-auto" alt="App">
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-6 col-md-12 col-sm-12 align-self-center mobile-top-fix">
                    <div class="left-heading">
                        <h2 class="section-title">Dormitory Finder</h2>
                    </div>
                    <div class="left-text">
                        <p>Welcome to the Dormitory Finder, your key to hassle-free accommodation search! 
                            Navigating the world of registered dormitories has never been easier, thanks to our dedicated tool 
                            designed to simplify the process and match you with the perfect dormitory.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="hr"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Features Big Item End ***** -->

    <!-- ***** Features Big Item Start ***** -->
    <section class="section colored">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 align-self-center mobile-bottom-fix">
                    <div class="left-heading">
                        <h2 class="section-title">2D Map Dormitory Locator</h2>
                    </div>
                    <div class="left-text">
                        <p>The 2D Map Dormitory Locator, your ultimate companion for navigating dormitories with 
                            precision and ease! This innovative tool combines cutting-edge technology with user-friendly 
                            design, offering an immersive experience to streamline your search for the ideal dormitory.</p>
                    </div>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-5 col-md-12 col-sm-12 align-self-center mobile-bottom-fix-big" data-scroll-reveal="enter right move 30px over 0.6s after 0.4s">
                    <img src="assets/images/right.svg" class="rounded img-fluid d-block mx-auto" alt="App">
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Features Big Item End ***** -->

    <!-- ***** Home Parallax Start ***** -->
    <section class="mini" id="web-features">
        <div class="mini-content">
            <div class="container">
                <div class="row">
                    <div class="offset-lg-3 col-lg-6">
                        <div class="info">
                            <h1 style="font-family: GBook; font-size:6vh;">Website Features</h1>
                            <p>Embark on a seamless journey with the exceptional array of features on our website. 
                                Designed to elevate your digital experience, our website features go beyond the ordinary, 
                                offering a user-friendly and dynamic platform for searching dormitories near Cavite State University.</p>
                        </div>
                    </div>
                </div>

                <!-- ***** Mini Box Start ***** -->
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <a href="#" class="mini-box">
                            <i><img src="assets/images/eye.svg" alt=""></i>
                            <strong>View Dormitories</strong>
                            <span>You get to view registered dormitories near CvSU.</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <a href="#" class="mini-box">
                            <i><img src="assets/images/search.svg" alt=""></i>
                            <strong>Search Dormitories</strong>
                            <span>You can search for dormitories of your choice.</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <a href="#" class="mini-box">
                            <i><img src="assets/images/sort.svg" alt=""></i>
                            <strong>Sort Dormitories</strong>
                            <span>You can sort dormitories by price or by barangay.</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <a href="#" class="mini-box">
                            <i><img src="assets/images/status.svg" alt=""></i>
                            <strong>Dormitory Availability</strong>
                            <span>You can see the status of dormitories if they are available</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <a href="#" class="mini-box">
                            <i><img src="assets/images/amenities.svg" alt=""></i>
                            <strong>Dormitory Amenities</strong>
                            <span>This will help you in finding the right dorm for you.</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <a href="#" class="mini-box">
                            <i><img src="assets/images/info.svg" alt=""></i>
                            <strong>Transportation Information</strong>
                            <span>Information regarding transportation from your desired dormitory, 
                                to Cavite State University.
                            </span>
                        </a>
                    </div>
                </div>
                <!-- ***** Mini Box End ***** -->
            </div>
        </div>
    </section>
    <!-- ***** Home Parallax End ***** -->

 <!-- ***** Dorms Start ***** -->
<div class="dorms">
 <section class="section" id="dorms">
        <div class="container">
            <!-- ***** Section Title Start ***** -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="center-heading">
                        <h2 class="section-title">Featured Dormitories</h2>
                    </div>
                </div>
                <div class="offset-lg-3 col-lg-6">
                    <div class="center-text">
                        <p>Featured dormitories in Indang, Cavite near Cavite State University.</p>
                    </div>
                </div>
            </div>
            <!-- ***** Section Title End ***** -->

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="blog-post-thumb">
                        <div class="img">
                            <img src="assets/images/upperdeck-dorm2.png" alt="">
                        </div>
                        <div class="blog-content">
                            <h3>
                                <a href="#">Upperdeck 15.com Dormitory</a>
                            </h3>
                            <div class="text">
                            <img src="assets/images/address.png">
                                9082 Roughroad, Brgy. Kaytapos, Indang, Cavite
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="blog-post-thumb">
                        <div class="img">
                            <img src="assets/images/2.png" alt="">
                        </div>
                        <div class="blog-content">
                            <h3>
                                <a href="#">Lola Fely's Dormitory</a>
                            </h3>
                            <div class="text">
                            <img src="assets/images/address.png">
                                St. Agatha Village, Brgy. Kaytapos, Indang, Cavite
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="blog-post-thumb">
                        <div class="img">
                            <img src="assets/images/3.png" alt="">
                        </div>
                        <div class="blog-content">
                            <h3>
                                <a href="#">H.L Lozada Dormitory</a>
                            </h3>
                            <div class="text">
                            <img src="assets/images/address.png">
                                025 H. Ilagan St., Brgy. Poblacion 1, Indang, Cavite
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Dorms End ***** -->
    </div>

     <!-- ***** Developers Start ***** -->
     <section class="section" id="developers">
        <div class="container">
            <!-- ***** Section Title Start ***** -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="center-heading">
                        <h2 class="section-title">Meet the Developers!</h2>
                    </div>
                </div>
                <div class="offset-lg-3 col-lg-6">
                    <div class="center-text">
                        <p>Step behind the scenes and get acquainted with the brilliant minds shaping our 
                            digital landscape. Our developers bring a wealth of expertise and innovation to 
                            the table.</p>
                    </div>
                </div>
            </div>
            <!-- ***** Section Title End ***** -->

            <div class="row">
                <!-- ***** Developers Item Start ***** -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="team-item">
                        <div class="team-content">
                            <p>I bring four years of expertise in CSS, HTML, JS, Python, and C++. 
                            I have exceptional skills in handling the intricacies of document management, ensuring that 
                            our website's content is not only accurate but also well-organized.</p>
                            <div class="user-image">
                                <img src="assets/images/zandrine.png" alt="">
                            </div>
                            <div class="team-info">
                                <h3 class="user-name">Zandrine Cañete</h3>
                                <span>Documents/Papers</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ***** Developers Item End ***** -->
                
                <!-- ***** Developers Item Start ***** -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="team-item">
                        <div class="team-content">
                            <p>With a background in HTML/CSS since 2015, I offer a wealth of experience in JavaScript, 
                                MySQL, and Python spanning four years. My dedication to crafting dynamic and responsive web 
                                solutions enhances the functionality and user experience of our endeavors.</p>
                            <div class="user-image">
                                <img src="assets/images/julia.png" alt="">
                            </div>
                            <div class="team-info">
                                <h3 class="user-name">Julia Tadeo</h3>
                                <span>Developer</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ***** Developers Item End ***** -->
                
                <!-- ***** Developers Item Start ***** -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="team-item">
                        <div class="team-content">
                        <p>As a Data Collector, I specialize in hands-on data collection to enhance our 
                        website's features. My role revolves around ensuring the accuracy 
                        and completeness, providing users with a seamless and reliable dormitory finding experience.
                        </p>
                            <div class="user-image">
                                <img src="assets/images/hans.png" alt="">
                            </div>
                            <div class="team-info">
                                <h3 class="user-name">Hans Bartolome</h3>
                                <span>Data Collector</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ***** Developers Item End ***** -->
            </div>
        </div>
    </section>
    <!-- ***** Developers End ***** -->


    <!-- ***** Contact Us Start ***** -->
    <section class="section colored" id="contact-us">
        <div class="container">
            <!-- ***** Section Title Start ***** -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="center-heading">
                        <h2 class="section-title">Talk To Us</h2>
                    </div>
                </div>
                <div class="offset-lg-3 col-lg-6">
                    <div class="center-text">
                        <p>Explore the avenue to connect directly with the masterminds behind our projects. 
                            We provide you with the means to reach out, ask questions, and engage with our talented team.</p>
                    </div>
                </div>
            </div>
            <!-- ***** Section Title End ***** -->

            <div class="row">
             <!-- Mini Box 1 -->
             <div class="col-md-4">
                <div class="mini-box">
                    <div class="mini-box-content">
                        <h4>Julia Tadeo</h4>
                        <p>Phone Number: +639068848521</p>
                        <p>Business Hours: Weekends <br>(02:00 PM - 10:00 PM)</p>
                    </div>
                    <div class="mini-box-icons">
                        <a href="https://www.facebook.com/thejuliatadeo"  target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="mailto:juliacristine.tadeo@cvsu.edu.ph"><i class="fa fa-envelope"></i></a>
                    </div>
                </div>
            </div>

            <!-- Mini Box 2 -->
            <div class="col-md-4">
                <div class="mini-box">
                    <div class="mini-box-content">
                        <h4>Zandrine Cañete</h4>
                        <p>Phone Number: +639264944264</p>
                        <p>Business Hours: Weekdays <br>(08:00 AM - 05:00 PM)</p>
                    </div>
                    <div class="mini-box-icons">
                        <a href="https://www.facebook.com/zndrncnt" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="mailto:zandrine.canete@cvsu.edu.ph"><i class="fa fa-envelope"></i></a>
                    </div>
                </div>
            </div>

            <!-- Mini Box 1 -->
            <div class="col-md-4">
                <div class="mini-box">
                    <div class="mini-box-content">
                        <h4>Hans Bartolome</h4>
                        <p>Phone Number: +639994328208</p>
                        <p>Business Hours: Weekends <br>(08:00 AM - 01:00 PM)</p>
                    </div>
                    <div class="mini-box-icons">
                        <a href="https://www.facebook.com/hans.bartolomew" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="mailto:hanschristian.bartolome@cvsu.edu.ph"><i class="fa fa-envelope"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- ***** Contact Us End ***** -->
    
    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container"> 
            <div class="row">
                <div class="col-lg-12">
                    <p class="copyright">Copyright &copy; 2024 Software Engineering II Requirement </p>
            </div>
        </div>
    </footer>
<script defer async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdDeqiJgvPJAOuYgqok22Wig8_OrFjal8&map_ids=6f33173a4413a9fc&callback=initMap"></script>

<script>
    var activePolygon;
var kaytaposPolyline;
var bancodPolyline;

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 14.200974449976675, lng: 120.88241101039964},
        zoom: 15,
        mapId: '6f33173a4413a9fc',

    });
    var kaytaposCoords = [
        { lat: 14.201643017801198, lng: 120.87573163660385 },
        { lat: 14.20008937134657, lng: 120.8771431490985 },
        { lat: 14.198653864910423, lng: 120.87757758726416 },
        { lat: 14.196311290446447, lng: 120.87933332718303 },
        { lat: 14.19602265725051, lng: 120.8793608198251 },
        { lat: 14.195970001153958, lng: 120.87975175179308 },
        { lat: 14.195444423267562, lng: 120.87976631430132 },
        { lat: 14.194844901401972, lng: 120.87967213083294 },
        { lat: 14.194524004755435, lng: 120.87967942759255 },
        { lat: 14.194027404448445, lng: 120.87997520566215 },
        { lat: 14.193916890667417, lng: 120.88014485538389 },
        { lat: 14.193314617293522, lng: 120.88004289188066 },
        { lat: 14.194561411731952, lng: 120.88449815733435 },
        { lat: 14.194651366607667, lng: 120.88618346508775 },
        { lat: 14.19506155138944, lng: 120.88760408060448 },
        { lat: 14.195199960466478, lng: 120.88831339360907 },
        { lat: 14.19613969975598, lng: 120.89143926286748 },
        { lat: 14.197551118750619, lng: 120.89062370298252 },
        { lat: 14.198015887518933, lng: 120.89003789963972 },
        { lat: 14.198368012045616, lng: 120.88840477112153 },
        { lat: 14.203615597447389, lng: 120.88227063353993 },
        { lat: 14.201643017801198, lng: 120.87573163660385 }
    ];

    // Coordinates for Bancod
var bancodCoords = [
    { lat: 14.201643735917026, lng: 120.87573019655873 },
    { lat: 14.202753974801846, lng: 120.87576204066723 },
    { lat: 14.203517789145343, lng: 120.87544218724129 },
    { lat: 14.206015003767037, lng: 120.87545718774044 },
    { lat: 14.206916060285467, lng: 120.87645566598606 },
    { lat: 14.207655158997172, lng: 120.87681508199402 },
    { lat: 14.208884384669918, lng: 120.8761425180848 },
    { lat: 14.210135000604808, lng: 120.87522783795346 },
    { lat: 14.21337631361339, lng: 120.87454080757223 },
    { lat: 14.21951311964056, lng: 120.87224550721064 },
    { lat: 14.221433469209126, lng: 120.87251793845304 },
    { lat: 14.22242862036443, lng: 120.87224502368709 },
    { lat: 14.222984369101473, lng: 120.87193992241004 },
    { lat: 14.224140712100255, lng: 120.8719238291566 },
    { lat: 14.226176531902187, lng: 120.87132236214562 },
    { lat: 14.228005007827146, lng: 120.87119178027972 },
    { lat: 14.230279639177896, lng: 120.86920082554361 },
    { lat: 14.23268692541217, lng: 120.86872037651456 },
    { lat: 14.233474687456095, lng: 120.86809408070833 },
    { lat: 14.235949360650872, lng: 120.86787318100286 },
    { lat: 14.236782328898148, lng: 120.86818551405155 },
    { lat: 14.235323375799936, lng: 120.86930698431131 },
    { lat: 14.233886289418276, lng: 120.86979528744749 },
    { lat: 14.23198808820649, lng: 120.86992507299004 },
    { lat: 14.231502189828166, lng: 120.87036718858958 },
    { lat: 14.231353907458711, lng: 120.87341899971098 },
    { lat: 14.224085386175787, lng: 120.87596702262371 },
    { lat: 14.222763196900548, lng: 120.87697464365255 },
    { lat: 14.221788145844057, lng: 120.87753151917367 },
    { lat: 14.22007567543577, lng: 120.87785158995757 },
    { lat: 14.217739633916198, lng: 120.87747877383929 },
    { lat: 14.215729056686353, lng: 120.87775203868512 },
    { lat: 14.213942805939334, lng: 120.87832508131284 },
    { lat: 14.212528850272063, lng: 120.87947689977332 },
    { lat: 14.211437332160887, lng: 120.88084367275214 },
    { lat: 14.209886125968413, lng: 120.88142263455623 },
    { lat: 14.20863533415357, lng: 120.88131539053052 },
    { lat: 14.205442467908128, lng: 120.88169805611723 },
    { lat: 14.203615258280225, lng: 120.8822692457517 },
    { lat: 14.201643735917026, lng: 120.87573019655873 }
];
var poblacionCoords = [
    { lat: 14.196591971513215, lng: 120.8778030123301 },
    { lat: 14.191784284901138, lng: 120.87780675231457 },
    { lat: 14.192252347305446, lng: 120.87914785683093 },
    { lat: 14.193344489133725, lng: 120.87962529004562 },
    { lat: 14.19393736395454, lng: 120.87966284096912 },
    { lat: 14.19424420205108, lng: 120.87960383236955 },
    { lat: 14.194629049245627, lng: 120.87957701027884 },
    { lat: 14.194842275112466, lng: 120.87936243355315 },
    { lat: 14.195471550295487, lng: 120.87984523118759 },
    { lat: 14.196022814708957, lng: 120.87990423978715 },
    { lat: 14.196591971513215, lng: 120.8778030123301 }
];


// Create a polygon and set its properties
var bancodPolygon = new google.maps.Polygon({
    paths: bancodCoords,
    strokeColor: '#FF0000',
    strokeOpacity: 0,
    fillOpacity: 0, 
    map: null
});

var kaytaposPolygon = new google.maps.Polygon({
    paths: kaytaposCoords,
    strokeColor: '#820300',
    strokeOpacity: 0,
    fillOpacity: 0,
    map: null 
});

var poblacionPolygon = new google.maps.Polygon({
    paths: poblacionCoords,
    strokeColor: '#820300',
    strokeOpacity: 0,
    fillOpacity: 0,
    map: null 
});

var kaytaposPolyline = new google.maps.Polyline({
    path: kaytaposCoords,
    strokeColor: '#820300',
    strokeOpacity: 0,
    icons: [{
        icon: {
            path: 'M 0,-1 0,1',
            strokeOpacity: 0.6,
            scale: 3
        },
        offset: '200px',
        repeat: '10px'
    }],
    map: null
});
var bancodPolyline = new google.maps.Polyline({
    path: bancodCoords,
    strokeColor: '#820300',
    strokeOpacity: 0,
    icons: [{
        icon: {
            path: 'M 0,-1 0,1',
            strokeOpacity: 0.6,
            scale: 3
        },
        offset: '200px',
        repeat: '10px'
    }],
    map: null
});

var poblacionPolyline = new google.maps.Polyline({
    path: poblacionCoords,
    strokeColor: '#820300',
    strokeOpacity: 0,
    icons: [{
        icon: {
            path: 'M 0,-1 0,1',
            strokeOpacity: 0.6,
            scale: 3
        },
        offset: '200px',
        repeat: '10px'
    }],
    map: null
});
    
    // Add the polygon to the map
    poblacionPolygon.setMap(map);
    bancodPolygon.setMap(map);
    kaytaposPolygon.setMap(map);
    
    const marker1 = new google.maps.Marker({
        position: {lat: 14.197644167424276, lng: 120.88560662369146},
        map: map,
        icon: {
            url: "assets/images/town.png",
            scaledSize: new google.maps.Size(35, 33)
        },
        animation: google.maps.Animation.DROP
    });
        const infowindow1 = new google.maps.InfoWindow({
                content: "Brgy. Kaytapos",
            });
                marker1.addListener("click", () => {
                    showPolygon(kaytaposPolygon, kaytaposPolyline);
                    infowindow1.open(map, marker1);
                });
    const marker2 = new google.maps.Marker({
        position: {lat: 14.19586863344934, lng: 120.87958175776734},
        map: map,
        icon: {
            url: "assets/images/town.png",
            scaledSize: new google.maps.Size(35, 33)
        },
        animation: google.maps.Animation.DROP
    });
        const infowindow2 = new google.maps.InfoWindow({
                    content: "Brgy. Poblacion 1",
                });
                    marker2.addListener("click", () => {
                        showPolygon(poblacionPolygon, poblacionPolyline);
                        infowindow2.open(map, marker2);
                    });
    const marker3 = new google.maps.Marker({
        position: {lat: 14.206785332016912, lng: 120.87815019855317},
        map: map,
        icon: {
            url: "assets/images/town.png",
            scaledSize: new google.maps.Size(35, 33)
        },
        animation: google.maps.Animation.DROP
    });
        const infowindow3 = new google.maps.InfoWindow({
                    content: "Brgy. Bancod",
                });
                    marker3.addListener("click", () => {
                        showPolygon(bancodPolygon, bancodPolyline);
                        infowindow3.open(map, marker3);
                    });
    const marker4 = new google.maps.Marker({
        position: {lat: 14.197849988381984, lng: 120.88146306339569},
        map: map,
        icon: {
            url: "assets/images/school.png",
            scaledSize: new google.maps.Size(45, 43)
        },
        animation: google.maps.Animation.DROP
    });
        const infowindow4 = new google.maps.InfoWindow({
                    content: "Cavite State University, Indang Cavite",
                });
                    marker4.addListener("click", () => {
                        infowindow4.open(map, marker4);
                    });

    function showPolygon(polygon, polyline) {
        // Remove the active polygon if exists
        if (activePolygon) {
            activePolygon.setMap(null);
            kaytaposPolyline.setMap(null);
            bancodPolyline.setMap(null);
            poblacionPolyline.setMap(null);
        }

        // Set the new polygon as the active polygon
        activePolygon = polygon;
        activePolygon.setMap(map);
        polyline.setMap(map);
    }

    var dormitoriesData = <?php echo json_encode($dormitoriesData); ?>;

// Function to add dormitory markers to the map
function addDormitoryMarkers(map) {
    for (var i = 0; i < dormitoriesData.length; i++) {
        (function (index) {
            var dormitory = dormitoriesData[index];

            var marker = new google.maps.Marker({
                position: {lat: parseFloat(dormitory.lat), lng: parseFloat(dormitory.lng)},
                map: map,
                title: dormitory.dorm_name,
                icon: {
                    url: "assets/images/dormitory.png",
                    scaledSize: new google.maps.Size(35, 35)
                }
            });

            var infowindow = new google.maps.InfoWindow({
                content: '<div><strong>' + dormitory.dorm_name + '</strong><br><a target="_blank" href="view_dorm.php?id=' + dormitory.dorm_id + '">View Dormitory</a></div>'
            });

            marker.addListener("click", function() {
                infowindow.open(map, marker);
            });
        })(i);
    }
}   

// Call the function to add dormitory markers when the map is initialized
addDormitoryMarkers(map);

}
</script>

    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script> 
    
    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>

  </body>
</html>