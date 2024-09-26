<?php
session_start();
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'], $_POST['group_id'])) {
    $message = $_POST['message'];
    $group_id = $_POST['group_id'];
    $username = $_SESSION['username']; // Assuming username is stored in session

    $sql = "INSERT INTO group_chat (group_id, username, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $group_id, $username, $message);
    $stmt->execute();
}
?>
