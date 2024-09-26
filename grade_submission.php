<?php
session_start();
include 'db.php';

// Ensure the user is logged in and is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: teacher_login.php");
    exit();
}

// Check if submission_id is provided
if (!isset($_POST['submission_id']) || empty($_POST['submission_id'])) {
    die("Submission ID is required.");
}

$submission_id = $_POST['submission_id'];
$grade = $_POST['grade'];
$feedback = $_POST['feedback'];

// Update the submission with the grade and feedback
$sql = "UPDATE submissions SET grade = ?, feedback = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("isi", $grade, $feedback, $submission_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $message = "Submission graded successfully.";
} else {
    $message = "Failed to grade submission.";
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Submission</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Grade Submission</h1>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <a href="teacher_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>
</body>
</html>
