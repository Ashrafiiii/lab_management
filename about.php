<?php
// about.php
// Start the session if needed
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Laboratory Management System</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add your custom CSS here -->
    <style>
        body {
            background-color: #f4f7fa;
            font-family: Arial, sans-serif;
        }
        .about-section {
            padding: 60px 0;
        }
        .about-content {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #3545d6; /* Use one of your preferred colors */
        }
    </style>
</head>
<body>

<div class="container about-section">
    <div class="row">
        <div class="col-md-12">
            <div class="about-content">
                <h1>About Laboratory Management System</h1>
                <p>Welcome to the Laboratory Management System, an innovative platform designed to streamline and enhance the laboratory experience for educators and students alike. Our system provides a collaborative environment where teachers can create assignments, students can work in groups, and everyone can track progress seamlessly.</p>
                
                <h2>Our Mission</h2>
                <p>Our mission is to create an efficient and organized laboratory environment where learning and collaboration are at the forefront. We aim to bridge the gap between teachers and students by providing tools that enhance group work, facilitate timely submissions, and offer a structured approach to managing lab tasks.</p>
                
                <h2>Key Features</h2>
                <ul>
                    <li><strong>Role-Based Access:</strong> Separate dashboards for Admins, Teachers, and Students ensure that everyone gets tailored access and features relevant to their needs.</li>
                    <li><strong>Teacher Dashboard:</strong> Teachers can create assignments, set deadlines, and define task requirements, enabling a clear and structured approach to lab work.</li>
                    <li><strong>Student Collaboration:</strong> Students can form groups, submit assignments, and track their progress, fostering teamwork and accountability.</li>
                    <li><strong>Progress Tracking:</strong> Both teachers and students can monitor assignment status and performance through an intuitive tracking system.</li>
                    <li><strong>Grading System:</strong> A comprehensive grading system provides feedback on completed tasks, helping students improve their skills.</li>
                    <li><strong>Task Reminders:</strong> Never miss a deadline with automated reminders for upcoming tasks and submissions.</li>
                </ul>
                
                <h2>Why Choose Us?</h2>
                <p>The Laboratory Management System is designed to simplify the management of lab assignments and foster an engaging learning environment. By centralizing communication and resources, we minimize confusion and maximize productivity. Whether you're a teacher looking to manage assignments or a student striving to excel in your lab work, our platform is here to support your educational journey.</p>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
