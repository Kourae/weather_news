CREATE DATABASE IF NOT EXISTS weathernews_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE weathernews_db;
SHOW GRANTS FOR 'root'@'localhost';

CREATE TABLE IF NOT EXISTS saved_countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    capital VARCHAR(100),
    region VARCHAR(100),
    population INT,
    weather TEXT,
    saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
