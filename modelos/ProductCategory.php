<?php
require_once "../config/connection.php";

class ProductCategoryModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "practice");
    }

    public function getAll() {
        $query = "SELECT * FROM product_category";
        $result = $this->conn->query($query);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create(array $data) {
        $query = "INSERT INTO product_category (product_id, category_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $data["product_id"], $data["category_id"]);

        return $stmt->execute();
    }

    public function update(array $data) {
        $query = "UPDATE product_category 
                  SET category_id = ? 
                  WHERE product_id = ? AND category_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $data["new_category_id"], $data["product_id"], $data["category_id"]);

        return $stmt->execute();
    }

    public function delete(array $data) {
        $query = "DELETE FROM product_category WHERE product_id = ? AND category_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $data["product_id"], $data["category_id"]);

        return $stmt->execute();
    }
}
