<?php
require_once "../config/connection.php";

class OrderDetailsModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "practice");
    }

    public function getAll() {
        $query = "SELECT * FROM order_details";
        $result = $this->conn->query($query);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create(array $data) {
        $query = "INSERT INTO order_details (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiid", $data["order_id"], $data["product_id"], $data["quantity"], $data["unit_price"]);

        return $stmt->execute();
    }

    public function update(array $data) {
        $query = "UPDATE order_details 
                  SET order_id = ?, product_id = ?, quantity = ?, unit_price = ? 
                  WHERE detail_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiidi", $data["order_id"], $data["product_id"], $data["quantity"], $data["unit_price"], $data["detail_id"]);
        
        return $stmt->execute();
    }

    public function delete(int $id) {
        $query = "DELETE FROM order_details WHERE detail_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
