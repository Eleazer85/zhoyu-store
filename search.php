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
                    <input class="form-control me-2" name="search" type="search" placeholder="Search">
                    <button class="btn btn-outline-success text-light" type="submit" id="search-button"><b>Search</b></button>
                </form>
            </div>
        </div>
    </nav>
    <?php 
        include 'searched_item.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>