<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assignment_id = $_POST['assignment_id'];
    $submitted_by = $_SESSION['user_id'];
    $submission_date = date('Y-m-d');

    $sql = "INSERT INTO submissions (assignment_id, submitted_by, submission_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $assignment_id, $submitted_by, $submission_date);
    
    if ($stmt->execute()) {
        header("Location: student_dashboard.php");
    } else {
        echo "Submission failed.";
    }
}
?>

<form method="POST" action="submit_assignment.php">
    <input type="hidden" name="assignment_id" value="<?php echo $_GET['assignment_id']; ?>">
    <textarea name="submission" placeholder="Paste your submission here" required></textarea>
    <button type="submit">Submit</button>
</form>
