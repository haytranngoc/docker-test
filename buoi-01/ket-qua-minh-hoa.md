# Kết quả minh họa buổi 01

Ngày kiểm chứng: **07/11/2026**. Người thực hiện: **trợ giảng Codex**, trong môi trường Linux cloud của cuộc trò chuyện.

Đây là kết quả chạy thực tế của trợ giảng, không phải kết quả kiểm tra Docker trên Windows của người học. Phần cài Docker Desktop/WSL 2 trên Windows chưa được kiểm chứng trên máy người học.

## Môi trường

- Docker CLI: `29.9.2`, build `a82e528`.
- Docker Engine: `29.9.2`.
- Daemon được kiểm tra qua socket cục bộ `/var/run/docker.sock`.

Các lệnh bên dưới được trình bày theo cú pháp dùng trong bài học. Khi thực thi trong cloud, trợ giảng chỉ định socket cục bộ và bỏ các biến chọn endpoint/context/TLS cho từng lệnh để tránh kết nối nhầm daemon. Người học dùng các lệnh PowerShell trong bài học, không cần cấu hình riêng của môi trường cloud.

## Quan sát đã kiểm chứng

| Lệnh | Kết quả quan sát |
| --- | --- |
| `docker run --name docker-buoi-01 hello-world` | Image được tải về; in `Hello from Docker!`; lệnh kết thúc thành công |
| `docker image ls hello-world` | Có `hello-world:latest` |
| `docker ps --filter name=docker-buoi-01` | Không có container đang chạy khớp bộ lọc |
| `docker ps -a --filter name=docker-buoi-01` | Có `docker-buoi-01`, image `hello-world`, trạng thái `Exited (0)` |
| `docker inspect docker-buoi-01` | Trường trạng thái được đọc: `status=exited`, `exitCode=0` |
| `docker logs docker-buoi-01` | Đọc lại được thông báo `Hello from Docker!` |
| `docker start -a docker-buoi-01` | Container cũ chạy lại và in thông báo thành công |
| `docker rm docker-buoi-01` | Xóa thành công container của bài học |
| `docker image ls hello-world` sau khi xóa container | Vẫn có `hello-world:latest` |

## Kiến thức rút ra từ minh họa

- Docker tải image khi image chưa có cục bộ.
- Image và container là hai đối tượng riêng biệt.
- Container có thể kết thúc thành công ngay sau khi chạy; `Exited` không tự động đồng nghĩa với lỗi.
- `run` tạo container mới, còn `start` dùng lại container có sẵn.
- Xóa container không tự động xóa image.

Tiến độ thực hành của người học được ghi riêng trong [bài tập](bai-tap.md).
