
USE QL_XeHoi;

CREATE TABLE QuyenTruyCap (
    QuyenID INT PRIMARY KEY AUTO_INCREMENT,
    TenQuyen VARCHAR(50) NOT NULL
);

CREATE TABLE NhanVien (
    MaNV VARCHAR(10) PRIMARY KEY,
    HoTenNV VARCHAR(100),
    QueQuan VARCHAR(100),
    NgaySinhNV DATE,
    SoDienThoaiNV VARCHAR(20),
    GioiTinh VARCHAR(10),
    EmailNV VARCHAR(100),
    TaiKhoan VARCHAR(100),
    MatKhau VARCHAR(100),
    QuyenID INT NOT NULL,
    FOREIGN KEY (QuyenID) REFERENCES QuyenTruyCap(QuyenID)
);

CREATE TABLE KhachHang (
    MaKH VARCHAR(10) PRIMARY KEY, 
    HoTenKH VARCHAR(100),
    NgaySinhKH DATE,
    SoDienThoaiKH VARCHAR(20),
    EmailKH VARCHAR(100),
    DiaChi VARCHAR(250)
);

CREATE TABLE HangXe (
    MaHX VARCHAR(10) PRIMARY KEY, 
    TenHX VARCHAR(100),
    DiaChiHX VARCHAR(255),
    SoDienThoaiHX VARCHAR(20),
    EmailHX VARCHAR(100)
);

CREATE TABLE XeHoi (
    MaXe VARCHAR(10) PRIMARY KEY, 
    AnhXe VARCHAR(200),
    TenXe VARCHAR(100),
    MaHX VARCHAR(10),
    FOREIGN KEY (MaHX) REFERENCES HangXe(MaHX) ON DELETE CASCADE,
    MauXe VARCHAR(50),
    CongNghe VARCHAR(200),
    Gia FLOAT,
    SoLuongTonKho INT
);

CREATE TABLE HoaDon (
    MaHD VARCHAR(10) PRIMARY KEY,
    MaKH VARCHAR(10),
    FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH) ON DELETE CASCADE,
    MaNV VARCHAR(10) NOT NULL,
    FOREIGN KEY (MaNV) REFERENCES NhanVien(MaNV) ON DELETE CASCADE,
    NgayLap DATETIME,
    TongTien FLOAT
);

CREATE TABLE ChiTietHoaDon (
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
('Nhân viên bán hàng'),
('Nhân viên thu ngân');

INSERT INTO NhanVien (MaNV, HoTenNV, QueQuan, NgaySinhNV, SoDienThoaiNV, GioiTinh, EmailNV, TaiKhoan, MatKhau, QuyenID)
VALUES 
('NV01', 'Lê Hà Ngọc Thy', 'TP HCM', '2004-11-24', '0912345678', 'Nam', 'nv1@gmail.com', 'nv01', '123', 1),
('NV02', 'Đỗ Trung Dũng', 'Hà Nội', '2004-06-20', '0987654321', 'Nữ', 'nv2@gmail.com', 'nv02', '123', 2),
('NV03', 'Nguyễn Thế Anh', 'Long An', '2004-03-10', '0934567890', 'Nữ', 'nv3@gmail.com', 'nv03', '123', 1),
('NV04', 'Hồ Quế Trân', 'Yên Bái', '2003-03-10', '0934567890', 'Nữ', 'nv4@gmail.com', 'nv04', '123', 3);

INSERT INTO KhachHang (MaKH, HoTenKH, NgaySinhKH, SoDienThoaiKH, EmailKH, DiaChi)
VALUES 
('KH01', 'Nguyễn Thị Giang', '1999-05-12', '0909876543', 'ntg@gmail.com', 'TP.HCM'),
('KH02', 'Trần Văn Hiệp', '2005-02-25', '0912345679', 'tvh@gmail.com', 'Bến Tre'),
('KH03', 'Lê Thị Ái Quyên', '2005-08-30', '0923456780', 'lti@gmail.com', 'TP.HCM'),
('KH04', 'Ngô Văn Phú', '2001-10-15', '0934567891', 'nvj@gmail.com', 'TP.HCM'),
('KH05', 'Phạm Thị Khánh Huyền', '2002-12-05', '0945678902', 'ptk@gmail.com', 'TP.HCM'),
('KH06', 'Vũ Văn Linh', '2003-03-20', '0956789013', 'vvl@gmail.com', 'TP.HCM'),
('KH07', 'Lê Văn Phụng', '2004-06-30', '0990123457', 'lvp@gmail.com', 'TP.HCM');

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
('XE08', 'xe08.jpg', 'Lamborghini Urus', 'HX01', 'Trắng', 'Công nghệ lái tự động', 140000000, 9),
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
('XE45', 'xe45.jpg', 'Mercedes-Benz A-Class', 'HX05', 'Xám', 'Công nghệ nhỏ gọn', 180000000, 7),
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


INSERT INTO HoaDon (MaHD, MaKH, MaNV, NgayLap, TongTien)
VALUES 
('HD01', 'KH01', 'NV02', '2024-09-15', 90000000),
('HD02', 'KH02', 'NV02', '2024-09-16', 32000000),
('HD03', 'KH03', 'NV03', '2024-09-17', 62000000),
('HD04', 'KH04', 'NV04', '2024-05-18', 80000000),
('HD05', 'KH05', 'NV03', '2024-09-01', 102000000),
('HD06', 'KH06', 'NV02', '2024-02-18', 42000000),
('HD07', 'KH07', 'NV02', '2024-09-12', 42000000);

INSERT INTO ChiTietHoaDon (MaHD, MaXe, SoLuong, GiaBan)
VALUES 
('HD01', 'XE01', 1, 20000000),
('HD02', 'XE05', 1, 32000000),
('HD03', 'XE03', 1, 88000000),
('HD04', 'XE06', 2, 40000000),
('HD05', 'XE08', 1, 60000000),
('HD05', 'XE09', 2, 42000000),
('HD06', 'XE10', 1, 42000000),
('HD07', 'XE09', 1, 42000000);
