<?php
class CustomerModel {
    private $conn;
    private $tableName = "KhachHang";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllCustomers($limit, $offset, $search = "") {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE HoTenKH LIKE '%$search%' LIMIT $limit OFFSET $offset";
        $stmt = $this->conn->query($sql);
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalCustomers($search = "") {
        $sql = "SELECT COUNT(*) AS total FROM " . $this->tableName . " WHERE HoTenKH LIKE '%$search%'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function generateMaKH() {
        $result = $this->conn->query("SELECT MAX(MaKH) AS maxMaKH FROM " . $this->tableName);
        $row = $result->fetch_assoc();
        $maxMaKH = $row['maxMaKH'];

        if ($maxMaKH) {
            $num = (int)substr($maxMaKH, 2);
            $num++;
        } else {
            $num = 1; // Bắt đầu từ 1 nếu chưa có mã nào
        }

        return 'KH' . str_pad($num, 2, '0', STR_PAD_LEFT); // Tạo mã khách hàng mới
    }

    public function addCustomer($data) {
        $maKH = $this->generateMaKH();
        $hoTenKH = $data['hoTenKH'];
        $ngaySinhKH = $data['ngaySinhKH'];
        $soDienThoaiKH = $data['soDienThoaiKH'];
        $emailKH = $data['emailKH'];
        $diaChi = $data['diaChi'];

        $sql = "INSERT INTO " . $this->tableName . " (MaKH, HoTenKH, NgaySinhKH, SoDienThoaiKH, EmailKH, DiaChi) 
                VALUES ('$maKH', '$hoTenKH', '$ngaySinhKH', '$soDienThoaiKH', '$emailKH', '$diaChi')";
        return $this->conn->query($sql);
    }

    public function deleteCustomer($maKH) {
        $sql = "DELETE FROM " . $this->tableName . " WHERE MaKH = '$maKH'";
        return $this->conn->query($sql);
    }

    public function updateCustomer($data) {
        $maKH = $data['maKH'];
        $hoTenKH = $data['hoTenKH'];
        $ngaySinhKH = $data['ngaySinhKH'];
        $soDienThoaiKH = $data['soDienThoaiKH'];
        $emailKH = $data['emailKH'];
        $diaChi = $data['diaChi'];

        $sql = "UPDATE " . $this->tableName . " SET 
                HoTenKH='$hoTenKH', 
                NgaySinhKH='$ngaySinhKH', 
                SoDienThoaiKH='$soDienThoaiKH', 
                EmailKH='$emailKH', 
                DiaChi='$diaChi' 
                WHERE MaKH='$maKH'";
        return $this->conn->query($sql);
    }

    public function getCustomerByMaKH($maKH) {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE MaKH = '$maKH'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }
}
?>