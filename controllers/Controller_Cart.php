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
    if (isset($_POST['ajax']) && isset($_POST['action']) && isset($_POST['maXe']) && $maKH) {
    $gioHangModel = new GioHangModel();
    $maXe = $_POST['maXe'];
    if ($_POST['action'] == 'increase') {
        $gioHangModel->increaseQuantity($maKH, $maXe);
    } else if ($_POST['action'] == 'decrease') {
        $gioHangModel->decreaseQuantity($maKH, $maXe); // Bạn cần viết hàm này
    }
    // Lấy lại thông tin giỏ hàng
    $cart = $gioHangModel->getCartByMaKH($maKH);
    $qty = 0; $subtotal = 0; $total = 0;
    foreach ($cart as $item) {
        if ($item->MaXe == $maXe) {
            $qty = $item->SoLuong;
            $subtotal = number_format($item->Gia * $item->SoLuong, 0, ",", ".");
        }
        $total += $item->Gia * $item->SoLuong;
    }
    echo json_encode([
        'success' => true,
        'qty' => $qty,
        'subtotal' => $subtotal,
        'total' => number_format($total, 0, ",", ".")
    ]);
    exit;
    }


    //Voucher
    // Xử lý áp dụng voucher
    if (isset($_POST['ajax']) && $_POST['action'] == 'apply_voucher' && isset($_POST['voucher'])) {
    $code = $_POST['voucher'];
    $db = new Database();
    $db->M_connect();
    $voucher = $db->M_getOne("SELECT * FROM Voucher WHERE MaVC = ?", [$code]);
    if ($voucher) {
        $today = date('Y-m-d');
        if ($today > $voucher->NgayHetHan) {
            echo json_encode(['success' => false, 'message' => 'Voucher đã hết hạn, vui lòng thử voucher khác']);
            exit;
        }
        $discount_percent = (int)$voucher->GiamGia;
        $cart = (new GioHangModel())->getCartByMaKH($maKH);
        $total = 0;
        foreach ($cart as $item) $total += $item->Gia * $item->SoLuong;
        $discounted = $total * (1 - $discount_percent / 100);
        echo json_encode([
            'success' => true,
            'message' => "Áp dụng thành công! Giảm {$discount_percent}%",
            'discounted_total' => number_format($discounted, 0, ",", ".")
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Mã không hợp lệ']);
    }
    exit;
    }



?>