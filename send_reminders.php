<?php
session_start();
include 'db.php';

// Ensure the user is logged in and is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assignment_id = $_POST['assignment_id'];

    $stmt = $conn->prepare("SELECT DISTINCT u.email FROM submissions s JOIN users u ON s.user_id = u.id WHERE s.assignment_id = ?");
    $stmt->bind_param("i", $assignment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $to = $row['email'];
        $subject = "Reminder: Assignment Due Soon";
        $message = "This is a reminder that your assignment with ID $assignment_id is due soon.";
        $headers = "From: no-reply@yourdomain.com";

        mail($to, $subject, $message, $headers);
    }

    echo "Reminders sent successfully.";
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Reminders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Send Reminders</h2>
        <form method="post">
            <div class="form-group">
                <label for="assignment_id">Assignment ID:</label>
                <input type="number" class="form-control" id="assignment_id" name="assignment_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Send Reminders</button>
        </form>
    </div>
</body>
</html>
