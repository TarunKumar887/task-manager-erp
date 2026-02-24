<?php
header("Content-Type: application/json"); 
require_once '../src/db.php';


session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        
        $sql = "SELECT * FROM tasks ORDER BY id DESC";
        $result = $conn->query($sql);
        $tasks = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($tasks);
        break;

    case 'POST':
       
        $data = json_decode(file_get_contents("php://input"), true);
        if(!empty($data['task_description'])) {
            $stmt = $conn->prepare("INSERT INTO tasks (project_id, employee_id, task_description, status) VALUES (?, ?, ?, 'Pending')");
            $stmt->bind_param("iis", $data['project_id'], $data['employee_id'], $data['task_description']);
            $stmt->execute();
            echo json_encode(["status" => "success", "id" => $conn->insert_id]);
        }
        break;

    case 'PUT':
        
        $data = json_decode(file_get_contents("php://input"), true);
        if(!empty($data['id'])) {
            $stmt = $conn->prepare("UPDATE tasks SET task_description=?, status=? WHERE id=?");
            $stmt->bind_param("ssi", $data['task_description'], $data['status'], $data['id']);
            $stmt->execute();
            echo json_encode(["status" => "updated"]);
        }
        break;

    case 'DELETE':
       
        $data = json_decode(file_get_contents("php://input"), true);
        if(!empty($data['id'])) {
            $stmt = $conn->prepare("DELETE FROM tasks WHERE id=?");
            $stmt->bind_param("i", $data['id']);
            $stmt->execute();
            echo json_encode(["status" => "deleted"]);
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;
}