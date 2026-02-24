<?php
session_start();
require_once 'src/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search != '') {
    $sql = "SELECT employees.*, departments.name as dept_name 
            FROM employees 
            LEFT JOIN departments ON employees.dept_id = departments.id 
            WHERE employees.full_name LIKE ? OR employees.email LIKE ? 
            ORDER BY employees.id DESC";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%$search%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT employees.*, departments.name as dept_name 
                            FROM employees 
                            LEFT JOIN departments ON employees.dept_id = departments.id 
                            ORDER BY employees.id DESC");
}

$depts = $conn->query("SELECT * FROM departments");
$depts_list = $depts->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Employees - Mini ERP</title>
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
    </style>
</head>
<body>

<div class="sidebar">
    <h3 class="text-center mb-4">Mini ERP</h3>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="employees.php" class="active">👥 Employees</a>
    <a href="departments.php">🏢 Departments</a>
    <a href="projects.php">📁 Projects</a>
    <a href="tasks.php">✅ Tasks</a>
    <hr>
    <a href="src/logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Employee Directory</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">+ Add Employee</button>
    </div>

    <div class="card p-3 mb-4 shadow-sm">
        <form action="employees.php" method="GET" class="row g-2">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">Search</button>
            </div>
        </form>
    </div>

    <table class="table table-hover bg-white shadow-sm rounded">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Email</th>
                <th>Position</th>
                <th>Salary</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><strong><?= $row['full_name'] ?></strong></td>
                    <td><span class="badge bg-secondary"><?= $row['dept_name'] ?? 'Unassigned' ?></span></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['position'] ?></td>
                    <td>$<?= number_format($row['salary'], 2) ?></td>
                    <td>
                        <button class="btn btn-sm btn-outline-warning" 
                                onclick='editEmployee(<?= json_encode($row) ?>)'>Edit</button>
                        <a href="src/delete.php?type=employee&id=<?= $row['id'] ?>" 
                           class="btn btn-sm btn-outline-danger" 
                           onclick="return confirm('Delete this record?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center">No employees found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addEmployeeModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="src/add_employee.php" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register New Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Full Name</label><input type="text" name="full_name" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
                
                <div class="mb-3"><label class="form-label text-primary">Login Password</label><input type="password" name="password" class="form-control" placeholder="Create unique password" required></div>
                
                <div class="mb-3">
                    <label class="form-label">Department</label>
                    <select name="dept_id" class="form-select" required>
                        <option value="">Select Department</option>
                        <?php foreach($depts_list as $d): ?>
                            <option value="<?= $d['id'] ?>"><?= $d['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Position</label><input type="text" name="position" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Salary</label><input type="number" name="salary" class="form-control" required></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Employee</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editEmployeeModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="src/update_employee.php" method="POST" class="modal-content">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Full Name</label><input type="text" name="full_name" id="edit_name" class="form-control" required></div>
                
                <div class="mb-3">
                    <label class="form-label text-primary">New Password (Leave blank to keep current)</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter new password to reset">
                </div>

                <div class="mb-3">
                    <label class="form-label">Department</label>
                    <select name="dept_id" id="edit_dept" class="form-select" required>
                        <?php foreach($depts_list as $d): ?>
                            <option value="<?= $d['id'] ?>"><?= $d['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Position</label><input type="text" name="position" id="edit_position" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Salary</label><input type="number" name="salary" id="edit_salary" class="form-control" required></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning">Update Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function editEmployee(data) {
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_name').value = data.full_name;
    document.getElementById('edit_dept').value = data.dept_id;
    document.getElementById('edit_position').value = data.position;
    document.getElementById('edit_salary').value = data.salary;
    var myModal = new bootstrap.Modal(document.getElementById('editEmployeeModal'));
    myModal.show();
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>