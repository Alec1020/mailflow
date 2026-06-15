CREATE DATABASE IF NOT EXISTS email_client CHARACTER
SET
    utf8mb4 COLLATE utf8mb4_unicode_ci;

USE email_client;

-- USERS
CREATE TABLE
    users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- MAILS
CREATE TABLE
    mails (
        id INT AUTO_INCREMENT PRIMARY KEY,
        sender_id INT NOT NULL,
        receiver_id INT NOT NULL,
        subject VARCHAR(255) NOT NULL,
        body LONGTEXT NOT NULL,
        parent_mail_id INT NULL,
        is_read TINYINT (1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT fk_sender FOREIGN KEY (sender_id) REFERENCES users (id) ON DELETE CASCADE,
        CONSTRAINT fk_receiver FOREIGN KEY (receiver_id) REFERENCES users (id) ON DELETE CASCADE,
        CONSTRAINT fk_parent FOREIGN KEY (parent_mail_id) REFERENCES mails (id) ON DELETE SET NULL
    );

CREATE INDEX idx_receiver ON mails (receiver_id);

CREATE INDEX idx_sender ON mails (sender_id);

CREATE INDEX idx_created ON mails (created_at);

-- Demo user
-- Email: admin@example.com
-- Password: 123456
INSERT INTO
    users (name, email, password)
VALUES
    (
        'Administrator',
        'admin@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    );