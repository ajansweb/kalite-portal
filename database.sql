-- Kalite Standartları Portalı Veritabanı Şeması

CREATE DATABASE IF NOT EXISTS kalite_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE kalite_portal;

-- Kullanıcılar Tablosu
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    phone VARCHAR(20),
    role ENUM('admin', 'user', 'supervisor') DEFAULT 'user',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Kontrol Listeleri Tablosu
CREATE TABLE checklists (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    project_name VARCHAR(255) NOT NULL,
    brand VARCHAR(100),
    checks JSON,
    notes LONGTEXT,
    quality_rating INT DEFAULT 100,
    status ENUM('draft', 'completed', 'archived') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    FULLTEXT INDEX ft_project (project_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Etiketler Tablosu
CREATE TABLE labels (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    brand VARCHAR(100) NOT NULL,
    circuit_number VARCHAR(50) NOT NULL,
    description VARCHAR(255),
    voltage INT DEFAULT 380,
    current INT,
    color VARCHAR(50) DEFAULT 'red',
    file_path VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_brand (brand),
    INDEX idx_circuit (circuit_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Raporlar Tablosu
CREATE TABLE reports (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    project_name VARCHAR(255) NOT NULL,
    customer_name VARCHAR(255),
    brand VARCHAR(100),
    description LONGTEXT,
    photos JSON,
    quality_rating INT DEFAULT 100,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_created (created_at),
    FULLTEXT INDEX ft_project (project_name),
    FULLTEXT INDEX ft_customer (customer_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Fotoğraflar Tablosu
CREATE TABLE photos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    report_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size INT,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (report_id) REFERENCES reports(id) ON DELETE CASCADE,
    INDEX idx_report_id (report_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Audit Log Tablosu
CREATE TABLE audit_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(100),
    entity_type VARCHAR(50),
    entity_id INT,
    old_value JSON,
    new_value JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_created (created_at),
    INDEX idx_action (action)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Demo Kullanıcı Ekleme
INSERT INTO users (name, email, password, phone, role, status) VALUES
('Admin Kullanıcı', 'admin@kalite-portal.local', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/TVm', '+90 555 0001', 'admin', 'active'),
('Usta Ali', 'ali@kalite-portal.local', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/TVm', '+90 555 0002', 'user', 'active'),
('Usta Mehmet', 'mehmet@kalite-portal.local', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/TVm', '+90 555 0003', 'user', 'active'),
('Denetçi Ayşe', 'ayse@kalite-portal.local', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/TVm', '+90 555 0004', 'supervisor', 'active');

-- Demo Kontrol Listesi
INSERT INTO checklists (user_id, project_name, brand, checks, notes, quality_rating, status) VALUES
(2, 'Ticari Bina - Panel A', 'ABB', 
 '["safety","connections","wiring","labeling","documentation","testing"]',
'Tüm kontroller başarıyla tamamlandı. Sistem tam kapasitede çalışıyor.',
100, 'completed'),
(3, 'Fabrika - Panel B', 'Siemens',
 '["safety","connections","wiring","labeling"]',
'Test aşamasında. Dokümantasyon henüz tamamlanmadı.',
85, 'draft');

-- Demo Etiketler
INSERT INTO labels (user_id, brand, circuit_number, description, voltage, current, color) VALUES
(2, 'ABB', 'F1', 'Aydınlatma Devresi', 380, 10, 'red'),
(2, 'ABB', 'Q1', 'Ana Kesici', 380, 32, 'yellow'),
(2, 'ABB', 'K1', 'Havalandırma', 380, 15, 'green'),
(3, 'Siemens', 'F2', 'Güç Kaynağı', 380, 20, 'blue'),
(3, 'Siemens', 'Q2', 'Yedek Kesici', 380, 25, 'white');

-- Demo Raporları
INSERT INTO reports (user_id, project_name, customer_name, brand, description, photos, quality_rating, status) VALUES
(2, 'Ticari Bina Projesi', 'ABC İnşaat A.Ş.', 'ABB',
'Elektrik panosu montajı başarıyla tamamlandı. Tüm kalite standartlarına uygun. Müşteri tarafından onaylandı.',
'[{"name":"panel_overview.jpg","path":"uploads/photos/panel_overview.jpg"},{"name":"wiring_detail.jpg","path":"uploads/photos/wiring_detail.jpg"}]',
100, 'published'),
(3, 'Fabrika Güç Sistemi', 'XYZ Üretim Ltd.', 'Siemens',
'Fabrika ana panosu montajı devam etmektedir. İlk faza ait kontroller tamamlanmıştır.',
'[{"name":"factory_panel.jpg","path":"uploads/photos/factory_panel.jpg"}]',
90, 'draft');

-- Trigger: Raporlar Silme İçin Fotoğrafları da Sil
DELIMITER //
CREATE TRIGGER delete_report_photos
BEFORE DELETE ON reports
FOR EACH ROW
BEGIN
  DELETE FROM photos WHERE report_id = OLD.id;
END//
DELIMITER ;

CREATE INDEX idx_user_brand ON labels(user_id, brand);
CREATE INDEX idx_report_brand ON reports(user_id, brand);
CREATE INDEX idx_checklist_brand ON checklists(user_id, brand);
