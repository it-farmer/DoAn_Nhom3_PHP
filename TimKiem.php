<?php
    $title = "Kết quả tìm kiếm";
    include("header.php");
?>

<style>

    .ketqua {
        font-size: 18px;
        color: #888;
        margin-top: 10px;
        align-items: center;
    }
    .ketqua2 {
        display: flex; 
        flex-direction: column; /* Căn giữa các phần tử con theo chiều ngang */
        font-size: 18px;
        color: #888;
        margin-top: 10px;
        align-items: center; /* Căn giữa các phần tử con theo chiều ngang */
    }
</style>

<div class="nen">
    <br><br>
    <div class="highlighted-products">
        <h2>Kết quả tìm kiếm</h2>
    </div>

    <?php
        include("ConnectDatabase.php");

        // Lấy từ khóa tìm kiếm từ URL
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

        if (!empty($keyword)) {
            // Tìm kiếm xe theo tên
            $keyword = "%" . $conn->real_escape_string($keyword) . "%";
            $sql = "SELECT * FROM XeHoi WHERE TenXe LIKE '$keyword'";
            $result = $conn->query($sql);

            echo '<div class="container">';
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card" onclick="showDetails(\'' . $row['MaXe'] . '\')">';
                    echo '<img src="assets/img/Xe/' . htmlspecialchars($row['AnhXe']) . '" class="card-img-top" alt="' . htmlspecialchars($row['TenXe']) . '">';
                    echo '<div class="card-body">';
                    echo '<h4 class="card-title">' . htmlspecialchars($row['TenXe']) . '</h4>';
                    echo '<p class="card-text">Giá: ' . number_format($row['Gia'], 0, ',', '.') . ' VNĐ</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p class= 'ketqua'>Không tìm thấy xe nào có tên chứa từ khóa '" . htmlspecialchars($_GET['keyword']) . "'.</p>";
            }
            echo '</div>';
        } else {
            echo "<p class= 'ketqua2'>Vui lòng nhập từ khóa để tìm kiếm.</p>";
        }

        $conn->close();
        include('sanphamNoiBac.php');
    ?>

    <br><br>

    <script>
        function showDetails(maXe) {
            window.location.href = 'product_details.php?maXe=' + maXe;
        }
    </script>
</div>

<?php
    include("footer.php");
?>

