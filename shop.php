<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://fonts.googleapis.com/css?family=Slackey' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg bg-theme">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="https://localhost/web-top-up">
                <img src="Images/logo2.png" width="70" height="50">
            </a>
            
            <!-- Mobile Menu Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-light" href="https://localhost/web-top-up"><b>Home</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="https://localhost/web-top-up/games?page=1"><b>All Games</b></a>
                    </li>
                </ul>
                
                <!-- Search Bar -->
                <form class="d-flex" role="search" method="get" action="search">
                    <input class="form-control me-2" type="search" name="search"  placeholder="Search">
                    <button class="btn btn-outline-success text-light" type="submit" id="search-button"><b>Search</b></button>
                </form>
            </div>
        </div>
    </nav>
<!-- 
    Thumbnail container that displays a background image.
    It contains the game description and the main catalogue section.
-->
  <?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    $connect = mysqli_connect("localhost","root","","web-top-up");
    $thumbnail_query = mysqli_query($connect,"SELECT * FROM `Gambar-thumbnail` WHERE Game_terkait = '".$_GET['games']."'");
    if(mysqli_num_rows($thumbnail_query) < 1){
      die("<h1 class='mx-5 text-center'>404 error</h1>");
    }
    while($row = mysqli_fetch_array($thumbnail_query)){
      $gambar = $row["Gambar"];
    };
  ?>
<div class="thumbnail-image" style="background-image:  
      linear-gradient(transparent 20%, white),
      url('<?php echo $gambar ?>') !important;
    ">
  
  <!-- 
      Game description box with a themed background color.
      Positioned inside the thumbnail container.
  -->
  <div class="games-description">
    <?php 
      $games_query = mysqli_query($connect,"SELECT * FROM `Games` WHERE Game_terkait = '".$_GET['games']."'");
      while($row = mysqli_fetch_array($games_query)):
    ?>
    <h2 class="text-light ms-3 mt-3"><?php echo $row["Nama-game"];?></h2>
    <p class="text-light ms-3 mt-2">
      <?php 
        echo $row["Description"];
        endwhile; 
      ?> 
    </p>
    <!-- Description goes here -->
  </div>

  <!-- 
      Main catalogue container that holds the game product listings.
  -->
  <div class="main-catalogue-container">

    <!-- 
        Games-product container that organizes the available game items.
        Uses flexbox to center and align elements.
    -->
  <form method="post" action="testing.php" class="w-100">
    <input type="hidden" id="selectedCatalogueProduct" name="catalogue_product" value="">
    <input type="hidden" id="selectedCataloguePrice" name="catalogue_price" value="">
    <input type="hidden" id="selectedCataloguePayment" name="catalogue_payment" value="">
    <input type="hidden" id="selectedCatalogueGames" name="catalogue_games" value="<?php echo str_replace("-"," ",$_GET["games"])?>">
    <div class="games-product">
      <?php
        $id_query = mysqli_query($connect,"SELECT`id_type` , `server_type`  , `server_options` FROM Games WHERE `Game_terkait` = '".$_GET['games']."'");
        while($row = mysqli_fetch_array($id_query)):
      ?>
      <div class="d-flex justify-content-center align-items-center w-100 mt-3 mb-3">
        <label for="player_id" class="text-light w-25"><b><?php echo $row['id_type']." : "?></b></label>
        <input type="text" name="player_id" class="rounded w-50" placeholder="<?php echo $row['id_type']?>" required>
      </div>
      <?php if($row['server_type'] == "input"):?>
      <div class="d-flex justify-content-center align-items-center w-100 mb-3">
        <label for="player_id" class="text-light w-25"><b>Server ID : </b></label>
        <input type="text" name="server" class="rounded w-50" placeholder="Server ID" required>
      </div>
      <?php 
        elseif($row['server_type'] == "dropdown"):
          $servers = explode(",",$row['server_options']);
          $servers_length = count($servers);
        ?>
      <div class="d-flex justify-content-center align-items-center w-100 mb-3 ">
        <label for="player_id" class="text-light w-25"><b>Server ID : </b></label>
        <select name="server" class="rounded w-50">
          <?php for($i=0;$i<$servers_length;$i++): ?>
            <option value="<?php echo $servers[$i];?>"><?php echo $servers[$i];?></option>
          <?php endfor;?>
        </select>
        </div>
      <?php endif; ?>
      <?php endwhile; ?>
    </div>
    <div class="games-product mt-5">
      <!-- First row of game product listings -->
      <div class="w-100 mt-3"><h3 class="text-light ms-3"> Region Indonesia </h3></div>
      <div class="catalogue-container  pb-3">
        <?php 
        $catalogue_query = mysqli_query($connect,"SELECT * FROM `Katalog` WHERE Game_terkait = '".$_GET['games']."' ");
        while ($row = mysqli_fetch_array($catalogue_query)):
        ?>
        <div class="catalogue"  product="<?php echo $row['Nominal'].' '.$row['Curency'] ?>" price="<?php echo 'Rp. '.$row['Harga']?>" onclick="selectCatalogue(this)">
          <img src="<?php echo $row['Gambar'];?>" class="catalogue-image">
          <div class="catalogue-price">
            <h6><?php echo $row['Nominal']." ".$row['Curency']?></h6>
            <h6>Rp. <?php echo $row['Harga'] ?></h6>
          </div>
        </div>
        <?php endwhile; ?>
      </div>

    </div> <!-- End of games-product -->

    <!-- 
        Payment section inside games-product container.
        Includes a collapsible payment option.
    -->
    <!-- 1. Bank Transfer -->
    <div class="games-product mt-5 pb-3 mb-5">
      
      <div class="payment-container mt-3">
        
      <div class="payment m-auto">
          <div data-bs-toggle="collapse" data-bs-target="#payment-method" class="pt-2 pb-2 ms-3 d-flex justify-content-between" style="width:95%;">
            <h3>  Payment Method</h3>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
            </svg>
          </div>

          <!-- Collapsible section containing pricing details -->
          <div class="payment-method collapse" id="payment-method">
            <div class="payment-list">
              <div class="pay pe-3" payment="QRIS" onclick="paymentMethod(this)">
                <img src="Images/qris.png" class="pembayaran">
              </div>
              <div class="pay pe-3" payment="BCA" onclick="paymentMethod(this)">
                <img src="Images/BCA.png" class="pembayaran">
              </div>
              </div>
            </div>
          </div>
          
      </div> <!-- End of payment-container -->

    </div> <!-- End of games-product -->
          <button class="d-flex justify-content-center align-items-center pesan ps-5 pe-5 m-auto" type="submit"><p class="text-light">Pesan Sekarang!</p></button>
    </form>
  </div> <!-- End of main-catalogue-container -->

</div> <!-- End of thumbnail-image -->

<script>
function selectCatalogue(element) {
    // Get data attributes from clicked container
    let product = element.getAttribute("product");
    let price = element.getAttribute("price");

    // Update hidden form fields
    document.getElementById("selectedCatalogueProduct").value = product;
    document.getElementById("selectedCataloguePrice").value = price;

    // Highlight the selected catalogue (optional)
    document.querySelectorAll(".catalogue").forEach(container => {
        container.style.border = "none"; // Reset border
    });
    element.style.border = "2px solid black"; // Highlight selected container

    console.log("Selected Product:", product);  // Debugging
    console.log("Selected Price:", price);
}
function paymentMethod(element){
  let payment = element.getAttribute("payment");
  document.getElementById("selectedCataloguePayment").value = payment

  // Highlight the selected catalogue (optional)
   document.querySelectorAll(".pay").forEach(container => {
    container.style.border = "none"; // Reset border
   });

   element.style.border = "2px solid black"; // Highlight selected container

   console.log("Selected Payment Method:",payment);
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>