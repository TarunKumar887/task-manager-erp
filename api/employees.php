<?php
header("Content-Type: application/json");
require_once '../src/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["error" => "Admin access required"]);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $result = $conn->query("SELECT id, full_name, email, role, created_at FROM employees");
        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $conn->prepare("INSERT INTO employees (full_name, email, password, role) VALUES (?, ?, ?, ?)");
        $hashed_pass = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->bind_param("ssss", $data['full_name'], $data['email'], $hashed_pass, $data['role']);
        $stmt->execute();
        echo json_encode(["status" => "Employee created", "id" => $conn->insert_id]);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
        $stmt->bind_param("i", $data['id']);
        $stmt->execute();
        echo json_encode(["status" => "Employee deleted"]);
        break;
}