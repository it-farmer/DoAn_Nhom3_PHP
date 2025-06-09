<?php
session_start();

include('ConnectDatabase_PDO.php');

if (isset($_POST['log_out'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

$_SESSION['KetQuaDangNhap'] = false;

if (isset($_POST['username_log']) && isset($_POST['password_log'])) {

    $sta = $pdo->prepare("SELECT * FROM nhanvien WHERE TaiKhoan = ? AND MatKhau =?");
    $sta->execute([$_POST['username_log'], $_POST['password_log']]);
    if ($sta->rowCount() > 0) {
        $nhanvien = $sta->fetch(PDO::FETCH_OBJ);
        $_SESSION['HoTenNV'] = $nhanvien->HoTenNV;
        $_SESSION['MaNV'] = $nhanvien->MaNV;
        $_SESSION['QueQuan'] = $nhanvien->QueQuan;
        $_SESSION['NgaySinhNV'] = $nhanvien->NgaySinhNV;
        $_SESSION['SoDienThoaiNV'] = $nhanvien->SoDienThoaiNV;
        $_SESSION['GioiTinh'] = $nhanvien->GioiTinh;
        $_SESSION['EmailNV'] = $nhanvien->EmailNV;
        $_SESSION['HinhAnhKH'] = $nhanvien->HinhAnhKH;
        $_SESSION['QuyenID'] = $nhanvien->QuyenID;
        $_SESSION['KetQuaDangNhap'] = true;
    }

    $sta = $pdo->prepare("SELECT * FROM khachhang WHERE TenDangNhap = ? AND MatKhau =?");
    $sta->execute([$_POST['username_log'], $_POST['password_log']]);
    if ($sta->rowCount() > 0) {
        $khachhang = $sta->fetch(PDO::FETCH_OBJ);
        if ($khachhang->HoTenKH != null)
            $_SESSION['HoTenKH'] = $khachhang->HoTenKH;
        else
            $_SESSION['HoTenKH'] = "Chưa xác định";
        $_SESSION['MaKH'] = $khachhang->MaKH;
        $_SESSION['NgaySinhKH'] = $khachhang->NgaySinhKH;
        $_SESSION['SoDienThoaiKH'] = $khachhang->SoDienThoaiKH;
        $_SESSION['DiaChi'] = $khachhang->DiaChi;
        $_SESSION['EmailKH'] = $khachhang->EmailKH;
        $_SESSION['TenDangNhap'] = $khachhang->TenDangNhap;
        $_SESSION['MatKhau'] = $khachhang->MatKhau;
        $_SESSION['HinhAnhKH'] = $khachhang->HinhAnhKH;
        $_SESSION['KetQuaDangNhap'] = true;
    }
}

if (isset($_SESSION['QuyenID']) && $_SESSION['QuyenID'] == 1) {
    header("Location: admin.php");
    exit();
}
if (isset($_SESSION['QuyenID']) && $_SESSION['QuyenID'] == 2) {
    header("Location: QL_HoaDon.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Error'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/cdbcf8b89b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/styles.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header class="header">
        <a name="header"></a>
        <div class="nav">
            <ul>
                <li><a href="index.php">Logo</a></li>
                <li><a href="./index.php">Trang chủ</a></li>
                <li>
                    <ul class="dropdown-menu">
                        <li style="width: 100px;">
                            <a href="#">Hãng xe <i class="fa-solid fa-angle-down"></i></a>
                            <ul class="sub-menu">
                                <li><a href="Loc.php">Tất cả hãng</a></li>
                                <li><a href="TungHangXe.php?hangxe=HX01">BMW</a></li>
                                <li><a href="TungHangXe.php?hangxe=HX02">Porsche</a></li>
                                <li><a href="TungHangXe.php?hangxe=HX03">Lamborghini</a></li>
                                <li><a href="TungHangXe.php?hangxe=HX04">Audi</a></li>
                                <li><a href="TungHangXe.php?hangxe=HX05">Mercedes-Benz</a></li>
                                <li><a href="TungHangXe.php?hangxe=HX06">Roll Royce</a></li>
                                <li><a href="TungHangXe.php?hangxe=HX07">Ferrari</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <form action="TimKiem.php" method="get">
                        <input style="width: 250px; height: 30px; border-radius: 2px; padding-left: 10px" type="text"
                            placeholder="Tìm kiếm" name="keyword">
                    </form>
                </li>
                <li><a href="services.php">Dịch vụ</a></li>
                <li><a href="contact.php">Liên hệ</a></li>
                <li><a href="about_us.php">Về chúng tôi</a></li>
                <!-- <li><a onclick="showLogin()" href="#">Đăng nhập / Đăng ký</a></li> -->
                <!-- Giỏ hàng -->

                <?php
                require_once __DIR__ . '/models/M_XeHoi.php';
                require_once __DIR__ . '/models/M_database.php';
                require_once __DIR__ . '/models/M_GioHang.php';
                // Hiển thị giỏ hàng theo Khách Hàng
                
                $maKH = isset($_SESSION['MaKH']) ? $_SESSION['MaKH'] : null;
                $cart = [];


                if ($maKH) {
                    $gioHangModel = new GioHangModel();
                    $cart = $gioHangModel->getCartByMaKH($maKH);
                }
                ?>
                <li class="cart-container">
                    <a style="text-decoration: none; color: white; margin: 0;" href="#"><i
                            class="fa-solid fa-cart-shopping"></i></a>
                    <div id="empty_cart" class="cart-dropdown">
                        <?php if (empty($cart)): ?>
                            <div>
                                <img id="empty_cart_img" src="assets/img/anothers/empty_cart.png" alt="Giỏ hàng">
                            </div>
                            <div><span>Chưa có sản phẩm</span></div>
                            <span>
                                <a href="TatCaHangXe.php"><button>Mua Ngay</button></a>
                            </span>
                        <?php else: ?>
                            <?php foreach ($cart as $item): ?>
                                <div class="cart-item">
                                    <img src="assets/img/Xe/<?php echo htmlspecialchars($item->AnhXe); ?>" width="120px"
                                        height="60px" alt="<?php echo htmlspecialchars($item->TenXe); ?>">
                                    <span><?php echo htmlspecialchars($item->TenXe); ?></span>
                                    <span><?php echo number_format($item->Gia, 0, ",", "."); ?> VNĐ</span>
                                    <span>x<?php echo $item->SoLuong; ?></span>
                                    <a href="controllers/Controller_Cart.php?action=delete&maXe=<?php echo $item->MaXe; ?>"
                                        onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                        <button>Xóa</button>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                            <span>
                                <a href="cart_detail.php"><button>Chi Tiết Giỏ Hàng</button></a>
                            </span>
                        <?php endif; ?>
                    </div>
                </li>
                <?php
                if (isset($_SESSION['HoTenNV']) || isset($_SESSION['HoTenKH'])) {
                    ?>
                    <li onclick="showOptionsUser()" style="color: white; cursor: pointer;">
                        <a href="#">
                            <?php if (isset($_SESSION['HoTenNV']))
                                echo $_SESSION['HoTenNV'];
                            else {
                                if (isset($_SESSION['HoTenKH']))
                                    echo $_SESSION['HoTenKH'];
                            }
                            ?>
                        </a>
                        <ul id="menuOptionsUser" style="display: none;">
                            <li style="margin: 5% auto;"><a href="user_detail.php">Thông tin cá nhân</a></li>
                            <hr style="height: 2px; background-color: black; border: 1px;">
                            <li>
                                <form action="index.php" method="post">
                                    <input type="hidden" name="log_out">
                                    <button
                                        style="padding: 3% 5%; background-color: transparent; border: none; width: 100px; cursor: pointer; font-size: 16px;">Đăng
                                        Xuất</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    <?php
                } else {
                    ?>
                    <li><a onclick="showLogin()" href="#">Đăng nhập / Đăng ký</a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <!-- Nút quay trở lại đầu trang -->
        <a href="#header">
            <div id="btn_header_page"><i class="fa-solid fa-chevron-up"></i></div>
        </a>
        <!-- Đăng nhập / Đăng ký -->
        <div id="login" class="login-container">
            <div class="slide_s_login">
                <img src="assets/img/Xe/A6_3.avif" alt="assets/img/Xe/A6_3.avif">
                <button onclick="closeLogin()" class="montserrat"><span>Trang chủ</span> <i
                        class="fa-solid fa-angle-right"></i></button>
            </div>
            <div class="form_control">
                <div id="log_form" class="login_main">
                    <h2>Đăng nhập</h2>
                    <form action="index.php" method="post">
                        <input id="form-log-username" name="username_log" type="text" placeholder="Tên đăng nhập">
                        <input id="form-log-password" name="password_log" type="password" placeholder="Mật khẩu">
                        <div style="display: flex; align-items: center; margin: 10px 0">
                            <input type="checkbox" id="cbox">
                            <label for="cbox" style="font-size: 13px; margin-left: 5px">Nhớ tài khoản</label>
                        </div>
                        <button>Đăng Nhập</button>
                    </form>
                    <p>Chưa có tài khoản? <span onclick="signup()">Đăng ký</span></p>
                    <div class="or_login">
                        <hr>
                        <span>Hoặc đăng nhập bằng</span>
                        <hr>
                    </div>
                    <div class="or_login_2">
                        <button><img src="assets/img/icons/google-logo.png" alt="gg_logo">Google</button>
                        <button><img src="assets/img/icons/github-logo.png" alt="git_logo">Github</button>
                    </div>
                </div>
                <div id="reg_form" class="login_main">
                    <h2>Đăng ký</h2>
                    <form action="index.php" method="post" onsubmit="return check_repass()">
                        <input id="form-reg-username" name="username_regis" type="text" placeholder="Tên đăng nhập">
                        <input id="form-reg-password" name="password_regis" type="password" placeholder="Mật khẩu">
                        <input id="form-reg-cfpassword" name="re_password_regis" type="password"
                            placeholder="Xác nhận lại Mật khẩu">
                        <div style="display: flex; align-items: center; margin: 10px 0">
                            <input type="checkbox" id="cbox2">
                            <label for="cbox2" style="font-size: 13px; margin-left: 5px">Đồng ý với <span>điều
                                    khoản</span>
                                & <span>điều kiện</span></label>
                        </div>
                        <button type="submit">Đăng Ký</button>
                    </form>
                    <p>Đã có tài khoản? <span onclick="signin()">Đăng nhập</span></p>
                    <div class="or_login">
                        <hr>
                        <span>Hoặc đăng ký với</span>
                        <hr>
                    </div>
                    <div class="or_login_2">
                        <button><img src="assets/img/icons/google-logo.png" alt="gg_logo">Google</button>
                        <button><img src="assets/img/icons/github-logo.png" alt="git_logo">Github</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if ($_SESSION['KetQuaDangNhap'] != true && isset($_POST['username_log']) && isset($_POST['password_log'])) {
            echo "
                <script>
                Swal.fire({
                    title: 'Đăng nhập thất bại!',
                    text: 'Vui lòng kiểm tra lại thông tin đăng nhập',
                    icon: 'error'
                }).then((result) => {
                        if (result.isConfirmed) {
                            showLogin();
                            signin();
                        }
                });
                </script>";
        }
        if ($_SESSION['KetQuaDangNhap'] == true && isset($_POST['username_log']) && isset($_POST['password_log'])) {
            echo "
                <script>
                Swal.fire({
                    title: 'Đăng nhập thành công!',
                    icon: 'success'
                });
                </script>";
        }
        if (isset($_POST['username_regis']) && isset($_POST['password_regis']) && isset($_POST['re_password_regis'])) {
            $sta = $pdo->prepare("SELECT * FROM khachhang WHERE TenDangNhap = ?");
            $sta->execute([$_POST['username_regis']]);
            if ($sta->rowCount() > 0) {
                echo "
                <script>
                Swal.fire({
                    title: 'Đăng ký thất bại!',
                    text: 'Username này đã được sử dụng.',
                    icon: 'error'
                }).then((result) => {
                        if (result.isConfirmed) {
                            showLogin();
                            signup();
                        }
                });
                </script>";
                return;
            }

            $result = $pdo->prepare("SELECT MAX(MaKH) AS maxMaKH FROM khachhang");
            $result->execute();
            $row = $result->fetch(PDO::FETCH_OBJ);
            $maxMaKH = $row->maxMaKH;

            if ($maxMaKH) {
                $num = (int) substr($maxMaKH, 2);
                $num++;
            } else {
                $num = 1; // Bắt đầu từ 1 nếu chưa có mã nào
            }

            $newMaKH = 'KH' . str_pad($num, 2, '0', STR_PAD_LEFT); // Tạo mã khách hàng mới
            $sta = $pdo->prepare("INSERT INTO khachhang (MaKH, TenDangNhap, MatKhau) VALUES (?, ?, ?)");
            $sta->execute([$newMaKH, $_POST['username_regis'], $_POST['password_regis']]);
            if ($sta) {
                echo "
                <script>
                Swal.fire({
                    title: 'Đăng ký thành công!',
                    text: 'Vui lòng đăng nhập.',
                    icon: 'success'
                }).then((result) => {
                        if (result.isConfirmed) {
                            showLogin();
                        }
                });
                </script>";
            } else {
                echo "<script>
            Swal.fire({
                title: 'Lỗi!',
                text: 'Đăng ký thất bại. Vui lòng thử lại!',
                icon: 'error'
            });
          </script>";
            }
        }
        ?>

    </header>

    <script>

        //Kiểm tra đăng nhập khi thêm giỏ hàng
        window.onload = function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('showLogin') === '1') {
                alert("Hãy đăng nhập để thêm sản phẩm vào giỏ hàng.");
                showLogin();
            }
        }
    </script>