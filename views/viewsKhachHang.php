<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Khách Hàng</title>
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
            width: 95%;
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
        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 12px;
            margin: 0 5px;
            background: #ff69b4;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s, transform 0.3s;
        }

        .pagination a:hover {
            background: #ff1493;
            transform: scale(1.1);
        }

        .pagination .active {
            background: #ff69b4;
            font-weight: bold;
            pointer-events: none; /* Disable pointer events on active page */
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Quản lý Khách Hàng</h2>

    <?php if (!empty($message)): ?>
        <div class="alert" style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px;">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" id="customerForm">
        <div class="form-group">
            <input type="hidden" name="maKH" value="<?php echo isset($customer) ? htmlspecialchars($customer['MaKH']) : ''; ?>">
            <input type="text" name="hoTenKH" placeholder="Họ Tên" value="<?php echo isset($customer) ? htmlspecialchars($customer['HoTenKH']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="date" name="ngaySinhKH" value="<?php echo isset($customer) ? htmlspecialchars($customer['NgaySinhKH']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="text" name="soDienThoaiKH" placeholder="Số Điện Thoại" value="<?php echo isset($customer) ? htmlspecialchars($customer['SoDienThoaiKH']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="email" name="emailKH" placeholder="Email" value="<?php echo isset($customer) ? htmlspecialchars($customer['EmailKH']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="text" name="diaChi" placeholder="Địa Chỉ" value="<?php echo isset($customer) ? htmlspecialchars($customer['DiaChi']) : ''; ?>" required>
        </div>
        <button type="submit" name="add" class="btn">Thêm Khách Hàng</button>
        <button type="submit" name="edit" class="btn" style="<?php echo isset($customer) ? '' : 'display:none;'; ?>">Sửa Khách Hàng</button>
        <button type="button" class="btn" onclick="resetForm()">Làm mới</button>
    </form>

    <form method="POST" style="margin-top: 20px;">
        <input type="text" name="search_term" placeholder="Tìm kiếm khách hàng" required class="nhap_timkiem">
        <button type="submit" name="search" class="btn">Tìm kiếm</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Mã KH</th>
                <th>Họ Tên</th>
                <th>Ngày Sinh</th>
                <th>Số Điện Thoại</th>
                <th>Email</th>
                <th>Địa Chỉ</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $customer): ?>
            <tr onclick="fillForm('<?php echo htmlspecialchars($customer['MaKH']); ?>', '<?php echo htmlspecialchars($customer['HoTenKH']); ?>', '<?php echo $customer['NgaySinhKH']; ?>', '<?php echo htmlspecialchars($customer['SoDienThoaiKH']); ?>', '<?php echo htmlspecialchars($customer['EmailKH']); ?>', '<?php echo htmlspecialchars($customer['DiaChi']); ?>')">
                <td><?php echo $customer['MaKH']; ?></td>
                <td><?php echo htmlspecialchars($customer['HoTenKH']); ?></td>
                <td><?php echo $customer['NgaySinhKH']; ?></td>
                <td><?php echo htmlspecialchars($customer['SoDienThoaiKH']); ?></td>
                <td><?php echo htmlspecialchars($customer['EmailKH']); ?></td>
                <td><?php echo htmlspecialchars($customer['DiaChi']); ?></td>
                <td>
                    <a href="?action=delete&id=<?php echo $customer['MaKH']; ?>" class="delete-btn">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="<?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
</div>

<script>
function fillForm(maKH, hoTen, ngaySinh, soDienThoai, email, diaChi) {
    document.forms['customerForm']['maKH'].value = maKH;
    document.forms['customerForm']['hoTenKH'].value = hoTen;
    document.forms['customerForm']['ngaySinhKH'].value = ngaySinh;
    document.forms['customerForm']['soDienThoaiKH'].value = soDienThoai;
    document.forms['customerForm']['emailKH'].value = email;
    document.forms['customerForm']['diaChi'].value = diaChi;

    // Hiện nút "Sửa"
    document.querySelector('button[name="edit"]').style.display = 'inline-block';
}

function resetForm() {
    const form = document.getElementById("customerForm");
    form.reset(); // Đặt lại form

    // Ẩn nút "Sửa"
    document.querySelector('button[name="edit"]').style.display = 'none';

}
</script>

</body>
</html>