<?php
require_once 'db_conn.php';

$amenityIcons = [
    'parking' => ['url' => 'assets/images/parking.png', 'color' => '#ffffff', 'size' => '20px'],
    'wifi' => ['url' => 'assets/images/wifi.png', 'color' => '#ffffff', 'size' => '20px'],
    'lounge' => ['url' => 'assets/images/lounge.png', 'color' => '#ffffff', 'size' => '20px'],
    'kitchen' => ['url' => 'assets/images/kitchen.png', 'color' => '#ffffff', 'size' => '20px'],
    'laundromat' => ['url' => 'assets/images/laundry.png', 'color' => '#ffffff', 'size' => '20px'],
    'study area' => ['url' => 'assets/images/study.png', 'color' => '#ffffff', 'size' => '20px'],
    'canteen' => ['url' => 'assets/images/canteen.png', 'color' => '#ffffff', 'size' => '20px'],
    'water' => ['url' => 'assets/images/water.png', 'color' => '#ffffff', 'size' => '20px'],
    'electricity' => ['url' => 'assets/images/electricity.png', 'color' => '#ffffff', 'size' => '20px'],
    'rooftop' => ['url' => 'assets/images/rooftop.png', 'color' => '#ffffff', 'size' => '20px'],
];

// Check if the dormitory ID is provided in the URL
if (isset($_GET['id'])) {
    $dormitoryId = $_GET['id'];

    // Fetch dormitory data based on the dormitory ID
    $sql = "SELECT dorm_id, dorm_name, address, r_fee, images, lat, lng, amenities, rooms, r_avail, description FROM dormitories WHERE dorm_id = $dormitoryId";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $dormitory = $result->fetch_assoc();
        $imageUrls = explode(',', $dormitory['images']);

    } else {
        // Dormitory not found, you can handle this case (e.g., redirect to an error page)
        echo "Dormitory not found";
        exit();
    }

    $conn->close();
} else {
    // Dormitory ID not provided, you can handle this case (e.g., redirect to an error page)
    echo "Dormitory ID not provided";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $dormitory['dorm_name']; ?> - View Dormitory</title>
    <link rel="stylesheet" href="assets/css/view_dorm.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body>
    <section>
        <?php
        include_once 'u-navbar.php';
        ?>
    </section><br><br>

    <div class="slideshow-container">
        <?php foreach ($imageUrls as $index => $imageName): ?>
            <?php
            // Assuming images are stored in the 'uploads/' directory
            $imageUrl = 'uploads/' . trim($imageName);
            ?>
            <img src="<?= $imageUrl ?>" alt="<?= $dormitory['dorm_name'] ?>" class="imgs" style="display: <?= $index < 3 ? 'inline-block' : 'none' ?>;">
        <?php endforeach; ?>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>


    <div class="card-content">
        <!-- First row: Dormitory name -->
        <div class="row">
            <h4 class="dname"><?php echo $dormitory['dorm_name']; ?></h4>
        </div>

        <!-- Second row: Dormitory information -->
        <div class="col-lg-8">
            <div class="row">
                <div class="info-column">
                    <div class="left-info">
                        <p class="address"><img src="assets/images/location.png"><?php echo $dormitory['address']; ?></p>
                        <div><br><br>
                            <h4>Number of Rooms: </h4><p class="rent"><?php echo $dormitory['rooms']; ?></p>
                        </div>
                        <div><br>
                            <h4>Description</h4><br>
                            <ul class="description">
                                <?php
                                // Assuming $dormitory['description'] contains the LONGTEXT content
                                $descriptionLines = explode("\n", $dormitory['description']);
                                foreach ($descriptionLines as $line) {
                                    // Trim each line and ignore empty lines
                                    $trimmedLine = trim($line);
                                    if (!empty($trimmedLine)) {
                                        echo "<li><img src='assets/images/pin.png' alt='Pin Icon'> {$trimmedLine}</li>";
                                    } else {
                                        echo "No description available.";
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <div><br><br><br><br>
                            <h4>Rent starts at</h4><br><p class="rent">₱ <?php echo $dormitory['r_fee']; ?></p>
                        </div>
                        <div><br>
                            <!-- Display amenities in boxes -->
                            <h4 class="amenity">Amenities</h4><br>
                            <?php
                            $amenities = explode(',', $dormitory['amenities']);
                            if (is_array($amenities) && !empty($amenities)) {
                                foreach ($amenities as $amenity) {
                                    $trimmedAmenity = trim($amenity);
                                    if (array_key_exists($trimmedAmenity, $amenityIcons)) {
                                        $iconDetails = $amenityIcons[$trimmedAmenity];
                                        $iconUrl = $iconDetails['url'];
                                        $iconColor = $iconDetails['color'];
                                        $iconSize = $iconDetails['size'];
                                        echo "<div class='amenity-box'><img src='{$iconUrl}' alt='{$trimmedAmenity} Icon' style='color: {$iconColor}; width: {$iconSize}; height: {$iconSize};'> {$trimmedAmenity}</div>";
                                    } else {
                                        echo "<div class='amenity-box'>{$trimmedAmenity}</div>";
                                    }
                                }
                            } else {
                                echo "<div class='amenity-box'>No amenities available</div>";
                            }
                            ?>
                        </div>
                        
                        <div><br><br>
                            <h4>Room Availability: </h4>
                            <?php
                            $availability = strtolower($dormitory['r_avail']);
                            $availabilityClass = ($availability === 'available') ? 'available' : 'not-available';
                            ?>
                            <p class="avail <?php echo $availabilityClass; ?>"><?php echo $dormitory['r_avail']; ?></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="map" style="margin-left: 10vh;"></div>
    <div id="directionsPanel" style="margin-left: 10vh;"></div>

    <!-- ***** Footer Start ***** -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="copyright">Copyright &copy; 2024 Software Engineering II Requirement </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- ***** Footer End ***** -->

<script>
// Declare initMap in the global scope
var map;
var customOverlay;

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: <?php echo $dormitory['lat']; ?>,
            lng: <?php echo $dormitory['lng']; ?>
        },
        zoom: 18,
        mapId: '6f33173a4413a9fc',
    });

    const markerContent = document.createElement('div');
    markerContent.innerHTML = `<p style="margin-top:2vh; font-family:Poppins; font-size:2.5vh;"><?php echo $dormitory['dorm_name']; ?></p>`;

    const dormMarker = new google.maps.Marker({
        position: {
            lat: <?php echo $dormitory['lat']; ?>,
            lng: <?php echo $dormitory['lng']; ?>
        },
        map: map,
        icon: {
            url: "assets/images/dormitory.png",
            scaledSize: new google.maps.Size(55, 53)
        },
        animation: google.maps.Animation.DROP
    });

    const infoWindow = new google.maps.InfoWindow({
        content: markerContent
    });

    dormMarker.addListener("click", () => {
        infoWindow.open(map, dormMarker);
    });

    const schoolMarker = new google.maps.Marker({
        position: {
            lat: 14.196481190333028,
            lng: 120.88115585563399
        },
        map: map,
        icon: {
            url: "assets/images/school.png",
            scaledSize: new google.maps.Size(55, 53)
        },
        animation: google.maps.Animation.DROP
    });

    const infoWindow1 = new google.maps.InfoWindow({
        content: "CvSU Gate 1"
    });

    schoolMarker.addListener("click", () => {
        infoWindow1.open(map, schoolMarker);
    });

    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer({
        map: map,
        panel: document.getElementById('directionsPanel'), // Specify the directions panel
        suppressMarkers: true // Do not display the default markers
    });

    // Define the origin and destination coordinates
    const origin = new google.maps.LatLng(14.196481190333028, 120.88115585563399);
    const destination = new google.maps.LatLng(<?php echo $dormitory['lat']; ?>, <?php echo $dormitory['lng']; ?>);

      // Create a request object for the directions service
    const request = {
        origin: origin,
        destination: destination,
        travelMode: google.maps.TravelMode.WALKING // You can change the travel mode as needed
    };

    // Call the directions service to get the route
    directionsService.route(request, function (result, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            // Display the route on the map
            directionsRenderer.setDirections(result);
        } else {
            console.error('Directions request failed. Status:', status);
        }
    });
}
        
</script>
<script src="assets/js/view_dorm.js"></script>
<script defer async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdDeqiJgvPJAOuYgqok22Wig8_OrFjal8&libraries=places&callback=initMap"></script>

</body>

</html>
