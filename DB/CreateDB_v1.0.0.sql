CREATE DATABASE poll CHARACTER SET utf8 COLLATE utf8_general_ci;

USE poll;

CREATE TABLE users 
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT
    , login VARCHAR(100) UNIQUE NOT NULL
    , email VARCHAR(100) UNIQUE NOT NULL
    , hash VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE polls
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT
    , question VARCHAR(100) NOT NULL
    , creation_date DATETIME NOT NULL
    , creation_user_id INT NOT NULL
    , duration INT NOT NULL
    , FOREIGN KEY (creation_user_id) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE poll_answers
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT
    , label VARCHAR(100) NOT NULL
    , poll_id INT NOT NULL
    , FOREIGN KEY (poll_id) REFERENCES polls(id)
) ENGINE=InnoDB;

INSERT INTO users (login, email, hash) VALUES ('jguillevic', 'guillevicjerome@yahoo.fr', '$2y$10$g6qyxpR4L5H9XsWNdaecGOCUfwEdUoXQdv5y355D8QzkubCZQU4qa');