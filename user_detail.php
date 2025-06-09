<?php
$title = "Thông tin cá nhân";
include("header.php");
include('ConnectDatabase_PDO.php');

if (isset($_POST['action']) && $_POST['action'] == 'edit_user') {
    if (isset($_FILES['HinhAnhKHMoi']) && $_FILES['HinhAnhKHMoi']['error'] == 0){
        $HinhAnhKH = $_FILES["HinhAnhKHMoi"]['name'];
    }
    else
        $HinhAnhKH = $_POST['HinhAnhKHCu'];

    $sta = $pdo->prepare("UPDATE khachhang SET HoTenKH = ?, NgaySinhKH = ?, SoDienThoaiKH = ?, EmailKH = ?, DiaChi = ?, HinhAnhKH = ?, TenDangNhap = ?, MatKhau = ? WHERE MaKH = ?");

    if ($sta->execute([$_POST['fullname'], $_POST['born'], $_POST['phone'], $_POST['email'], $_POST['address'], $HinhAnhKH, $_POST['username_edit'], $_POST['password_edit'], $_POST['MaKH']])) {
        $_SESSION['HoTenKH'] = $_POST['fullname'];
        $_SESSION['HinhAnhKH'] = $HinhAnhKH;
        $_SESSION['MaKH'] = $_POST['MaKH'];
        $_SESSION['NgaySinhKH'] = $_POST['born'];
        $_SESSION['SoDienThoaiKH'] = $_POST['phone'];
        $_SESSION['EmailKH'] = $_POST['email'];
        $_SESSION['DiaChi'] = $_POST['address'];
        $_SESSION['TenDangNhap'] = $_POST['username_edit'];
        $_SESSION['MatKhau'] = $_POST['password_edit'];
        echo "
            <script>
            Swal.fire({
                title: 'Cập nhật thông tin thành công!',
                icon: 'success'
            });
            </script>";
    }
}
?>
<div class="main-content">
    <!-- Thêm và Sửa Người Dừng -->
    <div class="content-section-2">
        <div class="form-box">
            <div style="display: flex; justify-content: space-between;">
                <h2 id="form-title">Thông Tin Cá Nhân</h2>
                <a href="index.php" class="selectBtn">Quay lại</a>
            </div>
            <form id="handle-form" method="post" action="user_detail.php" enctype="multipart/form-data">
                <input type="hidden" name="action" id="action" value="edit_user">
                <div style="width: 100%; height: 250px; display: flex; flex-direction: column; align-items: center;"
                    class="input-group">
                    <img style="width: 150px; height: 150px; object-fit: contain; border-radius: 50%; margin-bottom: 2%"
                        src="assets/img/Nguoi/<?php echo $_SESSION['HinhAnhKH'] ?>"
                        alt="<?php echo $_SESSION['HinhAnhKH'] ?>">
                    <input type="hidden" name="HinhAnhKHCu" id="HinhAnhKHCu"
                        value="<?php echo $_SESSION['HinhAnhKH'] ?>" readonly>
                    <label for="pic">Chọn hình ảnh mới</label>
                    <input id="pic" name="HinhAnhKHMoi" style="width: 20%; padding: 5px;" type="file">
                </div>
                <div class="input-group">
                    <label for="fullname">Mã Khách Hàng</label>
                    <input type="text" name="MaKH" id="MaKH" value="<?php echo $_SESSION['MaKH'] ?>" readonly>
                </div>
                <div class="input-group">
                    <label for="fullname">Họ và Tên</label>
                    <input type="text" name="fullname" id="fullname" value="<?php echo $_SESSION['HoTenKH'] ?>"
                        required>
                    <div class="error-message" id="fullname-error">Tên không được để trống</div>
                </div>
                <div class="input-group">
                    <label for="born">Ngày Sinh</label>
                    <input type="date" name="born" id="born" value="<?php echo $_SESSION['NgaySinhKH'] ?>" required>
                    <div class="error-message" id="born-error">Vui lòng chọn ngày sinh</div>
                </div>
                <div class="input-group">
                    <label for="address">Địa Chỉ</label>
                    <input type="text" name="address" id="address" value="<?php echo $_SESSION['DiaChi'] ?>" required>
                    <div class="error-message" id="address-error">Địa chỉ không được để trống</div>
                </div>
                <div class="input-group">
                    <label for="phone">Điện Thoại</label>
                    <input type="text" name="phone" id="phone" value="<?php echo $_SESSION['SoDienThoaiKH'] ?>"
                        required>
                    <div class="error-message" id="phone-error">Số điện thoại không hợp lệ</div>
                </div>
                <div class="input-group">
                    <label for="phone">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo $_SESSION['EmailKH'] ?>" required>
                    <div class="error-message" id="phone-error">Số điện thoại không hợp lệ</div>
                </div>
                <div class="input-group">
                    <label for="username">Tên Đăng Nhập</label>
                    <input type="text" name="username_edit" id="username" value="<?php echo $_SESSION['TenDangNhap'] ?>"
                        required>
                    <div class="error-message" id="username-error">Tên đăng nhập không được để trống</div>
                </div>
                <div class="input-group">
                    <label for="password">Mật Khẩu</label>
                    <input type="password" name="password_edit" id="password"
                        value="<?php echo $_SESSION['MatKhau'] ?>">
                    <div class="error-message" id="username-error">Mật khẩu không được để trống</div>
                </div>
                <button type="submit" id="form-btn" class="submit-btn">Cập Nhật Thông Tin</button>
            </form>
        </div>
    </div>
</div>
<?php
include("footer.php");
?>