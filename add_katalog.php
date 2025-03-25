<?php
$connect = mysqli_connect("localhost", "root", "", "web-top-up");
verifyToken();

// Fetch available games (using Game_terkait as the identifier)
$games_query = mysqli_query($connect, "SELECT `Nama-game`, `Game_terkait` FROM Games");
$games = [];
while ($row = mysqli_fetch_assoc($games_query)) {
    $games[$row['Game_terkait']] = $row['Nama-game']; // Store identifier => game name
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $harga = isset($_POST['harga']) ? intval($_POST['harga']) : 0;
    $nominal = isset($_POST['nominal']) ? intval($_POST['nominal']) : 0;
    $curency = isset($_POST['curency']) ? mysqli_real_escape_string($connect, $_POST['curency']) : "";
    $tipe = "Region Indonesia";
    $game_terkait = isset($_POST['game_terkait']) ? mysqli_real_escape_string($connect, $_POST['game_terkait']) : "";

    // File upload handling
    $gambar = "";
    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] == 0) {
        $target_dir = "Images/";
        $file_name = time() . "_" . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $gambar = $target_file;
            } else {
                echo "<div class='alert alert-danger'>Failed to upload image.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Invalid file type. Only JPG, PNG, and GIF are allowed.</div>";
        }
    }

    // Insert data if no errors
    if ($harga > 0 && $nominal > 0 && !empty($curency) && !empty($gambar) && !empty($game_terkait)) {
        $query = "INSERT INTO Katalog (Harga, Nominal, Curency, Gambar, Tipe, Game_terkait) 
                  VALUES ('$harga', '$nominal', '$curency', '$gambar', '$tipe', '$game_terkait')";
        try{
            if (mysqli_query($connect, $query)) {
                echo "<div class='alert alert-success'>Katalog added successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Database Error </div>";
            }
        } catch(mysqli_sql_exception $e){
            echo "<div class='alert alert-danger'>Database Error,  kemungkinan isi terlalu panjang </div>";
        }
    } else {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Katalog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Add Katalog</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="mb-3">
                <label for="nominal" class="form-label">Nominal</label>
                <input type="text" class="form-control" id="nominal" name="nominal" required>
            </div>
            <div class="mb-3">
                <label for="curency" class="form-label">Currency</label>
                <input type="text" class="form-control" id="curency" name="curency" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
            </div>
            <input type="hidden" name="tipe" value="Region Indonesia">
            <div class="mb-3">
                <label for="game_terkait" class="form-label">Game Terkait</label>
                <select class="form-select" id="game_terkait" name="game_terkait" required>
                    <option value="">Select a game</option>
                    <?php foreach ($games as $game_terkait => $name): ?>
                        <option value="<?php echo htmlspecialchars($game_terkait); ?>"><?php echo htmlspecialchars($name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Katalog</button>
        </form>
    </div>
</body>
</html>