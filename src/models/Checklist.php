<?php
// src/models/Checklist.php

class Checklist {
    private $pdo;
    private $table = 'checklists';

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Yeni kontrol listesi oluştur
     */
    public function create($user_id, $data) {
        $sql = "INSERT INTO {$this->table} 
                (user_id, project_name, brand, checks, notes, quality_rating, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, 'draft', NOW())";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $user_id,
            $data['project_name'] ?? '',
            $data['brand'] ?? '',
            json_encode($data['checks'] ?? []),
            $data['notes'] ?? '',
            $data['quality_rating'] ?? 100
        ]);
    }

    /**
     * Kontrol listesi getir
     */
    public function getById($id, $user_id = null) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        if ($user_id) {
            $sql .= " AND user_id = ?";
        }

        $stmt = $this->pdo->prepare($sql);
        $params = $user_id ? [$id, $user_id] : [$id];
        $stmt->execute($params);
        $result = $stmt->fetch();

        if ($result && isset($result['checks'])) {
            $result['checks'] = json_decode($result['checks'], true);
        }

        return $result;
    }

    /**
     * Tüm kontrol listeleri
     */
    public function getAll($user_id = null, $limit = 15, $offset = 0) {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];

        if ($user_id) {
            $sql .= " WHERE user_id = ?";
            $params[] = $user_id;
        }

        $sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $results = $stmt->fetchAll();

        foreach ($results as &$result) {
            if (isset($result['checks'])) {
                $result['checks'] = json_decode($result['checks'], true);
            }
        }

        return $results;
    }

    /**
     * Kontrol listesi güncelle
     */
    public function update($id, $user_id, $data) {
        $sql = "UPDATE {$this->table} 
                SET project_name = ?, 
                    brand = ?, 
                    checks = ?, 
                    notes = ?, 
                    quality_rating = ?,
                    status = ?,
                    updated_at = NOW()
                WHERE id = ? AND user_id = ?";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['project_name'] ?? '',
            $data['brand'] ?? '',
            json_encode($data['checks'] ?? []),
            $data['notes'] ?? '',
            $data['quality_rating'] ?? 100,
            $data['status'] ?? 'draft',
            $id,
            $user_id
        ]);
    }

    /**
     * Kontrol listesi sil
     */
    public function delete($id, $user_id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ? AND user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id, $user_id]);
    }

    /**
     * Tarih aralığında kontrol listeleri
     */
    public function getByDateRange($user_id, $from_date, $to_date) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE user_id = ? 
                AND DATE(created_at) BETWEEN ? AND ?
                ORDER BY created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $from_date, $to_date]);
        return $stmt->fetchAll();
    }

    /**
     * Marka bazlı kontrol listeleri
     */
    public function getByBrand($brand, $user_id = null) {
        $sql = "SELECT * FROM {$this->table} WHERE brand = ?";
        $params = [$brand];

        if ($user_id) {
            $sql .= " AND user_id = ?";
            $params[] = $user_id;
        }

        $sql .= " ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * İstatistik getir
     */
    public function getStatistics($user_id) {
        $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                AVG(quality_rating) as avg_quality,
                SUM(CASE WHEN DATE(created_at) = CURDATE() THEN 1 ELSE 0 END) as today_count
                FROM {$this->table}
                WHERE user_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }
}
