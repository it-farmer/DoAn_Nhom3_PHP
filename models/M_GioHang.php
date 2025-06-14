
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
    // Thêm sản phẩm mới vào giỏ hàng
    public function addToCart($maKH, $maXe, $soLuong = 1) {
        $sql = "INSERT INTO GioHang (MaKH, MaXe, SoLuong) VALUES (?, ?, ?)";
        return $this->dtb->M_excute($sql, [$maKH, $maXe, $soLuong]);
    }

    // Tăng số lượng sản phẩm đã có trong giỏ hàng
    public function increaseQuantity($maKH, $maXe) {
        $sql = "UPDATE GioHang SET SoLuong = SoLuong + 1 WHERE MaKH = ? AND MaXe = ?";
        return $this->dtb->M_excute($sql, [$maKH, $maXe]);
    }
    //Tăng giảm số lượng sản phẩm đã có trong giỏ hàng
    
    public function decreaseQuantity($maKH, $maXe) {
    $sql = "UPDATE GioHang SET SoLuong = GREATEST(SoLuong - 1, 1) WHERE MaKH = ? AND MaXe = ?";
    return $this->dtb->M_excute($sql, [$maKH, $maXe]);
    }

    
}
?>