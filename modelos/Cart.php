<?php
require_once "../config/connection.php";

class CartModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "practice");
    }

    public function getAll() {
        $query = "SELECT * FROM cart";
        $result = $this->conn->query($query);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create(array $data) {
        $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $data["user_id"], $data["product_id"], $data["quantity"]);

        return $stmt->execute();
    }

    public function update(array $data) {
        $query = "UPDATE cart 
                  SET user_id = ?, product_id = ?, quantity = ? 
                  WHERE cart_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiii", $data["user_id"], $data["product_id"], $data["quantity"], $data["cart_id"]);

        return $stmt->execute();
    }

    public function delete(int $id) {
        $query = "DELETE FROM cart WHERE cart_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
