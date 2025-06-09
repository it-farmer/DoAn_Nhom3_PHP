<?php
session_start();
include('ConnectDatabase_PDO.php');
require('phpmailer/src/PHPMailer.php');
require('phpmailer/src/Exception.php');
require('phpmailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$showLogout = true;

$sta = $pdo->prepare("SELECT * FROM xehoi WHERE SoLuongTonKho = 1");
$sta->execute();

if ($sta->rowCount() > 0) {
    $notis = $sta->fetchAll(PDO::FETCH_OBJ);
}

$sta = $pdo->prepare("SELECT * FROM nhanvien, quyentruycap WHERE nhanvien.QuyenID = quyentruycap.QuyenID");
$sta->execute();

if ($sta->rowCount() > 0) {
    $users = $sta->fetchAll(PDO::FETCH_OBJ);
}

$sta = $pdo->prepare("
    SELECT hoadon.*, nhanvien.HoTenNV, khachhang.HoTenKH, xehoi.TenXe, chitiethoadon.SoLuong, chitiethoadon.GiaBan
    FROM hoadon
    LEFT JOIN nhanvien ON hoadon.MaNV = nhanvien.MaNV
    LEFT JOIN khachhang ON hoadon.MaKH = khachhang.MaKH
    LEFT JOIN chitiethoadon ON hoadon.MaHD = chitiethoadon.MaHD
    LEFT JOIN xehoi ON chitiethoadon.MaXe = xehoi.MaXe
    ORDER BY hoadon.MaHD ASC
");
$sta->execute();
if ($sta->rowCount() > 0)
    $invoices = $sta->fetchAll(PDO::FETCH_OBJ);

$sta = $pdo->prepare("SELECT * FROM xehoi ");
$sta->execute();
if ($sta->rowCount() > 0)
    $cars = $sta->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['action']) && $_POST['action'] == 'export_report') {
    include('export_report.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/cdbcf8b89b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/styles.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="header_ad">
        <h1 style="display: flex; align-items: center;">
            Trang Quản Lý
        </h1>
        <div class="header-right">
            <i class="fa-solid fa-user"></i>
            <?php if (isset($showLogout) && $showLogout): ?>
                <span>
                    <?php
                    echo $_SESSION['HoTenNV'];
                    ?>
                </span>
                <form id="logout-id" action="index.php" method="post" onsubmit="return handleLogout()">
                    <input type="hidden" name="log_out">
                    <button class="logout-btn">Đăng Xuất</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <div style="display: flex; height: 100%;">
        <div class="sidebar">
            <ul>
                <li data-section="personnel" class="active"><i class="fa-solid fa-people-roof"></i> Quản Lý Nhân Viên
                </li>
                <li><a href="controllers/controllerKhachHang.php"><i class="fa-solid fa-people-roof"></i> Quản Lý Khách
                        Hàng</a>
                </li>
                <li><a href="QL_Xe.php"><i class="fa-solid fa-car"></i> Quản Lý Xe</a>
                </li>
                <li data-section="invoice"><i class="fa-solid fa-list-ul"></i> Hóa Đơn</li>
                <li data-section="reports"><i class="fa-solid fa-flag"></i> Báo Cáo</li>
                <li data-section="notifications"><i class="fa-solid fa-bell"></i> Thông Báo
                    (<?php if ($notis)
                        echo count($notis);
                    else
                        echo "0"; ?>)
                </li>
            </ul>
        </div>
        <div class="main-content">
            <!-- Quản Lý Nhân Sự -->
            <div id="personnel" class="content-section active">
                <div class="table-container">
                    <div style="display: flex; justify-content: space-between;">
                        <h2>Quản Lý Nhân Sự</h2>
                        <a href="QL_NhanVien.php"><button class="selectBtn" data-section="add_user"
                                onclick="resetUserForm()">Thêm Nhân
                                Viên</button></a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Mã NV</th>
                                <th>Họ Tên</th>
                                <th>Giới Tính</th>
                                <th>Ngày Sinh</th>
                                <th>Quê Quán</th>
                                <th>Điện Thoại</th>
                                <th>Email</th>
                                <th>Vai Trò</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) { ?>
                                <tr>
                                    <td><?php echo $user->MaNV ?></td>
                                    <td><?php echo $user->HoTenNV ?></td>
                                    <td><?php echo $user->GioiTinh ?></td>
                                    <td><?php echo $user->NgaySinhNV ?></td>
                                    <td><?php echo $user->QueQuan ?></td>
                                    <td><?php echo $user->SoDienThoaiNV ?></td>
                                    <td><?php echo $user->EmailNV ?></td>
                                    <td><?php echo $user->TenQuyen ?></td>
                                    <td>
                                        <div class="CRUD-form">
                                            <a href="QL_NhanVien.php"><button style="background-color: #EFB11D;"
                                                    onclick="editUser(<?php echo htmlspecialchars(json_encode($user)); ?>)">
                                                    Sửa
                                                </button></a>
                                        </div>
                                        <form class="CRUD-form" action="QL_NhanVien.php" method="post"
                                            onsubmit="return handleDelete(event)">
                                            <input type="hidden" name="action" value="delete_user">
                                            <input type="hidden" name="user_id" value="<?php echo $user->user_id ?>">
                                            <button style="background-color: #E43D12;">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quản Lý Hóa Đơn -->
            <div id="invoice" class="content-section">
                <div class="table-container">
                    <div style="display: flex; justify-content: space-between;">
                        <h2>Hóa Đơn</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Hóa Đơn</th>
                                <th>Người Thực Hiện</th>
                                <th>Khách Hàng</th>
                                <th>Ngày Lập</th>
                                <th>Tên Xe</th>
                                <th>Số Lượng</th>
                                <th>Giá</th>
                                <th>Tổng Tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invoices as $invoice) { ?>
                                <tr>
                                    <td><?php echo $invoice->MaHD ?></td>
                                    <td><?php echo $invoice->HoTenNV ?></td>
                                    <td><?php echo $invoice->HoTenKH ?></td>
                                    <td><?php echo $invoice->NgayLap ?></td>
                                    <td><?php echo $invoice->TenXe ?></td>
                                    <td><?php echo $invoice->SoLuong ?></td>
                                    <td><?php echo $invoice->GiaBan ?></td>
                                    <td><?php echo $invoice->TongTien ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Báo Cáo -->
            <div id="reports" class="content-section">
                <div class="table-container">
                    <div style="display: flex; justify-content: space-between;">
                        <h2>Tình Trạng Tồn Kho</h2>
                        <form method="post">
                            <input type="hidden" name="action" value="export_report">
                            <button class="selectBtn">Xuất Báo Cáo (.pdf)</button>
                        </form>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Xe</th>
                                <th>Mã Hãng Xe</th>
                                <th>Tên Xe</th>
                                <th>Màu Xe</th>
                                <th>Giá</th>
                                <th>Số Lượng Tồn Kho</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cars as $car) { ?>
                                <tr>
                                    <td><?php echo $car->MaXe ?></td>
                                    <td><?php echo $car->MaHX ?></td>
                                    <td><?php echo $car->TenXe ?></td>
                                    <td><?php echo $car->MauXe ?></td>
                                    <td><?php echo $car->Gia ?></td>
                                    <td><?php echo $car->SoLuongTonKho ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="reports-not-hidden" class="reports-not-hidden">
                <div class="table-container">
                    <div style="display: flex; justify-content: space-between;">
                        <h2>Tình Trạng Thiết Bị</h2>
                        <form action="admin.php" method="post">
                            <input type="hidden" name="action" value="export_report">
                            <button class="selectBtn">Xuất Báo Cáo (.pdf)</button>
                        </form>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Xe</th>
                                <th>Mã Hãng Xe</th>
                                <th>Tên Xe</th>
                                <th>Màu Xe</th>
                                <th>Giá</th>
                                <th>Số Lượng Tồn Kho</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cars as $car) { ?>
                                <tr>
                                    <td><?php echo $car->MaXe ?></td>
                                    <td><?php echo $car->MaHX ?></td>
                                    <td><?php echo $car->TenXe ?></td>
                                    <td><?php echo $car->MauXe ?></td>
                                    <td><?php echo $car->Gia ?></td>
                                    <td><?php echo $car->SoLuongTonKho ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="notifications" class="content-section">
                <div class="table-container">
                    <div style="display: flex; justify-content: space-between;">
                        <h2>Thông Báo</h2>
                        <form action="admin.php" method="post">
                            <input type="hidden" name="action" value="send_email">
                            <button class="selectBtn">Gửi Mail nhắc nhở</button>
                        </form>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align: center;">Thông Báo</th>
                                <th style="text-align: center;">Nội Dung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $num_noti = 1;
                            if ($notis) {
                                foreach ($notis as $noti) { ?>
                                    <tr>
                                        <td style="text-align: center; width: 20%;"><?php echo $num_noti++; ?></td>
                                        <td>
                                            <h4 style="color: #E43D12;"><i class="fa-solid fa-truck-ramp-box"></i> Nhập thêm xe!
                                            </h4>
                                            <br>
                                            <p>Xe: <?php echo $noti->TenXe ?> <br> Màu:
                                                <?php echo $noti->MauXe ?><br> Trong kho còn:
                                                <?php echo $noti->SoLuongTonKho ?> chiếc
                                            </p>
                                        </td>
                                    </tr>
                                <?php }
                            } else {
                                echo "<td colspan=2>Không có gì ở đây cả</td>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Thêm và Sửa Người Dừng -->
            <div id="add_user" class="content-section">
                <div class="form-box">
                    <div style="display: flex; justify-content: space-between;">
                        <h2 id="form-title">Thêm Nhân Viên</h2>
                        <button class="selectBtn" data-section="personnel">Quay lại</button>
                    </div>
                    <form id="handle-form" method="post" action="index.php">
                        <input type="hidden" name="action" id="action" value="add_user">
                        <input type="hidden" name="action2" id="action2" value="view/admin.php">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="input-group">
                            <label for="fullname">Họ và Tên</label>
                            <input type="text" name="fullname" id="fullname" required>
                            <div class="error-message" id="fullname-error">Tên không được để trống</div>
                        </div>
                        <div class="input-group">
                            <label for="born">Ngày Sinh</label>
                            <input type="date" name="born" id="born" required>
                            <div class="error-message" id="born-error">Vui lòng chọn ngày sinh</div>
                        </div>
                        <div class="input-group">
                            <label for="gender">Giới Tính</label>
                            <select name="gender" id="gender" required>
                                <option value="" disabled selected>Chọn giới tính</option>
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                            </select>
                            <div class="error-message" id="gender-error">Vui lòng chọn giới tính</div>
                        </div>
                        <div class="input-group">
                            <label for="address">Địa Chỉ</label>
                            <input type="text" name="address" id="address" required>
                            <div class="error-message" id="address-error">Địa chỉ không được để trống</div>
                        </div>
                        <div class="input-group">
                            <label for="phone">Điện Thoại</label>
                            <input type="text" name="phone" id="phone" required>
                            <div class="error-message" id="phone-error">Số điện thoại không hợp lệ</div>
                        </div>
                        <div class="input-group">
                            <label for="role_id">Vai Trò</label>
                            <select name="role_id" id="role_id" required>
                                <option value="" disabled selected>Chọn vai trò</option>
                                <option value="1">Quản trị viên</option>
                                <option value="2">Kỹ thuật viên</option>
                                <option value="3">Nhân viên</option>
                            </select>
                            <div class="error-message" id="role_id-error">Vui lòng chọn vai trò</div>
                        </div>
                        <div class="input-group">
                            <label for="username">Tên Đăng Nhập</label>
                            <input type="text" name="username_edit" id="username" required>
                            <div class="error-message" id="username-error">Tên đăng nhập không được để trống</div>
                        </div>
                        <div class="input-group">
                            <label for="password">Mật Khẩu</label>
                            <input type="password" name="password_edit" id="password">
                            <div class="error-message" id="username-error">Mật khẩu không được để trống</div>
                        </div>
                        <button type="submit" id="form-btn" class="submit-btn">Thêm Nhân Viên</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/js/script.js?v=<?php echo time(); ?>"></script>
    <?php
    if (isset($_POST['action']) && $_POST['action'] == "send_email") {
        // Lấy email của các kỹ thuật viên (role_id = 2)
        $sta = $pdo->prepare("SELECT HoTenNV, EmailNV FROM nhanvien WHERE QuyenID = 2");
        $sta->execute();

        if ($sta->rowCount() > 0)
            $operators = $sta->fetchAll(PDO::FETCH_OBJ);

        if ($operators && count($operators) > 0) {
            $mail = new PHPMailer(true);

            try {
                // Cấu hình SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // SMTP server của Gmail
                $mail->SMTPAuth = true;
                $mail->Username = 'dotrungdung.lop12a1@gmail.com'; // Email của bạn
                $mail->Password = 'qmbc nbza robx zvqp'; // Mật khẩu ứng dụng Gmail
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Thiết lập thông tin email
                foreach ($operators as $operator) {
                    $mail->setFrom('dotrungdung.lop12a1@gmail.com', 'Hệ Thống Bán Ô Tô');
                    $mail->addAddress($operator->EmailNV); // Thêm email của Nhân viên bán hàng
    
                    // Tạo danh sách xe cần nhập thêm
                    $car_list = "<ul>";
                    if ($notis && count($notis) > 0) {
                        foreach ($notis as $noti) {
                            $car_list .= "<li>" . htmlspecialchars($noti->MaXe) . " - " . $noti->TenXe . ": Chỉ còn: " . $noti->SoLuongTonKho . " chiếc.</li>";
                        }
                    }
                    $car_list .= "</ul>";

                    $mail->Subject = 'Thông Báo Từ Hệ Thống Bán Ô Tô';
                    $mail->Body = "
                        <h2>Thông Báo</h2>
                        <p>Xin chào <strong>" . $operator->HoTenNV . "</strong>,</p>
                        <p>Đây là một thông báo từ hệ thống bán ô tô.</p>
                        <p>Có một số xe cần được kiểm tra và nhập thêm trong thời gian tới:</p>
                        " . $car_list . "
                        <p>Vui lòng kiểm tra và thực hiện các công việc cần thiết.</p>
                        <p>Trân trọng,</p>
                        <p>" . $_SESSION['HoTenNV'] . " - Quản trị viên</p>
                    ";
                    $mail->CharSet = 'UTF-8';
                    $mail->isHTML(true);

                    // Gửi email
                    $mail->send();
                    $mail->clearAddresses(); // Xóa địa chỉ để gửi email tiếp theo
                }

                // Hiển thị thông báo thành công
                echo "<script>
                        Swal.fire({
                            title: 'Gửi nhắc nhở thành công!',
                            text: 'Email đã được gửi đến các nhân viên.',
                            icon: 'success'
                        }).then(() => {
                            showContent('notifications');
                        });
                    </script>";
            } catch (Exception $e) {
                // Hiển thị thông báo lỗi
                echo "<script>
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Không thể gửi email: " . addslashes($mail->ErrorInfo) . "',
                            icon: 'error'
                        }).then(() => {
                            showContent('notifications');
                        });
                    </script>";
            }
        } else {
            // Không tìm thấy kỹ thuật viên
            echo "<script>
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Không tìm thấy kỹ thuật viên nào để gửi email.',
                        icon: 'error'
                    }).then(() => {
                        showContent('notifications');
                    });
                </script>";
        }
    }
    ?>
</body>

</html>