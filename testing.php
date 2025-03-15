<?php 
if (isset($_POST["catalogue_price"]) && isset($_POST["catalogue_product"])){
    echo $_POST["catalogue_price"]."<br>";
    echo $_POST["catalogue_product"];
    header("Location: https://wa.me/6282233375118?text=Hello%20there!");
}

?>