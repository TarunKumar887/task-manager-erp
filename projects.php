<?php
session_start();
require_once 'src/db.php';

if (!isset($_SESSION['user_id'])) { 
    header("Location: index.php"); 
    exit(); 
}

$user_role = $_SESSION['role'] ?? 'user';
$result = $conn->query("SELECT * FROM projects ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Projects - Mini ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { height: 100vh; width: 250px; position: fixed; background: #212529; padding-top: 20px; color: white; }
        .sidebar h3 { font-weight: 800; text-transform: uppercase; padding: 0 20px; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 15px 25px; display: block; transition: 0.3s; border-radius: 5px; margin: 0 10px; font-weight: 700; }
        .sidebar a:hover { color: white; background: #343a40; }
        .sidebar .active { color: white; background: #0d6efd; font-weight: 800; }
        .sidebar a.text-danger { font-weight: 900; margin-top: 20px; }
        .main-content { margin-left: 250px; padding: 30px; }
        .card-stats { border: none; border-radius: 10px; transition: 0.3s; height: 100%; }
        .card-stats:hover { transform: translateY(-5px); }
    </style>
</head>
<body>

<div class="sidebar shadow">
    <h3 class="text-center mb-4">Mini ERP</h3>
    <a href="dashboard.php">🏠 Dashboard</a>
    
    <?php if($user_role === 'admin'): ?>
        <a href="employees.php">👥 Employees</a>
        <a href="departments.php">🏢 Departments</a>
    <?php endif; ?>
    
    <a href="projects.php" class="active">📁 Projects</a>
    <a href="tasks.php">✅ Tasks</a>
    <hr class="mx-3">
    <a href="src/logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="main-content">
    <nav class="navbar navbar-light bg-white mb-4 shadow-sm rounded p-3">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Project Directory</span>
            <?php if($user_role === 'admin'): ?>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">+ Create Project</button>
            <?php endif; ?>
        </div>
    </nav>

    <div class="table-responsive">
        <table class="table table-hover bg-white shadow-sm rounded">
            <thead class="table-dark">
                <tr>
                    <th>Project Name</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <?php if($user_role === 'admin'): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($row['project_name']) ?></strong></td>
                        <td><?= date('M d, Y', strtotime($row['deadline'])) ?></td>
                        <td><span class="badge bg-success">Active</span></td>
                        <?php if($user_role === 'admin'): ?>
                        <td>
                            <a href="src/delete_project.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center py-4 text-muted">No projects found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if($user_role === 'admin'): ?>
<div class="modal fade" id="addProjectModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="src/add_project.php" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Project Assignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Project Name</label>
                    <input type="text" name="project_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deadline Date</label>
                    <input type="date" name="deadline" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary w-100">Launch Project</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>