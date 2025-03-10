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
<nav class="navbar navbar-expand-lg bg-theme">
    <div class="container-fluid">
      <a class="navbar-brand" href="https://localhost/web-top-up"><img src="Images/logo2.png" width="70" height="50"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active text-light" aria-current="page" href="https://localhost/web-top-up"><b>Home</b></a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="#"><b>All-games</b></a>
          </li>
          <!--Disable drop down-->
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu bg-theme">
              <li><a class="dropdown-item text-light" href="#">Action</a></li>
              <li><a class="dropdown-item text-light" href="#">Another action</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-light" href="#">Something else here</a></li>
            </ul>
          </li> -->
          <li class="nav-item">
            <a class="nav-link text-light"><b>Voucher</b></a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
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
    <p class="text-light ms-3 mt-3">
      <?php 
        $games_query = mysqli_query($connect,"SELECT * FROM `Games` WHERE Game_terkait = '".$_GET['games']."'");
        while($row = mysqli_fetch_array($games_query)){
          echo $row["Description"];
        };

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
    <div class="games-product">

      <!-- First row of game product listings -->
      <div class="w-100 mt-3"><h3 class="text-light ms-3"> Region Indonesia </h3></div>
      <div class="catalogue-container  pb-3">
        <?php 
        $catalogue_query = mysqli_query($connect,"SELECT * FROM `Katalog` WHERE Game_terkait = '".$_GET['games']."' ");
        while ($row = mysqli_fetch_array($catalogue_query)):
        ?>
        <div class="catalogue">
          <img src="Images/Game-Money/2.png" class="catalogue-image">
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
              <div class="pay">
                <img src="Images/qris.png" class="pembayaran">
              </div>
              <div class="pay">
                <img src="Images/BCA.png" class="pembayaran">
              </div>
              </div>
            </div>
          </div>
          
      </div> <!-- End of payment-container -->

    </div> <!-- End of games-product -->
          <button class="d-flex justify-content-center align-items-center pesan ps-5 pe-5 m-auto"><p class="text-light">Pesan Sekarang!</p></button>
  </div> <!-- End of main-catalogue-container -->

</div> <!-- End of thumbnail-image -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>