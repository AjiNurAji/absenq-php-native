CREATE DATABASE IF NOT EXISTS absenq;

USE absenq;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    role ENUM('admin','employee') NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE class (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(50) NOT NULL
);

CREATE TABLE students (
    student_id VARCHAR(15) PRIMARY KEY NOT NULL,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    class_id INT NOT NULL,
    FOREIGN KEY (class_id) REFERENCES class(id)
);

CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_name VARCHAR(100) NOT NULL
);

CREATE TABLE schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    class_id INT NOT NULL,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id)
    FOREIGN KEY (class_id) REFERENCES class(id)
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) NOT NULL,
    schedule_id INT NOT NULL,
    type ENUM('in','out') NOT NULL,
    status ENUM('present','absent') NOT NULL,
    note VARCHAR(255),
    time DATETIME NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (schedule_id) REFERENCES schedules(id)
);

INSERT INTO users (username, role, password) VALUES (
  "admin",
  "admin",
  "$2y$12$ZCf2N3nmu7q5mBNZKr0vruA2V/Pf2VaPF/njbAoLPyTLXneArsVvm"
);