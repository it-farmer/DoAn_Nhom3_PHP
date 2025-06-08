
 <!-- CSS để định dạng tiêu đề và sản phẩm -->
<style>
    .nen{
        background-color: black;
    }
    /* --------- CHỮ HIGHTLIGHT cho sp nổi bậc =) --------- */
    .highlighted-products {
        margin: 3%;
        text-align: center;
    }

    .highlighted-products h2 {
        font-size: 3rem; /* Kích thước chữ lớn */
        color: white; /* Màu chữ đen */
        margin-bottom: 20px; /* Khoảng cách dưới */
        font-weight: bold; /* Làm đậm chữ */
        text-transform: uppercase; /* Chữ in hoa */
        letter-spacing: 2px; /* Khoảng cách giữa các chữ */
        position: relative; /* Để sử dụng cho hiệu ứng hover */
        padding: 10px 0; /* Khoảng cách trên và dưới */
        text-shadow: 2px 2px 5px rgba(255, 254, 254, 0.37); /* Đổ bóng cho chữ */
        color: white;
    }

    .highlighted-products h2::before,
    .highlighted-products h2::after {
        content: ""; /* Tạo đường kẻ */
        position: absolute; /* Đặt vị trí tuyệt đối */
        top: 50%; /* Căn giữa theo chiều dọc */
        width: 0%; /* Độ dài của đường kẻ ban đầu */
        height: 2px; /* Độ dày của đường kẻ */
        background-color:rgb(255, 254, 254); /* Màu đường kẻ */
        transition: width 0.3s ease; /* Hiệu ứng chuyển đổi khi hover */
        color: black;
    }

    .highlighted-products h2::before {
        left: 0; /* Đường kẻ bên trái */
        color: black;
    }

    .highlighted-products h2::after {
        right: 0; /* Đường kẻ bên phải */
        color: black;
    }

    .highlighted-products h2:hover::before,
    .highlighted-products h2:hover::after {
        width: 30%; /* Mở rộng đường kẻ khi hover */
        color: black;
    }
/* ---------- Thẻ CARD ---------- */
    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        /* margin: 20px; */
    }
    .product-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }
    .card {
        width: 20rem;
        height: 19rem;
        margin: 20px;
        background-color: white;
        padding: 10px;
        border-radius: 15px; /* Bo tròn góc card */
        box-shadow: 0 4px 8px rgba(255, 255, 255, 0.2); /* Đổ bóng cho card */
        transition: transform 0.2s; /* Hiệu ứng khi hover */
        font-family: "Arial", sans-serif; /* Font chữ */
        cursor: pointer;

    }
    .card:hover {
        transform: scale(1.05); /* Phóng to khi hover */
    }
    .card-img-top {
        width: 100%;
        height: 60%;
        object-fit: cover;
        border-top-left-radius: 15px; /* Bo tròn góc trên trái */
        border-top-right-radius: 15px; /* Bo tròn góc trên phải */
    }
    .card-body {
        text-align: center; /* Căn giữa nội dung card */
    }
    .card-title {
        font-size: 1.5rem; /* Kích thước chữ tên xe */
        margin: 10px 0; /* Khoảng cách trên và dưới */
    }
    .card-text {
        font-size: 1.2rem; /* Kích thước chữ giá xe */
        margin: 10px 0; /* Khoảng cách trên và dưới */
    }
/* ---------- Bút chuyển trang  --------- */
    .btn {
        background-color: #444; /* Màu nền nút */
        color: white; /* Màu chữ */
        border: none; /* Không có viền */
        padding: 10px 15px; /* Padding cho nút */
        border-radius: 5px; /* Bo tròn góc nút */
        transition: background-color 0.3s, transform 0.2s; /* Hiệu ứng chuyển đổi */
    }

    .btn:hover {
        background-color: #666; /* Màu nền khi hover */
        transform: scale(1.05); /* Phóng to nhẹ khi hover */
    }

    .pagination {
        text-align: center; /* Căn giữa */
        margin-top: 20px; /* Khoảng cách trên */
    }

    .pagination a {
        margin: 0 5px; /* Khoảng cách giữa các nút */
        padding: 10px 15px; /* Padding cho các nút */
        text-decoration: none; /* Xóa gạch chân */
        border: 1px solid #555; /* Viền màu trung tính */
        color: white; /* Màu chữ trắng */
        border-radius: 5px; /* Bo tròn góc */
        background-color: #333; /* Màu nền cho các nút phân trang */
        transition: background-color 0.3s, color 0.3s; /* Hiệu ứng chuyển đổi */
    }

    .pagination a.current {
        background-color: #555; /* Màu nền cho nút hiện tại */
        color: white; /* Màu chữ cho nút hiện tại */
        border: 1px solid #777; /* Viền màu sáng hơn cho nút hiện tại */
    }

    .pagination a:hover:not(.current) {
        background-color: #444; /* Màu nền khi hover cho nút không phải hiện tại */
        color: white; /* Màu chữ khi hover */
    }
    /* ---------------- */

</style>
<br>
<br>

<?php
include("ConnectDatabase.php");

// Lấy 15 sản phẩm có giá thấp nhất
$low_price_sql = "SELECT * FROM XeHoi ORDER BY Gia ASC LIMIT 15";
$low_price_result = $conn->query($low_price_sql);

// Lấy 8 sản phẩm có giá cao nhất
$high_price_sql = "SELECT * FROM XeHoi ORDER BY Gia DESC LIMIT 15";
$high_price_result = $conn->query($high_price_sql);



// Hiển thị sản phẩm nổi bật
echo '<div class="highlighted-products">';
echo '<h2>Sản phẩm nổi bật</h2>';
echo '<div class="container">';
if ($low_price_result->num_rows > 0) {
    while($row = $low_price_result->fetch_assoc()) {
        echo '<div class="card" onclick="showDetails(\'' . $row['MaXe'] . '\')">';
        echo '<img src="assets/img/Xe/' . $row['AnhXe'] . '" class="card-img-top" alt="' . $row['TenXe'] . '">';
        echo '<div class="card-body">';
        echo '<h4 class="card-title">' . $row['TenXe'] . '</h4>';
        echo '<p class="card-text">Giá: ' . number_format($row['Gia'], 0, ',', '.') . ' VNĐ</p>';
        echo '</div>';
        echo '</div>';
    }
}
echo '</div>'; 
echo '</div>'; 

// Hiển thị sản phẩm có giá cao nhất
echo '<div class="highlighted-products">';
echo '<h2>Sản phẩm cao cấp</h2>';
echo '<div class="product-container">';
if ($high_price_result->num_rows > 0) {
    while($row = $high_price_result->fetch_assoc()) {
        echo '<div class="card" onclick="showDetails(\'' . $row['MaXe'] . '\')">';
        echo '<img src="assets/img/Xe/' . $row['AnhXe'] . '" class="card-img-top" alt="' . $row['TenXe'] . '">';
        echo '<div class="card-body">';
        echo '<h3 class="card-title">' . $row['TenXe'] . '</h3>';
        echo '<p class="card-text">Giá: ' . number_format($row['Gia'], 0, ',', '.') . ' VNĐ</p>';
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

