<?php
$connect = new mysqli("localhost", "root", "", "web-top-up");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_game'])) {
    if (empty($_POST['nama_game']) || empty($_FILES['gambar_game']['name']) || empty($_FILES['gambar_thumbnail']['name'])) {
        die("Error: Required fields are missing.");
    }

    $nama_game = trim($_POST['nama_game']);
    $description = trim($_POST['description'] ?? '');
    $id_type = !empty($_POST['id_type']) ? $_POST['id_type'] : "Player ID";
    $server_type = trim($_POST['server_type'] ?? 'None');
    $server_options = trim($_POST['server_options'] ?? '');

    // ✅ Get platform availability from checkboxes
    $is_mobile = isset($_POST['platform_mobile']) ? "1" : "0";
    $is_pc = isset($_POST['platform_pc']) ? "1" : "0";
    $is_console = isset($_POST['platform_console']) ? "1" : "0";

    $platform_code = $is_mobile . $is_pc . $is_console;

    // ✅ Generate unique ID
    $stmt = $connect->prepare("SELECT COUNT(*) FROM Games WHERE LEFT(ID, 3) = ?");
    $stmt->bind_param("s", $platform_code);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $new_id = $platform_code . "-" . str_pad($count + 1, 5, "0", STR_PAD_LEFT);

    // ✅ Generate Game_terkait
    $base_game_terkait = strtolower(str_replace(" ", "-", $nama_game));
    $new_game_terkait = $base_game_terkait;

    $counter = 1;
    while (true) {
        $check_stmt = $connect->prepare("SELECT COUNT(*) FROM Games WHERE Game_terkait = ?");
        $check_stmt->bind_param("s", $new_game_terkait);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count == 0) break;
        $new_game_terkait = $base_game_terkait . "-" . $counter;
        $counter++;
    }

    // ✅ Upload Images
    $target_dir = "Images/";
    $gambar_game = $target_dir . uniqid("game_", true) . "." . pathinfo($_FILES['gambar_game']['name'], PATHINFO_EXTENSION);
    move_uploaded_file($_FILES['gambar_game']['tmp_name'], $gambar_game);
    chmod($gambar_game, 0644);

    $gambar_thumbnail = $target_dir . uniqid("thumbnail_", true) . "." . pathinfo($_FILES['gambar_thumbnail']['name'], PATHINFO_EXTENSION);
    move_uploaded_file($_FILES['gambar_thumbnail']['tmp_name'], $gambar_thumbnail);
    chmod($gambar_thumbnail, 0644);

    // ✅ Insert into Database
    $stmt = $connect->prepare("INSERT INTO Games (ID, `Nama-game`, `Description`, `id_type`, `server_type`, `server_options`, `Gambar-game`, `Game_terkait`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $new_id, $nama_game, $description, $id_type, $server_type, $server_options, $gambar_game, $new_game_terkait);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Game added successfully!'); window.location.href='admin.php?page=games';</script>";
}
?>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New Game</h4>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Game Name*:</label>
                    <input type="text" name="nama_game" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description:</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">ID Type:</label>
                    <input type="text" name="id_type" class="form-control" placeholder="Default: Player ID">
                </div>

                <div class="mb-3">
                    <label class="form-label">Platform Availability:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="platform_mobile" value="1" checked>
                        <label class="form-check-label">Mobile</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="platform_pc" value="1">
                        <label class="form-check-label">PC</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="platform_console" value="1">
                        <label class="form-check-label">Console</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Server Type:</label>
                    <select name="server_type" class="form-select">
                        <option value="None">None</option>
                        <option value="Input">Input</option>
                        <option value="Dropdown">Dropdown</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Server Options:</label>
                    <input type="text" name="server_options" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Game Image*:</label>
                    <input type="file" name="gambar_game" class="form-control" accept="image/*" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Thumbnail*:</label>
                    <input type="file" name="gambar_thumbnail" class="form-control" accept="image/*" required>
                </div>

                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                <div class="d-grid">
                    <button type="submit" name="add_game" class="btn btn-primary">Add Game</button>
                </div>
            </form>
        </div>
    </div>
</div>