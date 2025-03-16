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
    
    $stmt->close(); //close stmt to free resources
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
    $stmt->close();

    // Set a secure cookie with the raw token
    setcookie("auth_token", $token, [
        "expires" => time() + 3600,  // Cookie expires in 1 hour
        "path" => "/",
        "secure" => false,  //  Change to false for localhost testing
        "httponly" => true,  // Prevent JavaScript access
        "samesite" => "Lax"  // Change to Lax to allow redirections
    ]);            // Generate a secure token
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
        "secure" => true,  //  Only accept https
        "httponly" => true,  // Prevent JavaScript access
        "samesite" => "Strict"  // Change to Lax to allow redirections
    ]);
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
            echo "User verified: " . $row["Username"];
            $users = $row["Username"];
            $user_found = true;
            break;
        }
    }

    if($user_found == false){
        header('Location: https://localhost/web-top-up/login_admin.php ');
    }else{
        return [$users,$user_found];
    }
}

function cleanExpiredPayments($connect) {
    $sql = "DELETE FROM payments WHERE expires_at <= NOW()";
    $connect->query($sql);
}


if(verifyToken() != null && verifyToken()[1]){
    die("Already logged in");
}

//for testing purpose
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if(authenticate($username, $password) == true){
        if (isset($_POST["remember"]) && $_POST["remember"] == "on") {
            createToken();
            echo "Cookie has been set!";
        } else {
            echo "logging in without remembering you";
        };        
    }else{
        header('Location: https://localhost/web-top-up/login_admin.php ');
        exit;
    };
} else {
    header('Location: https://localhost/web-top-up/login_admin.php ');
    exit;
};

cleanExpiredPayments($connect);
?>