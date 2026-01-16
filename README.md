# Lichhop - CodeIgniter 3 Application

Dự án Lichhop được xây dựng trên framework CodeIgniter 3.1.13.

## Yêu cầu hệ thống

- PHP >= 5.6 (khuyến nghị PHP 7.4 hoặc cao hơn)
- Web server (Apache/Nginx)
- MySQL hoặc database tương thích

## Cài đặt

1. Clone repository này
2. Cấu hình database trong `application/config/database.php`
3. Cấu hình base URL trong `application/config/config.php`
4. Đảm bảo thư mục `application/cache` và `application/logs` có quyền ghi

## Cấu hình

### URL Rewriting
Dự án đã được cấu hình sẵn file `.htaccess` để loại bỏ `index.php` khỏi URL.

### Database
Cập nhật thông tin database trong file `application/config/database.php`:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password',
    'database' => 'your_database',
    ...
);
```

## Cấu trúc thư mục

- `application/` - Mã nguồn ứng dụng
  - `controllers/` - Controllers
  - `models/` - Models
  - `views/` - Views
  - `config/` - File cấu hình
- `system/` - CodeIgniter core system
- `index.php` - Entry point

## Tài liệu

- [CodeIgniter 3 Documentation](https://codeigniter.com/userguide3/)
