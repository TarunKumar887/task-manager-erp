<?php
session_start();
require_once 'src/db.php';

if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }

// Fetch tasks with Project and Employee names using JOIN
$tasks_sql = "SELECT tasks.*, projects.project_name, employees.full_name 
              FROM tasks 
              JOIN projects ON tasks.project_id = projects.id 
              JOIN employees ON tasks.employee_id = employees.id";
$tasks_result = $conn->query($tasks_sql);

// Fetch projects and employees for the dropdowns
$projects = $conn->query("SELECT id, project_name FROM projects");
$employees = $conn->query("SELECT id, full_name FROM employees");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Assignment - Mini ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar { height: 100vh; width: 250px; position: fixed; background: #212529; color: white; padding-top: 20px; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 15px 25px; display: block; }
        .sidebar a:hover, .sidebar .active { color: white; background: #0d6efd; }
        .main-content { margin-left: 250px; padding: 30px; }
    </style>
</head>
<body>
<div class="sidebar">
    <h3 class="text-center">Mini ERP</h3>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="employees.php">👥 Employees</a>
    <a href="projects.php">📁 Projects</a>
    <a href="tasks.php" class="active">✅ Tasks</a>
    <hr>
    <a href="src/logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="main-content">
    <h2>Assign Tasks</h2>
    <div class="card p-4 shadow-sm mb-4">
        <form action="src/add_task.php" method="POST" class="row g-3">
            <div class="col-md-3">
                <label>Project</label>
                <select name="project_id" class="form-select" required>
                    <?php while($p = $projects->fetch_assoc()): ?>
                        <option value="<?= $p['id'] ?>"><?= $p['project_name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label>Employee</label>
                <select name="employee_id" class="form-select" required>
                    <?php while($e = $employees->fetch_assoc()): ?>
                        <option value="<?= $e['id'] ?>"><?= $e['full_name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label>Task Detail</label>
                <input type="text" name="task_description" class="form-control" placeholder="What needs to be done?" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Assign</button>
            </div>
        </form>
    </div>

    <table class="table table-bordered bg-white">
        <thead class="table-light">
            <tr>
                <th>Project</th>
                <th>Assigned To</th>
                <th>Task</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while($t = $tasks_result->fetch_assoc()): ?>
            <tr>
                <td><?= $t['project_name'] ?></td>
                <td><?= $t['full_name'] ?></td>
                <td><?= $t['task_description'] ?></td>
                <td><span class="badge bg-warning"><?= $t['status'] ?></span></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>