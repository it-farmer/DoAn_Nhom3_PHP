<?php
include("ConnectDatabase.php");

// Số sản phẩm hiển thị mỗi trang
$limit = 20;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Tổng số sản phẩm
$total_result = $conn->query("SELECT COUNT(*) AS total FROM XeHoi");
$total_row = $total_result->fetch_assoc();
$total = $total_row['total'];
$total_pages = ceil($total / $limit);

// Lấy danh sách hãng xe
$hangXe_result = $conn->query("SELECT * FROM HangXe");

// Tạo mã xe tự động
function generateMaXe($conn) {
    $result = $conn->query("SELECT MAX(MaXe) AS maxMaXe FROM XeHoi");
    $row = $result->fetch_assoc();
    $maxMaXe = $row['maxMaXe'];
    
    if ($maxMaXe) {
        $num = (int)substr($maxMaXe, 2);
        $num++;
    } else {
        $num = 1; // Nếu chưa có mã nào, bắt đầu từ 1
    }
    
    return 'XE' . str_pad($num, 2, '0', STR_PAD_LEFT); // Tạo mã xe mới
}

// Thêm sản phẩm xe
if (isset($_POST['add'])) {
    $tenXe = $_POST['tenXe'];
    $maHX = $_POST['maHX'];
    $mauXe = $_POST['mauXe'];
    $congNghe = $_POST['congNghe'];
    $gia = $_POST['gia'];
    $soLuongTonKho = $_POST['soLuongTonKho'];

    // Tạo mã xe mới
    $maXe = generateMaXe($conn);

    // Xử lý upload ảnh
    $anhXe = $_FILES['anhXe']['name'];
    $target_dir = "HinhAnh/";
    $target_file = $target_dir . basename($anhXe);
    move_uploaded_file($_FILES['anhXe']['tmp_name'], $target_file);

    $conn->query("INSERT INTO XeHoi (MaXe, TenXe, MaHX, MauXe, CongNghe, Gia, SoLuongTonKho, AnhXe) VALUES ('$maXe', '$tenXe', '$maHX', '$mauXe', '$congNghe', $gia, $soLuongTonKho, '$anhXe')");
    // Cập nhật thông báo
    $message = "Thêm sản phẩm thành công!";
}

// Xóa sản phẩm xe
if (isset($_GET['delete'])) {
    $maXe = $_GET['delete'];
    $conn->query("DELETE FROM XeHoi WHERE MaXe = '$maXe'");
}

// Sửa sản phẩm xe
if (isset($_POST['edit'])) {
    $maXe = $_POST['maXe']; // Mã xe lấy từ form
    $tenXe = $_POST['tenXe'];
    $maHX = $_POST['maHX'];
    $mauXe = $_POST['mauXe'];
    $congNghe = $_POST['congNghe'];
    $gia = $_POST['gia'];
    $soLuongTonKho = $_POST['soLuongTonKho'];
    
    // Xử lý upload ảnh
    if (!empty($_FILES['anhXe']['name'])) {
        $anhXe = $_FILES['anhXe']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($anhXe);
        move_uploaded_file($_FILES['anhXe']['tmp_name'], $target_file);
    } else {
        $anhXe = $_POST['existing_anhXe']; // Giữ nguyên ảnh cũ
    }

    $conn->query("UPDATE XeHoi SET TenXe='$tenXe', MaHX='$maHX', MauXe='$mauXe', CongNghe='$congNghe', Gia=$gia, SoLuongTonKho=$soLuongTonKho, AnhXe='$anhXe' WHERE MaXe='$maXe'");
    $message = "Sửa sản phẩm thành công!";
}

// Tìm kiếm sản phẩm xe
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search_term'];
    $result = $conn->query("SELECT * FROM XeHoi WHERE TenXe LIKE '%$search%' LIMIT $limit OFFSET $offset");
} else {
    $result = $conn->query("SELECT * FROM XeHoi LIMIT $limit OFFSET $offset");
}

// Lấy thông tin sản phẩm khi nhấp vào
$product = null;
if (isset($_GET['edit'])) {
    $maXe = $_GET['edit'];
    $product = $conn->query("SELECT * FROM XeHoi WHERE MaXe='$maXe'")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Sản phẩm Xe</title>
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
        .edit-btn, .delete-btn {
            cursor: pointer;
            color: white;
            border-radius: 5px;
            padding: 5px 10px;
            text-decoration: none;
        }
        .edit-btn {
            background-color: #ffa500;
        }
        .delete-btn {
            background-color: #dc143c;
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
        }
        .pagination a:hover {
            background: #ff1493;
        }
        .pagination .active {
            background: #dc143c;
            font-weight: bold;
        }
        .file-input {
            display: flex;
            align-items: center;
        }
        .file-input input[type="file"] {
            margin-right: 10px;
        }
    </style>

    
</head>
<body>

<script>
function clearForm() {
    document.getElementById("lammoiform").reset(); // Đặt lại form
}


function resetForm() {
    <?php $message = null ?>
    const form = document.getElementById("lammoiform");
    
    // Duyệt qua tất cả các phần tử trong form
    for (let i = 0; i < form.elements.length; i++) {
        const element = form.elements[i];
        
        // Đặt lại giá trị cho input, select
        if (element.tagName === "INPUT" || element.tagName === "TEXTAREA") {
            // Đặt lại giá trị mặc định
            element.value = '';
        } else if (element.tagName === "SELECT") {
            // Đặt lại chọn mặc định
            element.selectedIndex = 0;
        }
    }
    
    // Ẩn nút "Sửa Sản phẩm Xe"
    const editButton = document.querySelector('button[name="edit"]');
    if (editButton) {
        editButton.style.display = 'none';
    }
    
    // Ẩn ảnh hiện tại và hiện lại phần chọn ảnh mới
    const currentImageLabel = document.querySelector('label[for="currentImage"]');
    if (currentImageLabel) {
        currentImageLabel.style.display = 'none'; // Ẩn nhãn ảnh hiện tại
    }

    const currentImage = document.querySelector('img[src*="HinhAnh/"]');
    if (currentImage) {
        currentImage.style.display = 'none'; // Ẩn ảnh hiện tại
    }
    
    // Hiển thị lại phần chọn ảnh mới
    const newImageSpan = document.querySelector('span[id="newImagePrompt"]');
    if (newImageSpan) {
        newImageSpan.style.display = 'block'; // Hiển thị lại phần chọn ảnh mới
    }
    
}
</script>

<div class="container">
    <h2>Quản lý Sản phẩm Xe</h2>
    
    <?php if (!empty($message)): ?>
        <div class="alert" style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px;">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    
    <form id="lammoiform" method="POST" enctype="multipart/form-data">
        <?php if (isset($product)): ?>
            <input type="hidden" name="maXe" value="<?php echo htmlspecialchars($product['MaXe']); ?>">
        <?php endif; ?>
        <div class="form-group">
            <input type="text" name="tenXe" placeholder="Tên Xe" value="<?php echo isset($product) ? htmlspecialchars($product['TenXe']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <select name="maHX" required>
                <option value="">Chọn Hãng Xe</option>
                <?php while ($hangXe = $hangXe_result->fetch_assoc()): ?>
                    <option value="<?php echo $hangXe['MaHX']; ?>" <?php echo (isset($product) && $product['MaHX'] === $hangXe['MaHX']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($hangXe['TenHX']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="mauXe" placeholder="Màu Xe" value="<?php echo isset($product) ? htmlspecialchars($product['MauXe']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="text" name="congNghe" placeholder="Công Nghệ" value="<?php echo isset($product) ? htmlspecialchars($product['CongNghe']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="number" name="gia" placeholder="Giá" value="<?php echo isset($product) ? htmlspecialchars($product['Gia']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="number" name="soLuongTonKho" placeholder="Số Lượng Tồn Kho" value="<?php echo isset($product) ? htmlspecialchars($product['SoLuongTonKho']) : ''; ?>" required>
        </div>
        <div class="form-group file-input">
            <input type="file" name="anhXe" accept="image/*">
            <?php if (isset($product)): ?>
                <input type="hidden" name="existing_anhXe" value="<?php echo htmlspecialchars($product['AnhXe']); ?>">
                <span>Chọn ảnh mới (nếu có)</span>
            <?php else: ?>
                <span>Chọn ảnh</span>
            <?php endif; ?>
        </div>
        <div class="form-group file-input">
            <?php if (isset($product)): ?>
                <label>Ảnh hiện tại:</label>
                <img src="HinhAnh/<?php echo htmlspecialchars($product['AnhXe']); ?>" alt="Ảnh hiện tại" style="max-width: 200px; margin-bottom: 10px;">
            <?php endif; ?>
        </div>
        <button type="submit" name="add" class="btn">Thêm Sản phẩm Xe</button>
        <button type="submit" name="edit" class="btn" style="<?php echo isset($product) ? '' : 'display:none;'; ?>">Sửa Sản phẩm Xe</button>
        <button type="button" name="new" class="btn" onclick="resetForm()">Làm mới</button>
    </form>

    <form method="POST" style="margin-top: 20px;">
        <input type="text" name="search_term" placeholder="Tìm kiếm sản phẩm xe" required class="nhap_timkiem">
        <button type="submit" name="search" class="btn">Tìm kiếm</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Mã Xe</th>
                <th>Tên Xe</th>
                <th>Mã Hãng Xe</th>
                <th>Màu Xe</th>
                <th>Công Nghệ</th>
                <th>Giá</th>
                <th>Số Lượng Tồn Kho</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr onclick="window.location.href='?edit=<?php echo $row['MaXe']; ?>'">
                <td><?php echo $row['MaXe']; ?></td>
                <td><?php echo htmlspecialchars($row['TenXe']); ?></td>
                <td><?php echo htmlspecialchars($row['MaHX']); ?></td>
                <td><?php echo htmlspecialchars($row['MauXe']); ?></td>
                <td><?php echo htmlspecialchars($row['CongNghe']); ?></td>
                <td><?php echo number_format($row['Gia'], 0, ',', '.'); ?> VNĐ</td>
                <td><?php echo $row['SoLuongTonKho']; ?></td>
                <td>
                    <a href="?delete=<?php echo $row['MaXe']; ?>" class="delete-btn">Xóa</a>
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

</body>
</html>

<?php
$conn->close();
?>

