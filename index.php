<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Lab Management System</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Lab Management System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="teacher_login.php">Teacher Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="student_login.php">Student Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Welcome to the Lab Management System</h1>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">For Teachers</h5>
                        <p class="card-text">Manage assignments, create groups, and grade student submissions.</p>
                        <a href="teacher_login.php" class="btn btn-primary">Teacher Login</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">For Students</h5>
                        <p class="card-text">View assignments, submit work, and check your grades.</p>
                        <a href="student_login.php" class="btn btn-primary">Student Login</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h3 class="text-center">About Us</h3>
            <p class="text-center">This system helps manage lab assignments and student submissions efficiently. For more details, please visit our <a href="about.php">About</a> page.</p>
        </div>
    </div>

    <footer class="text-center mt-5 py-4">
        <p>&copy; 2024 Lab Management System. All Rights Reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
