<?php
    $title = "Chi tiết giỏ hàng";
    include("header.php");
    require_once 'models/M_GioHang.php';
    require_once 'models/M_database.php';

    $maKH = isset($_SESSION['MaKH']) ? $_SESSION['MaKH'] : null;
    if (!$maKH) {
        header('Location: index.php?showLogin=1');
        echo "<script>alert('Bạn cần đăng nhập để xem giỏ hàng!');</script>";
        exit;
    }

$gioHangModel = new GioHangModel();
$cart = $gioHangModel->getCartByMaKH($maKH);

// Xử lý thanh toán
if (isset($_POST['checkout'])) {
    $tongTien = 0;
    foreach ($cart as $item) {
        $tongTien += $item->Gia * $item->SoLuong;
    }
    $db = new Database();
    $db->M_connect();
    // Tạo mã hóa đơn tăng dần
    $sqlMax = "SELECT MaHD FROM HoaDon ORDER BY MaHD DESC LIMIT 1";
    $result = $db->M_getOne($sqlMax);
    if ($result && preg_match('/HD(\d+)/', $result->MaHD, $matches)) {
        $nextNumber = intval($matches[1]) + 1;
        $maHD = 'HD' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
    } else {
        $maHD = 'HD01';
    }
    $maNV = 'NV01'; // Gán cứng hoặc lấy từ session nếu có đăng nhập nhân viên
    $ngayLap = date('Y-m-d H:i:s');

    // Lưu hóa đơn
    $db = new Database();
    $db->M_connect();
    $sqlHD = "INSERT INTO HoaDon (MaHD, MaKH, MaNV, NgayLap, TongTien) VALUES (?, ?, ?, ?, ?)";
    $db->M_excute($sqlHD, [$maHD, $maKH, $maNV, $ngayLap, $tongTien]);

    // Lưu chi tiết hóa đơn
    foreach ($cart as $item) {
        $sqlCT = "INSERT INTO ChiTietHoaDon (MaHD, MaXe, SoLuong, GiaBan) VALUES (?, ?, ?, ?)";
        $db->M_excute($sqlCT, [$maHD, $item->MaXe, $item->SoLuong, $item->Gia]);
        // Giảm số lượng tồn kho xe
        $sqlUpdate = "UPDATE XeHoi SET SoLuongTonKho = SoLuongTonKho - ? WHERE MaXe = ?";
        $db->M_excute($sqlUpdate, [$item->SoLuong, $item->MaXe]);
    }

    // Xóa giỏ hàng
    $db->M_excute("DELETE FROM GioHang WHERE MaKH = ?", [$maKH]);
    echo "<script>alert('Thanh toán thành công!');window.location='index.php';</script>";
    exit;
}
?>

<h2 class="cart-detail-title">Chi tiết giỏ hàng</h2>
<table class="table-cart" border="1">
    <tr>
        <th>Ảnh</th>
        <th>Tên xe</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
    </tr>
    <?php $tong = 0; foreach ($cart as $item): $tong += $item->Gia * $item->SoLuong; ?>
    <tr>
        <td><img src="assets/img/Xe/<?php echo htmlspecialchars($item->AnhXe); ?>" width="120"></td>
        <td><?php echo htmlspecialchars($item->TenXe); ?></td>
        <td><?php echo number_format($item->Gia, 0, ",", "."); ?> VNĐ</td>
        <td><?php echo $item->SoLuong; ?></td>
        <td><?php echo number_format($item->Gia * $item->SoLuong, 0, ",", "."); ?> VNĐ</td>
    </tr>
    <?php endforeach; ?>
    <tr class="cart-total-row">
        <td colspan="4"><b>Tổng cộng</b></td>
        <td><b><?php echo number_format($tong, 0, ",", "."); ?> VNĐ</b></td>
    </tr>
</table>
<form method="post">
    <button class="btn-checkout" type="submit" name="checkout">Thanh toán</button>
</form>

<br>
<br>
<br>
<br>
<?php
    include("footer.php");
?>