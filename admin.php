<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// make a new admin function
$connect = mysqli_connect("localhost","root","","web-top-up");

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

function create_admin($username,$password){
    global $connect;
    $hashed_password = password_hash($password,PASSWORD_BCRYPT);

    $stmt = $connect->prepare("INSERT INTO `admins` (`Username`,`Password`) VALUES (?,?)");
    $stmt->bind_param("ss",$username,$hashed_password);
    $stmt->execute();
};

function authenticate($username, $password){
    global $connect;

    // Prepare a SQL statement to prevent SQL injection by changung it into plain text
    // $stmt is a prepared statement object that holds the SQL query
    $stmt = $connect->prepare("SELECT * FROM `admins` WHERE Username = ?");
    
    // Bind the username parameter to the prepared statement as a string (s = string)
    $stmt->bind_param("s", $username);
    
    // Execute the prepared statement
    $stmt->execute();

    // Get the result set from the executed statement
    $result = $stmt->get_result();

    //define verify to prevent undefined risk
    $verify = false; 

    if ($result->num_rows > 0) {  // Check if any result is returned

        //query the result
        while ($row = mysqli_fetch_array($result)) { 
            $verify = password_verify($password,$row["Password"]); //check if password match
            break; //break in case htere are duplicate username (Impossible to happen but just in case)
        };

    }
    
    return $verify; //return the result of verification
};

function createToken(){
    global $connect;
    // Generate a secure token
    $token = bin2hex(random_bytes(32)); // 64-character random string
    $hashed_token = password_hash($token, PASSWORD_DEFAULT);

    // make a prepare statement
    $stmt = $connect->prepare("UPDATE admins SET session_token = ? WHERE Username = ?");
    $stmt->bind_param("ss", $hashed_token, $_POST["username"]);
    $stmt->execute();

    // Set a secure cookie with the raw token
    setcookie("auth_token", $token, [
        "expires" => time() + 3600,  // Cookie expires in 1 hour
        "path" => "/",
        "secure" => false,  //  Change to false for localhost testing
        "httponly" => true,  // Prevent JavaScript access
        "samesite" => "Lax"  // Change to Lax to allow redirections
    ]);            // Generate a secure token
}

function verifyToken(){
    global $connect; 

    if (isset($_COOKIE["auth_token"])) {
        $token = $_COOKIE["auth_token"];
    } else {
       return;
    }

    // Prepare the query
    $stmt = $connect->prepare("SELECT Username, session_token FROM admins WHERE session_token IS NOT NULL");
    $stmt->execute();
    $result = $stmt->get_result();

    $user_found = false;
    while($row = mysqli_fetch_array($result)){
        if (password_verify($token, $row["session_token"])) {
            $users = $row["Username"];
            $user_found = true;
            break;
        }
    }

    if($user_found == false){
        header('Location: https://localhost/web-top-up/login');
    }else{
        return [$users,$user_found];
    }
}

function cleanExpiredPayments($connect) {
    $sql = "DELETE FROM payments WHERE expires_at <= NOW()";
    $connect->query($sql);
}

function verifyLogin(){
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        if(authenticate($username, $password) == true){
            if (isset($_POST["remember"]) && $_POST["remember"] == "on") {
                createToken();
                return true;
                // echo "Cookie has been set!";
            } else {
               return true;
            };        
        }else{
            header('Location: https://localhost/web-top-up/login ');
            die('Forbidden');
            exit;
        };
    } else {
        header('Location: https://localhost/web-top-up/login');
        die('Forbidden');
        exit;
    };
}


if(verifyToken() != null && verifyToken()[1]){
    //do nothing
}elseif(verifyLogin() == true){
    //do nothing
}else{
    die('Forbidden');
}
cleanExpiredPayments($connect);
?>
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
    <div class="d-flex w-100">
        <div class="bg-dark admin-menu">
            <a href="https://localhost/web-top-up/admin?page=home">
                <div class="menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-house" viewBox="0 0 16 16">
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                    </svg>
                    <h1 class="text-light ms-3 fs-6 mt-3 mb-3 me-3">Home</h1>
                </div>
            </a>
            <a href="https://localhost/web-top-up/admin?page=games">
                <div class="menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-controller" viewBox="0 0 16 16">
                        <path d="M11.5 6.027a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2.5-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m-6.5-3h1v1h1v1h-1v1h-1v-1h-1v-1h1z"/>
                        <path d="M3.051 3.26a.5.5 0 0 1 .354-.613l1.932-.518a.5.5 0 0 1 .62.39c.655-.079 1.35-.117 2.043-.117.72 0 1.443.041 2.12.126a.5.5 0 0 1 .622-.399l1.932.518a.5.5 0 0 1 .306.729q.211.136.373.297c.408.408.78 1.05 1.095 1.772.32.733.599 1.591.805 2.466s.34 1.78.364 2.606c.024.816-.059 1.602-.328 2.21a1.42 1.42 0 0 1-1.445.83c-.636-.067-1.115-.394-1.513-.773-.245-.232-.496-.526-.739-.808-.126-.148-.25-.292-.368-.423-.728-.804-1.597-1.527-3.224-1.527s-2.496.723-3.224 1.527c-.119.131-.242.275-.368.423-.243.282-.494.575-.739.808-.398.38-.877.706-1.513.773a1.42 1.42 0 0 1-1.445-.83c-.27-.608-.352-1.395-.329-2.21.024-.826.16-1.73.365-2.606.206-.875.486-1.733.805-2.466.315-.722.687-1.364 1.094-1.772a2.3 2.3 0 0 1 .433-.335l-.028-.079zm2.036.412c-.877.185-1.469.443-1.733.708-.276.276-.587.783-.885 1.465a14 14 0 0 0-.748 2.295 12.4 12.4 0 0 0-.339 2.406c-.022.755.062 1.368.243 1.776a.42.42 0 0 0 .426.24c.327-.034.61-.199.929-.502.212-.202.4-.423.615-.674.133-.156.276-.323.44-.504C4.861 9.969 5.978 9.027 8 9.027s3.139.942 3.965 1.855c.164.181.307.348.44.504.214.251.403.472.615.674.318.303.601.468.929.503a.42.42 0 0 0 .426-.241c.18-.408.265-1.02.243-1.776a12.4 12.4 0 0 0-.339-2.406 14 14 0 0 0-.748-2.295c-.298-.682-.61-1.19-.885-1.465-.264-.265-.856-.523-1.733-.708-.85-.179-1.877-.27-2.913-.27s-2.063.091-2.913.27"/>
                    </svg>
                    <h1 class="text-light ms-3 fs-6 mt-3 mb-3 me-3">Games</h1>
                </div>
            </a>
            <a href="https://localhost/web-top-up/admin?page=katalog">
                <div class="menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-cart" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                    </svg>
                    <h1 class="text-light ms-3 fs-6 mt-3 mb-3 me-3">Katalog</h1>
                </div>
            </a>
            <a href="https://localhost/web-top-up/admin?page=invoice">
                <div class="menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-receipt" viewBox="0 0 16 16">
                        <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z"/>
                        <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5"/>
                    </svg>
                    <h1 class="text-light ms-3 fs-6 mt-3 mb-3 me-3">Invoice</h1>
                </div>
            </a>
        </div>
        <?php if(!isset($_GET["page"]) || !in_array($_GET["page"], ["home","games","katalog","invoice"] )): 
            echo '<script>window.location.href = "https://localhost/web-top-up/admin?page=home";</script>';
            exit;
        ?>
        <?php elseif($_GET["page"] == "home"):?>
            <div class="bg-light admin-config d-flex flex-column justify-content-center align-items-center">
                <h1>Halo, selamat datang <?php echo verifyToken()[0]; ?></h1><br>
                <p>Ini adalah admin page untuk  menambahkan data ke database <?php echo verifyToken()[0]; ?></p>
            </div>
        <?php elseif($_GET["page"] == "games"): ?>
            <div class="bg-light admin-config">
                <div class="data-table mt-5">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            </tr>
                            <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                            </tr>
                            <tr>
                            <th scope="row">3</th>
                            <td colspan="2">Larry the Bird</td>
                            <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif;?>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>