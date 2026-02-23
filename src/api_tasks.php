<?php
header("Content-Type: application/json");
require_once 'db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$data = null;

if ($id) {
    $sql = "SELECT * FROM tasks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
} else {
    $sql = "SELECT * FROM tasks ORDER BY id DESC";
    $result = $conn->query($sql);
    $data = $result->fetch_all(MYSQLI_ASSOC);
}

if ($data !== null && (!is_array($data) || count($data) > 0)) {
    echo json_encode(["status" => "success", "data" => $data]);
} else {
    if ($id) { http_response_code(404); }
    echo json_encode(["status" => "error", "message" => "No records found"]);
}
?>