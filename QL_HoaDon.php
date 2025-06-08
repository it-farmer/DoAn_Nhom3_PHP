<?php
$title = "Quản lý hóa đơn";
require_once 'models/M_database.php';

$db = new Database();
$db->M_connect();

// Xử lý xóa hóa đơn
if (isset($_GET['delete']) && $_GET['mahd']) {
    $mahd = $_GET['mahd'];
    // Xóa chi tiết hóa đơn trước
    $db->M_excute("DELETE FROM ChiTietHoaDon WHERE MaHD = ?", [$mahd]);
    // Xóa hóa đơn
    $db->M_excute("DELETE FROM HoaDon WHERE MaHD = ?", [$mahd]);
    header("Location: admin.php");
    exit;
}

// Xử lý thêm hóa đơn (đơn giản, bạn có thể mở rộng thêm)
if (isset($_POST['add'])) {
    $mahd = $_POST['mahd'];
    $makh = $_POST['makh'];
    $manv = $_POST['manv'];
    $ngaylap = $_POST['ngaylap'];
    $tongtien = $_POST['tongtien'];
    $db->M_excute("INSERT INTO HoaDon (MaHD, MaKH, MaNV, NgayLap, TongTien) VALUES (?, ?, ?, ?, ?)", [$mahd, $makh, $manv, $ngaylap, $tongtien]);
    header("Location: admin.php");
    exit;
}

// Xử lý sửa hóa đơn
if (isset($_POST['edit'])) {
    $mahd = $_POST['mahd'];
    $makh = $_POST['makh'];
    $manv = $_POST['manv'];
    $ngaylap = $_POST['ngaylap'];
    $tongtien = $_POST['tongtien'];
    $db->M_excute("UPDATE HoaDon SET MaKH=?, MaNV=?, NgayLap=?, TongTien=? WHERE MaHD=?", [$makh, $manv, $ngaylap, $tongtien, $mahd]);
    header("Location: admin.php");
    exit;
}

// Lấy danh sách hóa đơn
$hoadons = $db->M_getAll("SELECT * FROM HoaDon");

// Lấy chi tiết hóa đơn nếu có chọn
$cthd = [];
if (isset($_GET['mahd'])) {
    $cthd = $db->M_getAll("SELECT * FROM ChiTietHoaDon WHERE MaHD = ?", [$_GET['mahd']]);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Quản lý hóa đơn</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/cdbcf8b89b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/styles.css?v=<?php echo time(); ?>">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background: #eee;
        }

        form {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h2 class="admin-title">Danh sách hóa đơn</h2>
    <table class="table-admin">
        <tr>
            <th>Mã HĐ</th>
            <th>Mã KH</th>
            <th>Mã NV</th>
            <th>Ngày lập</th>
            <th>Tổng tiền</th>
            <th>Chi tiết</th>
            <th>Sửa</th>
            <th>Xóa</th>
        </tr>
        <?php foreach ($hoadons as $hd): ?>
            <tr>
                <td><?php echo htmlspecialchars($hd->MaHD); ?></td>
                <td><?php echo htmlspecialchars($hd->MaKH); ?></td>
                <td><?php echo htmlspecialchars($hd->MaNV); ?></td>
                <td><?php echo htmlspecialchars($hd->NgayLap); ?></td>
                <td><?php echo number_format($hd->TongTien, 0, ",", "."); ?> VNĐ</td>
                <td><a href="admin.php?mahd=<?php echo $hd->MaHD; ?>">Xem</a></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="mahd" value="<?php echo $hd->MaHD; ?>">
                        <input type="hidden" name="makh" value="<?php echo $hd->MaKH; ?>">
                        <input type="hidden" name="manv" value="<?php echo $hd->MaNV; ?>">
                        <input type="hidden" name="ngaylap" value="<?php echo $hd->NgayLap; ?>">
                        <input type="hidden" name="tongtien" value="<?php echo $hd->TongTien; ?>">
                        <button type="submit" name="showedit">Sửa</button>
                    </form>
                </td>
                <td><a href="admin.php?delete=1&mahd=<?php echo $hd->MaHD; ?>"
                        onclick="return confirm('Xóa hóa đơn này?')">Xóa</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Thêm hóa đơn mới</h3>
    <form method="post" class="admin-form">
        <input type="text" name="mahd" placeholder="Mã HĐ" required>
        <input type="text" name="makh" placeholder="Mã KH" required>
        <input type="text" name="manv" placeholder="Mã NV" required>
        <input type="datetime-local" name="ngaylap" required>
        <input type="number" name="tongtien" placeholder="Tổng tiền" required>
        <button type="submit" name="add">Thêm</button>
    </form>

    <?php if (isset($_POST['showedit'])): ?>
        <h3>Sửa hóa đơn</h3>
        <form method="post" class="admin-form">
            <input type="text" name="mahd" value="<?php echo htmlspecialchars($_POST['mahd']); ?>" readonly>
            <input type="text" name="makh" value="<?php echo htmlspecialchars($_POST['makh']); ?>" required>
            <input type="text" name="manv" value="<?php echo htmlspecialchars($_POST['manv']); ?>" required>
            <input type="datetime-local" name="ngaylap"
                value="<?php echo date('Y-m-d\TH:i', strtotime($_POST['ngaylap'])); ?>" required>
            <input type="number" name="tongtien" value="<?php echo htmlspecialchars($_POST['tongtien']); ?>" required>
            <button type="submit" name="edit">Cập nhật</button>
        </form>
    <?php endif; ?>

    <?php if (!empty($cthd)): ?>
        <h3>Chi tiết hóa đơn: <?php echo htmlspecialchars($_GET['mahd']); ?></h3>
        <table>
            <tr>
                <th>Mã xe</th>
                <th>Số lượng</th>
                <th>Giá bán</th>
            </tr>
            <?php foreach ($cthd as $ct): ?>
                <tr>
                    <td><?php echo htmlspecialchars($ct->MaXe); ?></td>
                    <td><?php echo $ct->SoLuong; ?></td>
                    <td><?php echo number_format($ct->GiaBan, 0, ",", "."); ?> VNĐ</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>

</html>