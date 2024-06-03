-- Active: 1716492075250@@127.0.0.1@3306@php_project
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id)
);

ALTER TABLE users MODIFY COLUMN profile_image VARCHAR(255);

ALTER TABLE users
ADD COLUMN user_title VARCHAR(255) DEFAULT "Software Developer";

CREATE TABLE IF NOT EXISTS likes (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Foreign Key (user_id) REFERENCES users (id),
    Foreign Key (post_id) REFERENCES posts (id),
    UNIQUE KEY unique_like (user_id, post_id)
);

ALTER TABLE likes
ADD CONSTRAINT fk_likes_user_id FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
ADD CONSTRAINT fk_likes_post_id FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE CASCADE;