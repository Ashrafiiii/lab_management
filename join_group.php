<?php
session_start();
include 'db.php';

// Ensure the user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_name = $_POST['group_name'];
    $user_id = $_SESSION['user_id'];

    // Check if the user is forming a new group or joining an existing one
    if (isset($_POST['form_group'])) {
        // Create a new group
        $stmt = $conn->prepare("INSERT INTO groups (group_name, leader_id) VALUES (?, ?)");
        $stmt->bind_param("si", $group_name, $user_id);
        $stmt->execute();
        $group_id = $stmt->insert_id;
        $stmt->close();

        // Add the user to the new group
        $stmt = $conn->prepare("INSERT INTO group_members (group_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $group_id, $user_id);
        $stmt->execute();
        $stmt->close();
        
        echo "Group formed and you have been added to it.";
    } elseif (isset($_POST['join_group'])) {
        $group_id = $_POST['group_id'];

        // Add the user to the existing group
        $stmt = $conn->prepare("INSERT INTO group_members (group_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $group_id, $user_id);
        if ($stmt->execute()) {
            echo "You have joined the group.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join or Form a Group</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Join or Form a Group</h2>
        <form method="post">
            <div class="form-group">
                <label for="group_name">Group Name (to form a new group):</label>
                <input type="text" class="form-control" id="group_name" name="group_name">
                <button type="submit" name="form_group" class="btn btn-success mt-3">Form Group</button>
            </div>
        </form>

        <form method="post">
            <div class="form-group">
                <label for="group_id">Join an Existing Group:</label>
                <input type="number" class="form-control" id="group_id" name="group_id" required>
                <button type="submit" name="join_group" class="btn btn-primary mt-3">Join Group</button>
            </div>
        </form>
    </div>
</body>
</html>
