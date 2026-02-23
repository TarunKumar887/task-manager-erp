<?php
session_start();
require_once 'src/db.php';

if (!isset($_SESSION['user_id'])) { 
    header("Location: index.php"); 
    exit(); 
}

$user_role = $_SESSION['role'] ?? 'user';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $user_role === 'admin') {
    $name = $_POST['dept_name'];
    $stmt = $conn->prepare("INSERT INTO departments (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
}

$depts = $conn->query("SELECT * FROM departments ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Departments - Mini ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { height: 100vh; width: 250px; position: fixed; background: #212529; color: white; padding-top: 20px; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 15px 25px; display: block; transition: 0.3s; border-radius: 5px; margin: 0 10px; }
        .sidebar a:hover { color: white; background: #343a40; }
        .sidebar .active { color: white; background: #0d6efd; }
        .main-content { margin-left: 250px; padding: 30px; }
    </style>
</head>
<body>

<div class="sidebar shadow">
    <h3 class="text-center mb-4">Mini ERP</h3>
    <a href="dashboard.php">🏠 Dashboard</a>
    
    <?php if($user_role === 'admin'): ?>
        <a href="employees.php">👥 Employees</a>
        <a href="departments.php" class="active">🏢 Departments</a>
    <?php endif; ?>
    
    <a href="projects.php">📁 Projects</a>
    <a href="tasks.php">✅ Tasks</a>
    <hr class="mx-3">
    <a href="src/logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Department Directory</h2>
    </div>

    <?php if($user_role === 'admin'): ?>
    <div class="card p-4 shadow-sm mb-4 border-0">
        <h5 class="mb-3 text-primary">Add New Department</h5>
        <form method="POST" class="row g-3">
            <div class="col-md-8">
                <input type="text" name="dept_name" class="form-control" placeholder="Enter department name..." required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Add Department</button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-hover bg-white shadow-sm rounded">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Department Name</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php if($depts->num_rows > 0): ?>
                    <?php while($d = $depts->fetch_assoc()): ?>
                    <tr>
                        <td><?= $d['id'] ?></td>
                        <td><strong><?= htmlspecialchars($d['name']) ?></strong></td>
                        <td><?= date('M d, Y', strtotime($d['created_at'])) ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="3" class="text-center py-4 text-muted">No departments found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>