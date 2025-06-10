<?php
require_once 'connection.php';
header('Content-Type: application/json');

$logFile = 'login.log';

if (!file_exists($logFile)) {
    if (!is_writable(__DIR__)) {
        echo json_encode([
            "success" => false,
            "message" => "No permission to create the log file in the root directory."
        ]);
        exit;
    }
}

function saveLog($user, $status) {
    global $logFile;
    $date = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'N/A';
    $browser = $_SERVER['HTTP_USER_AGENT'] ?? 'N/A';
    $entry = "[$date] IP: $ip - User: $user - Result: $status - Browser: $browser\n";
    file_put_contents($logFile, $entry, FILE_APPEND);
}

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $input) {
    $name = $connection->real_escape_string($input['name'] ?? '');
    $pass = $connection->real_escape_string($input['pass'] ?? '');

    $sql = "SELECT * FROM users WHERE name = '$name' AND password = '$pass'";
    $result = $connection->query($sql);

    if ($result && $result->num_rows === 1) {
        saveLog($name, "Success");
        echo json_encode([
            "success" => true,
            "message" => "Welcome, $name."
        ]);
    } else {
        saveLog($name, "Failure");
        echo json_encode([
            "success" => false,
            "message" => "Incorrect username or password."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request or incomplete data."
    ]);
}
?>
