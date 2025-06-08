
<?php
require_once __DIR__ . '/M_database.php';

class GioHangModel {
    private $dtb;

    public function __construct() {
        $this->dtb = new Database();
        $this->dtb->M_connect();
    }

    // Lấy sản phẩm giỏ hàng theo MaKH
    public function getCartByMaKH($maKH) {
        $sql = "SELECT gh.MaXe, gh.SoLuong, xh.TenXe, xh.AnhXe, xh.Gia
                FROM GioHang gh, XeHoi xh
                WHERE gh.MaXe = xh.MaXe
                AND gh.MaKH = ?";
        return $this->dtb->M_getAll($sql, [$maKH]);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteCartItem($maKH, $maXe) {
        $sql = "DELETE FROM GioHang WHERE MaKH = ? AND MaXe = ?";
        return $this->dtb->M_excute($sql, [$maKH, $maXe]);
    }
    //Quản Lý Hóa Đơn Khách Hàng
    // public function getHoaDonByMaKH($maKH) 
    // {
    //     $
    // }
}
?>