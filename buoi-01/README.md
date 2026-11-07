# Buổi 01 — Docker, image và container

**Thời lượng:** 45–60 phút. **Máy thực hành:** Windows 10/11, Docker Desktop, chế độ Linux containers với WSL 2.

**Mục tiêu:** giải thích được image khác container thế nào; chạy `hello-world`; xem container đã dừng; xóa container và nhận ra image vẫn còn.

## 1. Kiến thức nền — 10 phút

Docker giúp đóng gói ứng dụng cùng các thành phần cần thiết và chạy chúng trong môi trường nhất quán.

| Khái niệm | Ý nghĩa | Ví dụ |
| --- | --- | --- |
| Image | Mẫu đóng gói gồm chương trình, thư viện và cấu hình cần thiết; dùng để tạo container | `hello-world:latest` |
| Container | Một phiên bản được tạo từ image, có trạng thái và lớp ghi riêng; có thể đang chạy hoặc đã dừng | Container tên `docker-buoi-01` |
| Docker CLI | Công cụ nhận lệnh bạn gõ trong terminal | `docker run`, `docker ps` |
| Docker Engine / daemon | Dịch vụ xử lý yêu cầu tạo và quản lý image, container | Docker Desktop khởi động Engine để CLI kết nối |
| Registry | Nơi lưu và phân phối image | Docker Hub |

Một image có thể tạo ra nhiều container độc lập. Xóa một container không tự xóa image của nó.

Container dùng chung kernel của môi trường chạy nó. Với Linux containers trên Docker Desktop cho Windows, kernel Linux được cung cấp qua môi trường WSL 2; container không phải một bản Windows đầy đủ.

Khi chạy `docker run hello-world` lần đầu:

1. CLI gửi yêu cầu cho Docker Engine.
2. Engine chưa có image cục bộ nên tải `hello-world` từ Docker Hub.
3. Engine tạo một container từ image và chạy chương trình bên trong.
4. Chương trình in thông báo rồi kết thúc; container chuyển sang trạng thái `Exited (0)`.

`0` là mã thoát thành công. Container dừng khi tiến trình chính bên trong kết thúc.

## 2. Chuẩn bị Windows — 15–20 phút

Nếu đã cài và mở Docker Desktop, chuyển đến bước kiểm tra CLI/Engine phía dưới. Cài đặt lần đầu có thể cần thêm thời gian hoặc khởi động lại máy.

1. Kiểm tra phiên bản Windows và yêu cầu phần cứng theo [tài liệu Docker Desktop](https://docs.docker.com/desktop/setup/install/windows-install/). Bật ảo hóa CPU nếu máy chưa bật.
2. Mở PowerShell và kiểm tra WSL:

   ```powershell
   wsl --status
   wsl --list --verbose
   ```

3. Nếu chưa có WSL, mở PowerShell bằng **Run as administrator**, chạy lệnh sau rồi làm theo hướng dẫn khởi động lại/cài Linux nếu có:

   ```powershell
   wsl --install
   ```

   Nếu WSL đã có nhưng cũ, dùng `wsl --update`. Distro dùng cho bài học cần chạy WSL 2; tham khảo [hướng dẫn Microsoft](https://learn.microsoft.com/windows/wsl/install) khi cần chuyển phiên bản.

4. Cài Docker Desktop từ trang chính thức, chọn WSL 2 backend khi có lựa chọn. Mở ứng dụng, chờ Engine sẵn sàng; kiểm tra **Settings → General → Use the WSL 2 based engine**. Dùng chế độ Linux containers.
5. Mở lại PowerShell và chạy:

   ```powershell
   docker --version
   docker version
   ```

`docker --version` chỉ chứng minh CLI có sẵn. `docker version` phải hiển thị thông tin cả **Client** và **Server** để xác nhận Engine đang đáp ứng.

## 3. Bài thực hành — 15 phút

Gõ từng lệnh trong PowerShell và quan sát trước khi sang lệnh tiếp theo.

### Tạo và chạy container đầu tiên

```powershell
docker run --name docker-buoi-01 hello-world
```

Kết quả cần thấy: `Hello from Docker!`. Nếu chưa có image, Docker sẽ tải về trước. `--name` đặt tên container để các lệnh sau dễ tham chiếu.

### Phân biệt image với container

```powershell
docker image ls hello-world
docker ps
docker ps -a --filter name=docker-buoi-01
```

- `docker image ls`: liệt kê image đang có trên máy.
- `docker ps`: chỉ liệt kê container đang chạy, nên không thấy `hello-world` đã chạy xong. Các container khác trên máy vẫn có thể xuất hiện.
- `docker ps -a`: bao gồm container đã dừng; tìm container tên `docker-buoi-01` với trạng thái `Exited (0)`.

### Xem kết quả và chạy lại container cũ

```powershell
docker logs docker-buoi-01
docker start -a docker-buoi-01
```

`logs` đọc output đã lưu. `start` chạy lại container đã tồn tại; `-a` gắn terminal vào output. Lệnh này khác `docker run`, vốn tạo một container mới.

### Xóa container và kiểm tra image

```powershell
docker rm docker-buoi-01
docker ps -a --filter name=docker-buoi-01
docker image ls hello-world
```

Container đã bị xóa, nhưng image `hello-world` vẫn còn. Image này vẫn dùng được để tạo container khác.

## 4. Các lỗi thường gặp

| Hiện tượng | Cách xử lý |
| --- | --- |
| PowerShell không nhận lệnh `docker` | Hoàn tất cài Docker Desktop và mở lại terminal; kiểm tra Docker CLI đã có trong PATH |
| Có Client nhưng không kết nối được Server | Mở Docker Desktop, chờ Engine chạy; kiểm tra thông báo WSL trong ứng dụng |
| `The container name ... is already in use` | Container cũ vẫn tồn tại; dùng `docker start -a docker-buoi-01`, hoặc xóa đúng container của bài học bằng `docker rm docker-buoi-01` khi nó đã dừng rồi chạy lại |
| `hello-world` không xuất hiện trong `docker ps` | Bình thường: chương trình chạy xong nên container đã dừng; xem bằng `docker ps -a` |
| Image tải không được | Đọc lỗi cụ thể; kiểm tra kết nối, proxy hoặc giới hạn tải Docker Hub; ghi lại lỗi để xử lý |

## 5. Ôn tập — 5–10 phút

Điền [bài tập buổi 01](bai-tap.md) bằng kết quả trên máy Windows của bạn. Xem [kết quả minh họa](ket-qua-minh-hoa.md) để đối chiếu sau khi đã tự làm.

Buổi tiếp theo sẽ chạy Nginx, ánh xạ cổng và mở trang web trong trình duyệt.
