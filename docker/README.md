# PHP + PostgreSQL + MySQL + Redis trên Ubuntu 24.04

Ubuntu 24.04 là hệ điều hành **máy chủ chạy Docker**. Container PHP dùng image chính thức `php:8.5.12-apache` dựa trên Debian. Apache phục vụ PHP trực tiếp, không cần thêm Nginx cho cấu hình này.

| Dịch vụ | Phiên bản | Địa chỉ từ container PHP | Địa chỉ từ máy Ubuntu |
| --- | --- | --- | --- |
| PHP + Apache | PHP 8.5.12 | `php:80` | `http://127.0.0.1:8080` |
| PostgreSQL | 17 | `postgresql:5432` | `127.0.0.1:5432` |
| MySQL | 8.4 | `mysql:3306` | `127.0.0.1:3306` |
| Redis | 7.4 | `redis:6379` | `127.0.0.1:6379` |

PHP có các extension `pdo_mysql`, `pdo_pgsql` và `redis` (phpredis 6.3.0). Các image database/cache được cố định theo nhánh phiên bản trong bảng.

## Chạy lần đầu

Cài Docker Engine và Docker Compose plugin theo [hướng dẫn chính thức cho Ubuntu](https://docs.docker.com/engine/install/ubuntu/). Kiểm tra `docker version` và `docker compose version` hoạt động. Tài khoản chạy lệnh cần có quyền dùng Docker.

Trong thư mục gốc repo:

```bash
cp .env.example .env
chmod 600 .env
nano .env
```

Điền bốn mật khẩu khác rỗng: `POSTGRES_PASSWORD`, `MYSQL_PASSWORD`, `MYSQL_ROOT_PASSWORD`, `REDIS_PASSWORD`. Có thể tạo từng mật khẩu bằng `openssl rand -hex 24`. `.env` đã được loại khỏi Git.

```bash
docker compose -f docker.yaml config --quiet
docker compose -f docker.yaml up -d --build --wait --wait-timeout 300
curl --fail http://127.0.0.1:8080
```

Response mẫu khi cả ba kết nối đều thành công:

```json
{
    "php": "8.5.12",
    "services": {
        "postgresql": "ok",
        "mysql": "ok",
        "redis": "ok"
    }
}
```

File `src/index.php` thực sự kết nối và chạy truy vấn kiểm tra với hai database, đồng thời xác thực và ping Redis. Endpoint trả HTTP 503 nếu một kết nối thất bại; không trả mật khẩu hoặc lỗi chi tiết ra trình duyệt.

## Sửa code và vận hành

Code PHP đặt trong `src/`, được bind mount vào `/var/www/html` ở chế độ chỉ đọc với container. Sửa file trên máy Ubuntu sẽ có hiệu lực mà không cần build lại image. Nếu ứng dụng cần ghi file, thêm volume riêng cho thư mục dữ liệu của ứng dụng.

```bash
docker compose -f docker.yaml ps
docker compose -f docker.yaml logs -f php
docker compose -f docker.yaml exec php php -v
docker compose -f docker.yaml exec php php -m
docker compose -f docker.yaml exec php sh
docker compose -f docker.yaml down
```

`down` giữ named volume của PostgreSQL, MySQL và Redis. `down -v` xóa cả các volume này và dữ liệu bên trong. Redis bật AOF để lưu dữ liệu xuống volume.

Các cổng được bind vào `127.0.0.1` của máy Ubuntu để dùng cục bộ. Trong container, dùng tên dịch vụ trong bảng, không dùng `localhost` để gọi database/cache. Có thể đổi cổng bên máy Ubuntu qua `.env` nếu cổng mặc định đang được sử dụng; cổng nội bộ giữa container không thay đổi.

Mật khẩu và tên database của PostgreSQL/MySQL chỉ được khởi tạo từ biến môi trường khi volume dữ liệu còn trống. Nếu đã có dữ liệu, sửa `.env` không tự đổi tài khoản trong database; cập nhật tài khoản bằng SQL tương ứng rồi đồng bộ `.env`.

## Kết quả kiểm chứng

Trong môi trường Linux cloud của trợ giảng ngày 07/11/2026:

- `docker compose ... config --quiet` hợp lệ.
- PostgreSQL, MySQL và Redis đã khởi động cùng nhau và đều đạt healthcheck.
- Image PHP 8.5.12 đã build thành công, bao gồm biên dịch và bật `pdo_mysql`, `pdo_pgsql`, `redis`.
- Chưa kiểm chứng cả bốn dịch vụ cùng chạy hoặc response HTTP tổng hợp. Môi trường cloud có ổ đĩa khoảng 8 GB và Docker dùng storage driver VFS, đã hết chỗ khi lưu đồng thời các image. PHP được build riêng sau khi dọn các dịch vụ thử nghiệm.

Lệnh `curl` và JSON phía trên là hướng dẫn cùng kết quả mong đợi để kiểm tra trên máy Ubuntu của bạn.
