<style>
    body {
        background-color: #1a1a1a; /* Nền đen thống nhất */
        color: #f0f0f0; /* Chữ màu sáng thống nhất */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Font mềm mại hơn */
        margin: 0;
        padding: 0;
    }

    .nen {
        background-color: #1a1a1a; /* Đảm bảo nền vẫn là đen */
    }

    /* --------- CHỮ HIGHLIGHT cho sp nổi bậc (Điều chỉnh để trông hiện đại hơn) --------- */
    .highlighted-products {
        text-align: center;
        margin: 30px auto; /* Căn giữa và thêm khoảng cách */
        padding-bottom: 10px;
        border-bottom: 1px solid #444; /* Đường kẻ dưới tiêu đề */
        max-width: 1200px; /* Giới hạn chiều rộng để căn giữa đẹp hơn */
    }

    .highlighted-products h2 {
        font-size: 2.8em; /* Kích thước chữ lớn */
        color:rgb(255, 255, 255); /* Màu xanh ngọc độc đáo */
        margin-bottom: 10px; /* Khoảng cách dưới */
        font-weight: 600; /* Làm đậm vừa phải */
        text-transform: uppercase; /* Chữ in hoa */
        letter-spacing: 1.5px; /* Khoảng cách giữa các chữ */
        position: relative;
        padding: 10px 0;
        text-shadow: 0 0 5px rgba(0, 188, 212, 0.4); /* Đổ bóng nhẹ */
    }

    .highlighted-products h2::before,
    .highlighted-products h2::after {
        content: "";
        position: absolute;
        top: 50%;
        width: 0%; /* Độ dài của đường kẻ ban đầu */
        height: 2px;
        background-color:rgb(255, 255, 255); /* Màu xanh ngọc cho đường kẻ */
        transition: width 0.3s ease;
    }

    .highlighted-products h2::before {
        left: 0;
    }

    .highlighted-products h2::after {
        right: 0;
    }

    .highlighted-products h2:hover::before,
    .highlighted-products h2:hover::after {
        width: 30%; /* Mở rộng đường kẻ khi hover */
    }

    /* ---------- Thẻ CARD (Cập nhật để đồng bộ với Loc.php) ---------- */
    .container, .product-container { /* Áp dụng cho cả hai container của bạn */
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px; /* Khoảng cách giữa các card lớn hơn */
        justify-content: center; /* Căn giữa các item trong grid */
        max-width: 1200px; /* Giới hạn chiều rộng để căn giữa đẹp hơn */
        margin: 20px auto; /* Căn giữa và thêm khoảng cách trên dưới */
        padding: 0 20px; /* Thêm padding ngang */
    }

    .card {
        background-color: #2a2a2a; /* Nền card màu tối */
        border: 1px solid #4a4a4a; /* Viền rõ hơn */
        border-radius: 12px; /* Bo góc mềm mại hơn */
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5); /* Đổ bóng mạnh hơn */
        transition: transform 0.25s ease-in-out, box-shadow 0.25s ease-in-out;
        cursor: pointer;
        width: auto; /* Cho phép grid tự điều chỉnh width */
        height: auto; /* Cho phép nội dung tự điều chỉnh height */
        display: flex; /* Dùng flexbox để sắp xếp nội dung trong card */
        flex-direction: column; /* Sắp xếp các mục theo cột */
    }

    .card:hover {
        transform: translateY(-7px); /* Nhấc lên nhiều hơn */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.7); /* Đổ bóng mạnh hơn khi hover */
    }

    .card-img-top {
        width: 100%;
        height: 220px; /* Chiều cao ảnh lớn hơn */
        object-fit: cover;
        border-bottom: 1px solid #3d3d3d; /* Viền dưới ảnh */
    }

    .card-body {
        padding: 18px; /* Padding lớn hơn */
        text-align: center; /* Căn giữa nội dung card */
        flex-grow: 1; /* Cho phép body card mở rộng để lấp đầy không gian còn lại */
        display: flex;
        flex-direction: column;
        justify-content: center; /* Căn giữa nội dung theo chiều dọc trong body */
    }

    .card-title {
        color: #00bcd4; /* Màu xanh ngọc */
        font-size: 1.6em; /* To hơn */
        margin-bottom: 12px;
        font-weight: bold;
        text-shadow: 0 0 3px rgba(0, 188, 212, 0.2);
    }

    .card-text {
        color: #f5f5f5; /* Màu trắng sáng hơn */
        font-size: 1.1em;
        margin-bottom: 8px;
    }

    /* ---------- Bút chuyển trang (Cập nhật để đồng bộ) --------- */
    /* Lưu ý: Các nút phân trang này không có trong PHP code bạn cung cấp,
       nhưng nếu có, style này sẽ áp dụng */
    .pagination {
        display: flex; /* Dùng flexbox */
        justify-content: center; /* Căn giữa */
        margin-top: 40px; /* Khoảng cách trên */
        padding-bottom: 25px;
    }

    .pagination a {
        color:rgb(255, 255, 255); /* Màu xanh ngọc */
        padding: 10px 18px; /* Padding lớn hơn */
        text-decoration: none;
        transition: background-color .3s, color .3s, border-color .3s;
        border: 1px solid #4a4a4a; /* Viền rõ hơn */
        margin: 0 5px;
        border-radius: 6px;
        font-weight: 500;
    }

    .pagination a.current {
        background-color:rgb(255, 255, 255); /* Màu xanh ngọc khi active */
        color: white;
        border: 1px solid #0097a7;
    }

    .pagination a:hover:not(.current) {
        background-color: #3b3b3b; /* Màu nền hover */
        color: #00bcd4;
        border-color: #00bcd4;
    }

    /* Nếu bạn có các nút .btn riêng không phải phân trang, có thể giữ style này hoặc điều chỉnh */
    .btn {
        background-color: #00bcd4; /* Màu xanh ngọc cho nút */
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.2s;
    }

    .btn:hover {
        background-color: #0097a7; /* Màu xanh đậm hơn khi hover */
        transform: scale(1.05);
    }

</style>
<br>
<br>

<?php
include("ConnectDatabase.php");

// Lấy 12 sản phẩm có giá thấp nhất (đã sửa từ 15 và 8 thành 12 theo yêu cầu bạn)
$low_price_sql = "SELECT * FROM XeHoi ORDER BY Gia ASC LIMIT 12";
$low_price_result = $conn->query($low_price_sql);

// Lấy 12 sản phẩm có giá cao nhất
$high_price_sql = "SELECT * FROM XeHoi ORDER BY Gia DESC LIMIT 12";
$high_price_result = $conn->query($high_price_sql);


// Hiển thị sản phẩm nổi bật
echo '<div class="highlighted-products">';
echo '<h2>Sản phẩm nổi bật</h2>';
echo '<div class="container">'; // Giữ nguyên class 'container'
if ($low_price_result->num_rows > 0) {
    while($row = $low_price_result->fetch_assoc()) {
        echo '<div class="card" onclick="showDetails(\'' . htmlspecialchars($row['MaXe']) . '\')">'; // Giữ nguyên class 'card'
        echo '<img src="assets/img/Xe/' . htmlspecialchars($row['AnhXe']) . '" class="card-img-top" alt="' . htmlspecialchars($row['TenXe']) . '">'; // Giữ nguyên class 'card-img-top'
        echo '<div class="card-body">'; // Giữ nguyên class 'card-body'
        echo '<h4 class="card-title">' . htmlspecialchars($row['TenXe']) . '</h4>'; // Giữ nguyên class 'card-title'
        echo '<p class="card-text">Giá: ' . number_format($row['Gia'], 0, ',', '.') . ' VNĐ</p>'; // Giữ nguyên class 'card-text'
        echo '</div>';
        echo '</div>';
    }
}
echo '</div>';
echo '</div>';

// Hiển thị sản phẩm có giá cao nhất
echo '<div class="highlighted-products">';
echo '<h2>Sản phẩm cao cấp</h2>';
echo '<div class="product-container">'; // Giữ nguyên class 'product-container'
if ($high_price_result->num_rows > 0) {
    while($row = $high_price_result->fetch_assoc()) {
        echo '<div class="card" onclick="showDetails(\'' . htmlspecialchars($row['MaXe']) . '\')">'; // Giữ nguyên class 'card'
        echo '<img src="assets/img/Xe/' . htmlspecialchars($row['AnhXe']) . '" class="card-img-top" alt="' . htmlspecialchars($row['TenXe']) . '">'; // Giữ nguyên class 'card-img-top'
        echo '<div class="card-body">'; // Giữ nguyên class 'card-body'
        echo '<h4 class="card-title">' . htmlspecialchars($row['TenXe']) . '</h4>'; // Giữ nguyên class 'card-title' (Bạn dùng h3, tôi đổi về h4 để đồng bộ với phần trên và Loc.php)
        echo '<p class="card-text">Giá: ' . number_format($row['Gia'], 0, ',', '.') . ' VNĐ</p>'; // Giữ nguyên class 'card-text'
        echo '</div>';
        echo '</div>';
    }
}
echo '</div>';
echo '</div>';

// Đóng kết nối
$conn->close();
?>

<br>
<br>

<script>
function showDetails(maXe) {
    // Gọi AJAX hoặc chuyển hướng đến trang chi tiết sản phẩm
    window.location.href = 'product_details.php?maXe=' + maXe;
}
</script>