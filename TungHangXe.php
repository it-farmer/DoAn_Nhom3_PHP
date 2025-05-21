<?php
    include("models/ConnectDatabase.php");
     
    // Nhận mã hãng xe từ URL
    $hangxe = isset($_GET['hangxe']) ? $_GET['hangxe'] : '';

    // Lấy tên hãng xe
    $sql_hangxe = "SELECT TenHX FROM HangXe WHERE MaHX = ?";
    $stmt_hangxe = $conn->prepare($sql_hangxe);
    $stmt_hangxe->bind_param("s", $hangxe);
    $stmt_hangxe->execute();
    $result_hangxe = $stmt_hangxe->get_result();

    // Lấy tên hãng xe
    $ten_hangxe = '';
    if ($result_hangxe->num_rows > 0) {
        $row_hangxe = $result_hangxe->fetch_assoc();
        $ten_hangxe = $row_hangxe['TenHX'];
    }

    
    $title = $ten_hangxe;
    include("header.php");
?>
<div class="nen">
    <br>
    <br>

    <?php

    // Lấy danh sách xe theo hãng
    $sql = "SELECT * FROM XeHoi WHERE MaHX = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $hangxe);
    $stmt->execute();
    $result = $stmt->get_result();

    // Hiển thị tên hãng xe
    echo '<div class="highlighted-products">';
    echo '<h2>' . htmlspecialchars($ten_hangxe) . '</h2>'; // Hiển thị tên hãng xe
    echo '</div>';

    // Hiển thị danh sách xe
    echo '<div class="container">';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card" onclick="showDetails(\'' . $row['MaXe'] . '\')">';
            echo '<img src="HinhAnh/Xe/' . htmlspecialchars($row['AnhXe']) . '" class="card-img-top" alt="' . htmlspecialchars($row['TenXe']) . '">';
            echo '<div class="card-body">';
            echo '<h4 class="card-title">' . htmlspecialchars($row['TenXe']) . '</h4>';
            echo '<p class="card-text">Giá: ' . number_format($row['Gia'], 0, ',', '.') . ' VNĐ</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "<p>Không có sản phẩm nào cho hãng xe này.</p>";
    }
    echo '</div>'; // Đóng container

    // Đóng kết nối
    $conn->close();
    include('sanphamNoiBac.php');
    ?>
</div>

<?php
include("footer.php");
?>
