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
    <div style="display: flex; height: 100%;">
        <div class="sidebar">
            <ul>
                <?php if ($roleId == 1): // Quản trị viên ?>
                    <li data-section="personnel" class="active"><i class="fa-solid fa-people-roof"></i> Quản Lý Nhân Sự</li>
                    <li data-section="equipment"><i class="fa-solid fa-list-ul"></i> Quản Lý Thiết Bị</li>
                    <li data-section="reports"><i class="fa-solid fa-flag"></i> Báo Cáo</li>
                    <li data-section="history"><i class="fa-solid fa-clock-rotate-left"></i> Lịch Sử Hoạt Động</li>
                    <li data-section="notifications"><i class="fa-solid fa-bell"></i> Thông Báo
                        (<?php if ($notis)
                            echo count($notis);
                        else
                            echo "0"; ?>)</li>
                <?php elseif ($roleId == 2): // Kỹ thuật viên ?>
                    <li data-section="usage-log" class="active" onclick="resetLog()"><i class="fa-solid fa-file-pen"></i>
                        Ghi Lịch Sử Sử Dụng</li>
                    <li data-section="history"><i class="fa-solid fa-clock-rotate-left"></i> Các Bản Ghi</li>
                    <li data-section="maintenance"><i class="fa-solid fa-screwdriver-wrench"></i> Quản Lý Bảo Trì</li>
                <?php elseif ($roleId == 3): // Người xem ?>
                    <li data-section="equipment-view" class="active"><i class="fa-solid fa-eye"></i> Xem Thiết Bị</li>
                    <li data-section="edit-profile"><i class="fa-solid fa-clipboard-list"></i> Thông Tin Cá Nhân</li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="main-content">
            <!-- Quản Lý Nhân Sự -->
            <div id="personnel" class="content-section active">
                <div class="table-container">
                    <div style="display: flex; justify-content: space-between;">
                        <h2>Quản Lý Nhân Sự</h2>
                        <button class="selectBtn" data-section="add_user" onclick="resetUserForm()">Thêm Nhân
                            Viên</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ Tên</th>
                                <th>Ngày Sinh</th>
                                <th>Giới Tính</th>
                                <th>Địa Chỉ</th>
                                <th>Điện Thoại</th>
                                <th>Vai Trò</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) { ?>
                                <tr>
                                    <td><?php echo $user->user_id ?></td>
                                    <td><?php echo $user->fullname ?></td>
                                    <td><?php echo $user->born ?></td>
                                    <td><?php echo $user->gender ?></td>
                                    <td><?php echo $user->address ?></td>
                                    <td><?php echo $user->phone ?></td>
                                    <td><?php echo $user->role_name ?></td>
                                    <td>
                                        <div class="CRUD-form">
                                            <button style="background-color: #EFB11D;"
                                                onclick="editUser(<?php echo htmlspecialchars(json_encode($user)); ?>)">
                                                Sửa
                                            </button>
                                        </div>
                                        <form class="CRUD-form" action="index.php" method="post"
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
                    <div class="pagination">
                        <?php if ($totalPageUser > 1) { ?>
                            <a href="index.php?pageUser=1">Trang Đầu</a>
                            <a href="index.php?pageUser=<?php echo $currentPageUser - 1 ?>">Trước</a>
                            <?php
                            for ($i = $start_link_user; $i <= $end_link_user; $i++) {
                                if ($i == $currentPageUser) {
                                    ?>
                                    <a style="background-color: #E43D13;"
                                        href="index.php?pageUser=<?php echo $currentPageUser ?>"><?php echo $currentPageUser ?></a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="index.php?pageUser=<?php echo $i ?>"><?php echo $i ?></a>
                                    <?php
                                }
                            }
                            ?>
                            <a href="index.php?pageUser=<?php echo $currentPageUser + 1 ?>">Sau</a>
                            <a href="index.php?pageUser=<?php echo $totalPageUser ?>">Trang Cuối</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Quản Lý Thiết Bị -->
            <div id="equipment" class="content-section">
                <div class="table-container">
                    <div style="display: flex; justify-content: space-between;">
                        <h2>Quản Lý Thiết Bị</h2>
                        <button class="selectBtn" data-section="add_equipment" onclick="resetEquipmentForm()">Thêm Thiết
                            Bị</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên Thiết Bị</th>
                                <th>Loại</th>
                                <th>Mô Tả</th>
                                <th>Trạng Thái</th>
                                <th>Tổng Giờ Hoạt Động</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($equipments as $equipment) { ?>
                                <tr>
                                    <td><?php echo $equipment->equipment_id ?></td>
                                    <td><?php echo $equipment->equip_name ?></td>
                                    <td><?php echo $equipment->equip_type ?></td>
                                    <td><?php echo $equipment->equip_description ?></td>
                                    <td><?php echo $equipment->equip_status ?></td>
                                    <td><?php echo $equipment->total_operating_hours ?></td>
                                    <td>
                                        <div class="CRUD-form">
                                            <button style="background-color: #EFB11D;"
                                                onclick="editEquipment(<?php echo htmlspecialchars(json_encode($equipment)); ?>)">
                                                Sửa
                                            </button>
                                        </div>
                                        <form class="CRUD-form" action="index.php" method="post"
                                            onsubmit="return handleDelete_Equip(event)">
                                            <input type="hidden" name="action" value="delete_equip">
                                            <input type="hidden" name="equipment_id"
                                                value="<?php echo $equipment->equipment_id ?>">
                                            <button style="background-color: #E43D12;" type="submit">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <?php if ($totalPageEquipments > 1) { ?>
                            <a href="index.php?pageEquip=1">Trang Đầu</a>
                            <a href="index.php?pageEquip=<?php echo $currentPageEquipments - 1 ?>">Trước</a>
                            <?php
                            for ($i = $start_link_equip; $i <= $end_link_equip; $i++) {
                                if ($i == $currentPageEquipments) {
                                    ?>
                                    <a style="background-color: #E43D13;"
                                        href="index.php?pageEquip=<?php echo $currentPageEquipments ?>"><?php echo $currentPageEquipments ?></a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="index.php?pageEquip=<?php echo $i ?>"><?php echo $i ?></a>
                                    <?php
                                }
                            }
                            ?>
                            <a href="index.php?pageEquip=<?php echo $currentPageEquipments + 1 ?>">Sau</a>
                            <a href="index.php?pageEquip=<?php echo $totalPageEquipments ?>">Trang Cuối</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Báo Cáo -->
            <div id="reports" class="content-section">
                <div class="table-container">
                    <div style="display: flex; justify-content: space-between;">
                        <h2>Tình Trạng Thiết Bị</h2>
                        <form action="index.php" method="post">
                            <input type="hidden" name="action" value="export_report">
                            <button class="selectBtn">Xuất Báo Cáo (.pdf)</button>
                        </form>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Thiết Bị</th>
                                <th>Trạng Thái</th>
                                <th>Tổng Giờ Hoạt Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($equipments as $equipment) { ?>
                                <tr>
                                    <td><?php echo $equipment->equipment_id ?></td>
                                    <td><?php echo $equipment->equip_name ?></td>
                                    <td><?php echo $equipment->equip_status ?></td>
                                    <td><?php echo $equipment->total_operating_hours ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <?php if ($totalPageEquipments > 1) { ?>
                            <a href="index.php?pageReport=1">Trang Đầu</a>
                            <a href="index.php?pageReport=<?php echo $currentPageEquipments - 1 ?>">Trước</a>
                            <?php
                            for ($i = $start_link_equip; $i <= $end_link_equip; $i++) {
                                if ($i == $currentPageEquipments) {
                                    ?>
                                    <a style="background-color: #E43D13;"
                                        href="index.php?pageReport=<?php echo $currentPageEquipments ?>"><?php echo $currentPageEquipments ?></a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="index.php?pageReport=<?php echo $i ?>"><?php echo $i ?></a>
                                    <?php
                                }
                            }
                            ?>
                            <a href="index.php?pageReport=<?php echo $currentPageEquipments + 1 ?>">Sau</a>
                            <a href="index.php?pageReport=<?php echo $totalPageEquipments ?>">Trang Cuối</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div id="reports-not-hidden" class="reports-not-hidden">
                <div class="table-container">
                    <div style="display: flex; justify-content: space-between;">
                        <h2>Tình Trạng Thiết Bị</h2>
                        <form action="index.php" method="post">
                            <input type="hidden" name="action" value="export_report">
                            <button class="selectBtn">Xuất Báo Cáo (.pdf)</button>
                        </form>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Thiết Bị</th>
                                <th>Trạng Thái</th>
                                <th>Tổng Giờ Hoạt Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($equipments as $equipment) { ?>
                                <tr>
                                    <td><?php echo $equipment->equipment_id ?></td>
                                    <td><?php echo $equipment->equip_name ?></td>
                                    <td><?php echo $equipment->equip_status ?></td>
                                    <td><?php echo $equipment->total_operating_hours ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <?php if ($totalPageEquipments > 1) { ?>
                            <a href="index.php?pageReport=1">Trang Đầu</a>
                            <a href="index.php?pageReport=<?php echo $currentPageEquipments - 1 ?>">Trước</a>
                            <?php
                            for ($i = $start_link_equip; $i <= $end_link_equip; $i++) {
                                if ($i == $currentPageEquipments) {
                                    ?>
                                    <a style="background-color: #E43D13;"
                                        href="index.php?pageReport=<?php echo $currentPageEquipments ?>"><?php echo $currentPageEquipments ?></a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="index.php?pageReport=<?php echo $i ?>"><?php echo $i ?></a>
                                    <?php
                                }
                            }
                            ?>
                            <a href="index.php?pageReport=<?php echo $currentPageEquipments + 1 ?>">Sau</a>
                            <a href="index.php?pageReport=<?php echo $totalPageEquipments ?>">Trang Cuối</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Lịch Sử Hoạt Động -->
            <div id="history" class="content-section">
                <div class="table-container">
                    <h2>Lịch Sử Hoạt Động</h2>
                    <!-- [Backend] Lấy danh sách lịch sử từ bảng usage_logs -->
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Thiết Bị</th>
                                <th>Người Thực Hiện</th>
                                <th>Thời Gian Bắt Đầu</th>
                                <th>Thời Gian Kết Thúc</th>
                                <th>Thời gian hoạt động (giờ)</th>
                                <th>Trạng Thái</th>
                                <th>Ghi Chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log) { ?>
                                <tr>
                                    <td><?php echo $log->log_id ?></td>
                                    <td><?php echo $log->equip_name ?></td>
                                    <td><?php echo $log->fullname ?></td>
                                    <td><?php echo $log->start_time ?></td>
                                    <td><?php echo $log->end_time ?></td>
                                    <td><?php echo $log->duration ?></td>
                                    <td><?php echo $log->status ?></td>
                                    <td><?php echo $log->notes ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Thông báo bảo trì -->
            <div id="notifications" class="content-section">
                <div class="table-container">
                    <div style="display: flex; justify-content: space-between;">
                        <h2>Thông Báo</h2>
                        <form action="index.php" method="post">
                            <input type="hidden" name="action" value="send_email">
                            <button class="selectBtn">Nhắc nhở Bảo Trì</button>
                        </form>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align: center;">Thông Báo Số</th>
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
                                            <h4 style="color: #E43D12;"><i class="fa-solid fa-hammer"></i> Bảo trì vào ngày mai!
                                            </h4>
                                            <br>
                                            <p>Thiết bị: <?php echo $noti->equip_name ?> <br> Ngày bảo trì:
                                                <?php echo $noti->maintenance_date ?> <br> Ngày bảo trì tiếp theo:
                                                <?php echo $noti->next_maintenance_date ?>
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

            <!-- Thêm và Sửa Thiết Bị -->
            <div id="add_equipment" class="content-section">
                <div class="form-box">
                    <div style="display: flex; justify-content: space-between;">
                        <h2 id="equipment-form-title">Thêm Thiết Bị</h2>
                        <button class="selectBtn" data-section="equipment">Quay lại</button>
                    </div>
                    <form style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between;"
                        id="equipment-form" method="post" action="index.php">
                        <input type="hidden" name="action" id="equipment-action" value="add_equip">
                        <!-- <input type="hidden" name="action2" id="action2" value="view/admin.php"> -->
                        <input type="hidden" name="equipment_id" id="equipment_id">
                        <div class="input-group">
                            <label for="equip_name">Tên Thiết Bị</label>
                            <input type="text" name="equip_name" id="equip_name" required>
                            <div class="error-message" id="equip_name-error">Tên thiết bị không được để trống</div>
                        </div>
                        <div class="input-group">
                            <label for="equip_type">Loại Thiết Bị</label>
                            <input type="text" name="equip_type" id="equip_type" required>
                            <div class="error-message" id="equip_type-error">Loại thiết bị không được để trống</div>
                        </div>
                        <div class="input-group">
                            <label for="equip_description">Mô Tả</label>
                            <textarea name="equip_description" id="equip_description"
                                placeholder="Nhập mô tả (nếu có)"></textarea>
                        </div>
                        <div class="input-group">
                            <label for="equip_status">Trạng Thái</label>
                            <select name="equip_status" id="equip_status" required>
                                <option value="" disabled selected>Chọn trạng thái</option>
                                <option value="Hoạt động">Hoạt động</option>
                                <option value="Ngưng hoạt động">Ngưng hoạt động</option>
                                <option value="Đang bảo trì">Đang bảo trì</option>
                                <option value="Hư hỏng">Hư hỏng</option>
                            </select>
                            <div class="error-message" id="equip_status-error">Vui lòng chọn trạng thái</div>
                        </div>
                        <div class="input-group">
                            <label for="total_operating_hours">Tổng Giờ Hoạt Động</label>
                            <input type="number" name="total_operating_hours" id="total_operating_hours" step="0.01"
                                required>
                            <div class="error-message" id="total_operating_hours-error">Tổng giờ hoạt động không hợp lệ
                            </div>
                        </div>
                        <button id="equipment-form-btn" type="submit" class="submit-btn">Thêm Thiết Bị</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/script.js"></script>
</body>

</html>