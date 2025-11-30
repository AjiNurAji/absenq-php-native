CREATE DATABASE IF NOT EXISTS absenq;

USE absenq;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    type ENUM('admin','employee'),
    password VARCHAR(255)
);

CREATE TABLE class (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(50)
);

CREATE TABLE students (
    student_id VARCHAR(15) PRIMARY KEY UNIQUE,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255),
    class_id INT,
    FOREIGN KEY (class_id) REFERENCES class(id)
);

CREATE TABLE schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course VARCHAR(100),
    class VARCHAR(20),
    date DATE,
    start_time TIME,
    end_time TIME
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR,
    schedule_id INT,
    type ENUM('in','out'),
    time DATETIME,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (schedule_id) REFERENCES schedules(id) ON DELETE CASCADE ON UPDATE CASCADE
);

