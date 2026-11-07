# Bài tập buổi 01

Trạng thái: **Chưa xác nhận hoàn thành trên máy Windows của người học.**

## Kết quả thực hành

Chỉ đánh dấu sau khi bạn đã tự kiểm tra.

- [ ] `docker version` hiển thị cả Client và Server.
- [ ] Chạy `hello-world` và thấy `Hello from Docker!`.
- [ ] Tìm thấy image bằng `docker image ls hello-world`.
- [ ] Tìm thấy container đã dừng bằng `docker ps -a`.
- [ ] Chạy lại container cũ bằng `docker start -a docker-buoi-01`.
- [ ] Xóa container, kiểm tra image vẫn còn.

Phiên bản Docker trên máy: _chưa ghi nhận_.

Lỗi đã gặp và cách xử lý: _chưa ghi nhận_.

## Tự trả lời bằng lời của bạn

1. Image khác container như thế nào? Một image có tạo được nhiều container không?

   Trả lời: _chưa điền_.

2. Vì sao `hello-world` không xuất hiện trong `docker ps`, nhưng xuất hiện trong `docker ps -a`?

   Trả lời: _chưa điền_.

3. `Exited (0)` cho biết điều gì?

   Trả lời: _chưa điền_.

4. Sau `docker rm docker-buoi-01`, image `hello-world` có bị xóa không? Kiểm tra bằng lệnh nào?

   Trả lời: _chưa điền_.

5. `docker run` khác `docker start` ở điểm nào?

   Trả lời: _chưa điền_.

<details>
<summary>Đáp án tham khảo — mở sau khi tự trả lời</summary>

1. Image là mẫu đóng gói; container là một phiên bản được tạo từ image. Một image tạo được nhiều container.
2. `hello-world` đã chạy xong và dừng. `docker ps` chỉ hiển thị container đang chạy; `docker ps -a` bao gồm container đã dừng.
3. Tiến trình chính đã kết thúc với mã thoát thành công là 0.
4. Không. Dùng `docker image ls hello-world` để kiểm tra.
5. `run` tạo và chạy container mới; `start` khởi động lại container đã tồn tại.

</details>

## Ghi chép sau buổi học

- Điều đã hiểu rõ: _chưa điền_.
- Điều còn thắc mắc: _chưa điền_.
- Ngày hoàn thành: _chưa xác nhận_.
