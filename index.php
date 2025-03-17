
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Store</title>
    
    <!-- Import Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Slackey' rel='stylesheet'>
    
    <!-- Link external CSS file -->
    <link rel="stylesheet" href="style.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Set background gradient for the page */
        body {
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
    
    <!-- Poster Section -->
    <div id="poster" class="mt-2 mb-5">
        <img src="Images/Poster.jpeg">
    </div>
    
    <!-- Game List Section -->
    <div class="container-fluid">
        <div class="d-flex align-items-center games-list">
            <h2 class="category me-5">All Games</h2>
        </div>
        
        <!-- Game Grid - Dynamically loaded with PHP -->
        <div class="games-container pb-5">
            <?php include 'home_game.php'?>
        </div>
    </div>

    <!-- Pagination Navigation -->
    <nav aria-label="Page navigation example" class="d-flex justify-content-center">
        <ul class="pagination">
            <!-- <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li> -->
            <li class="page-item"><a class="page-link" href="">1</a></li>
            <li class="page-item">
                <a class="page-link" href="https://localhost/web-top-up/games?page=2" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>