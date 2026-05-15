<?php
// src/models/User.php

class User {
    private $pdo;
    private $table = 'users';

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Yeni kullanıcı oluştur
     */
    public function create($data) {
        $sql = "INSERT INTO {$this->table} 
                (name, email, password, phone, role, status, created_at) 
                VALUES (?, ?, ?, ?, ?, 'active', NOW())";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'] ?? '',
            $data['email'] ?? '',
            password_hash($data['password'] ?? '', PASSWORD_BCRYPT),
            $data['phone'] ?? null,
            $data['role'] ?? 'user'
        ]);
    }

    /**
     * Kullanıcı getir
     */
    public function getById($id) {
        $sql = "SELECT id, name, email, phone, role, status, created_at FROM {$this->table} WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Email ile kullanıcı ara
     */
    public function getByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? AND status = 'active'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Şifre doğrula
     */
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    /**
     * Kullanıcı güncelle
     */
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} 
                SET name = ?, email = ?, phone = ?, role = ?, updated_at = NOW()
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'] ?? '',
            $data['email'] ?? '',
            $data['phone'] ?? null,
            $data['role'] ?? 'user',
            $id
        ]);
    }

    /**
     * Şifre güncelle
     */
    public function updatePassword($id, $new_password) {
        $sql = "UPDATE {$this->table} 
                SET password = ?, updated_at = NOW()
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            password_hash($new_password, PASSWORD_BCRYPT),
            $id
        ]);
    }

    /**
     * Tüm aktif kullanıcılar
     */
    public function getAll($limit = 50) {
        $sql = "SELECT id, name, email, phone, role, status, created_at FROM {$this->table} 
                WHERE status = 'active' ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}
