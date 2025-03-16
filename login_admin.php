<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login</title>

    <!-- Import Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Slackey' rel='stylesheet'>

    <!-- Link external CSS file -->
    <link rel="stylesheet" href="style.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
  <div class="container admin-login mt-5">
    <h1 class="text-center pt-3">Login</h1>
    <form class="pt-3 px-2" method="post" action="admin.php">
      <!-- Email input -->
      <div data-mdb-input-init class="form-outline mb-3">
        <input type="text" name="username"  id="form2Example1"   class="form-control" />
        <label class="form-label" for="form2Example1">Username</label>
      </div>

      <!-- Password input -->
      <div data-mdb-input-init class="form-outline mb-4">
        <input type="password" name="password" id="form2Example2" username="" class="form-control" />
        <label class="form-label" for="form2Example2">Password</label>
      </div>

      <!-- 2 column grid layout for inline styling -->
      <div class="row mb-4">
        <div class="col d-flex justify-content-center">
          <!-- Checkbox -->
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="on" id="form2Example31" checked name="remember"/>
            <label class="form-check-label" for="form2Example31"> Remember me </label>
          </div>
        </div>

        <div class="col">
          <!-- Simple link -->
          <a href="#!">Forgot password?</a>
        </div>
      </div>

      <!-- Submit button -->
      <div class="w-100 d-flex justify-content-center">
        <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block">Sign in</button>
      </div>

      <!-- Register buttons -->
      <div class="text-center">
        <p>Not a member? <a href="#!">Register</a></p>
        <p>or sign up with:</p>
        <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
          <i class="fab fa-facebook-f"></i>
        </button>

        <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
          <i class="fab fa-google"></i>
        </button>

        <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
          <i class="fab fa-twitter"></i>
        </button>

        <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
          <i class="fab fa-github"></i>
        </button>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>