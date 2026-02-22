<?php
session_start();
require_once 'src/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$result = $conn->query("SELECT * FROM projects ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Projects - Mini ERP</title>
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
    <a href="projects.php" class="active">📁 Projects</a>
    <hr>
    <a href="src/logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Project Management</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProjectModal">+ Create Project</button>
    </div>

    <table class="table table-hover bg-white shadow-sm rounded">
        <thead class="table-dark">
            <tr>
                <th>Project Name</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><strong><?= $row['project_name'] ?></strong></td>
                <td><?= $row['deadline'] ?></td>
                <td><span class="badge bg-info text-dark"><?= $row['status'] ?></span></td>
                <td>
                    <a href="src/delete_project.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this project?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addProjectModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="src/add_project.php" method="POST" class="modal-content">
            <div class="modal-header"><h5>Add New Project</h5></div>
            <div class="modal-body">
                <div class="mb-3"><label>Project Name</label><input type="text" name="project_name" class="form-control" required></div>
                <div class="mb-3"><label>Description</label><textarea name="description" class="form-control"></textarea></div>
                <div class="mb-3"><label>Deadline</label><input type="date" name="deadline" class="form-control" required></div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-success">Save Project</button></div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>