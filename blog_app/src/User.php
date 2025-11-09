<?php
// src/User.php

class User {
    private $pdo;

    // Constructor accepts the PDO connection
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Register a new user
    public function register($username, $email, $password) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword]);
            return true;
        } catch (PDOException $e) {
            return "Registration failed: " . $e->getMessage();
        }
    }

    // Log in existing user
    public function login($email, $password) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
