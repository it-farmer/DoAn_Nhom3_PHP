<?php
include("ConnectDatabase.php"); // Đảm bảo file này chứa kết nối $conn

// Khởi tạo các biến lọc
$filter_conditions = [];
$filter_params = [];
$filter_types = "";
$filter_title = "Kết Quả Lọc"; // Tiêu đề mặc định
$additional_info = ""; // Thông tin thêm hiển thị dưới card

// --- Xử lý Lọc Theo Giá ---
if (isset($_GET['price'])) {
    $price_range = $_GET['price'];
    switch ($price_range) {
        case 'duoi_200':
            $filter_conditions[] = "XeHoi.Gia < 200000000";
            $filter_title = "Xe Dưới 200 Triệu";
            break;
        case '200_500':
            $filter_conditions[] = "XeHoi.Gia BETWEEN 200000000 AND 500000000";
            $filter_title = "Xe Từ 200 - 500 Triệu";
            break;
        case '500_1ty':
            $filter_conditions[] = "XeHoi.Gia BETWEEN 500000000 AND 1000000000";
            $filter_title = "Xe Từ 500 Triệu - 1 Tỷ";
            break;
        case '1ty_3ty':
            $filter_conditions[] = "XeHoi.Gia BETWEEN 1000000000 AND 3000000000";
            $filter_title = "Xe Từ 1 Tỷ - 3 Tỷ";
            break;
        case 'tren_3ty':
            $filter_conditions[] = "XeHoi.Gia > 3000000000";
            $filter_title = "Xe Trên 3 Tỷ";
            break;
    }
}

// --- Xử lý Lọc Theo Màu ---
if (isset($_GET['color'])) {
    $color = $_GET['color'];
    $filter_conditions[] = "XeHoi.MauXe = ?";
    $filter_params[] = $color;
    $filter_types .= "s";
    $filter_title = "Xe Màu " . htmlspecialchars($color);
}

// --- Xử lý Lọc Theo Năm Sản Xuất ---
if (isset($_GET['year'])) {
    $year_option = $_GET['year'];
    switch ($year_option) {
        case 'duoi_2021':
            $filter_conditions[] = "ThongSoKyThuat.NamSanXuat < 2021";
            $filter_title = "Xe Sản Xuất Dưới 2021";
            break;
        case '2022':
            $filter_conditions[] = "ThongSoKyThuat.NamSanXuat = 2022";
            $filter_title = "Xe Sản Xuất Năm 2022";
            break;
        case '2023':
            $filter_conditions[] = "ThongSoKyThuat.NamSanXuat = 2023";
            $filter_title = "Xe Sản Xuất Năm 2023";
            break;
    }
    $additional_info = "Năm Sản Xuất";
}

// --- Xử lý Lọc Theo Tốc Độ ---
if (isset($_GET['speed'])) {
    $speed_range = $_GET['speed'];
    switch ($speed_range) {
        case 'duoi_250':
            $filter_conditions[] = "CAST(REPLACE(ThongSoKyThuat.TocDoToiDa, ' km/h', '') AS UNSIGNED) < 250";
            $filter_title = "Xe Tốc Độ Dưới 250 km/h";
            break;
        case '250_300':
            $filter_conditions[] = "CAST(REPLACE(ThongSoKyThuat.TocDoToiDa, ' km/h', '') AS UNSIGNED) BETWEEN 250 AND 300";
            $filter_title = "Xe Tốc Độ Từ 250 - 300 km/h";
            break;
        case 'tren_300':
            $filter_conditions[] = "CAST(REPLACE(ThongSoKyThuat.TocDoToiDa, ' km/h', '') AS UNSIGNED) > 300";
            $filter_title = "Xe Tốc Độ Trên 300 km/h";
            break;
    }
    $additional_info = "Tốc Độ Tối Đa";
}

// --- Xử lý Lọc Theo Động Cơ ---
if (isset($_GET['engine'])) {
    $engine_type = $_GET['engine'];
    $filter_conditions[] = "ThongSoKyThuat.DongCo = ?";
    $filter_params[] = $engine_type;
    $filter_types .= "s";
    $filter_title = "Xe Động Cơ " . htmlspecialchars(ucfirst($engine_type));
    $additional_info = "Động Cơ";
}

// Nếu có lọc theo hãng xe từ trước (trường hợp trang này được gọi từ trang hãng xe)
$hangxe = isset($_GET['hangxe']) ? $_GET['hangxe'] : '';
if (!empty($hangxe)) {
    $filter_conditions[] = "XeHoi.MaHX = ?";
    $filter_params[] = $hangxe;
    $filter_types .= "s";

    // Cập nhật tiêu đề nếu chỉ lọc theo hãng xe hoặc kết hợp
    if (count($filter_conditions) === 1 && !isset($_GET['price']) && !isset($_GET['color']) && !isset($_GET['year']) && !isset($_GET['speed']) && !isset($_GET['engine'])) {
        $sql_hangxe = "SELECT TenHX FROM HangXe WHERE MaHX = ?";
        $stmt_hangxe = $conn->prepare($sql_hangxe);
        $stmt_hangxe->bind_param("s", $hangxe);
        $stmt_hangxe->execute();
        $result_hangxe = $stmt_hangxe->get_result();
        if ($result_hangxe->num_rows > 0) {
            $row_hangxe = $result_hangxe->fetch_assoc();
            $filter_title = htmlspecialchars($row_hangxe['TenHX']);
        }
    } else if (count($filter_conditions) > 1) { // Kết hợp lọc hãng xe với các loại lọc khác
        $sql_hangxe_title = "SELECT TenHX FROM HangXe WHERE MaHX = ?";
        $stmt_hangxe_title = $conn->prepare($sql_hangxe_title);
        $stmt_hangxe_title->bind_param("s", $hangxe);
        $stmt_hangxe_title->execute();
        $result_hangxe_title = $stmt_hangxe_title->get_result();
        if ($result_hangxe_title->num_rows > 0) {
            $row_hangxe_title = $result_hangxe_title->fetch_assoc();
            $filter_title .= " - Hãng " . htmlspecialchars($row_hangxe_title['TenHX']);
        }
    }
}


// --- Logic phân trang ---
$limit = 8; // Số sản phẩm trên mỗi trang
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $limit;

// Xây dựng câu truy vấn SQL CƠ SỞ (không có LIMIT/OFFSET) để đếm tổng số bản ghi
$base_sql = "SELECT XeHoi.*, ThongSoKyThuat.NamSanXuat, ThongSoKyThuat.DongCo, ThongSoKyThuat.TocDoToiDa
             FROM XeHoi
             JOIN ThongSoKyThuat ON XeHoi.MaXe = ThongSoKyThuat.MaXe";

if (!empty($filter_conditions)) {
    $base_sql .= " WHERE " . implode(" AND ", $filter_conditions);
}

// --- Đếm tổng số bản ghi ---
$count_sql = "SELECT COUNT(DISTINCT XeHoi.MaXe) AS total_records FROM XeHoi JOIN ThongSoKyThuat ON XeHoi.MaXe = ThongSoKyThuat.MaXe";
if (!empty($filter_conditions)) {
    $count_sql .= " WHERE " . implode(" AND ", $filter_conditions);
}

$stmt_count = $conn->prepare($count_sql);
if (!empty($filter_params)) {
    $stmt_count->bind_param($filter_types, ...$filter_params);
}
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$row_count = $result_count->fetch_assoc();
$total_records = $row_count['total_records'];
$total_pages = ceil($total_records / $limit); // Tổng số trang

// --- Lấy dữ liệu cho trang hiện tại ---
$sql_data = $base_sql . " LIMIT ? OFFSET ?";
$stmt_data = $conn->prepare($sql_data);

// Thêm kiểu dữ liệu cho LIMIT và OFFSET
$data_filter_types = $filter_types . "ii"; // 'i' cho integer

// Ghép các tham số lọc với tham số phân trang
$data_filter_params = array_merge($filter_params, [$limit, $offset]);

if (!empty($data_filter_params)) {
    $stmt_data->bind_param($data_filter_types, ...$data_filter_params);
}

$stmt_data->execute();
$result_data = $stmt_data->get_result();

$title = $filter_title; // Gán tiêu đề động cho trang
include("header.php"); // Bao gồm header

?>
<div class="nen">
    <br>
    <br>

    <?php
    // Hiển thị tiêu đề lọc
    echo '<div class="highlighted-products">';
    echo '<h2>' . htmlspecialchars($filter_title) . '</h2>';
    echo '</div>';

    // Hiển thị danh sách xe
    echo '<div class="container">';
    if ($result_data->num_rows > 0) {
        while ($row = $result_data->fetch_assoc()) {
            echo '<div class="card" onclick="showDetails(\'' . htmlspecialchars($row['MaXe']) . '\')">';
            echo '<img src="assets/img/Xe/' . htmlspecialchars($row['AnhXe']) . '" class="card-img-top" alt="' . htmlspecialchars($row['TenXe']) . '">';
            echo '<div class="card-body">';
            echo '<h4 class="card-title">' . htmlspecialchars($row['TenXe']) . '</h4>';
            echo '<p class="card-text">Giá: ' . number_format($row['Gia'], 0, ',', '.') . ' VNĐ</p>';

            // Hiển thị thông tin bổ sung nếu có
            if ($additional_info === "Năm Sản Xuất" && isset($row['NamSanXuat'])) {
                echo '<p class="card-text">Năm Sản Xuất: ' . htmlspecialchars($row['NamSanXuat']) . '</p>';
            } elseif ($additional_info === "Động Cơ" && isset($row['DongCo'])) {
                echo '<p class="card-text">Động Cơ: ' . htmlspecialchars($row['DongCo']) . '</p>';
            } elseif ($additional_info === "Tốc Độ Tối Đa" && isset($row['TocDoToiDa'])) {
                echo '<p class="card-text">Tốc Độ Tối Đa: ' . htmlspecialchars($row['TocDoToiDa']) . '</p>';
            }
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "<p>Không có sản phẩm nào phù hợp với tiêu chí lọc.</p>";
    }
    echo '</div>'; // Đóng container

    // --- Hiển thị phân trang ---
    if ($total_pages > 1) {
        echo '<div class="pagination">';
        // Nút Previous
        if ($current_page > 1) {
            echo '<a href="?' . http_build_query(array_merge($_GET, ['page' => $current_page - 1])) . '">&laquo; Trang Trước</a>';
        }

        // Các nút số trang
        for ($i = 1; $i <= $total_pages; $i++) {
            $active_class = ($i == $current_page) ? 'active' : '';
            echo '<a class="' . $active_class . '" href="?' . http_build_query(array_merge($_GET, ['page' => $i])) . '">' . $i . '</a>';
        }

        // Nút Next
        if ($current_page < $total_pages) {
            echo '<a href="?' . http_build_query(array_merge($_GET, ['page' => $current_page + 1])) . '">Trang Sau &raquo;</a>';
        }
        echo '</div>'; // Đóng pagination
    }

    // Đóng kết nối
    $conn->close();
    include('sanphamNoiBac.php'); // Nếu bạn muốn hiển thị sản phẩm nổi bật ở cuối trang lọc
    ?>
</div>

<?php
include("footer.php"); // Bao gồm footer
?>
