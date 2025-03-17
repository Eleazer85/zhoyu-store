<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$connect = mysqli_connect("localhost","root","","web-top-up");
if (isset($_POST["catalogue_price"]) && isset($_POST["catalogue_product"]) && isset($_POST["catalogue_payment"])){
    $price = $_POST["catalogue_price"];
    $amount = $_POST["catalogue_product"];
    $payment_method = $_POST["catalogue_payment"];
    $games = $_POST["catalogue_games"];
    $player_id = $_POST["player_id"];
    $server = $_POST["server"] ?? "No server available for this game";

    if (empty($price) || empty($amount) || empty($payment_method) || empty($games) || empty($player_id)) {
        echo "<script>
            alert('Mohon isi semua form nya');
            window.history.back();
        </script>";
        die('stop here empty()');
    }

    $payment_id = bin2hex(random_bytes(16)); // 32-character hex

    $stmt = $connect->prepare("INSERT INTO `payments` (`payment_id`,`game`,`amount`,`prices`,`payment_method`,`user_id/username`,`server`) VALUES  (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss",$payment_id,$games,$amount,$price,$payment_method,$player_id,$server);
    $stmt->execute();
    $stmt->close();

    $nama_game = urlencode($games);
    $nominal = urlencode($amount);
    $pembayaran = urldecode($payment_method);
    $player_id = urlencode($player_id);
    $id_pembayaran = urlencode($payment_id);

    if($server != "No server available for this game"){
        $server = urlencode($server);
        $message = "Hallo min, saya mau top up ke game : $nama_game%0A" .
        "ID pembayaran:$id_pembayaran%0A".
        "Nominal: $nominal,%0A" .
        "Pembayaran melalui: $pembayaran,%0A" .
        "ID: $player_id%0A" .
        "Server: $server";
    }else{
        $message = "Hallo min, saya mau top up ke game : $nama_game%0A" .
        "ID pembayaran:$id_pembayaran%0A".
        "Nominal: $nominal,%0A" .
        "Pembayaran melalui: $pembayaran,%0A" .
        "ID: $player_id%0A";
    };

    //This is ussed for testing purpose to print out the post values
    // echo $_POST["catalogue_price"]."<br>";
    // echo $_POST["catalogue_product"]."<br>";
    // echo $_POST["catalogue_payment"]."<br>";
    // echo $_POST["catalogue_games"]."<br>";

    header("Location: https://wa.me/6287851265092?text=$message");
}else{
    echo "
    <script>
        window.history.back();
    </script>
    ";
}

?>