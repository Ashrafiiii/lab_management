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

    $stmt = $conn->prepare("SELECT g.group_name, p.progress_status, p.feedback FROM progress p JOIN groups g ON p.group_id = g.id WHERE p.assignment_id = ?");
    $stmt->bind_param("i", $assignment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    header("Location: track_progress.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Progress</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Progress Details for Assignment ID: <?php echo htmlspecialchars($assignment_id); ?></h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Group Name</th>
                    <th>Progress Status</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['group_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['progress_status']); ?></td>
                        <td><?php echo htmlspecialchars($row['feedback']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</body>
</html>
