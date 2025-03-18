<?php
$connect = new mysqli("localhost", "root", "", "web-top-up");
session_start(); // Always at the top!

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

// ✅ Regenerate CSRF token on each page load
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
} else {
    // Regenerate token every time the form is loaded
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "Session Token: " . $_SESSION['csrf_token'] . "<br>";
    // echo "Form Token: " . $_POST['csrf_token'] . "<br>";
    
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid request. Possible CSRF attack.");
    }
}

// Check connection
if ($connect->connect_error) {
    die("Database connection failed: " . $connect->connect_error);
}

// Get game ID from URL
if (!isset($_GET['id'])) {
    die("Game ID is required.");
}

$game_id = $_GET['id'];

// Fetch game details
$stmt = $connect->prepare("SELECT * FROM Games WHERE ID = ?");
$stmt->bind_param("s", $game_id);
$stmt->execute();
$result = $stmt->get_result();
$game = $result->fetch_assoc();
$stmt->close();

if (!$game) {
    die("Game not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_game = $_POST['nama_game'];
    $description = $_POST['description'];
    $id_type = $_POST['id_type'];
    $server_type = $_POST['server_type'];
    $server_options = $_POST['server_options'];

    // Generate new Game_terkait format
    $base_game_terkait = strtolower(str_replace(" ", "-", $nama_game));
    $new_game_terkait = $base_game_terkait;

    // ✅ Check if `Game_terkait` already exists
    $counter = 1;
    while (true) {
        $check_stmt = $connect->prepare("SELECT COUNT(*) FROM Games WHERE Game_terkait = ?");
        $check_stmt->bind_param("s", $new_game_terkait);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count == 0 || $new_game_terkait == $game['Game_terkait']) {
            break; // ✅ Found a unique name OR it's the same as before
        }

        $new_game_terkait = $base_game_terkait . "-" . $counter;
        $counter++;
    }

// Function to delete old image safely
function deleteOldImage($oldImage) {
    if (!empty($oldImage) && file_exists($oldImage)) {
        unlink($oldImage); // Delete the old image
    }
}

    // Process game image upload
    $gambar_game = $game['Gambar-game']; // Keep the old image if no new one is uploaded
    if (!empty($_FILES['gambar_game']['name'])) {
        deleteOldImage($gambar_game); // Delete old image

        $target_dir = "Images/";
        $file_extension = pathinfo($_FILES['gambar_game']['name'], PATHINFO_EXTENSION);
        $random_filename = uniqid("game_", true) . "." . $file_extension;
        $gambar_game = $target_dir . $random_filename;

        if (move_uploaded_file($_FILES['gambar_game']['tmp_name'], $gambar_game)) {
            chmod($gambar_game, 0644);
        } else {
            die("Failed to upload game image.");
        }
    }

    // Process thumbnail upload
    $gambar_thumbnail = $game['Game_terkait']; // Keep the old image if no new one is uploaded
    if (!empty($_FILES['gambar_thumbnail']['name'])) {
        deleteOldImage($gambar_thumbnail); // Delete old image

        $target_dir = "Images/";
        $file_extension = pathinfo($_FILES['gambar_thumbnail']['name'], PATHINFO_EXTENSION);
        $random_filename = uniqid("thumbnail_", true) . "." . $file_extension;
        $gambar_thumbnail = $target_dir . $random_filename;

        if (move_uploaded_file($_FILES['gambar_thumbnail']['tmp_name'], $gambar_thumbnail)) {
            chmod($gambar_thumbnail, 0644);
        } else {
            die("Failed to upload thumbnail.");
        }
    }

    // Update Games table
    $stmt = $connect->prepare("UPDATE Games SET 
        `Nama-game` = ?, 
        `Description` = ?, 
        `id_type` = ?, 
        `server_type` = ?, 
        `server_options` = ?, 
        `Gambar-game` = ?, 
        `Game_terkait` = ? 
        WHERE ID = ?");
    $stmt->bind_param("ssssssss", $nama_game, $description, $id_type, $server_type, $server_options, $gambar_game, $new_game_terkait, $game_id);
    $stmt->execute();
    $stmt->close();

    // Update Katalog table
    $stmt = $connect->prepare("UPDATE Katalog SET `Game_terkait` = ? WHERE `Game_terkait` = ?");
    $stmt->bind_param("ss", $new_game_terkait, $game['Game_terkait']);
    $stmt->execute();
    $stmt->close();

    // ✅ Fix: Ensure `Game_terkait` updates in `Gambar-thumbnail`
    $stmt = $connect->prepare("UPDATE `Gambar-thumbnail` SET `Game_terkait` = ? WHERE `Game_terkait` = ?");
    $stmt->bind_param("ss", $new_game_terkait, $game['Game_terkait']);
    $stmt->execute();
    $stmt->close();

    // ✅ If a new image was uploaded, update `Gambar` too
    if (!empty($_FILES['gambar_thumbnail']['name'])) {
        $stmt = $connect->prepare("UPDATE `Gambar-thumbnail` SET `Gambar` = ? WHERE `Game_terkait` = ?");
        $stmt->bind_param("ss", $gambar_thumbnail, $new_game_terkait);
        $stmt->execute();
        $stmt->close();
    }

    echo "<script>alert('Game updated successfully!'); window.location.href='https://localhost/web-top-up/admin?page=games';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Game</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Container */
        .container {
            width: 90%;
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            background: #f8f8f8;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Form */
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        .form input, 
        .form textarea, 
        .form select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Textarea */
        .form textarea {
            height: 100px;
            resize: none;
        }

        /* Buttons */
        .form button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            background: #007bff;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        .form button:hover {
            background: #0056b3;
        }

        /* Image Preview */
        .preview-img {
            display: block;
            margin: 10px auto;
            max-width: 100%;
            max-height: 150px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 5px;
            background: white;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .container {
                width: 95%;
                padding: 15px;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Game</h2>
        <form method="POST" enctype="multipart/form-data" class="form">
            <!-- ✅ Hidden CSRF token field -->
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <label>Game Name:</label>
            <input type="text" name="nama_game" value="<?= htmlspecialchars($game['Nama-game']) ?>" required>

            <label>Description:</label>
            <textarea name="description"><?= htmlspecialchars($game['Description']) ?></textarea>

            <label>ID Type:</label>
            <input type="text" name="id_type" value="<?= htmlspecialchars($game['id_type']) ?>" required>

            <label>Server Type:</label>
            <select name="server_type">
                <option value="none" <?= ($game['server_type'] == 'none') ? 'selected' : '' ?>>None</option>
                <option value="input" <?= ($game['server_type'] == 'input') ? 'selected' : '' ?>>Input</option>
                <option value="dropdown" <?= ($game['server_type'] == 'dropdown') ? 'selected' : '' ?>>Dropdown</option>
            </select>

            <label>Server Options (comma-separated):</label>
            <input type="text" name="server_options" value="<?= htmlspecialchars($game['server_options']) ?>">

            <label>Game Image:</label>
            <input type="file" name="gambar_game">
            <img src="<?= htmlspecialchars($game['Gambar-game']) ?>" class="preview-img">

            <label>Thumbnail Image:</label>
            <input type="file" name="gambar_thumbnail">
            
            <button type="submit">Update Game</button>
        </form>
    </div>
</body>
</html>
