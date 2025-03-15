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
        /* Set background gradient for the page */
        body {
            min-height:100vh;
            background-image: linear-gradient(white, #d9d9d9, #ECD1D1, #ffc9c9);
            background-repeat: no-repeat;
        }
    </style>
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
                        <a class="nav-link active text-light" href="#"><b>Home</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light"><b>Voucher</b></a>
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
  <?php
      $game_perPage = 8;
      $connect = mysqli_connect('localhost','root','','web-top-up');
      function automatic_query($limit){
        $current_offset = " ".($_GET["page"] - 1) * $limit." ";
        $next_offset = " ".$_GET["page"] * $limit." ";
        
        #query
        $query = "SELECT * FROM `Games` LIMIT ".$limit." OFFSET".$current_offset;
        $next_query =  "SELECT * FROM `Games` LIMIT ".$limit." OFFSET".$next_offset;
        return [$query,$next_query];
      };

          //FUnction to check is the query is empty or not
      function query_available($connect,$query){
        $query = mysqli_query($connect,$query); 
        if(mysqli_num_rows($query) != 0){
            return true;
        }else{
            return false;
        }
      }
      $mysql_query = automatic_query($game_perPage)[0];
      $query = mysqli_query($connect,$mysql_query);
      if(!query_available($connect,$mysql_query)){
        die('404 error');
      }
  ?>
  <!-- Game List Section -->
  <div class="container-fluid py-3">
    <div class="d-flex align-items-center games-list">
        <h2 class="category me-5">All Games</h2>
    </div>
    
    <!-- Game Grid - Dynamically loaded with PHP -->
    <div class="games-container pb-5">
      <?php 
        while($row = mysqli_fetch_array($query)):
      ?>
      <div class="games" style="background-image:url(<?php echo $row['Gambar-game'] ?>)">
        <a href="shop?games=<?php echo $row["Game_terkait"]?>">
          <div class="redirect">
          </div>
        </a>
      </div>
      <?php endwhile; ?>
    </div>

</div>
  <nav aria-label="Page navigation example" class="d-flex justify-content-center">
    <ul class="pagination">
      <?php if($_GET["page"] != 1 || $_GET["page"] < 1): ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo 'https://localhost/web-top-up/games?page='.$_GET['page']-1 ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
      <?php endif; ?>
        <li class="page-item"><a class="page-link" href="#"><?php echo $_GET["page"];?></a></li>
      <?php
        $next_query = automatic_query($game_perPage)[1];
        $available = query_available($connect,$next_query);
        if( $available):
      ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo 'https://localhost/web-top-up/games?page='.$_GET['page']+1 ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
      <?php endif; ?>
    </ul>
  </nav>
</body>