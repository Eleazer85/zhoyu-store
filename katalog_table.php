<?php
$connect = mysqli_connect("localhost", "root", "", "web-top-up");

$limit = 10; // Records per page

// Get search term from GET request
$search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : "";

// Get current page, default to 1
$halaman = isset($_GET['halaman_katalog']) ? (int)$_GET['halaman_katalog'] : 1;
$halaman = max(1, $halaman); // Ensure at least page 1
$offset = ($halaman - 1) * $limit;

// Modify query to support search
$search_query = $search ? "WHERE `Game_terkait` LIKE '%$search%'" : "";

// Fetch total records based on search
$total_query = mysqli_query($connect, "SELECT COUNT(*) as total FROM Katalog $search_query");
$total_row = mysqli_fetch_assoc($total_query);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch limited records for the current page
$query = mysqli_query($connect, "SELECT * FROM Katalog $search_query LIMIT $offset, $limit");
?>

<!-- Search Form -->
<div class="admin-content">
    <form method="GET" class="mt-3">
        <!-- Keep the page parameter in the URL -->
        <input type="hidden" name="page" value="katalog">
        
        <input type="text" name="search" placeholder="Search katalog..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Data Table -->
    <div class="data-table mt-2 table-container" style="overflow-x: auto; max-width: 100%;">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Harga</th>
                    <th scope="col">Nominal</th>
                    <th scope="col">Currency</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Tipe</th>
                    <th scope="col">Game Terkait</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["Harga"]); ?></td>
                        <td><?php echo htmlspecialchars($row["Nominal"]); ?></td>
                        <td><?php echo htmlspecialchars($row["Curency"]); ?></td>
                        <td><img src="<?php echo htmlspecialchars($row["Gambar"]); ?>" alt="Gambar" style="width:50px; height:50px;"></td>
                        <td><?php echo htmlspecialchars($row["Tipe"]); ?></td>
                        <td><?php echo htmlspecialchars($row["Game_terkait"]); ?></td>
                        <td>
                            <a href="edit_katalog.php?id=<?php echo $row['Harga']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form method="POST" action="delete_katalog.php" onsubmit="return confirm('Are you sure you want to delete this item?');" style="display:inline-block;">
                                <input type="hidden" name="katalog_id" value="<?php echo htmlspecialchars($row['Harga']); ?>">
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
                <a class="page-link" href="?page=katalog&halaman_katalog=<?php echo $halaman - 1; ?>&search=<?php echo urlencode($search); ?>">&laquo; Prev</a>
            </li>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($halaman == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=katalog&halaman_katalog=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <!-- Next Button -->
            <li class="page-item <?php echo ($halaman >= $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=katalog&halaman_katalog=<?php echo $halaman + 1; ?>&search=<?php echo urlencode($search); ?>">Next &raquo;</a>
            </li>
        </ul>
    </nav>
</div>
