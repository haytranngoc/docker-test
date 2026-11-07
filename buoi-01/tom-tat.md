# Docker — tóm tắt nhanh

Docker đóng gói ứng dụng cùng thư viện và cấu hình cần thiết thành **image**, rồi tạo **container** để chạy ứng dụng đó trong môi trường cô lập.

- **Image:** mẫu đóng gói, dùng để tạo container.
- **Container:** một phiên bản được tạo từ image; có thể đang chạy hoặc đã dừng.
- **Registry:** nơi lưu image, ví dụ Docker Hub.
- **Volume:** nơi lưu dữ liệu độc lập với vòng đời container.

## Cơ chế hoạt động

```text
Dockerfile → docker build → Image → docker run → Container
                              ↕
                           Registry
```

Bạn gõ lệnh qua Docker CLI; Docker Engine nhận yêu cầu, tải image nếu cần, rồi tạo và chạy container. Container là tiến trình được cô lập về môi trường chạy và có thể bị giới hạn tài nguyên; các container dùng chung kernel của môi trường chủ. Docker Desktop trên Windows dùng môi trường Linux qua WSL 2 khi chạy Linux containers với WSL 2 backend.

Một image tạo được nhiều container. Xóa container không tự xóa image hay named volume. Dữ liệu chỉ nằm trong lớp ghi của container sẽ mất khi container đó bị xóa.

## Lệnh thường dùng

| Lệnh | Công dụng |
| --- | --- |
| `docker version` | Kiểm tra CLI và kết nối tới Engine |
| `docker pull nginx` | Tải image từ registry |
| `docker build -t my-app .` | Build image từ Dockerfile trong thư mục hiện tại |
| `docker run -d --name web -p 8080:80 nginx` | Tạo và chạy Nginx nền, ánh xạ cổng 8080 của máy vào cổng 80 của container |
| `docker ps` / `docker ps -a` | Xem container đang chạy / tất cả container |
| `docker image ls` | Xem image cục bộ |
| `docker logs -f web` | Theo dõi output của container |
| `docker exec -it web sh` | Mở shell trong container đang chạy |
| `docker stop web` / `docker start web` | Dừng / khởi động container đã tồn tại |
| `docker rm web` | Xóa container đã dừng |
| `docker compose up -d` | Chạy các dịch vụ khai báo trong file Compose |
| `docker compose down` | Dừng và xóa container/network do Compose quản lý; mặc định không xóa named volume |

Trong lệnh `run`: `-d` chạy nền; `--name` đặt tên; `-p` có thứ tự `cổng-máy:cổng-container`. Ví dụ Nginx trên truy cập qua `http://localhost:8080`.

`docker run` tạo container mới; `docker start` dùng lại container cũ. `docker compose` cần có file cấu hình như `compose.yaml`.
