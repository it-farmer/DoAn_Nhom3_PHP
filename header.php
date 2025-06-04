<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Error'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cdbcf8b89b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/styles.css?v=<?php echo time(); ?>">
    <script src="./assets/js/script.js"></script>

    <!-- thêm cho dropdown -->
    <script>
            $(document).ready(function(){
        $('.dropdown-menu li').hover(function(){
            $(this).children('.sub-menu').slideToggle();
        });
    });
    </script>
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
                                <li><a href="TatCaHangXe.php">Tất cả hãng</a></li>
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
                        <input style="width: 250px; height: 30px; border-radius: 10px; padding-left: 10px"
                            type="text"
                            placeholder="Tìm kiếm"
                            name="keyword">
                    </form>
                </li>
                <li><a href="services.php">Dịch vụ</a></li>
                <li><a href="contact.php">Liên hệ</a></li>
                <li><a href="about_us.php">Về chúng tôi</a></li>
                <li><a onclick="showLogin()" href="#">Đăng nhập / Đăng ký</a></li>

                <li>
                    <div class="filter-menu">
                        <a href="#" class="filter-button">Lọc </a>
                        <div class="filter-dropdown">
                            <div class="filter-option" onmouseover="showSubMenu('price-submenu')" onmouseout="hideSubMenu('price-submenu')">
                                Lọc Theo Giá
                                <div class="submenu" id="price-submenu">
                                    <a href="XuLyLoc.php?price=duoi_200">Dưới 200 triệu</a>
                                    <a href="XuLyLoc.php?price=200_500">200 - 500 triệu</a>
                                    <a href="XuLyLoc.php?price=500_1ty">500 triệu - 1 tỷ</a>
                                    <a href="XuLyLoc.php?price=1ty_3ty">1 tỷ - 3 tỷ</a>
                                    <a href="XuLyLoc.php?price=tren_3ty">Trên 3 tỷ</a>
                                </div>
                            </div>
                            <div class="filter-option" onmouseover="showSubMenu('color-submenu')" onmouseout="hideSubMenu('color-submenu')">
                                Lọc Theo Màu
                                <div class="submenu" id="color-submenu">
                                    <a href="XuLyLoc.php?color=den">Đen</a>
                                    <a href="XuLyLoc.php?color=trang">Trắng</a>
                                    <a href="XuLyLoc.php?color=bac">Bạc</a>
                                    <a href="XuLyLoc.php?color=xam">Xám</a>
                                    <a href="XuLyLoc.php?color=do">Đỏ</a>
                                    <a href="XuLyLoc.php?color=xanh">Xanh</a>
                                    <a href="XuLyLoc.php?color=vang">Vàng</a>
                                </div>
                            </div>
                            <div class="filter-option" onmouseover="showSubMenu('year-submenu')" onmouseout="hideSubMenu('year-submenu')">
                                Lọc Theo Năm Sản Xuất
                                <div class="submenu" id="year-submenu">
                                    <a href="XuLyLoc.php?year=duoi_2021">Dưới 2021</a>
                                    <a href="XuLyLoc.php?year=2022">Năm 2022</a>
                                    <a href="XuLyLoc.php?year=2023">Năm 2023</a>
                                </div>
                            </div>
                            <div class="filter-option" onmouseover="showSubMenu('speed-submenu')" onmouseout="hideSubMenu('speed-submenu')">
                                Lọc Theo Tốc Độ
                                <div class="submenu" id="speed-submenu">
                                    <a href="XuLyLoc.php?speed=duoi_250">Dưới 250 km/h</a>
                                    <a href="XuLyLoc.php?speed=250_300">250 - 300 km/h</a>
                                    <a href="XuLyLoc.php?speed=tren_300">Trên 300 km/h</a>
                                </div>
                            </div>
                            <div class="filter-option" onmouseover="showSubMenu('engine-submenu')" onmouseout="hideSubMenu('engine-submenu')">
                                Lọc Theo Động Cơ
                                <div class="submenu" id="engine-submenu">
                                    <a href="XuLyLoc.php?engine=xang">Xăng</a>
                                    <a href="XuLyLoc.php?engine=hybrid">Hybrid</a>
                                    <a href="XuLyLoc.php?engine=khac">Khác</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

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
                <button onclick="closeLogin()" class="montserrat"><span>Trang chủ</span>  <i class="fa-solid fa-angle-right"></i></button>
            </div>
            <div class="form_control">
                <div id="log_form" class="login_main">
                    <h2>Đăng nhập</h2>
                    <input id="form-log-username" type="text" placeholder="Tên đăng nhập">
                    <input id="form-log-password" type="password" placeholder="Mật khẩu">
                    <div style="display: flex; align-items: center; margin: 10px 0"> 
                        <input type="checkbox" id="cbox"> 
                        <label for="cbox" style="font-size: 13px; margin-left: 5px">Nhớ tài khoản</label>
                    </div>
                    <button>Đăng Nhập</button>
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
                <div id="reg_form"  class="login_main">
                    <h2>Đăng ký</h2>
                    <input id="form-reg-username" type="text" placeholder="Tên đăng nhập">
                    <input id="form-reg-password" type="password" placeholder="Mật khẩu">
                    <input id="form-reg-cfpassword" type="password" placeholder="Xác nhận lại Mật khẩu">
                    <div style="display: flex; align-items: center; margin: 10px 0"> 
                        <input type="checkbox" id="cbox2"> 
                        <label for="cbox2" style="font-size: 13px; margin-left: 5px">Đồng ý với <span>điều khoản</span> & <span>điều kiện</span></label>
                    </div>
                    <button>Đăng Ký</button>
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
        
        
    </header>

<script>
    document.querySelector('.filter-button').addEventListener('click', function() {
        const dropdown = document.querySelector('.filter-dropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    function showSubMenu(submenuId) {
        const submenu = document.getElementById(submenuId);
        submenu.style.display = 'block';
    }

    function hideSubMenu(submenuId) {
        const submenu = document.getElementById(submenuId);
        submenu.style.display = 'none';
    }

    // Đóng dropdown khi nhấn ra ngoài
    window.onclick = function(event) {
        if (!event.target.matches('.filter-button')) {
            const dropdown = document.querySelector('.filter-dropdown');
            dropdown.style.display = 'none';
        }
    }
</script>