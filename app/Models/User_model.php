<?php
class User_model {
    private $db;
    public function __construct() { $this->db = new Database(); }

    public function getUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind('email', $email);
        return $this->db->single();
    }

    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function updatePassword($email, $newPassword) {
        $this->db->query('UPDATE users SET password = :password WHERE email = :email');
        $this->db->bind('password', password_hash($newPassword, PASSWORD_DEFAULT));
        $this->db->bind('email', $email);
        return $this->db->execute();
    }

    public function registerUser($data) {
        $this->db->query('INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, "user")');
        $this->db->bind('name', $data['name']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->execute();
        return $this->db->lastInsertId();
    }

    public function getAdmins() {
        $this->db->query('SELECT id, name, email, created_at FROM users WHERE role = "admin" ORDER BY created_at ASC');
        return $this->db->resultSet();
    }

    public function createAdmin($data) {
        $this->db->query('INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, "admin")');
        $this->db->bind('name', $data['name']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
        return $this->db->execute();
    }

    public function deleteUser($id) {
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    public function saveResetToken($email, $token, $expires) {
        $this->db->query('UPDATE users SET reset_token = :token, reset_token_expires = :expires WHERE email = :email');
        $this->db->bind('token', $token);
        $this->db->bind('expires', $expires);
        $this->db->bind('email', $email);
        return $this->db->execute();
    }

    public function verifyResetToken($email, $token) {
        $this->db->query('SELECT * FROM users WHERE email = :email AND reset_token = :token AND reset_token_expires >= NOW()');
        $this->db->bind('email', $email);
        $this->db->bind('token', $token);
        return $this->db->single();
    }

    public function clearResetToken($email) {
        $this->db->query('UPDATE users SET reset_token = NULL, reset_token_expires = NULL WHERE email = :email');
        $this->db->bind('email', $email);
        return $this->db->execute();
    }
}
