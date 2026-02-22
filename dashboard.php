<?php
session_start();

// Security check: If not logged in, kick back to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'src/db.php';
// Count total employees
$emp_count_query = "SELECT COUNT(*) as total FROM employees";
$emp_count_result = $conn->query($emp_count_query);
$emp_count = $emp_count_result->fetch_assoc()['total'];

// Count total projects
$proj_count_query = "SELECT COUNT(*) as total FROM projects";
$proj_count_result = $conn->query($proj_count_query);
$proj_count = $proj_count_result->fetch_assoc()['total'];

// Count pending tasks
$task_count_query = "SELECT COUNT(*) as total FROM tasks WHERE status = 'Pending'";
$task_count_result = $conn->query($task_count_query);
$task_count = $task_count_result->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mini ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { height: 100vh; width: 250px; position: fixed; background: #212529; padding-top: 20px; color: white; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 15px 25px; display: block; transition: 0.3s; }
        .sidebar a:hover { color: white; background: #343a40; }
        .sidebar .active { color: white; background: #0d6efd; }
        .main-content { margin-left: 250px; padding: 30px; }
        .card-stats { border: none; border-radius: 10px; transition: 0.3s; }
        .card-stats:hover { transform: translateY(-5px); }
    </style>
</head>
<body>

<div class="sidebar shadow">
    <h3 class="text-center mb-4">Mini ERP</h3>
    <a href="dashboard.php" class="active">🏠 Dashboard</a>
    <a href="employees.php">👥 Employees</a>
    <a href="projects.php">📁 Projects</a>
    <a href="tasks.php">✅ Tasks</a>
    <hr>
    <a href="src/logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="main-content">
    <nav class="navbar navbar-light bg-white mb-4 shadow-sm rounded">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Admin Dashboard</span>
            <span class="navbar-text">
                Welcome back, <strong><?php echo $_SESSION['username']; ?></strong>!
            </span>
        </div>
    </nav>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-stats bg-primary text-white shadow">
                <div class="card-body">
                    <h5>Total Employees</h5>
                    <h2 class="display-4"><?php echo $emp_count; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stats bg-success text-white shadow">
                <div class="card-body">
                    <h5>Active Projects</h5>
                    <h2 class="display-4"><?php echo $proj_count; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stats bg-warning text-white shadow">
                <div class="card-body">
                    <h5>Pending Tasks</h5>
                    <h2 class="display-4"><?php echo $task_count; ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>