<?php
$title = "Trang chủ";
include("header.php");
include('ConnectDatabase_PDO.php');
?>
<video style="height: 90vh; width: 100%; object-fit: cover;" autoplay loop muted playsinline>
    <source src="assets/background-video/bmw.mp4" type="video/mp4">
    Trình duyệt không hỗ trợ Video.
</video>
<a href="TatCaHangXe.php">
    <h2 class="font_hover" style="position: absolute; top: 7%; left: 5%; font-size: 2.5rem; color: white; cursor: pointer">
        <i style="color: #c00;" class="fa-solid fa-chevron-right"></i> Go far Together.
    </h2>
</a>
<div class="main_container">
    <div class="show_brands">
        <h2 class="merriweather">Cung cấp các mẫu xe hàng đầu thế giới</h2>
        <div class="slideshow_brands">
            <div class="slide">
                <img src="assets/img/icons/logo-bmw.jpg" alt="BMW">
                <div class="caption">BMW</div>
            </div>
            <div class="slide">
                <img src="assets/img/icons/Mercedes-Logo.png" alt="Mercedes-Benz">
                <div class="caption">Mercedes-Benz</div>
            </div>
            <div class="slide">
                <img src="assets/img/icons/Ferrari-Logo.png" alt="Ferrari">
                <div class="caption">Ferrari</div>
            </div>
            <div class="slide">
                <img src="assets/img/icons/audi-logo.png" alt="Audi">
                <div class="caption">Audi</div>
            </div>
            <div class="slide">
                <img src="assets/img/icons/Lamborghini_Logo.png" alt="Lamborghini">
                <div class="caption">Lamborghini</div>
            </div>
            <div class="slide">
                <img src="assets/img/icons/Porsche-Logo.png" alt="Porsche">
                <div class="caption">Porsche</div>
            </div>
            <div class="slide">
                <img src="assets/img/icons/Rolls-Royce-Logo.png" alt="Roll-Royce">
                <div class="caption">Roll Royce</div>
            </div>
        </div>
    </div>
    <div class="btn_showall"><a href="TatCaHangXe.php"><button>Tất cả xe <i
                    class="fa-solid fa-arrow-right-long"></i></button></a></div>
    <div class="product_famous">
        <?php
        $sta = $pdo->prepare("SELECT * FROM XeHoi ORDER BY Gia ASC LIMIT 10");
        $sta->execute();

        if ($sta->rowCount() > 0) {
            $famous_cars = $sta->fetchAll(PDO::FETCH_OBJ);
        } else {
            echo "<script>alert('Không tìm thấy Ô Tô Nổi bật!');</script>";
        }
        foreach ($famous_cars as $car) {
            ?>
            <div class="card_product">
                <a href="product_details.php?maXe=<?php echo $car->MaXe ?>">
                    <h3><?php echo $car->TenXe ?></h3>
                    <p>Giá <span style="font-weight: bold;"><?php echo number_format($car->Gia, 0, ",", ".") ?>
                            <font style="font-size: 12px">VNĐ</font>
                        </span></p>
                    <div class="img_card_product" style="background-image: url('assets/img/Xe/<?php echo $car->AnhXe ?>');">
                    </div>
                </a>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="banner_grid">
        <div class="banner_grid_content">
            <h2>THIẾT KẾ THỜI THƯỢNG, THỂ THAO, SANG TRỌNG</h2>
        </div>
        <div class="banner_grid_content">
        </div>
        <div class="banner_grid_content">
        </div>
        <div class="banner_grid_content">
        </div>
    </div>
    <div class="banner_mec">
        <div
            style="background-image: url('assets/img/Xe/xe43.jpg'); background-size: 150%; background-position: 50% 100%;">
        </div>
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: flex-start">
            <h2 class="merriweather">VỊ THẾ VƯỢT THỜI GIAN từ <br> 1886.</h2>
            <p>Định nghĩa về xe luôn thay đổi, nhưng đẳng cấp thì không. Khi đó là <br> Mercedes-Benz.</p>
            <a href="TungHangXe.php?hangxe=HX05"><button>Tìm hiểu thêm</button></a>
        </div>
    </div>
</div>
<?php
include("footer.php");
?>