<?php
session_start();
include '../db.php';

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Admin Dashboard</h2>
        <ul class="list-group">
            <li class="list-group-item"><a href="manage_users.php">Manage Users</a></li>
            <li class="list-group-item"><a href="view_assignments.php">View Assignments</a></li>
            <li class="list-group-item"><a href="send_announcements.php">Send Announcements</a></li>
            <li class="list-group-item"><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>
