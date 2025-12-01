CREATE DATABASE IF NOT EXISTS absenq;

USE absenq;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    role ENUM('admin','employee'),
    password VARCHAR(255)
);

CREATE TABLE class (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(50)
);

CREATE TABLE students (
    student_id VARCHAR(15) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255),
    class_id INT,
    FOREIGN KEY (class_id) REFERENCES class(id)
);

CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_name VARCHAR(100)
);

CREATE TABLE schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    class_id INT,
    date DATE,
    start_time TIME,
    end_time TIME,
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (class_id) REFERENCES class(id)
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20),
    schedule_id INT,
    type ENUM('in','out'),
    time DATETIME,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (schedule_id) REFERENCES schedules(id)
);

INSERT INTO users (username, role, password) VALUES (
  "admin",
  "admin",
  "$2y$12$ZCf2N3nmu7q5mBNZKr0vruA2V/Pf2VaPF/njbAoLPyTLXneArsVvm"
);