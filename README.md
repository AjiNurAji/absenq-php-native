# <center>AbsenQ <br><p style="font-size: 20px; font-weight: normal;">QR Code-Based Attendance System</p></center>

AbsenQ is a modern QR Code-based attendance application designed for university lectures and classes. Students generate their own QR codes, which remain valid for 4 minutes, and lecturers can scan them using any device.
This application was built to fulfill the final project for the Basic Web Programming course, taught by Khaerul Anam, M.Kom.

The application includes the following features:
- Time-limited QR Codes (4 minutes validity)
- Anti-reuse QR (the token is recorded only once)
- Real-time synchronized countdown with the server
- QR scanning via laptop or mobile phone cameras
- Check-in and check-out validation
- Student dashboard: recent attendance & upcoming schedules
- Middleware for authentication and role management
- Simple custom MVC Router
- Weekly statistics for charting purposes

## ⚙️ Tech Stack
- **BackEnd**
  - PHP 8.4+
  - Native PHP
  - Composer
  - PDO MySQL
  - Endroid/QrCode
- **FrontEnd**
  - Tailwind CSS
  - HTML5 + JavaScript
  - html5-qrcode (library for reading QR Codes)
- **Database**
  - MySQL 5.7 / MariaDB 10+

## 📁 Folder Structure
``` mdx
absenq
|_ app
|  |_ Controllers
|  |_ Core
|  |_ Helpers
|  |_ Middlewares
|  |_ Models
|  |_ Views
|_ docker
|  |_ apache
|  |  |_ 000-default.conf
|_ public
|  |_ assets
|  | |_ css
|  | |_ js
|  |_ index.php
|_ routes
|  |_ web.php
|_ storage
|  |_ qr
|_ vendor
```

## 📦 Installation & Setup (Docker Desktop)
1. Clone the Repository
``` bash
git clone [https://github.com/ajinuraji/absen-php-native.git](https://github.com/ajinuraji/absen-php-native.git) absenq
cd absenq
```
2. Setup
``` bash
docker-compose up --build -d
```
3. Database Setup
- Open the following phpMyAdmin URL in your browser:
  ``` web
  http://localhost:8081
  ```
  Log in using the username and password specified in the `docker-compose.yml` file.
- Import database/database.sql into phpMyAdmin.
4. Configure the Environment File.
- Copy the `.env.example` file rename it to `.env`.
- Fill in the required configurations in `.env`:
  ``` env
  APP_NAME=AbsenQ
  APP_URL=http://localhost
  
  DB_HOST=localhost
  DB_NAME=absenq
  DB_USER=root
  DB_PASS=
  ```
5. Access the application via `https://localhost:8000`.
6. Log in as an admin using the default credentials: username `admin` and password `admin`.

## 🤝 Contributors
- Aji Nur Aji
- Indah Suci Ramadani
- Nessya Cipto Meilody

Pull requests are welcome. Please create an issue for bugs or new feature requests.
---
## 📜 License
MIT License.
