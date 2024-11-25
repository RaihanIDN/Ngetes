# Template Login/Logout System

## Fitur
- Sistem login/logout dengan database MySQL
- Form registrasi pengguna baru
- Validasi keamanan (hashed password)

## Cara Install
1. Salin folder ini ke direktori `htdocs` XAMPP.
2. Buat database di MySQL:
   ```sql
   CREATE DATABASE project_template;
   USE project_template;
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) UNIQUE,
       password VARCHAR(255)
   );
