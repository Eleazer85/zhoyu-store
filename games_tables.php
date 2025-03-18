<?php
$connect = mysqli_connect("localhost", "root", "", "web-top-up");

$limit = 10; // Number of records per page


// Check if the user submitted a page change
if (isset($_POST['page'])) {
    $_SESSION['halaman'] = $_POST['page'];
}

// Get current page from session, default to 1
$halaman = isset($_SESSION['halaman']) ? $_SESSION['halaman'] : 1;
$offset = ($halaman - 1) * $limit;

// Handle search input
$search = isset($_POST['search']) ? mysqli_real_escape_string($connect, $_POST['search']) : "";

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

<div class="bg-light admin-config">
    <div class="admin-content">
        <form method="POST" class="mt-3">
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
        <form method="POST" class="admin-pagination">
        <nav>
            <ul class="pagination">
                <!-- Previous Button -->
                <li class="page-item <?php echo ($halaman <= 1) ? 'disabled' : ''; ?>">
                    <button type="submit" name="page" value="<?php echo $halaman - 1; ?>" class="page-link">&laquo; Prev</button>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($halaman == $i) ? 'active' : ''; ?>">
                        <button type="submit" name="page" value="<?php echo $i; ?>" class="page-link"><?php echo $i; ?></button>
                    </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <li class="page-item <?php echo ($halaman >= $total_pages) ? 'disabled' : ''; ?>">
                    <button type="submit" name="page" value="<?php echo $halaman + 1; ?>" class="page-link">Next &raquo;</button>
                </li>
            </ul>
        </nav>
        </form>
    </div>
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
