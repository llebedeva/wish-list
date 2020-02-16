CREATE DATABASE db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE db;
CREATE TABLE wishes (
                                       id INT AUTO_INCREMENT PRIMARY KEY,
                                       wish TEXT,
                                       link TEXT,
                                       description TEXT,
                                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
