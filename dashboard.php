<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'src/db.php';

$user_role = $_SESSION['role'] ?? 'user';

$emp_count = 0;
if($user_role == 'admin') {
    $emp_count_result = $conn->query("SELECT COUNT(*) as total FROM employees");
    $emp_count = $emp_count_result->fetch_assoc()['total'];
}

$proj_count_result = $conn->query("SELECT COUNT(*) as total FROM projects");
$proj_count = $proj_count_result->fetch_assoc()['total'];

$dept_count_result = $conn->query("SELECT COUNT(*) as total FROM departments");
$dept_count = $dept_count_result->fetch_assoc()['total'];

if($user_role == 'admin') {
    $task_count_query = "SELECT COUNT(*) as total FROM tasks WHERE status = 'Pending'";
} else {
    $user_id = $_SESSION['user_id'];
    $task_count_query = "SELECT COUNT(*) as total FROM tasks WHERE status = 'Pending' AND employee_id = (SELECT id FROM employees WHERE full_name = '{$_SESSION['username']}' LIMIT 1)";
}
$task_count_result = $conn->query($task_count_query);
$task_count = ($task_count_result) ? $task_count_result->fetch_assoc()['total'] : 0;
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
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 15px 25px; display: block; transition: 0.3s; border-radius: 5px; margin: 0 10px; }
        .sidebar a:hover { color: white; background: #343a40; }
        .sidebar .active { color: white; background: #0d6efd; }
        .main-content { margin-left: 250px; padding: 30px; }
        .card-stats { border: none; border-radius: 10px; transition: 0.3s; height: 100%; }
        .card-stats:hover { transform: translateY(-5px); }
    </style>
</head>
<body>

<div class="sidebar shadow">
    <h3 class="text-center mb-4">Mini ERP</h3>
    <a href="dashboard.php" class="active">🏠 Dashboard</a>
    
    <?php if($user_role == 'admin'): ?>
        <a href="employees.php">👥 Employees</a>
        <a href="departments.php">🏢 Departments</a>
    <?php endif; ?>
    
    <a href="projects.php">📁 Projects</a>
    <a href="tasks.php">✅ Tasks</a>
    <hr class="mx-3">
    <a href="src/logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="main-content">
    <nav class="navbar navbar-light bg-white mb-4 shadow-sm rounded p-3">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">
                <?php echo ($user_role == 'admin') ? 'Admin Dashboard' : 'Employee Portal'; ?>
            </span>
            <span class="navbar-text">
                Welcome, <span class="badge bg-info text-dark"><?php echo ucfirst($user_role); ?></span> 
                <strong><?php echo $_SESSION['username']; ?></strong>!
            </span>
        </div>
    </nav>

    <div class="row g-4">
        <?php if($user_role == 'admin'): ?>
        <div class="col-md-3">
            <div class="card card-stats bg-primary text-white shadow">
                <div class="card-body text-center">
                    <h6>Total Employees</h6>
                    <h2 class="display-6"><?php echo $emp_count; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats bg-dark text-white shadow">
                <div class="card-body text-center">
                    <h6>Departments</h6>
                    <h2 class="display-6"><?php echo $dept_count; ?></h2>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="col-md-3">
            <div class="card card-stats bg-success text-white shadow">
                <div class="card-body text-center">
                    <h6>Active Projects</h6>
                    <h2 class="display-6"><?php echo $proj_count; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stats bg-warning text-dark shadow">
                <div class="card-body text-center">
                    <h6>Pending Tasks</h6>
                    <h2 class="display-6"><?php echo $task_count; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 p-4 bg-white rounded shadow-sm border">
        <h4>System Overview</h4>
        <p class="text-muted">You are currently logged in as <strong><?php echo $user_role; ?></strong>. 
        <?php if($user_role == 'admin'): ?>
            You have full access to manage employees, departments, and project assignments.
        <?php else: ?>
            You can view and update the status of tasks assigned specifically to you.
        <?php endif; ?>
        </p>
    </div>
</div>

</body>
</html>