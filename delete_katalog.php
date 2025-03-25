<?php
$connect = mysqli_connect("localhost", "root", "", "web-top-up");

function verifyToken(){
    global $connect; 

    if (!isset($_COOKIE["auth_token"])) {
        header('Location: https://localhost/web-top-up/login');
        exit;
    }

    $token = $_COOKIE["auth_token"];

    // ✅ Fetch the user where the session_token matches
    $stmt = $connect->prepare("SELECT Username, session_token FROM admins WHERE session_token IS NOT NULL");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        if (password_verify($token, $row["session_token"])) {
            return [$row["Username"], true];
        }
    }

    // ❌ No user found, redirect
    header('Location: https://localhost/web-top-up/login');
    exit;
}
verifyToken();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['katalog_id'])) {
    $id = $_POST['katalog_id'];
    $delete_query = "DELETE FROM Katalog WHERE Harga='$id'";
    mysqli_query($connect, $delete_query);
}

header("Location: admin?page=katalog");
exit;
?>