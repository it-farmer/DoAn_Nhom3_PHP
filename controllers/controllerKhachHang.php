<?php
include("../models/models.php");

// Kết nối database (giả sử file ConnectDatabase.php định nghĩa biến $conn)
include("../ConnectDatabase.php");
$customerModel = new CustomerModel($conn);

$message = "";

// Số khách hàng hiển thị mỗi trang
$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Xử lý thêm khách hàng
if (isset($_POST['add'])) {
    $data = $_POST;
    if ($customerModel->addCustomer($data)) {
        $message = "Thêm khách hàng thành công!";
    } else {
        $message = "Lỗi khi thêm khách hàng.";
    }
}

// Xử lý xóa khách hàng
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $maKH = $_GET['id'];
    if ($customerModel->deleteCustomer($maKH)) {
        $message = "Xóa khách hàng thành công!";
    } else {
        $message = "Lỗi khi xóa khách hàng.";
    }
}

// Xử lý sửa khách hàng
if (isset($_POST['edit'])) {
    $data = $_POST;
    if ($customerModel->updateCustomer($data)) {
        $message = "Sửa thông tin khách hàng thành công!";
    } else {
        $message = "Lỗi khi sửa thông tin khách hàng.";
    }
}

// Xử lý tìm kiếm
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search_term'];
}

// Lấy danh sách khách hàng
$customers = $customerModel->getAllCustomers($limit, $offset, $search);

// Tính tổng số trang
$totalCustomers = $customerModel->getTotalCustomers($search);
$totalPages = ceil($totalCustomers / $limit);

// Lấy thông tin khách hàng để hiển thị trên form sửa (nếu có)
$customer = null;
if (isset($_GET['edit_id'])) {
    $customer = $customerModel->getCustomerByMaKH($_GET['edit_id']);
}

// Gọi view để hiển thị dữ liệu
include("../views/views.php");

$conn->close();
?>