<?php
session_start();
include 'db.php';

// Ensure the user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: student_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch student's group
$sql_group = "SELECT g.group_name 
               FROM groups g
               JOIN student_groups sg ON g.id = sg.group_id
               WHERE sg.student_id = ?";
$stmt_group = $conn->prepare($sql_group);

if (!$stmt_group) {
    die("Prepare failed: " . $conn->error);
}

$stmt_group->bind_param("i", $user_id);
$stmt_group->execute();
$group_result = $stmt_group->get_result();
$group = $group_result->fetch_assoc();

// Fetch upcoming deadlines
$sql_deadlines = "SELECT * FROM assignments 
                  WHERE (group_id IS NULL OR group_id IN 
                        (SELECT group_id FROM student_groups WHERE student_id = ?)) 
                  AND (student_id = ? OR student_id IS NULL) 
                  AND deadline >= CURDATE() 
                  ORDER BY deadline";
$stmt_deadlines = $conn->prepare($sql_deadlines);

if (!$stmt_deadlines) {
    die("Prepare failed: " . $conn->error);
}

$stmt_deadlines->bind_param("ii", $user_id, $user_id);
$stmt_deadlines->execute();
$deadlines_result = $stmt_deadlines->get_result();

// Fetch student's assignments
$sql_assignments = "SELECT a.*, 
    (SELECT COUNT(s.id) FROM submissions s WHERE s.assignment_id = a.id AND s.submitted_by = ?) as submitted 
    FROM assignments a 
    WHERE (a.group_id IS NULL OR a.group_id IN 
           (SELECT group_id FROM student_groups WHERE student_id = ?)) 
    AND (a.student_id = ? OR a.student_id IS NULL)";
$stmt_assignments = $conn->prepare($sql_assignments);

if (!$stmt_assignments) {
    die("Prepare failed: " . $conn->error);
}

$stmt_assignments->bind_param("iii", $user_id, $user_id, $user_id);
$stmt_assignments->execute();
$assignments_result = $stmt_assignments->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to the updated CSS file -->
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome to Your Dashboard, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Student'; ?></h2>

        <!-- Display Group -->
        <section class="mb-4">
            <h3>Your Group</h3>
            <p>
                <?php if ($group): ?>
                    <?php echo htmlspecialchars($group['group_name']); ?>
                <?php else: ?>
                    No Group Assigned
                <?php endif; ?>
            </p>
        </section>

        <!-- Upcoming Deadlines -->
        <section class="mb-4">
            <h3>Upcoming Deadlines</h3>
            <ul class="list-group">
                <?php if ($deadlines_result->num_rows > 0): ?>
                    <?php while ($deadline = $deadlines_result->fetch_assoc()): ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($deadline['title']); ?> - 
                            Deadline: <?php echo htmlspecialchars($deadline['deadline']); ?>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li class="list-group-item">No upcoming deadlines.</li>
                <?php endif; ?>
            </ul>
        </section>

        <!-- Assignments -->
        <section class="mb-4">
            <h3>Your Assignments</h3>
            <ul class="list-group">
                <?php if ($assignments_result->num_rows > 0): ?>
                    <?php while ($assignment = $assignments_result->fetch_assoc()): ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($assignment['title']); ?> - 
                            Status: <?php echo $assignment['submitted'] > 0 ? 'Submitted' : 'Pending'; ?>
                            <a href="submit_assignment.php?assignment_id=<?php echo $assignment['id']; ?>" class="btn btn-primary btn-sm float-right">Submit</a>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li class="list-group-item">No assignments found.</li>
                <?php endif; ?>
            </ul>
        </section>

        <!-- Group Chat (Placeholder) -->
        <section>
            <h3>Group Chat</h3>
            <p>If there's a group chat system in place, this is where students can interact with their group members. You can link to a chat feature here, or display a chat interface directly.</p>
        </section>
    </div>
</body>
</html>
