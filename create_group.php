<?php
session_start();
include 'db.php';

// Ensure the user is logged in and is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: teacher_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_name = $_POST['group_name'];

    if (!empty($group_name)) {
        $sql = "INSERT INTO groups (group_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("s", $group_name);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            // Set success message in session
            $_SESSION['message'] = 'Group created successfully!';
            header("Location: teacher_dashboard.php");
            exit();  // Ensure no further code is executed
        } else {
            echo "Failed to create group.";
        }
        
        $stmt->close();
    } else {
        echo "Group name is required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Group</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Create Group</h2>
        <form action="create_group.php" method="post">
            <div class="form-group">
                <label for="group_name">Group Name:</label>
                <input type="text" class="form-control" id="group_name" name="group_name" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Group</button>
        </form>
    </div>
</body>
</html>
