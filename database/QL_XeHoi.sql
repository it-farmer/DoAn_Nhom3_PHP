DROP DATABASE IF EXISTS QL_XeHoi;
CREATE DATABASE IF NOT EXISTS QL_XeHoi;
USE QL_XeHoi;

CREATE TABLE IF NOT EXISTS QuyenTruyCap (
    QuyenID INT PRIMARY KEY AUTO_INCREMENT,
    TenQuyen VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS NhanVien (
    MaNV VARCHAR(10) PRIMARY KEY,
    HoTenNV VARCHAR(100),
    QueQuan VARCHAR(100),
    NgaySinhNV DATE,
    SoDienThoaiNV VARCHAR(20),
    GioiTinh VARCHAR(10),
    EmailNV VARCHAR(100),
    HinhAnhNV VARCHAR(20),
    TaiKhoan VARCHAR(100),
    MatKhau VARCHAR(100),
    QuyenID INT NOT NULL,
    FOREIGN KEY (QuyenID) REFERENCES QuyenTruyCap(QuyenID)
);

CREATE TABLE IF NOT EXISTS KhachHang (
    MaKH VARCHAR(10) PRIMARY KEY, 
    HoTenKH VARCHAR(100),
    NgaySinhKH DATE,
    SoDienThoaiKH VARCHAR(20),
    EmailKH VARCHAR(100),
    DiaChi VARCHAR(250),
    HinhAnhKH VARCHAR(20),
    TenDangNhap VARCHAR(100),
    MatKhau VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS HangXe (
    MaHX VARCHAR(10) PRIMARY KEY, 
    TenHX VARCHAR(100),
    DiaChiHX VARCHAR(255),
    SoDienThoaiHX VARCHAR(20),
    EmailHX VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS XeHoi (
    MaXe VARCHAR(10) PRIMARY KEY, 
    AnhXe VARCHAR(200),
    TenXe VARCHAR(100),
    MaHX VARCHAR(10),
    FOREIGN KEY (MaHX) REFERENCES HangXe(MaHX) ON DELETE CASCADE,
    MauXe VARCHAR(50),
    CongNghe VARCHAR(200),
    Gia FLOAT,
    SoLuongTonKho INT,
    MoTa TEXT,
    ThoiGianBaoHanh VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS ThongSoKyThuat (
    MaXe VARCHAR(10) PRIMARY KEY,
    FOREIGN KEY (MaXe) REFERENCES XeHoi(MaXe) ON DELETE CASCADE,
    MauNgoaiThat VARCHAR(50),
    MauNoiThat VARCHAR(100),
    SoXiLanh INT,
    DungTich VARCHAR(50),
    ChieuDai VARCHAR(50),
    ChieuRong VARCHAR(50),
    ChieuCao VARCHAR(50),
    KhoiLuong VARCHAR(50),
    TrongLuongToiDa VARCHAR(50),
    TocDoToiDa VARCHAR(50),
    SoCua INT,
    SoChoNgoi INT,
    HopSo VARCHAR(50),
    NamSanXuat INT,
    DongCo VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS HinhAnhXe (
    MaHinh INT AUTO_INCREMENT PRIMARY KEY,
    MaXe VARCHAR(10),
    FOREIGN KEY (MaXe) REFERENCES XeHoi(MaXe) ON DELETE CASCADE,
    TenHinh VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS DanhGiaBinhLuan (
    MaDanhGia INT AUTO_INCREMENT PRIMARY KEY,
    MaKH VARCHAR(10),
    MaXe VARCHAR(10),
    FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH) ON DELETE CASCADE,
    FOREIGN KEY (MaXe) REFERENCES XeHoi(MaXe) ON DELETE CASCADE,
    NoiDung TEXT,
    SoSao INT,
    NgayDanhGia DATETIME
);

CREATE TABLE IF NOT EXISTS GioHang (
    MaGH INT AUTO_INCREMENT PRIMARY KEY,
    MaKH VARCHAR(10),
    MaXe VARCHAR(10),
    SoLuong INT,
    FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH) ON DELETE CASCADE,
    FOREIGN KEY (MaXe) REFERENCES XeHoi(MaXe) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS HoaDon (
    MaHD VARCHAR(10) PRIMARY KEY,
    MaKH VARCHAR(10),
    FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH) ON DELETE CASCADE,
    MaNV VARCHAR(10) NOT NULL,
    FOREIGN KEY (MaNV) REFERENCES NhanVien(MaNV) ON DELETE CASCADE,
    NgayLap DATETIME,
    TongTien FLOAT
);

CREATE TABLE IF NOT EXISTS ChiTietHoaDon (
    MaHD VARCHAR(10) NOT NULL,
    FOREIGN KEY (MaHD) REFERENCES HoaDon(MaHD) ON DELETE CASCADE,
    MaXe VARCHAR(10) NOT NULL,
    FOREIGN KEY (MaXe) REFERENCES XeHoi(MaXe) ON DELETE CASCADE,
    SoLuong INT,
    GiaBan FLOAT,
    PRIMARY KEY (MaHD, MaXe)
);

INSERT INTO QuyenTruyCap (TenQuyen)
VALUES 
('Quản lý'),
('Nhân viên bán hàng');

INSERT INTO NhanVien (MaNV, HoTenNV, QueQuan, NgaySinhNV, SoDienThoaiNV, GioiTinh, EmailNV, HinhAnhNV, TaiKhoan, MatKhau, QuyenID)
VALUES 
('NV01', 'Lê Hà Ngọc Thy', 'TP HCM', '2004-11-24', '0912345678', 'Nam', 'nv1@gmail.com', 'NV01.jpg', 'nv01', '123', 1),
('NV02', 'Đỗ Trung Dũng', 'Hà Nội', '2004-06-20', '0987654321', 'Nữ', 'nv2@gmail.com', 'NV02.jpg', 'nv02', '123', 2),
('NV03', 'Nguyễn Thế Anh', 'Long An', '2004-03-10', '0934567890', 'Nữ', 'nv3@gmail.com', 'NV03.jpg', 'nv03', '123', 1),
('NV04', 'Hồ Quế Trân', 'Yên Bái', '2003-03-10', '0934567890', 'Nữ', 'nv4@gmail.com', 'NV04.jpg', 'nv04', '123', 2);

-- Sửa INSERT cho bảng KhachHang, bổ sung TenDangNhap và MatKhau
INSERT INTO KhachHang (MaKH, HoTenKH, NgaySinhKH, SoDienThoaiKH, EmailKH, DiaChi, HinhAnhKH, TenDangNhap, MatKhau)
VALUES 
('KH01', 'Nguyễn Thị Giang', '1999-05-12', '0909876543', 'ntg@gmail.com', 'TP.HCM', 'KH01.jpg', 'kh01', '123'),
('KH02', 'Trần Văn Hiệp', '2005-02-25', '0912345679', 'tvh@gmail.com', 'Bến Tre', 'KH02.jpg', 'kh02', '123'),
('KH03', 'Lê Thị Ái Quyên', '2005-08-30', '0923456780', 'lti@gmail.com', 'TP.HCM', 'KH03.jpg', 'kh03', '123'),
('KH04', 'Ngô Văn Phú', '2001-10-15', '0934567891', 'nvj@gmail.com', 'TP.HCM', 'KH04.jpg', 'kh04', '123'),
('KH05', 'Phạm Thị Khánh Huyền', '2002-12-05', '0945678902', 'ptk@gmail.com', 'TP.HCM', 'KH05.jpg', 'kh05', '123'),
('KH06', 'Vũ Văn Linh', '2003-03-20', '0956789013', 'vvl@gmail.com', 'TP.HCM', 'KH06.jpg', 'kh06', '123'),
('KH07', 'Lê Văn Phụng', '2004-06-30', '0990123457', 'lvp@gmail.com', 'TP.HCM', 'KH07.jpg', 'kh07', '123');

INSERT INTO HangXe (MaHX, TenHX, DiaChiHX, SoDienThoaiHX, EmailHX) VALUES
('HX01', 'BMW', 'BMW AG, Petuelring 130, 80788 München, Đức', '+49 89 1250 1600', 'contact@bmw.com'),
('HX02', 'Porsche', 'Porsche AG, Porschestrasse 1, 73614 Zuffenhausen, Đức', '+49 711 911 0', 'info@porsche.com'),
('HX03', 'Lamborghini', 'Automobili Lamborghini S.p.A., Via Modena, 12, 40019 Sant\Agata Bolognese BO, Ý', '+39 051 681 7611', 'info@lamborghini.com'),
('HX04', 'Audi', 'Audi AG, Auto-Union-Straße 1, 85057 Ingolstadt, Đức', '+49 841 89 0', 'info@audi.com'),
('HX05', 'Mercedes-Benz', 'Mercedes-Benz AG, Mercedesstraße 120, 70372 Stuttgart, Đức', '+49 711 17 0', 'info@mercedes-benz.com'),
('HX06', 'Roll-Royce', 'Rolls-Royce Motor Cars Limited, The Drive, Goodwood, Chichester, West Sussex PO18 0SH, Vương quốc Anh', '+44 1243 525700', 'info@rolls-royce.com'),
('HX07', 'Ferrari', 'Ferrari N.V., Via Abetone Inferiore, 4, 41053 Maranello MO, Ý', '+39 0536 949111', 'info@ferrari.com');

INSERT INTO XeHoi (MaXe, AnhXe, TenXe, MaHX, MauXe, CongNghe, Gia, SoLuongTonKho) VALUES
('XE01', 'xe01.jpg', 'BMW M3', 'HX01', 'Đen', 'Công nghệ lái tự động', 150000000, 10),
('XE02', 'xe02.jpg', 'BMW X5', 'HX01', 'Trắng', 'Công nghệ Hybrid', 200000000, 8),
('XE03', 'xe03.jpg', 'BMW 7 Series', 'HX01', 'Bạc', 'Công nghệ chống va chạm', 250000000, 5),
('XE04', 'xe04.jpg', 'BMW Z4', 'HX01', 'Đỏ', 'Công nghệ động cơ điện', 180000000, 6),
('XE05', 'xe05.jpg', 'BMW i8', 'HX01', 'Xanh', 'Công nghệ tiết kiệm nhiên liệu', 300000000, 3),
('XE06', 'xe06.jpg', 'BMW M4', 'HX01', 'Xám', 'Công nghệ an toàn cao', 220000000, 4),
('XE07', 'xe07.jpg', 'BMW X3', 'HX01', 'Đen', 'Công nghệ thông minh', 160000000, 12),
('XE08', 'xe08.jpg', 'BMW 320i', 'HX01', 'Trắng', 'Công nghệ lái tự động', 140000000, 9),
('XE09', 'xe09.jpg', 'BMW M5', 'HX01', 'Bạc', 'Công nghệ điều khiển từ xa', 260000000, 7),
('XE10', 'xe10.jpg', 'BMW 3 Series', 'HX01', 'Đỏ', 'Công nghệ âm thanh 3D', 175000000, 11),

-- Porsche
('XE11', 'xe11.jpg', 'Porsche 911', 'HX02', 'Xanh', 'Công nghệ turbo', 300000000, 5),
('XE12', 'xe12.jpg', 'Porsche Cayenne', 'HX02', 'Đen', 'Công nghệ hybrid', 200000000, 7),
('XE13', 'xe13.jpg', 'Porsche Macan', 'HX02', 'Bạc', 'Công nghệ điều khiển thông minh', 180000000, 4),
('XE14', 'xe14.jpg', 'Porsche Panamera', 'HX02', 'Trắng', 'Công nghệ an toàn', 350000000, 2),
('XE15', 'xe15.jpg', 'Porsche Taycan', 'HX02', 'Đỏ', 'Công nghệ điện', 400000000, 3),
('XE16', 'xe16.jpg', 'Porsche 718', 'HX02', 'Xám', 'Công nghệ hiệu suất cao', 250000000, 6),
('XE17', 'xe17.jpg', 'Porsche Boxster', 'HX02', 'Xanh dương', 'Công nghệ turbo', 220000000, 5),
('XE18', 'xe18.jpg', 'Porsche 356', 'HX02', 'Bạc', 'Công nghệ cổ điển', 300000000, 2),
('XE19', 'xe19.jpg', 'Porsche 904', 'HX02', 'Đỏ', 'Công nghệ thể thao', 400000000, 1),
('XE20', 'xe20.jpg', 'Porsche 918', 'HX02', 'Vàng', 'Công nghệ hybrid cao cấp', 450000000, 1),

-- Lamborghini
('XE21', 'xe21.jpg', 'Lamborghini Huracan', 'HX03', 'Đen', 'Công nghệ V10', 400000000, 3),
('XE22', 'xe22.jpg', 'Lamborghini Aventador', 'HX03', 'Đỏ', 'Công nghệ động cơ V12', 600000000, 2),
('XE23', 'xe23.jpg', 'Lamborghini Urus', 'HX03', 'Vàng', 'Công nghệ SUV', 500000000, 4),
('XE24', 'xe24.jpg', 'Lamborghini Gallardo', 'HX03', 'Xanh', 'Công nghệ thể thao', 450000000, 2),
('XE25', 'xe25.jpg', 'Lamborghini Sián', 'HX03', 'Bạc', 'Công nghệ hybrid', 700000000, 1),
('XE26', 'xe26.jpg', 'Lamborghini Centenario', 'HX03', 'Đen', 'Công nghệ giới hạn', 800000000, 1),
('XE27', 'xe27.jpg', 'Lamborghini Huracan EVO', 'HX03', 'Trắng', 'Công nghệ mới nhất', 450000000, 3),
('XE28', 'xe28.jpg', 'Lamborghini Murcielago', 'HX03', 'Xanh dương', 'Công nghệ cổ điển', 550000000, 1),
('XE29', 'xe29.jpg', 'Lamborghini Reventon', 'HX03', 'Đỏ', 'Công nghệ độc quyền', 1000000000, 1),

-- Audi
('XE30', 'xe30.jpg', 'Audi A4', 'HX04', 'Đen', 'Công nghệ quattro', 180000000, 10),
('XE31', 'xe31.jpg', 'Audi A6', 'HX04', 'Bạc', 'Công nghệ tự động', 250000000, 8),
('XE32', 'xe32.jpg', 'Audi Q5', 'HX04', 'Trắng', 'Công nghệ SUV', 220000000, 6),
('XE33', 'xe33.jpg', 'Audi Q7', 'HX04', 'Đỏ', 'Công nghệ an toàn', 300000000, 5),
('XE34', 'xe34.jpg', 'Audi A8', 'HX04', 'Xanh', 'Công nghệ sang trọng', 400000000, 4),
('XE35', 'xe35.jpg', 'Audi TT', 'HX04', 'Xám', 'Công nghệ thể thao', 350000000, 3),
('XE36', 'xe36.jpg', 'Audi R8', 'HX04', 'Xanh dương', 'Công nghệ hiệu suất cao', 600000000, 2),
('XE37', 'xe37.jpg', 'Audi Q8', 'HX04', 'Vàng', 'Công nghệ SUV cao cấp', 550000000, 1),
('XE38', 'xe38.jpg', 'Audi e-tron', 'HX04', 'Trắng', 'Công nghệ điện', 700000000, 1),
('XE39', 'xe39.jpg', 'Audi Q3', 'HX04', 'Đen', 'Công nghệ nhỏ gọn', 160000000, 7),

-- Mercedes-Benz
('XE40', 'xe40.jpg', 'Mercedes-Benz C-Class', 'HX05', 'Đen', 'Công nghệ an toàn', 200000000, 10),
('XE41', 'xe41.jpg', 'Mercedes-Benz E-Class', 'HX05', 'Bạc', 'Công nghệ tự động', 250000000, 8),
('XE42', 'xe42.jpg', 'Mercedes-Benz S-Class', 'HX05', 'Trắng', 'Công nghệ sang trọng', 400000000, 5),
('XE43', 'xe43.jpg', 'Mercedes-Benz GLE', 'HX05', 'Đỏ', 'Công nghệ SUV', 300000000, 6),
('XE44', 'xe44.jpg', 'Mercedes-Benz GLC', 'HX05', 'Xanh', 'Công nghệ hiệu suất cao', 280000000, 4),
('XE45', 'xe45.jpg', 'Mercedes-Benz A-Class', 'HX05', 'Xám', 'Công nghệ nhỏ gọn', 280000000, 7),
('XE46', 'xe46.jpg', 'Mercedes-Benz CLA', 'HX05', 'Vàng', 'Công nghệ thể thao', 220000000, 3),
('XE47', 'xe47.jpg', 'Mercedes-Benz EQC', 'HX05', 'Đen', 'Công nghệ điện', 600000000, 2),
('XE48', 'xe48.jpg', 'Mercedes-Benz G-Class', 'HX05', 'Bạc', 'Công nghệ SUV cao cấp', 700000000, 1),
('XE49', 'xe49.jpg', 'Mercedes-Benz SL-Class', 'HX05', 'Trắng', 'Công nghệ thể thao', 800000000, 1),
('XE50', 'xe50.jpg', 'Mercedes-Benz GLS', 'HX05', 'Đỏ', 'Công nghệ SUV', 750000000, 1),
('XE51', 'xe51.jpg', 'Mercedes-Benz GLA', 'HX05', 'Xanh', 'Công nghệ nhỏ gọn', 650000000, 1),
('XE52', 'xe52.jpg', 'Mercedes-Benz EQS', 'HX05', 'Vàng', 'Công nghệ điện', 950000000, 1),
('XE53', 'xe53.jpg', 'Mercedes-Benz Citan', 'HX05', 'Đen', 'Công nghệ hiệu suất cao', 550000000, 1),
('XE54', 'xe54.jpg', 'Mercedes-Benz V-Class', 'HX05', 'Bạc', 'Công nghệ sang trọng', 750000000, 1),

-- Roll-Royce
('XE55', 'xe55.jpg', 'Roll-Royce Phantom', 'HX06', 'Trắng', 'Công nghệ sang trọng', 1000000000, 3),
('XE56', 'xe56.jpg', 'Roll-Royce Cullinan', 'HX06', 'Đen', 'Công nghệ SUV cao cấp', 1200000000, 2),
('XE57', 'xe57.jpg', 'Roll-Royce Ghost', 'HX06', 'Bạc', 'Công nghệ đẳng cấp', 1300000000, 1),
('XE58', 'xe58.jpg', 'Roll-Royce Wraith', 'HX06', 'Đỏ', 'Công nghệ thể thao', 1500000000, 1),
('XE59', 'xe59.jpg', 'Roll-Royce Dawn', 'HX06', 'Xanh', 'Công nghệ mui trần', 1400000000, 1),
('XE60', 'xe60.jpg', 'Roll-Royce Silver Ghost', 'HX06', 'Xanh dương', 'Công nghệ cổ điển', 1600000000, 1),
('XE61', 'xe61.jpg', 'Roll-Royce Sweptail', 'HX06', 'Vàng', 'Công nghệ độc quyền', 2000000000, 1),
('XE62', 'xe62.jpg', 'Roll-Royce Black Badge', 'HX06', 'Xám', 'Công nghệ giới hạn', 1700000000, 1),
('XE63', 'xe63.jpg', 'Roll-Royce Phantom II', 'HX06', 'Trắng', 'Công nghệ sang trọng', 1800000000, 1),
('XE64', 'xe64.jpg', 'Roll-Royce Dawn Black Badge', 'HX06', 'Đen', 'Công nghệ độc quyền', 1900000000, 1),

-- Ferrari
('XE65', 'xe65.jpg', 'Ferrari 488', 'HX07', 'Đen', 'Công nghệ V8', 2500000000, 5),
('XE66', 'xe66.jpg', 'Ferrari F8', 'HX07', 'Đỏ', 'Công nghệ thể thao', 3000000000, 3),
('XE67', 'xe67.jpg', 'Ferrari Roma', 'HX07', 'Trắng', 'Công nghệ mới', 2800000000, 4),
('XE68', 'xe68.jpg', 'Ferrari SF90', 'HX07', 'Xanh', 'Công nghệ hybrid', 3500000000, 2),
('XE69', 'xe69.jpg', 'Ferrari LaFerrari', 'HX07', 'Xám', 'Công nghệ hiệu suất cao', 4000000000, 1),
('XE70', 'xe70.jpg', 'Ferrari Portofino', 'HX07', 'Vàng', 'Công nghệ mui trần', 3200000000, 2),
('XE71', 'xe71.jpg', 'Ferrari 812', 'HX07', 'Đen', 'Công nghệ động cơ V12', 4500000000, 2),
('XE72', 'xe72.jpg', 'Ferrari F12', 'HX07', 'Bạc', 'Công nghệ thể thao', 4800000000, 1),
('XE73', 'xe73.jpg', 'Ferrari 348', 'HX07', 'Đỏ', 'Công nghệ cổ điển', 1500000000, 1),
('XE74', 'xe74.jpg', 'Ferrari 599', 'HX07', 'Xanh dương', 'Công nghệ thể thao', 1700000000, 1),
('XE75', 'xe75.jpg', 'Ferrari 458', 'HX07', 'Trắng', 'Công nghệ hiệu suất cao', 4300000000, 1),
('XE76', 'xe76.jpg', 'Ferrari California', 'HX07', 'Đen', 'Công nghệ mui trần', 2500000000, 1);

-- -----------------------------------------------
-- -----------------------------------------------
-- -----------------------------------------------
-- VÌ MÔ TẢ CHIẾM KHÁ NHIỀU DÒNG DỮ LIỆU NÊN KHÔNG INSERT Ở ĐÂY! 
-- CHẠY FILE database/Insert_MoTa_BH.PHP ĐỂ THÊM DỮ LIỆU MÔ TẢ VÀ THỜI GIAN BẢO HÀNH CHO CÁC XE TRÊN
-- -----------------------------------------------
-- -----------------------------------------------
-- -----------------------------------------------


INSERT INTO ThongSoKyThuat (MaXe, MauNgoaiThat, MauNoiThat, SoXiLanh, DungTich, ChieuDai, ChieuRong, ChieuCao, KhoiLuong, TrongLuongToiDa, TocDoToiDa, SoCua, SoChoNgoi, HopSo, NamSanXuat, DongCo)
VALUES
('XE01', 'Đen', 'Đen', 6, '3.0L', '4794 mm', '1903 mm', '1432 mm', '1725 kg', '2245 kg', '280 km/h', 4, 5, 'Tự động', 2023, 'Xăng'),  -- BMW M3
('XE02', 'Trắng', 'Nâu', 6, '3.0L', '4922 mm', '2004 mm', '1745 mm', '2135 kg', '2860 kg', '243 km/h', 5, 5, 'Tự động', 2023, 'Xăng'),  -- BMW X5
('XE03', 'Bạc', 'Đen', 8, '4.4L', '5260 mm', '1902 mm', '1479 mm', '2180 kg', '2740 kg', '250 km/h', 4, 5, 'Tự động', 2023, 'Xăng'),  -- BMW 7 Series
('XE04', 'Đỏ', 'Đen', 4, '2.0L', '4324 mm', '1864 mm', '1304 mm', '1490 kg', '1860 kg', '250 km/h', 2, 2, 'Tự động', 2023, 'Xăng'),  -- BMW Z4
('XE05', 'Xanh', 'Trắng', 3, '1.5L', '4689 mm', '1942 mm', '1291 mm', '1595 kg', '1920 kg', '250 km/h', 2, 4, 'Tự động', 2023, 'Hybrid'),  -- BMW i8
('XE06', 'Xám', 'Đen', 6, '3.0L', '4794 mm', '1887 mm', '1393 mm', '1725 kg', '2155 kg', '290 km/h', 2, 4, 'Tự động', 2023, 'Xăng'),  -- BMW M4
('XE07', 'Đen', 'Nâu', 4, '2.0L', '4708 mm', '1891 mm', '1676 mm', '1790 kg', '2400 kg', '235 km/h', 5, 5, 'Tự động', 2023, 'Xăng'),  -- BMW X3
('XE08', 'Trắng', 'Đen', 8, '4.0L', '5112 mm', '2016 mm', '1638 mm', '2200 kg', '2750 kg', '305 km/h', 5, 5, 'Tự động', 2023, 'Xăng'),  -- Lamborghini Urus
('XE09', 'Bạc', 'Đen', 8, '4.4L', '4983 mm', '1903 mm', '1473 mm', '1970 kg', '2440 kg', '305 km/h', 4, 5, 'Tự động', 2023, 'Xăng'),  -- BMW M5
('XE10', 'Đỏ', 'Đen', 4, '2.0L', '4709 mm', '1827 mm', '1442 mm', '1545 kg', '2050 kg', '250 km/h', 4, 5, 'Tự động', 2023, 'Xăng'),  -- BMW 3 Series
('XE11', 'Đen', 'Đen', 6, '3.0L', '4794 mm', '1903 mm', '1432 mm', '1725 kg', '2245 kg', '280 km/h', 4, 5, 'Sàn', 2021, 'Xăng'),  
('XE12', 'Trắng', 'Nâu', 6, '3.0L', '4922 mm', '2004 mm', '1745 mm', '2135 kg', '2860 kg', '243 km/h', 5, 5, 'Tự động', 2022, 'Xăng'),  
('XE13', 'Bạc', 'Đen', 8, '4.4L', '5260 mm', '1902 mm', '1479 mm', '2180 kg', '2740 kg', '250 km/h', 4, 5, 'Sàn', 2020, 'Xăng'),  
('XE14', 'Đỏ', 'Đen', 4, '2.0L', '4324 mm', '1864 mm', '1304 mm', '1490 kg', '1860 kg', '250 km/h', 2, 2, 'Tự động', 2023, 'Xăng'),  
('XE15', 'Xanh', 'Trắng', 3, '1.5L', '4689 mm', '1942 mm', '1291 mm', '1595 kg', '1920 kg', '250 km/h', 2, 4, 'Tự động', 2022, 'Hybrid'),  
('XE16', 'Xám', 'Đen', 6, '3.0L', '4794 mm', '1887 mm', '1393 mm', '1725 kg', '2155 kg', '290 km/h', 2, 4, 'Sàn', 2021, 'Xăng'),  
('XE17', 'Đen', 'Nâu', 4, '2.0L', '4708 mm', '1891 mm', '1676 mm', '1790 kg', '2400 kg', '235 km/h', 5, 5, 'Tự động', 2020, 'Xăng'),  
('XE18', 'Trắng', 'Đen', 8, '4.0L', '5112 mm', '2016 mm', '1638 mm', '2200 kg', '2750 kg', '305 km/h', 5, 5, 'Sàn', 2023, 'Xăng'),  
('XE19', 'Bạc', 'Đen', 8, '4.4L', '4983 mm', '1903 mm', '1473 mm', '1970 kg', '2440 kg', '305 km/h', 4, 5, 'Tự động', 2021, 'Xăng'),  
('XE20', 'Đỏ', 'Đen', 4, '2.0L', '4709 mm', '1827 mm', '1442 mm', '1545 kg', '2050 kg', '250 km/h', 4, 5, 'Sàn', 2022, 'Xăng'),  
('XE21', 'Đen', 'Đen', 6, '3.0L', '4794 mm', '1903 mm', '1432 mm', '1725 kg', '2245 kg', '280 km/h', 4, 5, 'Tự động', 2023, 'Xăng'),  
('XE22', 'Trắng', 'Nâu', 6, '3.0L', '4922 mm', '2004 mm', '1745 mm', '2135 kg', '2860 kg', '243 km/h', 5, 5, 'Sàn', 2020, 'Xăng'),  
('XE23', 'Bạc', 'Đen', 8, '4.4L', '5260 mm', '1902 mm', '1479 mm', '2180 kg', '2740 kg', '250 km/h', 4, 5, 'Tự động', 2021, 'Xăng'),  
('XE24', 'Đỏ', 'Đen', 4, '2.0L', '4324 mm', '1864 mm', '1304 mm', '1490 kg', '1860 kg', '250 km/h', 2, 2, 'Sàn', 2022, 'Xăng'),  
('XE25', 'Xanh', 'Trắng', 3, '1.5L', '4689 mm', '1942 mm', '1291 mm', '1595 kg', '1920 kg', '250 km/h', 2, 4, 'Tự động', 2023, 'Hybrid'),  
('XE26', 'Xám', 'Đen', 6, '3.0L', '4794 mm', '1887 mm', '1393 mm', '1725 kg', '2155 kg', '290 km/h', 2, 4, 'Sàn', 2020, 'Xăng'),  
('XE27', 'Đen', 'Nâu', 4, '2.0L', '4708 mm', '1891 mm', '1676 mm', '1790 kg', '2400 kg', '235 km/h', 5, 5, 'Tự động', 2021, 'Xăng'),  
('XE28', 'Trắng', 'Đen', 8, '4.0L', '5112 mm', '2016 mm', '1638 mm', '2200 kg', '2750 kg', '305 km/h', 5, 5, 'Sàn', 2022, 'Xăng'),  
('XE29', 'Bạc', 'Đen', 8, '4.4L', '4983 mm', '1903 mm', '1473 mm', '1970 kg', '2440 kg', '305 km/h', 4, 5, 'Tự động', 2023, 'Xăng'),  
('XE30', 'Đỏ', 'Đen', 4, '2.0L', '4709 mm', '1827 mm', '1442 mm', '1545 kg', '2050 kg', '250 km/h', 4, 5, 'Sàn', 2020, 'Xăng'),  
('XE31', 'Đen', 'Đen', 6, '3.0L', '4794 mm', '1903 mm', '1432 mm', '1725 kg', '2245 kg', '280 km/h', 4, 5, 'Tự động', 2021, 'Xăng'),  
('XE32', 'Trắng', 'Nâu', 6, '3.0L', '4922 mm', '2004 mm', '1745 mm', '2135 kg', '2860 kg', '243 km/h', 5, 5, 'Sàn', 2022, 'Xăng'),  
('XE33', 'Bạc', 'Đen', 8, '4.4L', '5260 mm', '1902 mm', '1479 mm', '2180 kg', '2740 kg', '250 km/h', 4, 5, 'Tự động', 2023, 'Xăng'),  
('XE34', 'Đỏ', 'Đen', 4, '2.0L', '4324 mm', '1864 mm', '1304 mm', '1490 kg', '1860 kg', '250 km/h', 2, 2, 'Sàn', 2020, 'Xăng'),  
('XE35', 'Xanh', 'Trắng', 3, '1.5L', '4689 mm', '1942 mm', '1291 mm', '1595 kg', '1920 kg', '250 km/h', 2, 4, 'Tự động', 2021, 'Hybrid'),  
('XE36', 'Xám', 'Đen', 6, '3.0L', '4794 mm', '1887 mm', '1393 mm', '1725 kg', '2155 kg', '290 km/h', 2, 4, 'Sàn', 2022, 'Xăng'),  
('XE37', 'Đen', 'Nâu', 4, '2.0L', '4708 mm', '1891 mm', '1676 mm', '1790 kg', '2400 kg', '235 km/h', 5, 5, 'Tự động', 2023, 'Xăng'),  
('XE38', 'Trắng', 'Đen', 8, '4.0L', '5112 mm', '2016 mm', '1638 mm', '2200 kg', '2750 kg', '305 km/h', 5, 5, 'Sàn', 2020, 'Xăng'),  
('XE39', 'Bạc', 'Đen', 8, '4.4L', '4983 mm', '1903 mm', '1473 mm', '1970 kg', '2440 kg', '305 km/h', 4, 5, 'Tự động', 2021, 'Xăng'),  
('XE40', 'Đỏ', 'Đen', 4, '2.0L', '4709 mm', '1827 mm', '1442 mm', '1545 kg', '2050 kg', '250 km/h', 4, 5, 'Sàn', 2022, 'Xăng'),  
('XE41', 'Đen', 'Đen', 6, '3.0L', '4794 mm', '1903 mm', '1432 mm', '1725 kg', '2245 kg', '280 km/h', 4, 5, 'Tự động', 2023, 'Xăng'),  
('XE42', 'Trắng', 'Nâu', 6, '3.0L', '4922 mm', '2004 mm', '1745 mm', '2135 kg', '2860 kg', '243 km/h', 5, 5, 'Sàn', 2020, 'Xăng'),  
('XE43', 'Bạc', 'Đen', 8, '4.4L', '5260 mm', '1902 mm', '1479 mm', '2180 kg', '2740 kg', '250 km/h', 4, 5, 'Tự động', 2021, 'Xăng'),  
('XE44', 'Đỏ', 'Đen', 4, '2.0L', '4324 mm', '1864 mm', '1304 mm', '1490 kg', '1860 kg', '250 km/h', 2, 2, 'Sàn', 2022, 'Xăng'),  
('XE45', 'Xanh', 'Trắng', 3, '1.5L', '4689 mm', '1942 mm', '1291 mm', '1595 kg', '1920 kg', '250 km/h', 2, 4, 'Tự động', 2023, 'Hybrid'),  
('XE46', 'Xám', 'Đen', 6, '3.0L', '4794 mm', '1887 mm', '1393 mm', '1725 kg', '2155 kg', '290 km/h', 2, 4, 'Sàn', 2020, 'Xăng'),  
('XE47', 'Đen', 'Nâu', 4, '2.0L', '4708 mm', '1891 mm', '1676 mm', '1790 kg', '2400 kg', '235 km/h', 5, 5, 'Tự động', 2021, 'Xăng'),  
('XE48', 'Trắng', 'Đen', 8, '4.0L', '5112 mm', '2016 mm', '1638 mm', '2200 kg', '2750 kg', '305 km/h', 5, 5, 'Sàn', 2022, 'Xăng'),  
('XE49', 'Bạc', 'Đen', 8, '4.4L', '4983 mm', '1903 mm', '1473 mm', '1970 kg', '2440 kg', '305 km/h', 4, 5, 'Tự động', 2023, 'Xăng'),  
('XE50', 'Đỏ', 'Đen', 4, '2.0L', '4709 mm', '1827 mm', '1442 mm', '1545 kg', '2050 kg', '250 km/h', 4, 5, 'Sàn', 2020, 'Xăng'),  
('XE51', 'Đen', 'Đen', 6, '3.0L', '4794 mm', '1903 mm', '1432 mm', '1725 kg', '2245 kg', '280 km/h', 4, 5, 'Tự động', 2021, 'Xăng'),  
('XE52', 'Trắng', 'Nâu', 6, '3.0L', '4922 mm', '2004 mm', '1745 mm', '2135 kg', '2860 kg', '243 km/h', 5, 5, 'Sàn', 2022, 'Xăng'),  
('XE53', 'Bạc', 'Đen', 8, '4.4L', '5260 mm', '1902 mm', '1479 mm', '2180 kg', '2740 kg', '250 km/h', 4, 5, 'Tự động', 2023, 'Xăng'),  
('XE54', 'Đỏ', 'Đen', 4, '2.0L', '4324 mm', '1864 mm', '1304 mm', '1490 kg', '1860 kg', '250 km/h', 2, 2, 'Sàn', 2020, 'Xăng'),  
('XE55', 'Xanh', 'Trắng', 3, '1.5L', '4689 mm', '1942 mm', '1291 mm', '1595 kg', '1920 kg', '250 km/h', 2, 4, 'Tự động', 2021, 'Hybrid'),  
('XE56', 'Xám', 'Đen', 6, '3.0L', '4794 mm', '1887 mm', '1393 mm', '1725 kg', '2155 kg', '290 km/h', 2, 4, 'Sàn', 2022, 'Xăng'),  
('XE57', 'Đen', 'Nâu', 4, '2.0L', '4708 mm', '1891 mm', '1676 mm', '1790 kg', '2400 kg', '235 km/h', 5, 5, 'Tự động', 2023, 'Xăng'),  
('XE58', 'Trắng', 'Đen', 8, '4.0L', '5112 mm', '2016 mm', '1638 mm', '2200 kg', '2750 kg', '305 km/h', 5, 5, 'Sàn', 2020, 'Xăng'),  
('XE59', 'Bạc', 'Đen', 8, '4.4L', '4983 mm', '1903 mm', '1473 mm', '1970 kg', '2440 kg', '305 km/h', 4, 5, 'Tự động', 2021, 'Xăng'),  
('XE60', 'Đỏ', 'Đen', 4, '2.0L', '4709 mm', '1827 mm', '1442 mm', '1545 kg', '2050 kg', '250 km/h', 4, 5, 'Sàn', 2022, 'Xăng'),  
('XE61', 'Đen', 'Đen', 6, '3.0L', '4794 mm', '1903 mm', '1432 mm', '1725 kg', '2245 kg', '280 km/h', 4, 5, 'Tự động', 2023, 'Xăng'),  
('XE62', 'Trắng', 'Nâu', 6, '3.0L', '4922 mm', '2004 mm', '1745 mm', '2135 kg', '2860 kg', '243 km/h', 5, 5, 'Sàn', 2020, 'Xăng'),  
('XE63', 'Bạc', 'Đen', 8, '4.4L', '5260 mm', '1902 mm', '1479 mm', '2180 kg', '2740 kg', '250 km/h', 4, 5, 'Tự động', 2021, 'Xăng'),  
('XE64', 'Đỏ', 'Đen', 4, '2.0L', '4324 mm', '1864 mm', '1304 mm', '1490 kg', '1860 kg', '250 km/h', 2, 2, 'Sàn', 2022, 'Xăng'),  
('XE65', 'Xanh', 'Trắng', 3, '1.5L', '4689 mm', '1942 mm', '1291 mm', '1595 kg', '1920 kg', '250 km/h', 2, 4, 'Tự động', 2023, 'Hybrid'),  
('XE66', 'Xám', 'Đen', 6, '3.0L', '4794 mm', '1887 mm', '1393 mm', '1725 kg', '2155 kg', '290 km/h', 2, 4, 'Sàn', 2020, 'Xăng'),  
('XE67', 'Đen', 'Nâu', 4, '2.0L', '4708 mm', '1891 mm', '1676 mm', '1790 kg', '2400 kg', '235 km/h', 5, 5, 'Tự động', 2021, 'Xăng'),  
('XE68', 'Trắng', 'Đen', 8, '4.0L', '5112 mm', '2016 mm', '1638 mm', '2200 kg', '2750 kg', '305 km/h', 5, 5, 'Sàn', 2022, 'Xăng'),  
('XE69', 'Bạc', 'Đen', 8, '4.4L', '4983 mm', '1903 mm', '1473 mm', '1970 kg', '2440 kg', '305 km/h', 4, 5, 'Tự động', 2023, 'Xăng'),  
('XE70', 'Đỏ', 'Đen', 4, '2.0L', '4709 mm', '1827 mm', '1442 mm', '1545 kg', '2050 kg', '250 km/h', 4, 5, 'Sàn', 2020, 'Xăng'),  
('XE71', 'Đen', 'Đen', 6, '3.0L', '4794 mm', '1903 mm', '1432 mm', '1725 kg', '2245 kg', '280 km/h', 4, 5, 'Tự động', 2021, 'Xăng'),  
('XE72', 'Trắng', 'Nâu', 6, '3.0L', '4922 mm', '2004 mm', '1745 mm', '2135 kg', '2860 kg', '243 km/h', 5, 5, 'Sàn', 2022, 'Xăng'),  
('XE73', 'Bạc', 'Đen', 8, '4.4L', '5260 mm', '1902 mm', '1479 mm', '2180 kg', '2740 kg', '250 km/h', 4, 5, 'Tự động', 2023, 'Xăng'),  
('XE74', 'Đỏ', 'Đen', 4, '2.0L', '4324 mm', '1864 mm', '1304 mm', '1490 kg', '1860 kg', '250 km/h', 2, 2, 'Sàn', 2020, 'Xăng'),  
('XE75', 'Xanh', 'Trắng', 3, '1.5L', '4689 mm', '1942 mm', '1291 mm', '1595 kg', '1920 kg', '250 km/h', 2, 4, 'Tự động', 2021, 'Hybrid'),  
('XE76', 'Xám', 'Đen', 6, '3.0L', '4794 mm', '1887 mm', '1393 mm', '1725 kg', '2155 kg', '290 km/h', 2, 4, 'Sàn', 2022, 'Xăng');

-- INSERT cho bảng HinhAnhXe (hình ảnh phụ cho xe)
INSERT INTO HinhAnhXe (MaXe, TenHinh)
VALUES
('XE01', 'xe01_02.jpg'),('XE01', 'xe01_03.jpg'),('XE01', 'xe01_04.jpg'),('XE01', 'xe01_05.jpg'),
('XE02', 'xe02_02.jpg'),('XE02', 'xe02_03.jpg'),('XE02', 'xe02_04.jpg'),('XE02', 'xe02_05.jpg'),('XE03', 'xe03_02.jpg'), 
('XE03', 'xe03_03.jpg'),('XE03', 'xe03_04.jpg'),('XE03', 'xe03_05.jpg'),('XE04', 'xe04_02.jpg'),('XE04', 'xe04_03.jpg'),
('XE04', 'xe04_04.jpg'),('XE04', 'xe04_05.jpg'),('XE05', 'xe05_02.jpg'),('XE05', 'xe05_03.jpg'),('XE05', 'xe05_04.jpg'),
('XE05', 'xe05_05.jpg'),('XE06', 'xe06_02.jpg'),('XE06', 'xe06_03.jpg'),('XE06', 'xe06_04.jpg'),('XE06', 'xe06_05.jpg'),
('XE07', 'xe07_02.jpg'),('XE07', 'xe07_03.jpg'),('XE07', 'xe07_04.jpg'),('XE07', 'xe07_05.jpg'),('XE08', 'xe08_02.jpg'), 
('XE08', 'xe08_03.jpg'),('XE08', 'xe08_04.jpg'),('XE08', 'xe08_05.jpg'),('XE09', 'xe09_02.jpg'),('XE09', 'xe09_03.jpg'),
('XE09', 'xe09_04.jpg'),('XE09', 'xe09_05.jpg'),('XE10', 'xe10_02.jpg'),('XE10', 'xe10_03.jpg'),('XE10', 'xe10_04.jpg'),
('XE10', 'xe10_05.jpg'),('XE11', 'xe11_02.jpg'),('XE11', 'xe11_03.jpg'),('XE11', 'xe11_04.jpg'),('XE11', 'xe11_05.jpg'),
('XE12', 'xe12_02.jpg'),('XE12', 'xe12_03.jpg'),('XE12', 'xe12_04.jpg'),('XE12', 'xe12_05.jpg'),('XE13', 'xe13_02.jpg'), 
('XE13', 'xe13_03.jpg'),('XE13', 'xe13_04.jpg'),('XE13', 'xe13_05.jpg'),('XE14', 'xe14_02.jpg'),('XE14', 'xe14_03.jpg'),
('XE14', 'xe14_04.jpg'),('XE14', 'xe14_05.jpg'),('XE15', 'xe15_02.jpg'),('XE15', 'xe15_03.jpg'),('XE15', 'xe15_04.jpg'),
('XE15', 'xe15_05.jpg'),('XE16', 'xe16_02.jpg'),('XE16', 'xe16_03.jpg'),('XE16', 'xe16_04.jpg'),('XE16', 'xe16_05.jpg'),
('XE17', 'xe17_02.jpg'),('XE17', 'xe17_03.jpg'),('XE17', 'xe17_04.jpg'),('XE17', 'xe17_05.jpg'),('XE18', 'xe18_02.jpg'), 
('XE18', 'xe18_03.jpg'),('XE18', 'xe18_04.jpg'),('XE18', 'xe18_05.jpg'),('XE19', 'xe19_02.jpg'),('XE19', 'xe19_03.jpg'),
('XE19', 'xe19_04.jpg'),('XE19', 'xe19_05.jpg'),('XE20', 'xe20_02.jpg'),('XE20', 'xe20_03.jpg'),('XE20', 'xe20_04.jpg'),
('XE20', 'xe20_05.jpg'),('XE21', 'xe21_02.jpg'),('XE21', 'xe21_03.jpg'),('XE21', 'xe21_04.jpg'),('XE21', 'xe21_05.jpg'),
('XE22', 'xe22_02.jpg'),('XE22', 'xe22_03.jpg'),('XE22', 'xe22_04.jpg'),('XE22', 'xe22_05.jpg'),('XE23', 'xe23_02.jpg'), 
('XE23', 'xe23_03.jpg'),('XE23', 'xe23_04.jpg'),('XE23', 'xe23_05.jpg'),('XE24', 'xe24_02.jpg'),('XE24', 'xe24_03.jpg'),
('XE24', 'xe24_04.jpg'),('XE24', 'xe24_05.jpg'),('XE25', 'xe25_02.jpg'),('XE25', 'xe25_03.jpg'),('XE25', 'xe25_04.jpg'),
('XE25', 'xe25_05.jpg'),('XE26', 'xe26_02.jpg'),('XE26', 'xe26_03.jpg'),('XE26', 'xe26_04.jpg'),('XE26', 'xe26_05.jpg'),
('XE27', 'xe27_02.jpg'),('XE27', 'xe27_03.jpg'),('XE27', 'xe27_04.jpg'),('XE27', 'xe27_05.jpg'),('XE28', 'xe28_02.jpg'),
('XE28', 'xe28_03.jpg'),('XE28', 'xe28_04.jpg'),('XE28', 'xe28_05.jpg'),('XE29', 'xe29_02.jpg'),('XE29', 'xe29_03.jpg'),
('XE29', 'xe29_04.jpg'),('XE29', 'xe29_05.jpg'),('XE30', 'xe30_02.jpg'),('XE30', 'xe30_03.jpg'),('XE30', 'xe30_04.jpg'),
('XE30', 'xe30_05.jpg'),('XE31', 'xe31_02.jpg'),('XE31', 'xe31_03.jpg'),('XE31', 'xe31_04.jpg'),('XE31', 'xe31_05.jpg'),
('XE32', 'xe32_02.jpg'),('XE32', 'xe32_03.jpg'),('XE32', 'xe32_04.jpg'),('XE32', 'xe32_05.jpg'),('XE33', 'xe33_02.jpg'), 
('XE33', 'xe33_03.jpg'),('XE33', 'xe33_04.jpg'),('XE33', 'xe33_05.jpg'),('XE34', 'xe34_02.jpg'),('XE34', 'xe34_03.jpg'),
('XE34', 'xe34_04.jpg'),('XE34', 'xe34_05.jpg'),('XE35', 'xe35_02.jpg'),('XE35', 'xe35_03.jpg'),('XE35', 'xe35_04.jpg'),
('XE35', 'xe35_05.jpg'),('XE36', 'xe36_02.jpg'),('XE36', 'xe36_03.jpg'),('XE36', 'xe36_04.jpg'),('XE36', 'xe36_05.jpg'),
('XE37', 'xe37_02.jpg'),('XE37', 'xe37_03.jpg'),('XE37', 'xe37_04.jpg'),('XE37', 'xe37_05.jpg'),('XE38', 'xe38_02.jpg'), 
('XE38', 'xe38_03.jpg'),('XE38', 'xe38_04.jpg'),('XE38', 'xe38_05.jpg'),('XE39', 'xe39_02.jpg'),('XE39', 'xe39_03.jpg'),
('XE39', 'xe39_04.jpg'),('XE39', 'xe39_05.jpg'),('XE40', 'xe40_02.jpg'),('XE40', 'xe40_03.jpg'),('XE40', 'xe40_04.jpg'),
('XE40', 'xe40_05.jpg'),('XE41', 'xe41_02.jpg'),('XE41', 'xe41_03.jpg'),('XE41', 'xe41_04.jpg'),('XE41', 'xe41_05.jpg'),
('XE42', 'xe42_02.jpg'),('XE42', 'xe42_03.jpg'),('XE42', 'xe42_04.jpg'),('XE42', 'xe42_05.jpg'),('XE43', 'xe43_02.jpg'), 
('XE43', 'xe43_03.jpg'),('XE43', 'xe43_04.jpg'),('XE43', 'xe43_05.jpg'),('XE44', 'xe44_02.jpg'),('XE44', 'xe44_03.jpg'),
('XE44', 'xe44_04.jpg'),('XE44', 'xe44_05.jpg'),('XE45', 'xe45_02.jpg'),('XE45', 'xe45_03.jpg'),('XE45', 'xe45_04.jpg'),
('XE45', 'xe45_05.jpg'),('XE46', 'xe46_02.jpg'),('XE46', 'xe46_03.jpg'),('XE46', 'xe46_04.jpg'),('XE46', 'xe46_05.jpg'),
('XE47', 'xe47_02.jpg'),('XE47', 'xe47_03.jpg'),('XE47', 'xe47_04.jpg'),('XE47', 'xe47_05.jpg'),('XE48', 'xe48_02.jpg'), 
('XE48', 'xe48_03.jpg'),('XE48', 'xe48_04.jpg'),('XE48', 'xe48_05.jpg'),('XE49', 'xe49_02.jpg'),('XE49', 'xe49_03.jpg'),
('XE49', 'xe49_04.jpg'),('XE49', 'xe49_05.jpg'),('XE50', 'xe50_02.jpg'),('XE50', 'xe50_03.jpg'),('XE50', 'xe50_04.jpg'),
('XE50', 'xe50_05.jpg'),('XE51', 'xe51_02.jpg'),('XE51', 'xe51_03.jpg'),('XE51', 'xe51_04.jpg'),('XE51', 'xe51_05.jpg'),
('XE52', 'xe52_02.jpg'),('XE52', 'xe52_03.jpg'),('XE52', 'xe52_04.jpg'),('XE52', 'xe52_05.jpg'),('XE53', 'xe53_02.jpg'), 
('XE53', 'xe53_03.jpg'),('XE53', 'xe53_04.jpg'),('XE53', 'xe53_05.jpg'),('XE54', 'xe54_02.jpg'),('XE54', 'xe54_03.jpg'),
('XE54', 'xe54_04.jpg'),('XE54', 'xe54_05.jpg'),('XE55', 'xe55_02.jpg'),('XE55', 'xe55_03.jpg'),('XE55', 'xe55_04.jpg'),
('XE55', 'xe55_05.jpg'),('XE56', 'xe56_02.jpg'),('XE56', 'xe56_03.jpg'),('XE56', 'xe56_04.jpg'),('XE56', 'xe56_05.jpg'),
('XE57', 'xe57_02.jpg'),('XE57', 'xe57_03.jpg'),('XE57', 'xe57_04.jpg'),('XE57', 'xe57_05.jpg'),('XE58', 'xe58_02.jpg'), 
('XE58', 'xe58_03.jpg'),('XE58', 'xe58_04.jpg'),('XE58', 'xe58_05.jpg'),('XE59', 'xe59_02.jpg'),('XE59', 'xe59_03.jpg'),
('XE59', 'xe59_04.jpg'),('XE59', 'xe59_05.jpg'),('XE60', 'xe60_02.jpg'),('XE60', 'xe60_03.jpg'),('XE60', 'xe60_04.jpg'),
('XE60', 'xe60_05.jpg'),('XE61', 'xe61_02.jpg'),('XE61', 'xe61_03.jpg'),('XE61', 'xe61_04.jpg'),('XE61', 'xe61_05.jpg'),
('XE62', 'xe62_02.jpg'),('XE62', 'xe62_03.jpg'),('XE62', 'xe62_04.jpg'),('XE62', 'xe62_05.jpg'),('XE63', 'xe63_02.jpg'), 
('XE63', 'xe63_03.jpg'),('XE63', 'xe63_04.jpg'),('XE63', 'xe63_05.jpg'),('XE64', 'xe64_02.jpg'),('XE64', 'xe64_03.jpg'),
('XE64', 'xe64_04.jpg'),('XE64', 'xe64_05.jpg'),('XE65', 'xe65_02.jpg'),('XE65', 'xe65_03.jpg'),('XE65', 'xe65_04.jpg'),
('XE65', 'xe65_05.jpg'),('XE66', 'xe66_02.jpg'),('XE66', 'xe66_03.jpg'),('XE66', 'xe66_04.jpg'),('XE66', 'xe66_05.jpg'),
('XE67', 'xe67_02.jpg'),('XE67', 'xe67_03.jpg'),('XE67', 'xe67_04.jpg'),('XE67', 'xe67_05.jpg'),('XE68', 'xe68_02.jpg'), 
('XE68', 'xe68_03.jpg'),('XE68', 'xe68_04.jpg'),('XE68', 'xe68_05.jpg'),('XE69', 'xe69_02.jpg'),('XE69', 'xe69_03.jpg'),
('XE69', 'xe69_04.jpg'),('XE69', 'xe69_05.jpg'),('XE70', 'xe70_02.jpg'),('XE70', 'xe70_03.jpg'),('XE70', 'xe70_04.jpg'),
('XE70', 'xe70_05.jpg'),('XE71', 'xe71_02.jpg'),('XE71', 'xe71_03.jpg'),('XE71', 'xe71_04.jpg'),('XE71', 'xe71_05.jpg'),
('XE72', 'xe72_02.jpg'),('XE72', 'xe72_03.jpg'),('XE72', 'xe72_04.jpg'),('XE72', 'xe72_05.jpg'),('XE73', 'xe73_02.jpg'),
('XE73', 'xe73_03.jpg'),('XE73', 'xe73_04.jpg'),('XE73', 'xe73_05.jpg'),('XE74', 'xe74_02.jpg'),('XE74', 'xe74_03.jpg'),
('XE74', 'xe74_04.jpg'),('XE74', 'xe74_05.jpg'),('XE75', 'xe75_02.jpg'),('XE75', 'xe75_03.jpg'),('XE75', 'xe75_04.jpg'),
('XE75', 'xe75_05.jpg'),('XE76', 'xe76_02.jpg'),('XE76', 'xe76_03.jpg'),('XE76', 'xe76_04.jpg'),('XE76', 'xe76_05.jpg'); 

-- INSERT cho bảng DanhGiaBinhLuan
INSERT INTO DanhGiaBinhLuan (MaKH, MaXe, NoiDung, SoSao, NgayDanhGia)
VALUES
('KH01', 'XE01', 'Xe mạnh mẽ, thiết kế đẹp!', 5, '2024-09-20 10:00:00'),
('KH02', 'XE02', 'Rất phù hợp cho gia đình, nhưng giá hơi cao.', 4, '2024-09-21 15:30:00'),
('KH03', 'XE21', 'Trải nghiệm lái tuyệt vời, siêu xe đáng mơ ước!', 5, '2024-09-22 09:15:00');

-- INSERT cho bảng GioHang (giỏ hàng mẫu)
INSERT INTO GioHang (MaKH, MaXe, SoLuong)
VALUES
('KH01', 'XE03', 1), -- KH01 thêm BMW 7 Series
('KH04', 'XE11', 1), -- KH04 thêm Porsche 911
('KH05', 'XE38', 2); -- KH05 thêm 2 Audi e-tron

INSERT INTO HoaDon (MaHD, MaKH, MaNV, NgayLap, TongTien)
VALUES 
('HD01', 'KH01', 'NV02', '2024-09-15', 150000000),
('HD02', 'KH02', 'NV02', '2024-09-16', 300000000),
('HD03', 'KH03', 'NV04', '2024-09-17', 250000000),
('HD04', 'KH04', 'NV04', '2024-05-18', 440000000),
('HD05', 'KH05', 'NV02', '2024-09-01', 660000000),
('HD06', 'KH06', 'NV04', '2024-02-18', 175000000),
('HD07', 'KH07', 'NV02', '2024-09-12', 260000000);

INSERT INTO ChiTietHoaDon (MaHD, MaXe, SoLuong, GiaBan)
VALUES 
('HD01', 'XE01', 1, 150000000),
('HD02', 'XE05', 1, 300000000),
('HD03', 'XE03', 1, 250000000),
('HD04', 'XE06', 2, 220000000),
('HD05', 'XE08', 1, 140000000),
('HD05', 'XE09', 2, 260000000),
('HD06', 'XE10', 1, 175000000),
('HD07', 'XE09', 1, 260000000);

CREATE TABLE `voucher` (
  `MaVC` varchar(20) NOT NULL,
  `TenVC` varchar(50) NOT NULL,
  `GiamGia` int(100) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `NgayHetHan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `voucher`
--

INSERT INTO `voucher` (`MaVC`, `TenVC`, `GiamGia`, `SoLuong`, `NgayHetHan`) VALUES
('VC0001', 'GIAMGIA 10%', 10, 100, '2026-01-01'),
('VC0002', 'Chào Bạn Mới', 5, 10, '2024-01-01');
COMMIT;

-- Cấu trúc bảng cho bảng `thongtingiaohang`
--

CREATE TABLE `thongtingiaohang` (
  `MaHD` varchar(10) NOT NULL,
  `TenKH` varchar(100) NOT NULL,
  `SDT` varchar(13) NOT NULL,
  `DiaChi` varchar(200) NOT NULL,
  `TongTien` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thongtingiaohang`
--

INSERT INTO `thongtingiaohang` (`MaHD`, `TenKH`, `SDT`, `DiaChi`, `TongTien`) VALUES
('HD01', 'theanh', '086863912', '140 Le trong Tan', 675000000),
('HD06', 'theanh', '2', '140 Le trong Tan', 150000000);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `thongtingiaohang`
--
ALTER TABLE `thongtingiaohang`
  ADD KEY `ttgh_fk` (`MaHD`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `thongtingiaohang`
--
ALTER TABLE `thongtingiaohang`
  ADD CONSTRAINT `ttgh_fk` FOREIGN KEY (`MaHD`) REFERENCES `hoadon` (`MaHD`) ON DELETE CASCADE;
COMMIT;