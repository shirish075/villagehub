-- Create the database
CREATE DATABASE IF NOT EXISTS villagehub;

-- Use the database
USE villagehub;

-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL
);

-- Create the issues table
CREATE TABLE IF NOT EXISTS issues (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(50) NOT NULL,
    photo VARCHAR(255),
    user_id INT(6) UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create the statuses table (optional)
CREATE TABLE IF NOT EXISTS statuses (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    issue_id INT(6) UNSIGNED,
    status VARCHAR(50) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (issue_id) REFERENCES issues(id)
);
