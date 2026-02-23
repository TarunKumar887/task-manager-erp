<?php
session_start();
require_once 'src/db.php';

if (!isset($_SESSION['user_id'])) { 
    header("Location: index.php"); 
    exit(); 
}

$user_role = $_SESSION['role'] ?? 'user';
$username = $_SESSION['username'];
$search = $_GET['search'] ?? '';

$tasks_sql = "SELECT tasks.*, projects.project_name, employees.full_name 
              FROM tasks 
              LEFT JOIN projects ON tasks.project_id = projects.id 
              LEFT JOIN employees ON tasks.employee_id = employees.id";

if ($user_role !== 'admin') {
    $tasks_sql .= " WHERE employees.full_name = '$username'";
} elseif (!empty($search)) {
    $tasks_sql .= " WHERE projects.project_name LIKE '%$search%' OR tasks.task_description LIKE '%$search%'";
}

$tasks_sql .= " ORDER BY tasks.id DESC";
$tasks_result = $conn->query($tasks_sql);

$projects = ($user_role === 'admin') ? $conn->query("SELECT id, project_name FROM projects") : null;
$employees = ($user_role === 'admin') ? $conn->query("SELECT id, full_name FROM employees") : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasks - Mini ERP</title>
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
        <a href="departments.php">🏢 Departments</a>
    <?php endif; ?>
    
    <a href="projects.php">📁 Projects</a>
    <a href="tasks.php" class="active">✅ Tasks</a>
    <hr class="mx-3">
    <a href="src/logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><?php echo ($user_role === 'admin') ? 'Task Management' : 'My Tasks'; ?></h2>
    </div>

    <?php if($user_role === 'admin'): ?>
    <div class="card p-4 shadow-sm mb-4 border-0">
        <h5 class="mb-3 text-primary">Assign New Task</h5>
        <form action="src/add_task.php" method="POST" class="row g-3">
            <div class="col-md-3">
                <select name="project_id" class="form-select" required>
                    <option value="" selected disabled>Select Project</option>
                    <?php while($p = $projects->fetch_assoc()): ?>
                        <option value="<?= $p['id'] ?>"><?= $p['project_name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="employee_id" class="form-select" required>
                    <option value="" selected disabled>Assign To Employee</option>
                    <?php while($e = $employees->fetch_assoc()): ?>
                        <option value="<?= $e['id'] ?>"><?= $e['full_name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="task_description" class="form-control" placeholder="Task Details..." required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Assign</button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-hover bg-white shadow-sm rounded">
            <thead class="table-dark">
                <tr>
                    <th>Project</th>
                    <th>Employee</th>
                    <th>Task Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($tasks_result && $tasks_result->num_rows > 0): ?>
                    <?php while($t = $tasks_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $t['project_name'] ?? '<span class="text-muted">No Project</span>' ?></td>
                        <td><?= $t['full_name'] ?? '<span class="text-danger">Unassigned</span>' ?></td>
                        <td><?= htmlspecialchars($t['task_description']) ?></td>
                        <td>
                            <span class="badge <?= ($t['status'] == 'Pending') ? 'bg-warning text-dark' : 'bg-success' ?>">
                                <?= $t['status'] ?>
                            </span>
                        </td>
                        <td>
                            <?php if($t['status'] == 'Pending'): ?>
                                <a href="src/complete_task.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-success">Done</a>
                            <?php else: ?>
                                <span class="text-muted small">Completed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center py-4 text-muted">No tasks assigned yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>