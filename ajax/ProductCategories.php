<?php
require_once "../modelos/ProductCategory.php";

header("Content-Type: application/json");

$user = new ProductCategoryModel();
$method = $_SERVER["REQUEST_METHOD"];

switch($method){
    case 'GET':
        echo json_encode($user->getall());
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $user->create($data)]);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $user->update($data)]);
        break;
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $data);
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $user->delete($data)]);
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
}

?>