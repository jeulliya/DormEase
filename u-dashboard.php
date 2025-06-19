<?php
require_once 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/u-dashboard.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body>
    <section>
        <?php
            include_once 'u-navbar.php';
            // Fetch dormitory data from the database
            $sql = "SELECT dorm_id, dorm_name, address, r_fee, images FROM dormitories";
            $result = mysqli_query($conn, $sql);

            $dorms = [];
            while ($row = $result->fetch_assoc()) {
                $dorms[] = $row;
            }

            $uploadDirectory = "uploads/";
            foreach ($dorms as $dorm) {
                $imageUrls = json_decode($dorm['images'], true);
                $imageUrl = !empty($imageUrls[0]) ? $uploadDirectory . trim($imageUrls[0]) : 'assets/images/default_image.png';
            }
            $conn->close();
        ?>

    </section>

    <div class="search-container">
        <input type="text" id="search" onkeyup="myFunction()" placeholder="Search Dormitories" name="search" autocomplete="off">
    </div>

    <!-- Sorting buttons -->
    <div class="sort">
            <button onclick="sortAsc('Price')">Price</button>
            <button onclick="sortDorms('Kaytapos')">Brgy. Kaytapos</button>
            <button onclick="sortDorms('Poblacion')">Brgy. Poblacion 1</button>
            <button onclick="sortDorms('Bancod')">Brgy. Bancod</button>
            <button onclick="sortDorms('All')">All</button>
        </div>


    <!-- ***** Featured Dorms Area Start ***** -->
    <div class="feat-dorm">
        <div class="container" id="table" style="padding:0;">
            <div class="row">

<!-- Display dormitories -->
<?php foreach ($dorms as $dorm) : ?>
    <!-- Card Box -->
    <div class="col-lg-4">
        <div class="card-box">
            <div class="card-img">
            <?php
                $imageUrls = !empty($dorm['images']) ? explode(',', $dorm['images']) : [];

                if (!empty($imageUrls[0])) {
                    // Display only the first image
                    $firstImageUrl = $uploadDirectory . trim($imageUrls[0]);
                    echo '<img src="' . $firstImageUrl . '" alt="' . $dorm['dorm_name'] . '">';
                } else {
                    // Default image if no images are available
                    echo '<img src="assets/images/default_image.png" alt="' . $dorm['dorm_name'] . '">';
                }
                ?>
            </div>
            <div class="card-content">
                <div class="info-column">
                    <div class="left-info">
                        <h4 class="dname"><?php echo $dorm['dorm_name']; ?></h4><br>
                        <p class="address"><img src="assets/images/location.png"><?php echo $dorm['address']; ?></p>
                        <br><h4>Rent starts at</h4>
                        <p class="rent">₱ <?php echo $dorm['r_fee']; ?></p>
                        <!-- Add a link to the specific dorm's PHP file with dorm ID -->
                    <a href="view_dorm.php?id=<?php echo $dorm['dorm_id']; ?>" class="view-button">View Dormitory</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
        
            </div>        
        </div>
    </div>
    <!-- ***** Featured Dorms Area End ***** -->

   <!-- ***** Footer Start ***** -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="copyright">Copyright &copy; 2023 Software Engineering II Requirement </p>
            </div>
        </div>
    </div>
</footer>
<!-- ***** Footer End ***** -->


<script>
function myFunction() {
  // Declare variables
  var input, filter, container, dorms, i, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  container = document.getElementById("table");
  dorms = container.getElementsByClassName("col-lg-4"); // Assuming each dormitory is contained in a div with the class "col-lg-4"

  // Loop through all dormitories, and hide those that don't match the search query
  for (i = 0; i < dorms.length; i++) {
    var dormName = dorms[i].getElementsByClassName("dname")[0]; // Assuming the dormitory name is inside an element with the class "dname"
    
    if (dormName) {
      txtValue = dormName.textContent || dormName.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        dorms[i].style.display = "";
      } else {
        dorms[i].style.display = "none";
      }
    }
  }
}

function sortDorms(barangay) {
    var dorms, i, addressElement, address, shouldShow;
    dorms = document.getElementsByClassName("col-lg-4"); 

    for (i = 0; i < dorms.length; i++) {
        addressElement = dorms[i].getElementsByClassName("address")[0]; 

        if (addressElement) {
            address = addressElement.textContent || addressElement.innerText;
            address = address.toLowerCase(); // Convert address to lowercase for case-insensitive comparison
            barangay = barangay.toLowerCase(); // Convert barangay to lowercase for case-insensitive comparison

            shouldShow = (barangay === 'all' || address.includes(barangay));

            if (shouldShow) {
                dorms[i].style.display = ""; 
            } else {
                dorms[i].style.display = "none"; 
            }
        }
    }
}

function sortAsc() {
    var dorms, i, priceElement, price;
    dorms = document.getElementsByClassName("col-lg-4"); // Assuming each dormitory is contained in a div with the class "col-lg-4"

    // Extract dorm prices from dorm elements
    var dormArray = Array.from(dorms).map(function (dorm) {
        priceElement = dorm.querySelector('.rent'); // Assuming the rent is inside an element with the class "rent"

        return {
            element: dorm,
            price: priceElement ? parseFloat(priceElement.textContent.trim().replace('₱', '')) : 0
        };
    });

    // Sort the array based on price in ascending order
    dormArray.sort(function (a, b) {
        return a.price - b.price;
    });

    // Loop through sorted dorms and update the display
    for (i = 0; i < dormArray.length; i++) {
        dormArray[i].element.style.order = i + 1;
        dormArray[i].element.style.display = "";
    }
}

    </script>

</body>

</html>
