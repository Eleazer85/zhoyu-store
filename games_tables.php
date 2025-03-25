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

$limit = 10; // Number of records per page

// Get current page number, default to 1
$halaman = isset($_GET['halaman_games']) ? max(1, intval($_GET['halaman_games'])) : 1;
$offset = ($halaman - 1) * $limit;

// Handle search input from GET
$search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : "";

// Modify query to support search
$search_query = $search ? "WHERE `Nama-game` LIKE '%$search%' OR `Description` LIKE '%$search%'" : "";

// Fetch total number of records based on search
$total_query = mysqli_query($connect, "SELECT COUNT(*) as total FROM Games $search_query");
$total_row = mysqli_fetch_assoc($total_query);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch limited records for the current page
$query = mysqli_query($connect, "SELECT * FROM Games $search_query LIMIT $offset, $limit");
?>

<div class="admin-content">
    <form method="GET" class="mt-3">
        <input type="hidden" name="page" value="games"> <!-- Keep ?page=games -->
        <input type="text" name="search" placeholder="Search games..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>
    <div class="data-table mt-2 table-container" style="overflow-x: auto; max-width: 100%;">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama game</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Nama ID</th>
                    <th scope="col">Tipe server</th>
                    <th scope="col">Opsi server</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["ID"]); ?></td>
                        <td><?php echo htmlspecialchars($row["Nama-game"]); ?></td>
                        <td><?php echo (strlen($row["Description"]) > 30) ? htmlspecialchars(substr($row["Description"], 0, 30)) . "..." : htmlspecialchars($row["Description"]); ?></td>
                        <td><?php echo htmlspecialchars($row["id_type"]); ?></td>
                        <td><?php echo htmlspecialchars($row["server_type"]); ?></td>
                        <td><?php echo empty($row["server_options"]) ? "<i>NULL</i>" : htmlspecialchars($row["server_options"]); ?></td>
                        <!-- Edit & Delete buttons -->
                        <td>
                            <a href="edit_game.php?id=<?php echo $row['ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form method="POST" action="delete_game.php" onsubmit="return confirm('Are you sure you want to delete this game?');" style="display:inline-block;">
                                <input type="hidden" name="game_id" value="<?php echo htmlspecialchars($row['ID']); ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="admin-content">
    <nav>
        <ul class="pagination">
            <!-- Previous Button -->
            <li class="page-item <?php echo ($halaman <= 1) ? 'disabled' : ''; ?>">
                <a href="?page=games&halaman_games=<?php echo $halaman - 1; ?>&search=<?php echo urlencode($search); ?>" class="page-link">&laquo; Prev</a>
            </li>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($halaman == $i) ? 'active' : ''; ?>">
                    <a href="?page=games&halaman_games=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="page-link"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <!-- Next Button -->
            <li class="page-item <?php echo ($halaman >= $total_pages) ? 'disabled' : ''; ?>">
                <a href="?page=games&halaman_games=<?php echo $halaman + 1; ?>&search=<?php echo urlencode($search); ?>" class="page-link">Next &raquo;</a>
            </li>
        </ul>
    </nav>
</div>

<?php
if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error_message'] . "</div>";
    unset($_SESSION['error_message']);
}
?>