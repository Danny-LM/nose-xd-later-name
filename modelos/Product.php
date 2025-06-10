<?php
require_once "../config/connection.php";

class ProductModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "practice");
    }

    public function getAll() {
        $query = "SELECT * FROM products";
        $result = $this->conn->query($query);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create(array $data) {
        $query = "INSERT INTO products (product_name, description, price, stock, seller_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssdii", $data["product_name"], $data["description"], $data["price"], $data["stock"], $data["seller_id"]);
        
        return $stmt->execute();
    }

    public function update(array $data) {
        $query = "UPDATE products 
                  SET product_name = ?, description = ?, price = ?, stock = ?, seller_id = ? 
                  WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssdiis", $data["product_name"], $data["description"], $data["price"], $data["stock"], $data["seller_id"], $data["product_id"]);
        
        return $stmt->execute();
    }

    public function delete(int $id) {
        $query = "DELETE FROM products WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
}
