<?php
session_start();
include 'db.php';

// Ensure the user is logged in and is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: teacher_login.php");
    exit();
}

// Check if assignment_id is provided
if (!isset($_GET['assignment_id']) || empty($_GET['assignment_id'])) {
    die("Assignment ID is required.");
}

$assignment_id = $_GET['assignment_id'];

// Fetch the assignment details
$sql_assignment = "SELECT * FROM assignments WHERE id = ?";
$stmt_assignment = $conn->prepare($sql_assignment);

if (!$stmt_assignment) {
    die("Prepare failed: " . $conn->error);
}

$stmt_assignment->bind_param("i", $assignment_id);
$stmt_assignment->execute();
$assignment_result = $stmt_assignment->get_result();

if ($assignment_result->num_rows === 0) {
    die("Assignment not found.");
}

$assignment = $assignment_result->fetch_assoc();

// Fetch submissions for this assignment
$sql_submissions = "SELECT s.*, u.username 
    FROM submissions s 
    JOIN users u ON s.submitted_by = u.id 
    WHERE s.assignment_id = ?";
$stmt_submissions = $conn->prepare($sql_submissions);

if (!$stmt_submissions) {
    die("Prepare failed: " . $conn->error);
}

$stmt_submissions->bind_param("i", $assignment_id);
$stmt_submissions->execute();
$submissions_result = $stmt_submissions->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Assignment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Grade Assignment: <?php echo htmlspecialchars($assignment['title']); ?></h1>

        <!-- Submissions -->
        <h3>Submissions</h3>
        <?php if ($submissions_result->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($submission = $submissions_result->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <p>Submitted by: <?php echo htmlspecialchars($submission['username']); ?></p>
                        <p>Submission Date: <?php echo htmlspecialchars($submission['submission_date']); ?></p>
                        <p>Content: <?php echo isset($submission['content']) ? nl2br(htmlspecialchars($submission['content'])) : 'No content available'; ?></p>
                        <form action="grade_submission.php" method="post">
                            <input type="hidden" name="submission_id" value="<?php echo $submission['id']; ?>">
                            <div class="form-group">
                                <label for="grade">Grade:</label>
                                <input type="number" class="form-control" id="grade" name="grade" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="feedback">Feedback:</label>
                                <textarea class="form-control" id="feedback" name="feedback" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Grade</button>
                        </form>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No submissions yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
