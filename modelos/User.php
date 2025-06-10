<?php
require_once "../config/connection.php";

Class UserModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "practice");
    }

    public function getAll() {
        $query = "SELECT * FROM users";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create(array $data) {
        $query = "INSERT INTO users (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $data["name"], $data["email"], $data["password"], $data["phone"], $data["address"]);
        return $stmt->execute();
    }

    public function update(array $data) {
        $query = "UPDATE users 
                  SET name = ?, email = ?, password = ?, phone = ?, address = ? 
                  WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssi", $data["name"], $data["email"], $data["password"], $data["phone"], $data["address"], $data["user_id"]);

        return $stmt->execute();
    }

    public function delete(int $id) {
        $query = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
