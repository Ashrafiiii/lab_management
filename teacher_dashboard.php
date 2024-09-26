<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to the updated CSS file -->
</head>
<body>
    <header>
        <h1 class="teacher-dashboard-header">Teacher Dashboard</h1>
    </header>

    <div class="container mt-5">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_SESSION['message']); ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <!-- Create Group -->
        <section class="mb-4">
            <h3>Create Group</h3>
            <form action="create_group.php" method="post">
                <div class="form-group">
                    <label for="group_name">Group Name:</label>
                    <input type="text" class="form-control" id="group_name" name="group_name" required>
                </div>
                <button type="submit" class="btn btn-primary">Create Group</button>
            </form>
        </section>

        <!-- Add Student to Group -->
        <section class="mb-4">
            <h3>Add Student to Group</h3>
            <form action="add_student_to_group.php" method="post">
                <div class="form-group">
                    <label for="student_id">Select Student:</label>
                    <select class="form-control" id="student_id" name="student_id" required>
                        <?php
                        if (isset($students_result) && $students_result->num_rows > 0):
                            while ($student = $students_result->fetch_assoc()): ?>
                                <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['username']); ?></option>
                            <?php endwhile;
                        else: ?>
                            <option value="">No students available</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="group_id">Select Group:</label>
                    <select class="form-control" id="group_id" name="group_id" required>
                        <?php
                        if (isset($groups_result) && $groups_result->num_rows > 0):
                            while ($group = $groups_result->fetch_assoc()): ?>
                                <option value="<?php echo $group['id']; ?>"><?php echo htmlspecialchars($group['group_name']); ?></option>
                            <?php endwhile;
                        else: ?>
                            <option value="">No groups available</option>
                        <?php endif; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add to Group</button>
            </form>
        </section>

        <!-- Create Assignment -->
        <section class="mb-4">
            <h3>Create Assignment</h3>
            <form action="create_assignment.php" method="post">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="deadline">Deadline:</label>
                    <input type="date" class="form-control" id="deadline" name="deadline" required>
                </div>
                <div class="form-group">
                    <label for="materials">Materials:</label>
                    <textarea class="form-control" id="materials" name="materials" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="group_id">Assign to Group (Optional):</label>
                    <select class="form-control" id="group_id" name="group_id">
                        <option value="">None</option>
                        <?php
                        if (isset($groups_result) && $groups_result->num_rows > 0):
                            $groups_result->data_seek(0);
                            while ($group = $groups_result->fetch_assoc()): ?>
                                <option value="<?php echo $group['id']; ?>"><?php echo htmlspecialchars($group['group_name']); ?></option>
                            <?php endwhile;
                        endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="student_id">Assign to Student (Optional):</label>
                    <select class="form-control" id="student_id" name="student_id">
                        <option value="">None</option>
                        <?php
                        if (isset($students_result) && $students_result->num_rows > 0):
                            $students_result->data_seek(0);
                            while ($student = $students_result->fetch_assoc()): ?>
                                <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['username']); ?></option>
                            <?php endwhile;
                        endif; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Create Assignment</button>
            </form>
        </section>

        <!-- Assignments Created by Teacher -->
        <section class="mb-4">
            <h3>Assignments Created</h3>
            <ul class="list-group">
                <?php if (isset($assignments_result) && $assignments_result->num_rows > 0): ?>
                    <?php while ($assignment = $assignments_result->fetch_assoc()): ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($assignment['title']); ?>
                            <a href="grade_assignment.php?assignment_id=<?php echo $assignment['id']; ?>" class="btn btn-primary btn-sm float-right">Grade Submissions</a>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li class="list-group-item">No assignments created yet.</li>
                <?php endif; ?>
            </ul>
        </section>

        <!-- Submitted Assignments -->
        <section>
            <h3>Submitted Assignments</h3>
            <ul class="list-group">
                <?php if (isset($submissions_result) && $submissions_result->num_rows > 0): ?>
                    <?php while ($submission = $submissions_result->fetch_assoc()): ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($submission['title']); ?> submitted by <?php echo htmlspecialchars($submission['username']); ?>
                            <br>
                            Submission Date: <?php echo htmlspecialchars($submission['submission_date']); ?>
                            <a href="grade_submission.php?submission_id=<?php echo $submission['id']; ?>" class="btn btn-primary btn-sm float-right">Grade</a>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li class="list-group-item">No submissions found.</li>
                <?php endif; ?>
            </ul>
        </section>
    </div>

    
</body>
</html>
