<?php
 include("header.php");
?>

<div class="nen">
    <?php

    // include("slide_show.php"); 
    include("slide_show2.php");

    include("ConnectDatabase.php");


    // Xác định số bản ghi mỗi trang
    $records_per_page = 9;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $records_per_page;

    // Lấy danh sách xe hơi
    $sql = "SELECT * FROM xehoi LIMIT $offset, $records_per_page";
    $result = $conn->query($sql);

    echo '<br> 
        <div class="highlighted-products">
            <h2>Tất cả sản phẩm</h2>
        </div>';

    // Hiển thị danh sách xe
    echo '<div class="container">';
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="card" onclick="showDetails(\'' . $row['MaXe'] . '\')">'; // Thay đổi để hiển thị chi tiết
            echo '<img src="HInhAnh/Xe/' . $row['AnhXe'] . '" class="card-img-top" alt="' . $row['TenXe'] . '">';
            echo '<div class="card-body">';
            echo '<h4 class="card-title">' . $row['TenXe'] . '</h4>';
            echo '<p class="card-text">Giá: ' . number_format($row['Gia'], 0, ',', '.') . ' VNĐ</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "<p>Không có xe nào.</p>";
    }
    echo '</div>'; // Đóng container

    // Lấy tổng số bản ghi để tính toán trang
    $total_sql = "SELECT COUNT(*) as total FROM xehoi";
    $total_result = $conn->query($total_sql);
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $records_per_page);

    // Hiển thị nút chuyển trang
    echo '<div class="pagination">';

    // Nút "Trước"
    $prev_page = $page - 1;
    if ($prev_page < 1) {
        $prev_page = $total_pages; // Nếu ở trang 1, chuyển đến trang cuối
    }
    echo '<a href="?page=' . $prev_page . '">Trước</a>';

    // Các số trang
    for ($i = 1; $i <= $total_pages; $i++) {
        $class = ($i == $page) ? 'current' : '';
        echo '<a class="' . $class . '" href="?page=' . $i . '">' . $i . '</a> ';
    }

    // Nút "Sau"
    $next_page = $page + 1;
    if ($next_page > $total_pages) {
        $next_page = 1; // Nếu ở trang cuối, chuyển đến trang 1
    }
    echo '<a href="?page=' . $next_page . '">Sau</a>';

    echo '</div>'; // Đóng pagination

    // Đóng kết nối
    $conn->close();

    include('sanphamNoiBac.php');
    ?>

    <br>
    <br>

    <script>
    function showDetails(maXe) {
        // Gọi AJAX hoặc chuyển hướng đến trang chi tiết sản phẩm
        window.location.href = 'chitiet.php?maXe=' + maXe;
    }
    </script>
</div>


<?php

include("footer.php");
?>
