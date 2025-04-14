CREATE DATABASE QL_XeHoi;
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

INSERT INTO HangXe (MaHX, TenHX, DiaChiHX, SoDienThoaiHX, EmailHX)
VALUES 
('HX01', 'Honda', 'Số 1, Đường 1, TP.HCM', '02823456789', 'honda@gmail.com'),
('HX02', 'Toyota', 'Số 2, Đường 2, TP.HCM', '02834567890', 'toyota@gmail.com'),
('HX03', 'Hyundai', 'Số 3, Đường 3, TP.HCM', '06487627164', 'hyundai@gmail.com'),
('HX04', 'Nissan', 'Số 4, Đường 5, TP.HCM', '02456823757', 'nissan@gmail.com'),
('HX05', 'Vinfast', 'Số 5, Đường 5, TP.HCM', '09736256235', 'vinfast@gmail.com');

INSERT INTO XeHoi (MaXe, AnhXe, TenXe, MaHX, MauXe, CongNghe, Gia, SoLuongTonKho)
VALUES 
('XE01', 'XE001.png', 'Vinfast Fadil', 'HX05', 'Xám', 'Sạc điện thoại - Đồng hồ kỹ thuật số', 90000000, 50),
('XE02', 'XE002.png', 'Vinfast Lux SA2.0', 'HX05', 'Xanh', 'ABS - Đồng hồ cơ', 40000000, 45),
('XE03', 'XE003.jpg', 'Hyundai Grand i10', 'HX03', 'Đen', 'ABS - Đồng hồ kỹ thuật số', 62000000, 30),
('XE04', 'XE004.jpg', 'Hyundai SantaFe', 'HX03', 'Xanh rêu', 'ABS - Smart Key', 70000000, 20),
('XE05', 'XE005.jpg', 'Nissan Leaf (EV)', 'HX04', 'Đỏ', 'Sạc điện thoại - Đồng hồ kỹ thuật số', 32000000, 35),
('XE06', 'XE006.png', 'Toyota Vios', 'HX02', 'Đen', 'Smart Key - ABS', 40000000, 40),
('XE07', 'XE007.png', 'Vinfast Lux A2.0', 'HX05', 'Đỏ', 'ABS - Đồng hồ kỹ thuật số', 27000000, 25),
('XE08', 'XE008.png', 'Hyundai Grand i10', 'HX03', 'Đỏ', 'Smart Key - Đồng hồ cơ', 60000000, 15),
('XE09', 'XE009.png', 'Honda Accord', 'HX02', 'Kem', 'Smart Key - Đồng hồ kỹ thuật số', 42000000, 10),
('XE10', 'XE0010.png', 'Nissan Qashqai', 'HX04', 'Xanh rêu', 'Smart Key - ABS', 23000000, 5),
('XE11', 'XE0011.png', 'Hyundai Grand i10', 'HX03', 'Xanh', 'ABS - Đồng hồ kỹ thuật số', 30000000, 8),
('XE12', 'XE0012.png', 'Nissan Z (Sport Car)', 'HX04', 'Xám', 'ABS - Smart Key', 60000000, 2),
('XE13', 'XE0013.jpg', 'Toyota Camry', 'HX02', 'Xanh', 'Sạc điện thoại - Đồng hồ cơ', 30000000, 60),
('XE14', 'XE0014.jpg', 'Hyundai Elantra', 'HX03', 'Trắng', 'Smart Key - ABS', 37000000, 12),
('XE15', 'XE0015.png', 'Honda HR-V', 'HX02', 'Xanh', 'Smart Key - ABS', 120000000, 20),
('XE16', 'XE0016.png', 'Honda Civic', 'HX02', 'Xanh', 'Smart Key - ABS', 150000000, 25),
('XE17', 'XE0017.png', 'Vinfast President', 'HX05', 'Xanh', 'Smart Key - ABS', 700000000, 21);

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