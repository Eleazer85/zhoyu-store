<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "web-top-up");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['game_id'])) {
    // Convert game_id to an integer (to prevent SQL injection)
    $game_id = $_POST['game_id']; 
    
    // Debug: Check if the correct ID is being received
    error_log("Deleting game with ID: " . $game_id);

    // Use a prepared statement to prevent SQL injection
    $query = "DELETE FROM Games WHERE ID = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "s", $game_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = "Game deleted successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to delete the game.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connect);

    header("Location: https://localhost/web-top-up/admin?page=games");
    exit();
} else {
    $_SESSION['error_message'] = "Invalid request!";
    header("Location: https://localhost/web-top-up/admin?page=games");
    exit();
} 