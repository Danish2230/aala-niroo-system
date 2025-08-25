-- ایجاد پایگاه داده
CREATE DATABASE IF NOT EXISTS aala_niroo;
USE aala_niroo;

-- جدول دارایی‌ها
CREATE TABLE IF NOT EXISTS assets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    serial_number VARCHAR(255) UNIQUE,
    purchase_date DATE,
    status ENUM('فعال', 'غیرفعال', 'در حال تعمیر') DEFAULT 'فعال',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول مشتریان
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    company VARCHAR(255),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول کاربران سیستم
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('ادمین', 'کاربر عادی') DEFAULT 'کاربر عادی',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- درج کاربر پیش‌فرض (admin)
-- رمز عبور: 123456 (به صورت hash شده)
INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ادمین');
