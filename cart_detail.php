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
        <td>
            <button type="button" class="btn-qty" data-max="<?php echo $item->SoLuongTonKho; ?>" data-maxe="<?php echo $item->MaXe; ?>" data-action="increase">+</button>
            <span class="cart-qty" id="qty-<?php echo $item->MaXe; ?>"><?php echo $item->SoLuong; ?></span>
            <button type="button" class="btn-qty" data-max="<?php echo $item->SoLuongTonKho; ?>" data-maxe="<?php echo $item->MaXe; ?>" data-action="decrease">-</button>

        </td>
        <td id="total-<?php echo $item->MaXe; ?>"><?php echo number_format($item->Gia * $item->SoLuong, 0, ",", "."); ?> VNĐ</td>
    </tr>
    <?php endforeach; ?>
    
    <tr class="cart-total-row">
        <td colspan="4"><b>Tổng cộng</b></td>
        <td><b id="cart-total"><?php echo number_format($tong, 0, ",", "."); ?> VNĐ</b></td>
    </tr>
</table>
<div class="voucher-container">
    <input type="text" name="voucher" id="voucher" class="voucher-input" placeholder="Nhập mã giảm giá">
    <button type="button" class="voucher-btn" onclick="applyVoucher()">Áp dụng</button>
</div>
<div style="margin-left: 1135px;">
        <span id="voucher-message" style="color:green"></span>
</div>
<form method="post" action="checkout.php">
    <input type="hidden" name="voucher" id="hidden-voucher">
    <button class="btn-checkout" type="submit" name="checkout">Thanh toán</button>
</form>
<script>
    document.querySelector('.btn-checkout').onclick = function() {
    document.getElementById('hidden-voucher').value = document.getElementById('voucher').value;
};
</script>

<br>
<br>
<br>
<br>
<?php
    include("footer.php");
?>
<script>
function updateCart(maXe, action) {
    fetch('controllers/Controller_Cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `ajax=1&action=${action}&maXe=${maXe}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('qty-' + maXe).innerText = data.qty;
            document.getElementById('total-' + maXe).innerText = data.subtotal + ' VNĐ';
            document.getElementById('cart-total').innerText = data.total + ' VNĐ';
        } else {
            alert(data.message || 'Có lỗi xảy ra');
        }
    });
}

document.querySelectorAll('.btn-qty').forEach(btn => {
    btn.addEventListener('click', function() {
        updateCart(this.dataset.maxe, this.dataset.action);
    });

});
</script>
<script>
function applyVoucher() {
    var code = document.getElementById('voucher').value;
    fetch('controllers/Controller_Cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `ajax=1&action=apply_voucher&voucher=${code}`
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('voucher-message').innerText = data.message;
        if (data.discounted_total) {
            document.getElementById('cart-total').innerText = data.discounted_total + ' VNĐ';
        }
    });
}
</script>