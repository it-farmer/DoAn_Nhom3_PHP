<?php
include("ConnectDatabase.php");

// Số nhân viên hiển thị mỗi trang
$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Tổng số nhân viên
$total_result = $conn->query("SELECT COUNT(*) AS total FROM NhanVien");
$total_row = $total_result->fetch_assoc();
$total = $total_row['total'];
$total_pages = ceil($total / $limit);

// Tạo mã nhân viên tự động
function generateMaNV($conn) {
    $result = $conn->query("SELECT MAX(MaNV) AS maxMaNV FROM NhanVien");
    $row = $result->fetch_assoc();
    $maxMaNV = $row['maxMaNV'];
    
    if ($maxMaNV) {
        $num = (int)substr($maxMaNV, 2);
        $num++;
    } else {
        $num = 1; // Bắt đầu từ 1 nếu chưa có mã nào
    }
    
    return 'NV' . str_pad($num, 2, '0', STR_PAD_LEFT); // Tạo mã nhân viên mới
}

// Thêm nhân viên
if (isset($_POST['add'])) {
    $hoTenNV = $_POST['hoTenNV'];
    $queQuan = $_POST['queQuan'];
    $ngaySinhNV = $_POST['ngaySinhNV'];
    $soDienThoaiNV = $_POST['soDienThoaiNV'];
    $gioiTinh = $_POST['gioiTinh'];
    $emailNV = $_POST['emailNV'];
    $taiKhoan = $_POST['taiKhoan'];
    $matKhau = $_POST['matKhau'];
    $quyenID = $_POST['quyenID'];
    
    $maNV = generateMaNV($conn); // Tạo mã nhân viên mới

    $conn->query("INSERT INTO NhanVien (MaNV, HoTenNV, QueQuan, NgaySinhNV, SoDienThoaiNV, GioiTinh, EmailNV, TaiKhoan, MatKhau, QuyenID) VALUES ('$maNV', '$hoTenNV', '$queQuan', '$ngaySinhNV', '$soDienThoaiNV', '$gioiTinh', '$emailNV', '$taiKhoan', '$matKhau', $quyenID)");
    $message = "Thêm nhân viên thành công!";
}

// Xóa nhân viên
if (isset($_GET['delete'])) {
    $maNV = $_GET['delete'];
    $conn->query("DELETE FROM NhanVien WHERE MaNV = '$maNV'");
    // $message = "Xóa nhân viên thành công!";
}

// Sửa nhân viên
if (isset($_POST['edit'])) {
    $maNV = $_POST['maNV'];
    $hoTenNV = $_POST['hoTenNV'];
    $queQuan = $_POST['queQuan'];
    $ngaySinhNV = $_POST['ngaySinhNV'];
    $soDienThoaiNV = $_POST['soDienThoaiNV'];
    $gioiTinh = $_POST['gioiTinh'];
    $emailNV = $_POST['emailNV'];
    $taiKhoan = $_POST['taiKhoan'];
    $matKhau = $_POST['matKhau'];
    $quyenID = $_POST['quyenID'];
    
    $conn->query("UPDATE NhanVien SET HoTenNV='$hoTenNV', QueQuan='$queQuan', NgaySinhNV='$ngaySinhNV', SoDienThoaiNV='$soDienThoaiNV', GioiTinh='$gioiTinh', EmailNV='$emailNV', TaiKhoan='$taiKhoan', MatKhau='$matKhau', QuyenID=$quyenID WHERE MaNV='$maNV'");
    $message = "Sửa nhân viên thành công!";
}

// Tìm kiếm nhân viên
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search_term'];
}

// Lấy danh sách nhân viên với phân trang
$result = $conn->query("SELECT * FROM NhanVien WHERE HoTenNV LIKE '%$search%' LIMIT $limit OFFSET $offset");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Nhân viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #ff69b4;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .nhap_timkiem {
            width: 50%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            background-color: #ff69b4;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .delete-btn {
            cursor: pointer;
            color: white;
            border-radius: 5px;
            padding: 5px 10px;
            text-decoration: none;
            background-color: red;
        }
        .btn:hover {
            background-color: #ff1493;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Quản lý Nhân viên</h2>
    
    <?php if (!empty($message)): ?>
        <div class="alert" style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px;">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" id="employeeForm">
        <div class="form-group">
            <input type="hidden" name="maNV" value="<?php echo isset($employee) ? htmlspecialchars($employee['MaNV']) : ''; ?>">
            <input type="text" name="hoTenNV" placeholder="Họ Tên" value="<?php echo isset($employee) ? htmlspecialchars($employee['HoTenNV']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="text" name="queQuan" placeholder="Quê Quán" value="<?php echo isset($employee) ? htmlspecialchars($employee['QueQuan']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="date" name="ngaySinhNV" value="<?php echo isset($employee) ? htmlspecialchars($employee['NgaySinhNV']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="text" name="soDienThoaiNV" placeholder="Số Điện Thoại" value="<?php echo isset($employee) ? htmlspecialchars($employee['SoDienThoaiNV']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <select name="gioiTinh" required>
                <option value="">Giới Tính</option>
                <option value="Nam" <?php echo (isset($employee) && $employee['GioiTinh'] === 'Nam') ? 'selected' : ''; ?>>Nam</option>
                <option value="Nữ" <?php echo (isset($employee) && $employee['GioiTinh'] === 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
            </select>
        </div>
        <div class="form-group">
            <input type="email" name="emailNV" placeholder="Email" value="<?php echo isset($employee) ? htmlspecialchars($employee['EmailNV']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="text" name="taiKhoan" placeholder="Tài Khoản" value="<?php echo isset($employee) ? htmlspecialchars($employee['TaiKhoan']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="password" name="matKhau" placeholder="Mật Khẩu" value="<?php echo isset($employee) ? htmlspecialchars($employee['MatKhau']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="number" name="quyenID" placeholder="Quyền ID" value="<?php echo isset($employee) ? htmlspecialchars($employee['QuyenID']) : ''; ?>" required>
        </div>
        <button type="submit" name="add" class="btn">Thêm Nhân viên</button>
        <button type="submit" name="edit" class="btn" style="<?php echo isset($employee) ? '' : 'display:none;'; ?>">Sửa Nhân viên</button>
        <button type="button" class="btn" onclick="resetForm()">Làm mới</button>
    </form>

    <form method="POST" style="margin-top: 20px;">
        <input type="text" name="search_term" placeholder="Tìm kiếm nhân viên" required class="nhap_timkiem">
        <button type="submit" name="search" class="btn">Tìm kiếm</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Mã NV</th>
                <th>Họ Tên</th>
                <th>Quê Quán</th>
                <th>Ngày Sinh</th>
                <th>Số Điện Thoại</th>
                <th>Giới Tính</th>
                <th>Email</th>
                <th>Tài Khoản</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr onclick="fillForm('<?php echo htmlspecialchars($row['MaNV']); ?>', '<?php echo htmlspecialchars($row['HoTenNV']); ?>', '<?php echo htmlspecialchars($row['QueQuan']); ?>', '<?php echo $row['NgaySinhNV']; ?>', '<?php echo htmlspecialchars($row['SoDienThoaiNV']); ?>', '<?php echo htmlspecialchars($row['GioiTinh']); ?>', '<?php echo htmlspecialchars($row['EmailNV']); ?>', '<?php echo htmlspecialchars($row['TaiKhoan']); ?>')">
                <td><?php echo $row['MaNV']; ?></td>
                <td><?php echo htmlspecialchars($row['HoTenNV']); ?></td>
                <td><?php echo htmlspecialchars($row['QueQuan']); ?></td>
                <td><?php echo $row['NgaySinhNV']; ?></td>
                <td><?php echo htmlspecialchars($row['SoDienThoaiNV']); ?></td>
                <td><?php echo htmlspecialchars($row['GioiTinh']); ?></td>
                <td><?php echo htmlspecialchars($row['EmailNV']); ?></td>
                <td><?php echo htmlspecialchars($row['TaiKhoan']); ?></td>
                <td>
                    <a href="?delete=<?php echo $row['MaNV']; ?>" class="delete-btn">Xóa</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="<?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
</div>

<script>
function fillForm(maNV, hoTen, queQuan, ngaySinh, soDienThoai, gioiTinh, email, taiKhoan) {
    document.forms['employeeForm']['maNV'].value = maNV;
    document.forms['employeeForm']['hoTenNV'].value = hoTen;
    document.forms['employeeForm']['queQuan'].value = queQuan;
    document.forms['employeeForm']['ngaySinhNV'].value = ngaySinh;
    document.forms['employeeForm']['soDienThoaiNV'].value = soDienThoai;
    document.forms['employeeForm']['gioiTinh'].value = gioiTinh;
    document.forms['employeeForm']['emailNV'].value = email;
    document.forms['employeeForm']['taiKhoan'].value = taiKhoan;

    // Hiện nút "Sửa"
    document.querySelector('button[name="edit"]').style.display = 'inline-block';
}

function resetForm() {
    const form = document.getElementById("employeeForm");
    form.reset(); // Đặt lại form

    // Ẩn nút "Sửa"
    document.querySelector('button[name="edit"]').style.display = 'none';
}
</script>

</body>
</html>

<?php
$conn->close();
?>