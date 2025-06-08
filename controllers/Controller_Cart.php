
<?php
    session_start();
    require_once '../models/M_XeHoi.php';
    require_once '../models/M_GioHang.php';

    $maKH = isset($_SESSION['MaKH']) ? $_SESSION['MaKH'] : null;
    if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['maXe'])) 
    {
        if (!$maKH) 
        {
            // Nếu chưa đăng nhập, chuyển về trang chủ và hiện popup đăng nhập
            header('Location: ../index.php?showLogin=1');
            exit;
        }
        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['maXe']) && $maKH)
        {
            $gioHangModel = new GioHangModel();
            $gioHangModel->deleteCartItem($maKH, $_GET['maXe']);
            header('Location: ../header.php');
            exit;
        }
    }

    if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['maXe'])) {
        $maXe = $_GET['maXe'];
        $xeModel = new XeHoi();
        $xe = $xeModel->getXeByMaXe($maXe);

        if ($xe) {
            // Chuẩn bị dữ liệu sản phẩm
            $product = [
                'MaXe'   => $xe->MaXe,
                'TenXe'  => $xe->TenXe,
                'AnhXe'  => $xe->AnhXe,
                'Gia'    => $xe->Gia,
                'SoLuong' => 1
            ];

            // Thêm vào session giỏ hàng
            if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
            if (isset($_SESSION['cart'][$maXe])) {
                $_SESSION['cart'][$maXe]['SoLuong'] += 1;
            } else {
                $_SESSION['cart'][$maXe] = $product;
            }
        }
        // Quay lại trang chi tiết sản phẩm
        header('Location: ../product_details.php?maXe=' . $maXe . '&addcart=success');
        exit;
    }
?>
