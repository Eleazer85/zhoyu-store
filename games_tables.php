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

// Fetch total number of records
$total_query = mysqli_query($connect, "SELECT COUNT(*) as total FROM Games");
$total_row = mysqli_fetch_assoc($total_query);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit); // Total pages calculation

// Fetch limited records for the current page
$query = mysqli_query($connect, "SELECT * FROM Games LIMIT $offset, $limit");
?>

<div class="bg-light admin-config">
    <div class="admin-content">
        <div class="data-table mt-2">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama game</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Nama ID</th>
                        <th scope="col">Tipe server</th>
                        <th scope="col">Opsi server</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($query)): ?>
                        <tr>
                            <td><?php echo $row["ID"]; ?></td>
                            <td><?php echo $row["Nama-game"]; ?></td>
                            <td><?php echo (strlen($row["Description"]) > 30) ? substr($row["Description"], 0, 30) . "..." : $row["Description"]; ?></td>
                            <td><?php echo $row["id_type"]; ?></td>
                            <td><?php echo $row["server_type"]; ?></td>
                            <td><?php echo empty($row["server_options"]) ? "<i>NULL</i>" : $row["server_options"]; ?></td>
                             <!-- Delete button -->
                             <td>
                                <form method="POST" action="delete_game.php" onsubmit="return confirm('Are you sure you want to delete this game?');">
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