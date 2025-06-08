<?php
    // require_once("DOAN_NHOM3_PHP/models/M_database.php");
    require_once __DIR__ . '/M_database.php';
    class XeHoi
    {
        private $dtb;

        public function __construct()
        {
            $this->dtb= new Database();
            $this->dtb->M_connect();
        }

        public function getXeByMaXe($maXe)
        {
            $sql = "SELECT * FROM XeHoi WHERE MaXe = ?";
            $options = array($maXe);
            $result = $this->dtb->M_getOne($sql, $options);
            return $result;
        }

        public function getAllXe()
        {
            $sql = "SELECT * FROM XeHoi";
            $result = $this->dtb->M_getAll($sql);
            return $result;
        }

        public function DeleteXe($maXe)
        {
            $sql = "DELETE FROM XeHoi WHERE MaXe = ?";
            $options = array($maXe);
            return $this->dtb->M_excute($sql, $options);
        }
    }

?>