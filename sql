CREATE DATABASE IF NOT EXIST clientes;
USE clientes;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO usuarios (username, password)
VALUES ('admin', '$2y$10$ULu6.NrO.Xu98XBDd5U8Du7NiiFn2mJmYSp5zrdJJ0jMrxtDjPL6W');