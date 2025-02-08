<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://fonts.googleapis.com/css?family=Slackey' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    body{
      background-image:linear-gradient(white,#d9d9d9,#ECD1D1,#ffc9c9  )
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-theme">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="Images/logo2.png" width="70" height="50"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active text-light" aria-current="page" href="#"><b>Home</b></a>
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
<div id="poster" class="mt-2 mb-5">
<img src="Images/Poster.jpeg">
</div>
<!--This is a grid of games based on the user selection-->
<div class="container-fluid">
  <div class="d-flex align-items-center games-list">
    <h2 class="category me-5">Popular Games</h2>
    <!-- <h4 class="category mx-2">Mobile Games</h4>
    <h4 class="category mx-2">PC Games</h4> -->
  </div>
  <div class="games-container pb-5">
    <?php 
    $connect = mysqli_connect('localhost','root','','web-top-up');
    $query = mysqli_query($connect,"SELECT * FROM Games ORDER BY Likes LIMIT 8");
    while($row = mysqli_fetch_array($query)):
    ?>
    <div class="games" style="background-image:url(<?php echo $row['Gambar-game'] ?>)">
      <a href="shop?games=mobile-legend">
        <div class="redirect">
        </div>
      </a>
    </div>
    <?php endwhile; ?>
  </div>
</div>
<!-- <nav aria-label="Page navigation example" class=" d-flex justify-content-center mt-5">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav> -->
<!--This is the other games that's not on the top grid-->
<!-- <div class="other-games">
</div> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
