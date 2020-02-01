CREATE TABLE IF NOT EXISTS wishes (
                                       id INT AUTO_INCREMENT PRIMARY KEY,
                                       wish TEXT,
                                       link TEXT,
                                       description TEXT,
                                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;
