<?php
include("ConnectDatabase.php"); // Đảm bảo file này chứa kết nối $conn
include("Header.php"); // Bao gồm header để có tiêu đề trang

// Khởi tạo các biến lọc
$filter_conditions = [];
$filter_params = [];
$filter_types = "";


// Lấy các giá trị lọc từ form POST hoặc từ GET (nếu chuyển trang)
$selected_prices = isset($_POST['price']) ? $_POST['price'] : (isset($_GET['price']) ? $_GET['price'] : []);
$selected_colors = isset($_POST['color']) ? $_POST['color'] : (isset($_GET['color']) ? $_GET['color'] : []);
$selected_years = isset($_POST['year']) ? $_POST['year'] : (isset($_GET['year']) ? $_GET['year'] : []);
$selected_speeds = isset($_POST['speed']) ? $_POST['speed'] : (isset($_GET['speed']) ? $_GET['speed'] : []);
$selected_engines = isset($_POST['engine']) ? $_POST['engine'] : (isset($_GET['engine']) ? $_GET['engine'] : []);

// Biến cờ để kiểm tra xem form đã được submit hay có tiêu chí lọc nào được chọn không
// Dựa vào $_POST để biết có phải là submit form hay không, hoặc $_GET['page'] để biết là phân trang
$form_submitted = !empty($_POST) || (isset($_GET['page']) && !empty(array_filter($_GET, fn($key) => $key !== 'page', ARRAY_FILTER_USE_KEY)));

$has_filters_selected = false;
if (!empty($selected_prices) || !empty($selected_colors) || !empty($selected_years) || !empty($selected_speeds) || !empty($selected_engines)) {
    $has_filters_selected = true;
   
}

// Khởi tạo một mảng để lưu trữ tất cả các tham số lọc hiện tại (dùng cho phân trang)
$current_filter_params = [];

// Nếu có dữ liệu POST (tức là form lọc vừa được submit)
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        if ($key !== 'page') {
            $current_filter_params[$key] = $value;
        }
    }
} else {
    // Nếu không có POST (tức là request GET, ví dụ: từ phân trang hoặc lần đầu tải trang)
    foreach ($_GET as $key => $value) {
        if ($key !== 'page') {
            $current_filter_params[$key] = $value;
        }
    }
}

// Xử lý lọc CHỈ KHI có tiêu chí lọc được chọn (dù là từ POST hay GET)
if ($has_filters_selected || !empty($current_filter_params)) {

    // --- Xử lý Lọc Theo Giá ---
    if (!empty($selected_prices)) {
        $price_conditions = [];
        foreach ($selected_prices as $price_range) {
            switch ($price_range) {
                case 'duoi_200': $price_conditions[] = "XeHoi.Gia < 200000000"; break;
                case '200_500': $price_conditions[] = "XeHoi.Gia BETWEEN 200000000 AND 500000000"; break;
                case '500_1ty': $price_conditions[] = "XeHoi.Gia BETWEEN 500000000 AND 1000000000"; break;
                case '1ty_3ty': $price_conditions[] = "XeHoi.Gia BETWEEN 1000000000 AND 3000000000"; break;
                case 'tren_3ty': $price_conditions[] = "XeHoi.Gia > 3000000000"; break;
            }
        }
        if (!empty($price_conditions)) {
            $filter_conditions[] = "(" . implode(" OR ", $price_conditions) . ")";
        }
    }

    // --- Xử lý Lọc Theo Màu ---
    if (!empty($selected_colors)) {
        $color_placeholders = implode(',', array_fill(0, count($selected_colors), '?'));
        $filter_conditions[] = "XeHoi.MauXe IN ($color_placeholders)";
        $filter_params = array_merge($filter_params, $selected_colors);
        $filter_types .= str_repeat('s', count($selected_colors));
    }

    // --- Xử lý Lọc Theo Năm Sản Xuất ---
    if (!empty($selected_years)) {
        $year_conditions = [];
        foreach ($selected_years as $year_option) {
            switch ($year_option) {
                case 'duoi_2021': $year_conditions[] = "ThongSoKyThuat.NamSanXuat < 2021"; break;
                case '2022': $year_conditions[] = "ThongSoKyThuat.NamSanXuat = 2022"; break;
                case '2023': $year_conditions[] = "ThongSoKyThuat.NamSanXuat = 2023"; break;
            }
        }
        if (!empty($year_conditions)) {
            $filter_conditions[] = "(" . implode(" OR ", $year_conditions) . ")";
        }
    }

    // --- Xử lý Lọc Theo Tốc Độ ---
    if (!empty($selected_speeds)) {
        $speed_conditions = [];
        foreach ($selected_speeds as $speed_range) {
            switch ($speed_range) {
                case 'duoi_250': $speed_conditions[] = "CAST(REPLACE(ThongSoKyThuat.TocDoToiDa, ' km/h', '') AS UNSIGNED) < 250"; break;
                case '250_300': $speed_conditions[] = "CAST(REPLACE(ThongSoKyThuat.TocDoToiDa, ' km/h', '') AS UNSIGNED) BETWEEN 250 AND 300"; break;
                case 'tren_300': $speed_conditions[] = "CAST(REPLACE(ThongSoKyThuat.TocDoToiDa, ' km/h', '') AS UNSIGNED) > 300"; break;
            }
        }
        if (!empty($speed_conditions)) {
            $filter_conditions[] = "(" . implode(" OR ", $speed_conditions) . ")";
        }
    }

    // --- Xử lý Lọc Theo Động Cơ ---
    if (!empty($selected_engines)) {
        $engine_placeholders = implode(',', array_fill(0, count($selected_engines), '?'));
        $filter_conditions[] = "ThongSoKyThuat.DongCo IN ($engine_placeholders)";
        $filter_params = array_merge($filter_params, $selected_engines);
        $filter_types .= str_repeat('s', count($selected_engines));
    }
}

// Nếu có lọc theo hãng xe từ GET
$hangxe = isset($_GET['hangxe']) ? $_GET['hangxe'] : '';
if (!empty($hangxe)) {
    $filter_conditions[] = "XeHoi.MaHX = ?";
    $filter_params[] = $hangxe;
    $filter_types .= "s";
    // Cập nhật tiêu đề nếu có lọc theo hãng
    $sql_hangxe_title = "SELECT TenHX FROM HangXe WHERE MaHX = ?";
    $stmt_hangxe_title = $conn->prepare($sql_hangxe_title);
    $stmt_hangxe_title->bind_param("s", $hangxe);
    $stmt_hangxe_title->execute();
    $result_hangxe_title = $stmt_hangxe_title->get_result();
    if ($result_hangxe_title->num_rows > 0) {
        $row_hangxe_title = $result_hangxe_title->fetch_assoc();
       
    }
    // Đảm bảo hangxe cũng được thêm vào current_filter_params để phân trang
    $current_filter_params['hangxe'] = $hangxe;
}


// --- Logic phân trang ---
$limit = 9; // Số sản phẩm trên mỗi trang
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $limit;

// Xây dựng câu truy vấn SQL CƠ SỞ (không có LIMIT/OFFSET) để đếm tổng số bản ghi
$base_sql = "SELECT XeHoi.*, ThongSoKyThuat.NamSanXuat, ThongSoKyThuat.DongCo, ThongSoKyThuat.TocDoToiDa
             FROM XeHoi
             LEFT JOIN ThongSoKyThuat ON XeHoi.MaXe = ThongSoKyThuat.MaXe";

$count_sql_where_clause = "";
if (!empty($filter_conditions)) {
    $count_sql_where_clause = " WHERE " . implode(" AND ", $filter_conditions);
}

// --- Đếm tổng số bản ghi ---
$count_sql = "SELECT COUNT(DISTINCT XeHoi.MaXe) AS total_records FROM XeHoi LEFT JOIN ThongSoKyThuat ON XeHoi.MaXe = ThongSoKyThuat.MaXe" . $count_sql_where_clause;

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
$sql_data = $base_sql . $count_sql_where_clause . " LIMIT ? OFFSET ?";
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
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        /* CSS cho nền đen và các phần tử lọc */
        body {
            background-color: #1a1a1a; /* Nền đen */
            color: #f0f0f0; /* Chữ màu sáng */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Font mềm mại hơn */
            margin: 0;
            padding: 0;
        }

        .khu-chinh {
            padding: 20px;
        }

        .tieu-de-chung {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid #444;
        }

        .tieu-de-chung h2 {
            color: rgb(255, 255, 255); /* Màu trắng */
            font-size: 2.8em; /* To hơn chút */
            font-weight: 600; /* Đậm vừa phải */
            margin-bottom: 10px;
            text-shadow: 0 0 5px rgba(0, 188, 212, 0.4); /* Thêm đổ bóng nhẹ */
        }

        /* Container cho các nút lọc chính (Lọc Theo Giá, Lọc Theo Màu, ...) */
        .thanh-loc-chinh {
            display: flex; /* Hiển thị các nút theo hàng ngang */
            flex-wrap: wrap; /* Cho phép xuống dòng nếu không đủ chỗ */
            gap: 15px; /* Khoảng cách giữa các nút */
            justify-content: center; /* Căn giữa các nút */
            /* background-color: #2a2a2a; */
            border-radius: 10px; /* Bo góc mềm mại hơn */
           
           
        }

        .nut-loc-chinh {
            background-color: #3b3b3b; /* Màu nền nút */
            color: #e0e0e0; /* Màu chữ nút */
            padding: 12px 25px; /* Padding lớn hơn */
            border: none;
            border-radius: 6px; /* Bo góc nhẹ */
            cursor: pointer;
            font-size: 1.15em; /* Font lớn hơn chút */
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
            display: flex; /* Dùng flex để căn icon nếu có */
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Đổ bóng nhẹ cho nút */
        }

        .nut-loc-chinh:hover {
            background-color: #00bcd4; /* Màu xanh ngọc khi hover */
            color: white;
            transform: translateY(-2px); /* Hiệu ứng nhấc nhẹ khi hover */
            box-shadow: 0 4px 8px rgba(0, 188, 212, 0.3); /* Đổ bóng khi hover */
        }

        .nut-loc-chinh.active {
            background-color: #00bcd4;
            color: white;
            border: 1px solid #0097a7; /* Viền khi active */
            box-shadow: 0 4px 10px rgba(0, 188, 212, 0.5);
        }

        /* Container cho form lọc (chứa các dropdown khi nhấp) */
        .khu-form-loc {
            /*background-color: #2a2a2a; /* Cố định màu nền */
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); */
            position: relative;
            text-align: center; /* Căn giữa các nút trong form */
        }

        /* Các dropdown/menu con chứa checkbox */
        .menu-loc-con {
            display: none; /* Mặc định ẩn */
            position: absolute;
            background-color: #3a3a3a; /* Nền của dropdown */
            min-width: 250px; /* Rộng hơn chút */
            box-shadow: 0px 10px 20px 0px rgba(0,0,0,0.5); /* Đổ bóng mạnh hơn */
            z-index: 100;
            padding: 20px; /* Padding lớn hơn */
            border-radius: 8px;
            border: 1px solid #555;
            top: calc(100% + 15px); /* Đặt dưới nút chính, khoảng cách lớn hơn */
            left: 50%;
            transform: translateX(-50%);
            animation: fadeIn 0.3s ease-out; /* Thêm hiệu ứng fade in */
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(-50%) translateY(-10px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }

        .menu-loc-con.hien-thi {
            display: block; /* Hiện khi có class hien-thi */
        }

        .menu-loc-con label {
            display: flex;
            align-items: center;
            margin-bottom: 12px; /* Khoảng cách giữa các checkbox lớn hơn */
            cursor: pointer;
            color: #ccc;
            font-size: 1.05em; /* Font lớn hơn chút */
        }

        .menu-loc-con label:last-child {
            margin-bottom: 0;
        }

        .menu-loc-con input[type="checkbox"] {
            margin-right: 12px; /* Khoảng cách lớn hơn */
            width: 20px; /* Kích thước checkbox lớn hơn */
            height: 20px;
            vertical-align: middle;
            accent-color: #00bcd4; /* Màu xanh ngọc khi checkbox được check */
            cursor: pointer;
            border-radius: 3px; /* Bo góc nhẹ cho checkbox */
        }

        .menu-loc-con input[type="checkbox"]:checked + span {
            color: #00bcd4;
            font-weight: bold;
        }

        .menu-loc-con .nut-ap-dung {
            background-color: #00bcd4;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-top: 20px; /* Khoảng cách lớn hơn */
            width: 100%;
            transition: background-color 0.3s ease, box-shadow 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 188, 212, 0.2);
        }

        .menu-loc-con .nut-ap-dung:hover {
            background-color: #0097a7; /* Màu xanh đậm hơn khi hover */
            box-shadow: 0 4px 8px rgba(0, 188, 212, 0.4);
        }

        /* Card sản phẩm */
        .khung-san-pham {
            display: grid;
            /* Điều chỉnh để hiển thị 3 cột trên màn hình lớn và tự động co giãn */
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px; /* Tăng khoảng cách giữa các card */
            justify-content: center;
            max-width: 1200px; /* Giữ nguyên hoặc điều chỉnh theo ý muốn */
            margin: 20px auto;
            padding: 0 20px;
        }


        .the-xe {
            background-color: #2a2a2a;
            border: 1px solid #4a4a4a; /* Viền rõ hơn */
            border-radius: 12px; /* Bo góc mềm mại hơn */
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5); /* Đổ bóng mạnh hơn */
            transition: transform 0.25s ease-in-out, box-shadow 0.25s ease-in-out;
            cursor: pointer;
        }

        .the-xe:hover {
            transform: translateY(-7px); /* Nhấc lên nhiều hơn */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.7); /* Đổ bóng mạnh hơn khi hover */
        }

        .anh-xe {
            width: 100%;
            height: 220px; /* Chiều cao ảnh lớn hơn */
            object-fit: cover;
            border-bottom: 1px solid #3d3d3d; /* Viền dưới ảnh */
        }

        .thong-tin-xe {
            padding: 18px; /* Padding lớn hơn */
        }

        .ten-xe {
            color: #00bcd4;
            font-size: 1.6em; /* To hơn */
            margin-bottom: 12px;
            font-weight: bold;
            text-shadow: 0 0 3px rgba(0, 188, 212, 0.2);
        }

        .gia-xe {
            color: #f5f5f5; /* Màu trắng sáng hơn */
            font-size: 1.1em;
            margin-bottom: 8px;
        }

        .thong-tin-phu {
            color: #a0a0a0; /* Màu xám dịu hơn */
            font-size: 0.95em;
        }

        /* Phân trang */
        .phan-trang {
            display: flex;
            justify-content: center;
            margin-top: 40px; /* Khoảng cách lớn hơn */
            padding-bottom: 25px;
        }

        .phan-trang a {
            color: #00bcd4;
            padding: 10px 18px; /* Padding lớn hơn */
            text-decoration: none;
            transition: background-color .3s, color .3s, border-color .3s;
            border: 1px solid #4a4a4a; /* Viền rõ hơn */
            margin: 0 5px;
            border-radius: 6px;
            font-weight: 500;
        }

        .phan-trang a.active {
            background-color: #00bcd4;
            color: white;
            border: 1px solid #0097a7;
        }

        .phan-trang a:hover:not(.active) {
            background-color: #3b3b3b; /* Màu nền hover giống nút lọc */
            color: #00bcd4;
            border-color: #00bcd4;
        }

        .khong-ket-qua {
            text-align: center;
            color: #e0e0e0; /* Màu sáng hơn cho thông báo */
            font-size: 1.4em; /* To hơn */
            padding: 60px; /* Padding lớn hơn */
            background-color: #2a2a2a;
            border-radius: 10px;
            margin: 30px auto;
            max-width: 80%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .thong-bao-loc {
            text-align: center;
            color: #e0e0e0;
            font-size: 1.2em;
            margin-top: 20px;
            padding: 15px;
            background-color: #3b3b3b;
            border-radius: 8px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<div class="khu-chinh">
    <br><br>

    <form action="Loc.php" method="post" id="formLocChinh" class="khu-form-loc">
        <?php if (!empty($hangxe)): ?>
            <input type="hidden" name="hangxe" value="<?php echo htmlspecialchars($hangxe); ?>">
        <?php endif; ?>

        <div class="thanh-loc-chinh">
            <div class="nhom-loc-chuyen-doi">
                <button type="button" class="nut-loc-chinh" onclick="anHienDropdown('gia-dropdown', this)">Lọc Theo Giá</button>
                <div class="menu-loc-con" id="gia-dropdown">
                    <label>
                        <input type="checkbox" name="price[]" value="duoi_200" <?php echo in_array('duoi_200', $selected_prices) ? 'checked' : ''; ?>>
                        <span>Dưới 200 triệu</span>
                    </label>
                    <label>
                        <input type="checkbox" name="price[]" value="200_500" <?php echo in_array('200_500', $selected_prices) ? 'checked' : ''; ?>>
                        <span>200 - 500 triệu</span>
                    </label>
                    <label>
                        <input type="checkbox" name="price[]" value="500_1ty" <?php echo in_array('500_1ty', $selected_prices) ? 'checked' : ''; ?>>
                        <span>500 triệu - 1 tỷ</span>
                    </label>
                    <label>
                        <input type="checkbox" name="price[]" value="1ty_3ty" <?php echo in_array('1ty_3ty', $selected_prices) ? 'checked' : ''; ?>>
                        <span>1 tỷ - 3 tỷ</span>
                    </label>
                    <label>
                        <input type="checkbox" name="price[]" value="tren_3ty" <?php echo in_array('tren_3ty', $selected_prices) ? 'checked' : ''; ?>>
                        <span>Trên 3 tỷ</span>
                    </label>
                    <button type="submit" class="nut-ap-dung">Áp Dụng Giá</button>
                </div>
            </div>

            <div class="nhom-loc-chuyen-doi">
                <button type="button" class="nut-loc-chinh" onclick="anHienDropdown('mau-dropdown', this)">Lọc Theo Màu</button>
                <div class="menu-loc-con" id="mau-dropdown">
                    <label>
                        <input type="checkbox" name="color[]" value="Đen" <?php echo in_array('Đen', $selected_colors) ? 'checked' : ''; ?>>
                        <span>Đen</span>
                    </label>
                    <label>
                        <input type="checkbox" name="color[]" value="Trắng" <?php echo in_array('Trắng', $selected_colors) ? 'checked' : ''; ?>>
                        <span>Trắng</span>
                    </label>
                    <label>
                        <input type="checkbox" name="color[]" value="Bạc" <?php echo in_array('Bạc', $selected_colors) ? 'checked' : ''; ?>>
                        <span>Bạc</span>
                    </label>
                    <label>
                        <input type="checkbox" name="color[]" value="Xám" <?php echo in_array('Xám', $selected_colors) ? 'checked' : ''; ?>>
                        <span>Xám</span>
                    </label>
                    <label>
                        <input type="checkbox" name="color[]" value="Đỏ" <?php echo in_array('Đỏ', $selected_colors) ? 'checked' : ''; ?>>
                        <span>Đỏ</span>
                    </label>
                    <label>
                        <input type="checkbox" name="color[]" value="Xanh" <?php echo in_array('Xanh', $selected_colors) ? 'checked' : ''; ?>>
                        <span>Xanh</span>
                    </label>
                    <label>
                        <input type="checkbox" name="color[]" value="Vàng" <?php echo in_array('Vàng', $selected_colors) ? 'checked' : ''; ?>>
                        <span>Vàng</span>
                    </label>
                    <label>
                        <input type="checkbox" name="color[]" value="Cam" <?php echo in_array('Cam', $selected_colors) ? 'checked' : ''; ?>>
                        <span>Cam</span>
                    </label>
                    <button type="submit" class="nut-ap-dung">Áp Dụng Màu</button>
                </div>
            </div>

            <div class="nhom-loc-chuyen-doi">
                <button type="button" class="nut-loc-chinh" onclick="anHienDropdown('nam-sx-dropdown', this)">Lọc Theo Năm Sản Xuất</button>
                <div class="menu-loc-con" id="nam-sx-dropdown">
                    <label>
                        <input type="checkbox" name="year[]" value="duoi_2021" <?php echo in_array('duoi_2021', $selected_years) ? 'checked' : ''; ?>>
                        <span>Dưới 2021</span>
                    </label>
                    <label>
                        <input type="checkbox" name="year[]" value="2022" <?php echo in_array('2022', $selected_years) ? 'checked' : ''; ?>>
                        <span>Năm 2022</span>
                    </label>
                    <label>
                        <input type="checkbox" name="year[]" value="2023" <?php echo in_array('2023', $selected_years) ? 'checked' : ''; ?>>
                        <span>Năm 2023</span>
                    </label>
                    <button type="submit" class="nut-ap-dung">Áp Dụng Năm</button>
                </div>
            </div>

            <div class="nhom-loc-chuyen-doi">
                <button type="button" class="nut-loc-chinh" onclick="anHienDropdown('toc-do-dropdown', this)">Lọc Theo Tốc Độ</button>
                <div class="menu-loc-con" id="toc-do-dropdown">
                    <label>
                        <input type="checkbox" name="speed[]" value="duoi_250" <?php echo in_array('duoi_250', $selected_speeds) ? 'checked' : ''; ?>>
                        <span>Dưới 250 km/h</span>
                    </label>
                    <label>
                        <input type="checkbox" name="speed[]" value="250_300" <?php echo in_array('250_300', $selected_speeds) ? 'checked' : ''; ?>>
                        <span>250 - 300 km/h</span>
                    </label>
                    <label>
                        <input type="checkbox" name="speed[]" value="tren_300" <?php echo in_array('tren_300', $selected_speeds) ? 'checked' : ''; ?>>
                        <span>Trên 300 km/h</span>
                    </label>
                    <button type="submit" class="nut-ap-dung">Áp Dụng Tốc Độ</button>
                </div>
            </div>

            <div class="nhom-loc-chuyen-doi">
                <button type="button" class="nut-loc-chinh" onclick="anHienDropdown('dong-co-dropdown', this)">Lọc Theo Động Cơ</button>
                <div class="menu-loc-con" id="dong-co-dropdown">
                    <label>
                        <input type="checkbox" name="engine[]" value="Xăng" <?php echo in_array('Xăng', $selected_engines) ? 'checked' : ''; ?>>
                        <span>Xăng</span>
                    </label>
                    <label>
                        <input type="checkbox" name="engine[]" value="Hybrid" <?php echo in_array('Hybrid', $selected_engines) ? 'checked' : ''; ?>>
                        <span>Hybrid</span>
                    </label>
                    <label>
                        <input type="checkbox" name="engine[]" value="Điện" <?php echo in_array('Điện', $selected_engines) ? 'checked' : ''; ?>>
                        <span>Điện</span>
                    </label>
                    <label>
                        <input type="checkbox" name="engine[]" value="Khác" <?php echo in_array('Khác', $selected_engines) ? 'checked' : ''; ?>>
                        <span>Khác</span>
                    </label>
                    <button type="submit" class="nut-ap-dung">Áp Dụng Động Cơ</button>
                </div>
            </div>
        </div>
    </form>
    

    <?php
    // Hiển thị sản phẩm chỉ khi có kết quả từ bộ lọc
    if ($total_records > 0) {
        echo '<div class="khung-san-pham">';
        while ($row = $result_data->fetch_assoc()) {
            echo '<div class="the-xe" onclick="hienChiTiet(\'' . htmlspecialchars($row['MaXe']) . '\')">';
            echo '<img src="assets/img/Xe/' . htmlspecialchars($row['AnhXe']) . '" class="anh-xe" alt="' . htmlspecialchars($row['TenXe']) . '">';
            echo '<div class="thong-tin-xe">';
            echo '<h4 class="ten-xe">' . htmlspecialchars($row['TenXe']) . '</h4>';
            echo '<p class="gia-xe">Giá: ' . number_format($row['Gia'], 0, ',', '.') . ' VNĐ</p>';
            // Thêm các thông tin kỹ thuật khác nếu cần và có dữ liệu
            if (isset($row['NamSanXuat'])) {
                echo '<p class="thong-tin-phu">Năm SX: ' . htmlspecialchars($row['NamSanXuat']) . '</p>';
            }
            if (isset($row['DongCo'])) {
                echo '<p class="thong-tin-phu">Động Cơ: ' . htmlspecialchars($row['DongCo']) . '</p>';
            }
            if (isset($row['TocDoToiDa'])) {
                echo '<p class="thong-tin-phu">Tốc độ: ' . htmlspecialchars($row['TocDoToiDa']) . '</p>';
            }
            echo '</div>';
            echo '</div>';
        }
        echo '</div>'; // Đóng khung-san-pham

        // Hiển thị phân trang
        if ($total_pages > 1) {
            echo '<div class="phan-trang">';
            // Sử dụng $current_filter_params đã được xử lý ở trên
            $params_for_pagination = $current_filter_params;

            // Nút Previous
            if ($current_page > 1) {
                $prev_page_url = '?' . http_build_query(array_merge($params_for_pagination, ['page' => $current_page - 1]));
                echo '<a href="' . htmlspecialchars($prev_page_url) . '">&laquo; Trang Trước</a>';
            }

            // Các nút số trang
            for ($i = 1; $i <= $total_pages; $i++) {
                $active_class = ($i == $current_page) ? 'active' : '';
                $page_url = '?' . http_build_query(array_merge($params_for_pagination, ['page' => $i]));
                echo '<a class="' . $active_class . '" href="' . htmlspecialchars($page_url) . '">' . $i . '</a>';
            }

            // Nút Next
            if ($current_page < $total_pages) {
                $next_page_url = '?' . http_build_query(array_merge($params_for_pagination, ['page' => $current_page + 1]));
                echo '<a href="' . htmlspecialchars($next_page_url) . '">Trang Sau &raquo;</a>';
            }
            echo '</div>'; // Đóng phan-trang
        }
    } elseif ($form_submitted && !$has_filters_selected) {
        // Form đã submit nhưng không có bất kỳ checkbox nào được chọn
        echo "<p class='thong-bao-loc'>Bạn chưa chọn bất kỳ tiêu chí lọc nào. Vui lòng chọn một hoặc nhiều lựa chọn để lọc sản phẩm.</p>";
    } else {
        // Trường hợp không có sản phẩm nào phù hợp với tiêu chí lọc ĐÃ CHỌN
        // Hoặc là lần đầu vào trang mà không có bộ lọc nào được chọn (và không có sản phẩm nào để hiển thị)
        echo "<p class='khong-ket-qua'>Không có sản phẩm nào phù hợp với tiêu chí lọc của bạn.</p>";
    }
    // Đóng kết nối
    $conn->close();
    ?>
</div>

<script>
    // Hàm để ẩn/hiện dropdown và thêm/bỏ class 'active' cho nút
    function anHienDropdown(idDropdown, phanTuNut) {
        const dropdownHienTai = document.getElementById(idDropdown);
        const tatCaDropdowns = document.querySelectorAll('.menu-loc-con');
        const tatCaNutLocChinh = document.querySelectorAll('.nut-loc-chinh');

        // Đóng tất cả các dropdown khác và bỏ class 'active' của các nút khác
        tatCaDropdowns.forEach(d => {
            if (d.id !== idDropdown) {
                d.classList.remove('hien-thi');
            }
        });
        tatCaNutLocChinh.forEach(b => {
            if (b !== phanTuNut) {
                b.classList.remove('active');
            }
        });

        // Toggle dropdown hiện tại và class 'active' của nút hiện tại
        dropdownHienTai.classList.toggle('hien-thi');
        phanTuNut.classList.toggle('active');
    }

    // Đóng dropdown khi click ra ngoài
    window.onclick = function(suKien) {
        if (!suKien.target.matches('.nut-loc-chinh') && !suKien.target.closest('.menu-loc-con')) {
            const dropdowns = document.querySelectorAll('.menu-loc-con');
            dropdowns.forEach(dropdown => {
                if (dropdown.classList.contains('hien-thi')) {
                    dropdown.classList.remove('hien-thi');
                }
            });
            const buttons = document.querySelectorAll('.nut-loc-chinh');
            buttons.forEach(button => {
                button.classList.remove('active');
            });
        }
    }

    function hienChiTiet(maXe) {
        window.location.href = 'product_details.php?maXe=' + maXe;
    }
</script>

<?php
include("sanphamNoiBac.php");
include("footer.php");
?>
</body>
</html>