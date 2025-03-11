<?php
// make a new admin function
$connect = mysqli_connect("localhost","root","","web-top-up");

function create_admin($username,$password){
    global $connect;
    $hashed_password = password_hash($password,PASSWORD_BCRYPT);

    $stmt = $connect->prepare("INSERT INTO `admins` (`Username`,`Password`) VALUES (?,?)");
    $stmt->bind_param("ss",$username,$hashed_password);
    $stmt->execute();
};

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

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


//for testing purpose
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if(authenticate($username, $password) == true){
        echo "password match!";
    }else{
        header('Location: https://localhost/web-top-up/login_admin.php ');
    };
} else {
    echo "Please fill out the form.";
};
?>