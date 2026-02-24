<?php
header("Content-Type: application/json");
require_once '../src/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit(json_encode(["error" => "Unauthorized"]));
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $result = $conn->query("SELECT * FROM projects");
        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        break;

    case 'POST':
        if ($_SESSION['role'] !== 'admin') exit(json_encode(["error" => "Forbidden"]));
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $conn->prepare("INSERT INTO projects (project_name, description, client_name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data['project_name'], $data['description'], $data['client_name']);
        $stmt->execute();
        echo json_encode(["status" => "Project created"]);
        break;
}