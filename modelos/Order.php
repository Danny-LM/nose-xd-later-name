<?php
require_once "../config/connection.php";

class OrderModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "practice");
    }

    public function getAll() {
        $query = "SELECT * FROM orders";
        $result = $this->conn->query($query);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create(array $data) {
        $query = "INSERT INTO orders (user_id, total, status) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ids", $data["user_id"], $data["total"], $data["status"]);

        return $stmt->execute();
    }

    public function update(array $data) {
        $query = "UPDATE orders 
                  SET user_id = ?, total = ?, status = ? 
                  WHERE order_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("idsi", $data["user_id"], $data["total"], $data["status"], $data["order_id"]);

        return $stmt->execute();
    }

    public function delete(int $id) {
        $query = "DELETE FROM orders WHERE order_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
