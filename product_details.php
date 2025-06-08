<?php
    include("ConnectDatabase_PDO.php");
     
    

    // Nhận mã xe từ URL
    $maxe = isset($_GET['maXe']) ? $_GET['maXe'] : '';

    // Lấy tên và các thông tin xe
    $sta = $pdo->prepare("SELECT * FROM xehoi WHERE MaXe = ?");
    $sta->execute([$maxe]);

    if($sta->rowCount() > 0) {
        $row = $sta->fetch(PDO::FETCH_OBJ);
        $tenxe = $row->TenXe;
    } else {
        $tenxe = "Error";
        echo "<script>alert('Không tìm thấy mã Ô Tô này!');</script>";
    }

    // Lấy thông số xe
    $sta = $pdo->prepare("SELECT * FROM thongsokythuat WHERE MaXe = ?");
    $sta->execute([$maxe]);
    if($sta->rowCount() > 0) {
        $thongso = $sta->fetch(PDO::FETCH_OBJ);
    } else {
        echo "<script>alert('Không tìm thấy thông số kỹ thuật cho xe này');</script>";
    }

    // Lấy bình luận của khách hàng
    $sta = $pdo->prepare("SELECT HoTenKH, NoiDung, SoSao, NgayDanhGia FROM danhgiabinhluan, khachhang WHERE danhgiabinhluan.MaKH = khachhang.MaKH AND danhgiabinhluan.MaXe = ?");
    $sta->execute([$maxe]);
    if($sta->rowCount() > 0) {
        $all_binhluan = $sta->fetchAll(PDO::FETCH_OBJ);
        $tong_binhluan = $sta->rowCount();
    } else {
        $all_binhluan = [];
        $tong_binhluan = 0;
    }
    
    $title = $tenxe;
    include("header.php");
?>
    <section class="product-detail">
        <div class="slide-show-product-detail">
            <img src="assets/img/Xe/<?php echo $row->AnhXe ?>" alt="<?php echo $row->TenXe ?>">
            <div class="info_product merriweather">
                <h1><?php echo $tenxe; ?></h1>
                <p style="text-align: left;"><?php echo $row->CongNghe; ?></p>
                <p style="text-align: right;">Hỗ trợ bảo hành lên đến <span style="color: lightgreen; font-weight: bold;"><?php echo $row->ThoiGianBaoHanh; ?></span></p>
                <form action="controllers/Controller_Cart.php" method="get" style="display:inline;">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="maXe" value="<?php echo $row->MaXe; ?>">
                    <button type="submit" class="btn_add_cart" name="cf_button">Thêm vào giỏ</button>
                    <button type="submit" class="btn_add_cart btn_buy_now"  name="cf_button">Mua Ngay</button>
                </form>
                
                <table class="pro_table_count" border="0">
                    <tr>
                        <th>Giá</th>
                        <th>Màu</th>
                        <th>Số Lượng</th>
                    </tr>
                    <tr>
                        <td><?php echo number_format($row->Gia, 0, ",", ".") ?> VNĐ</td>
                        <td><?php echo $row->MauXe; ?></td>
                        <td><?php echo $row->SoLuongTonKho; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="specifications-product">
            <h1>Các Thông Số</h1>
            <ul>
                <li>
                    <strong>Màu nội thất</strong>
                    <span><?php echo $thongso->MauNoiThat ?></span>
                </li>
                <li>
                    <strong>Màu ngoại thất</strong>
                    <span><?php echo $thongso->MauNgoaiThat ?></span>
                </li>
                <li>
                    <strong>Số Xi Lanh</strong>
                    <span><?php echo $thongso->SoXiLanh ?></span>
                </li>
                <li>
                    <strong>Dung tích</strong>
                    <span><?php echo $thongso->DungTich ?></span>
                </li>
                <li>
                    <strong>Chiều dài</strong>
                    <span><?php echo $thongso->ChieuDai ?></span>
                </li>
                <li>
                    <strong>Chiều rộng</strong>
                    <span><?php echo $thongso->ChieuRong ?></span>
                </li>
                <li>
                    <strong>Chiều cao</strong>
                    <span><?php echo $thongso->ChieuCao ?></span>
                </li>
                <li>
                    <strong>Khối lượng</strong>
                    <span><?php echo $thongso->KhoiLuong ?></span>
                </li>
                <li>
                    <strong>Trọng lượng tối đa</strong>
                    <span><?php echo $thongso->TrongLuongToiDa ?></span>
                </li>
                <li>
                    <strong>Tốc độ tối đa</strong>
                    <span><?php echo $thongso->TocDoToiDa ?></span>
                </li>
                <li>
                    <strong>Số cửa</strong>
                    <span><?php echo $thongso->SoCua ?></span>
                </li>
                <li>
                    <strong>Số chỗ ngồi</strong>
                    <span><?php echo $thongso->SoChoNgoi ?></span>
                </li>
                <li>
                    <strong>Hộp số</strong>
                    <span><?php echo $thongso->HopSo ?></span>
                </li>
                <li>
                    <strong>Năm sản xuất</strong>
                    <span><?php echo $thongso->NamSanXuat ?></span>
                </li>
                <li>
                    <strong>Động cơ</strong>
                    <span><?php echo $thongso->DongCo ?></span>
                </li>
            </ul>
        </div>
        <div class="product-description">
            <h1 >Mô Tả Sản Phẩm</h1>
            <p><?php echo $row->MoTa ?></p>
        </div>
        <div class="rating">
            <h2>Bình luận <span>(<?php echo $tong_binhluan ?>)</span></h2>
            <div class="add-new-rate">

            </div>
            <?php
                foreach ($all_binhluan as $binhluan) {
            ?>
                <div class="rating-item">
                    <div class="rating-of-cus">
                        <!-- cần cập nhật hình khachhang -->
                        <img style="margin-right: 3%;" src="assets/img/nguoi/nguoi1.jpg" alt="<?php echo $binhluan->HoTenKH ?>">
                        <div style="width: 80%;">
                            <div class="flex" style="align-items: center;">
                                <span style="margin-right: 3%;"><?php echo $binhluan->HoTenKH ?></span>
                                <span style="width: 50%; font-size: 12px;"><i style="margin-right: 2%;" class="fa-solid fa-clock"></i><?php echo $binhluan->NgayDanhGia ?></span>
                            </div>
                            <br>
                            <span style="font-size: 13px; display: flex; align-items: stretch;">
                                <?php echo $binhluan->SoSao ?>  
                                <?php
                                    for($star = 1; $star <= 5; $star++) {
                                        if($star <= $binhluan->SoSao) {
                                            echo '<i class="fa-solid fa-star" style="color: #FFD43B;"></i>';
                                        } else {
                                            echo '<i class="fa-regular fa-star" style="color: #FFD43B;"></i>';
                                        }
                                    }
                                ?>
                            </span>
                            <br>
                            <p style="font-size: 13px;"><?php echo $binhluan->NoiDung ?></p>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>
        </div>
    </section>
<?php 
    include("footer.php");
?>