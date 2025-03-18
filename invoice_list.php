<?php
$connect = mysqli_connect("localhost", "root", "", "web-top-up");

// Pagination settings
$limit = 10; // Entries per page
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : "";
$search_query = !empty($search) ? "WHERE 
    payment_id LIKE '%$search%' OR 
    game LIKE '%$search%' OR 
    amount LIKE '%$search%' OR 
    payment_method LIKE '%$search%' OR 
    `user_id/username` LIKE '%$search%' OR 
    server LIKE '%$search%'" : "";

// Fetch total records (for pagination)
$total_query = mysqli_query($connect, "SELECT COUNT(*) as total FROM payments $search_query");
$total_data = mysqli_fetch_assoc($total_query)['total'];
$total_pages = ceil($total_data / $limit);

// Fetch filtered data
$query = "SELECT payment_id, game, amount, payment_method, `user_id/username`, server 
          FROM payments 
          $search_query 
          ORDER BY created_at DESC 
          LIMIT $limit OFFSET $offset";
$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Invoice List</h2>
        <form method="GET">
    <input type="hidden" name="page" value="invoice"> <!-- Keep on invoice page -->
    <input type="text" name="search" placeholder="Search invoices..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <button type="submit">Search</button>
</form>

        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Payment ID</th>
                    <th>Game</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>User ID / Username</th>
                    <th>Server</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['payment_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['game']); ?></td>
                            <td><?php echo htmlspecialchars($row['amount']); ?></td>
                            <td><?php echo htmlspecialchars($row['payment_method'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($row['user_id/username']); ?></td>
                            <td><?php echo htmlspecialchars($row['server']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">No invoices found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</body>
</html>