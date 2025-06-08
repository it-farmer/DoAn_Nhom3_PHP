<?php
    session_start();
    require_once '../models/M_XeHoi.php';
    require_once '../models/M_GioHang.php';

    $maKH = isset($_SESSION['MaKH']) ? $_SESSION['MaKH'] : null;

    if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['maXe'])) {
        if (!$maKH) {
            header('Location: ../index.php?showLogin=1');
            exit;
        }

        $maXe = $_GET['maXe'];
        $gioHangModel = new GioHangModel();

        // Kiểm tra sản phẩm đã có trong giỏ chưa
        $cartItems = $gioHangModel->getCartByMaKH($maKH);
        $found = false;
        foreach ($cartItems as $item) {
            if ($item->MaXe == $maXe) {
                $found = true;
                break;
            }
        }

        if ($found) {
            // Nếu đã có, tăng số lượng
            $gioHangModel->increaseQuantity($maKH, $maXe);
        } else {
            // Nếu chưa có, thêm mới
            $gioHangModel->addToCart($maKH, $maXe, 1);
        }

        header('Location: ../product_details.php?maXe=' . $maXe . '&addcart=success');
        exit;
    }

    // Xóa sản phẩm khỏi giỏ hàng
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['maXe']) && $maKH) {
        $gioHangModel = new GioHangModel();
        $gioHangModel->deleteCartItem($maKH, $_GET['maXe']);
        header('Location: ../index.php');
        exit;
    }
?>