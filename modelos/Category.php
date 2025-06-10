<?php
require_once "../config/connection.php";

class CategoryModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "practice");
    }

    public function getAll() {
        $query = "SELECT * FROM categories";
        $result = $this->conn->query($query);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create(array $data) {
        $query = "INSERT INTO categories (category_name) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $data["category_name"]);

        return $stmt->execute();
    }

    public function update(array $data) {
        $query = "UPDATE categories 
                  SET category_name = ? 
                  WHERE category_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $data["category_name"], $data["category_id"]);

        return $stmt->execute();
    }

    public function delete(int $id) {
        $query = "DELETE FROM categories WHERE category_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
