CREATE DATABASE IF NOT EXISTS weathernews_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE weathernews_db;
SHOW GRANTS FOR 'your_username'@'localhost';

CREATE TABLE IF NOT EXISTS saved_countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    capital VARCHAR(100),
    latlng VARCHAR(100),
    saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);