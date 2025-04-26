<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Error'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Slab&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cdbcf8b89b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="resources/css/styles.css">
    <script src="resources/js/script.js"></script>

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
        <div class="nav"> 
            <ul>
                <li><a href="index.php">Logo</a></li>
                <li><a href="index.php">Trang chủ</a></li>
                <li>
                    <ul class="dropdown-menu">
                        <li style="width: 100px;">
                            <a href="#">Hãng xe<i class="fa-solid fa-angle-down"></i></a>
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
                <li><input style="width: 250px; height: 30px; border-radius: 10px; padding-left: 10px" type="text" placeholder="Tìm kiếm"></li>
                <li><a href="#">Dịch vụ</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="about_us.php">Về chúng tôi</a></li>
                <li><a onclick="showLogin()" href="#">Đăng nhập / Đăng ký</a></li>
            </ul>
        </div>
        <!-- Đăng nhập / Đăng ký -->
        <div id="login" class="login-container">
            <div class="slide_s_login">
                <img src="resources/img/brand/Audi/Audi A6/OutSide/A6_3.avif" alt="granturismo-trofeo-red-right-view-desktop.jpg">
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
                        <button><img src="resources/img/icons/google-logo.png" alt="gg_logo">Google</button>
                        <button><img src="resources/img/icons/github-logo.png" alt="git_logo">Github</button>
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
                        <button><img src="resources/img/icons/google-logo.png" alt="gg_logo">Google</button>
                        <button><img src="resources/img/icons/github-logo.png" alt="git_logo">Github</button>
                    </div>
                </div>
            </div>
        </div>
    </header>
