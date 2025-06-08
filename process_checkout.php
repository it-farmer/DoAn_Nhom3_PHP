<?php
include 'header.php';
require_once 'models/M_database.php';
require_once 'models/M_GioHang.php';

$maKH = $_SESSION['MaKH'] ?? '';
$tenkh = $_POST['tenkh'];
$sdt = $_POST['sdt'];
$diachi = $_POST['diachi'];
$voucher = $_POST['voucher'] ?? '';
$pttt = $_POST['pttt'] ?? '';
$db = new Database();
$db->M_connect();

$gioHangModel = new GioHangModel();
$cart = $gioHangModel->getCartByMaKH($maKH);

// 1. Tạo mã hóa đơn mới
$sqlMax = "SELECT MaHD FROM HoaDon ORDER BY MaHD DESC LIMIT 1";
$result = $db->M_getOne($sqlMax);
if ($result && preg_match('/HD(\d+)/', $result->MaHD, $matches)) {
    $nextNumber = (int)$matches[1] + 1;
    $maHD = 'HD' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
} else {
    $maHD = 'HD01';
}

// 2. Tính tổng tiền
$tongtien = 0;
foreach ($cart as $item) {
    $tongtien += $item->Gia * $item->SoLuong;
}

// 3. Áp dụng voucher nếu có
if ($voucher) {
    $voucherData = $db->M_getOne("SELECT * FROM Voucher WHERE MaVC = ?", [$voucher]);
    if ($voucherData) {
        $today = date('Y-m-d');
        if ($today <= $voucherData->NgayHetHan) {
            $discount_percent = (int)$voucherData->GiamGia;
            $tongtien = $tongtien * (1 - $discount_percent / 100);
        }
    }
}

// 4. Thêm hóa đơn
$db->M_excute("INSERT INTO HoaDon (MaHD, MaKH, NgayLap, TongTien, PTTT) VALUES (?, ?, NOW(), ?, ?)", [
    $maHD, $maKH, $tongtien, $pttt
]);

// 5. Thêm chi tiết hóa đơn và cập nhật tồn kho
foreach ($cart as $item) {
    // Thêm chi tiết hóa đơn
    $db->M_excute("INSERT INTO ChiTietHoaDon (MaHD, MaXe, SoLuong, GiaBan) VALUES (?, ?, ?, ?)", [
        $maHD, $item->MaXe, $item->SoLuong, $item->Gia
    ]);
    // Trừ số lượng tồn kho của xe
    $db->M_excute("UPDATE xehoi SET SoLuongTonKho = SoLuongTonKho - ? WHERE MaXe = ?", [
        $item->SoLuong, $item->MaXe
    ]);
}

// 6. Thêm thông tin giao hàng
$db->M_excute("INSERT INTO ThongTinGiaoHang (MaHD, TenKH, SDT, DiaChi, TongTien) VALUES (?, ?, ?, ?, ?)", [
    $maHD, $tenkh, $sdt, $diachi, $tongtien
]);

// 7. Xóa giỏ hàng của khách hàng
$db->M_excute("DELETE FROM GioHang WHERE MaKH = ?", [$maKH]);

echo "<script>alert('Đặt hàng thành công!');window.location='index.php';</script>";
?>