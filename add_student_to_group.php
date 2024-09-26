<?php
session_start();
include 'db.php';

// Ensure the user is logged in and is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: teacher_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $group_id = $_POST['group_id'];

    if (!empty($student_id) && !empty($group_id)) {
        $sql = "INSERT INTO student_groups (student_id, group_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("ii", $student_id, $group_id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = 'Student added to group successfully!';
            header("Location: teacher_dashboard.php");
            exit();  // Ensure no further code is executed
        } else {
            echo "Failed to add student to group.";
        }
        
        $stmt->close();
    } else {
        echo "Student ID and Group ID are required.";
    }
}
?>
