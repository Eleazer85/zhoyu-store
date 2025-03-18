<?php
$connect = mysqli_connect("localhost", "root", "", "web-top-up");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['katalog_id'])) {
    $id = $_POST['katalog_id'];
    $delete_query = "DELETE FROM Katalog WHERE Harga='$id'";
    mysqli_query($connect, $delete_query);
}

header("Location: admin?page=katalog");
exit;
?>