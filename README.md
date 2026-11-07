# Nhật ký học Docker

Lộ trình dành cho người mới, thực hành trên Windows 10/11 với Docker Desktop và WSL 2. Mỗi buổi khoảng 45–60 phút.

## Mục tiêu

Sau 4 tuần, tự viết Dockerfile và chạy một ứng dụng cùng PostgreSQL bằng Docker Compose.

| Tuần | Chủ đề | Sản phẩm thực hành |
| --- | --- | --- |
| 1 | Image, container, vòng đời container, port, log | Chạy và quản lý Nginx |
| 2 | Dockerfile, build, tag, `.dockerignore`, cache | Image cho ứng dụng Node.js hoặc Python |
| 3 | Volume, bind mount, network, Docker Compose | Ứng dụng kết nối PostgreSQL, dữ liệu được lưu bền vững |
| 4 | Biến môi trường, healthcheck, tối ưu image, quyền chạy | Dự án có hướng dẫn dựng lại từ đầu |

## Các buổi học

| Buổi | Nội dung | Tài liệu |
| --- | --- | --- |
| 01 | Docker là gì; image và container; cài đặt trên Windows; `hello-world` | [Bài học](buoi-01/README.md) · [Bài tập](buoi-01/bai-tap.md) · [Kết quả minh họa](buoi-01/ket-qua-minh-hoa.md) |

Đọc nhanh: [Docker là gì, cơ chế hoạt động và các lệnh thường dùng](buoi-01/tom-tat.md).

Cấu hình thực hành: [docker.yaml](docker.yaml) chạy PHP 8.5.12, PostgreSQL, MySQL và Redis trên Ubuntu 24.04. Xem [hướng dẫn chạy](docker/README.md).

## Cách ghi nhận tiến độ

Mỗi buổi lưu kiến thức, lệnh thực hành, lỗi gặp và câu trả lời ôn tập vào repo này. Chỉ đánh dấu hoàn thành khi người học đã chạy bài và xác nhận kết quả. Kết quả do trợ giảng chạy trong cloud được ghi riêng, không thay cho thực hành trên máy Windows của người học.

Sau mỗi buổi học, cập nhật ghi chép và đẩy commit lên GitHub. Không đưa mật khẩu, token hoặc file `.env` vào repo.

## Tài liệu chính

- [Docker Get Started](https://docs.docker.com/get-started/)
- [Cài Docker Desktop trên Windows](https://docs.docker.com/desktop/setup/install/windows-install/)
- [Cài WSL](https://learn.microsoft.com/windows/wsl/install)
