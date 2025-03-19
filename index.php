
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
    <!-- font-awesome -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <footer class="footer mt-3">
        <div class="container">
            <div class="footer-column">
                <h3>Media Sosial</h3>
                <ul>
                    <li><a href="http://www.youtube.com/@bangzhoyu" class="fab fa-youtube" > YouTube</a></li>
                    <li><a href="http://instagram.com/bangzhoyu"class="fab fa-instagram"> Instagaram</a></li>
                    <li><a href="http://discord.gg/DNK7kkcxPF" class="fa-brands fa-discord"> Discord</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3></h3>
                <ul>
                    <li><a href="http://tiktok.com/@bangzhoyu?_t=ZS-8te79Vo00F5&_r=1" class="fab fa-tiktok"> TikTok</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Kontak</h3>
                <ul>
                    <li><a href="#" class="fas fa-envelope"> Emails</a></li>
                    <li><a href="https://wa.me/c/6287851265092" class="fab fa-whatsapp"> Whatsapp</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2025 MIRICELA.
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>