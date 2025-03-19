<?php
$connect = mysqli_connect("localhost", "root", "", "web-top-up");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($connect, "SELECT * FROM Katalog WHERE Harga = '$id'");
    $data = mysqli_fetch_assoc($query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $harga = $_POST["harga"];
    $nominal = $_POST["nominal"];
    $curency = $_POST["curency"];
    $tipe = $_POST["tipe"];
    $game_terkait = $_POST["game_terkait"];

    // Handle image upload
    if (!empty($_FILES["gambar"]["name"])) {
        $target_dir = "Images/Game-Money";
        $imageFileType = strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));
        $newFileName = uniqid() . "." . $imageFileType;
        $target_file = $target_dir . $newFileName;

        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $gambar = $target_file;
            } else {
                echo '<div class="alert alert-danger">Failed to upload image.</div>';
                exit;
            }
        } else {
            echo '<div class="alert alert-danger">File is not a valid image.</div>';
            exit;
        }
    } else {
        $gambar = $data['Gambar'];
    }

    // Update database
    $update_query = "UPDATE Katalog SET Harga='$harga', Nominal='$nominal', Curency='$curency', Gambar='$gambar', Tipe='$tipe', Game_terkait='$game_terkait' WHERE Harga='$id'";
    mysqli_query($connect, $update_query);

    $_SESSION['success_message'] = "Katalog updated successfully!";
    header("Location: admin?page=katalog");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Katalog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>Edit Katalog</h4>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Harga:</label>
                        <input type="text" name="harga" value="<?php echo htmlspecialchars($data['Harga']); ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nominal:</label>
                        <input type="text" name="nominal" value="<?php echo htmlspecialchars($data['Nominal']); ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Curency:</label>
                        <input type="text" name="curency" value="<?php echo htmlspecialchars($data['Curency']); ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar:</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                        <div class="mt-2">
                            <img src="<?php echo htmlspecialchars($data['Gambar']); ?>" class="img-thumbnail" style="width: 150px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipe:</label>
                        <input type="text" name="tipe" value="<?php echo htmlspecialchars($data['Tipe']); ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Game Terkait:</label>
                        <input type="text" name="game_terkait" value="<?php echo htmlspecialchars($data['Game_terkait']); ?>" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                        <a href="admin?page=katalog" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>