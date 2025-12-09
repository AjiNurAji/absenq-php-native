# <center>AbsenQ <br><p style="font-size: 20px; font-weight: normal;">Sistem Absensi Berbasis Kode QR</p></center>

AbsenQ adalah aplikasi absensi modern berbasis QR Code yang dirancang untuk kebutuhan perkuliahan dan kelas. Mahasiswa melakukan generate QR secara mandiri, QR berlaku selama 4 menit, dan dosen melakukan scan menggunakan perangkat apa pun.
Aplikasi ini dibuat untuk memenuhi tugas akhir mata kuliah Pemrograman Web Dasar dosen pengampu Khaerul Anam, M.Kom.

Aplikasi dilengkapi dengan fitur:
- QR Code dengan masa berlaku terbatas (4 menit)
- QR anti penggunaan kembali (token dicatat 1 kali)
- Hitung mundur sinkron real-time dengan server
- Scan QR melalui kamera laptop/ponsel
- Validasi absen masuk dan pulang
- Dashboard mahasiswa: absen terakhir & jadwal mendatang
- Middleware untuk autentikasi dan peran
- Router MVC custom sederhana
- Statistik mingguan untuk bagan kebutuhan

## ⚙️ Tech Stack
- BackEnd
  - PHP 8.4+
  - Native PHP
  - Composer
  - PDO Mysql
  - Endroid/QrCode
- FrontEnd
  - Tailwind CSS
  - HTML5 + Javascript
  - html5-qrcode (library untuk membaca QR Code)
- Database
  - MySQL 5.7 / MariaDB 10+

## 📁 Stuktur Folder
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
## 📦 Instalasi & Setup (Docker Desktop)
1. Clone Repository
   ``` bash
   git clone https://github.com/ajinuraji/absen-php-native.git absenq
   cd absenq
   ```
2. Setup
   ``` bash
    docker-compose up --build -d
   ```
3. Setup database
   - Buka url phpmyadmin berikut di browser:
    ```mdx
    http://localhost:8081
    ```
    > login dengan user dan password yang ada pada `docker-compose.yml`
   -  Import `database/database.sql` ke phpmyadmin.
4. Atur file environment
   - Copy file `.env.example` menjadi `.env`
   - Isi kebutuhan yang ada pada `.env`
   ```env
   APP_NAME=AbsenQ
   APP_URL=http://localhost
   
   DB_HOST=localhost
   DB_NAME=absenq
   DB_USER=root
   DB_PASS=
   ```
5. Akses aplikasi melalu `http://localhost:8000`.
6. Login sebagai admin dengan data yang telah di tambahkan yaitu `admin` dan password `admin`.

## 🤝 Kontribusi
- Aji Nur Aji
- Indah Suci Ramadani
- Nessya Cipto Meilody
> Pull request dipersilakan. Silakan buat *issue* untuk bug/fitur baru.

## 📜 Lisensi
MIT License.



