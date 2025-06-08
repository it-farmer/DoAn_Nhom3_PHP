<?php
    class Database
    {
        public $conn;

        function M_connect()
        {
            try
            {
                $this->conn=new PDO('mysql:host=localhost;dbname=ql_xehoi','root','');
            }
            catch (PDOException $ex)
            {
                echo "Error:".$ex->getMessage();
                echo "Ket nối thất bại";
                die();
            }
        }

        function M_excute($sql, $option= array())
        {
            $result =$this->conn->prepare($sql);
            if($option)
            {
                for($i=0 ; $i<count($option);$i++)
                {
                    $result->bindParam($i+1,$option[$i]);
                }
            }
            $result->execute();
            return $result;
        }

        function M_getAll($sql,$option = array())
        {
            $result = $this->M_excute($sql, $option);
            return $result-> fetchAll(PDO::FETCH_OBJ);
        }
        function M_getOne($sql, $option = array())
        {
            $result = $this->M_excute($sql, $option);
            return $result->fetch(PDO::FETCH_OBJ);
        }

        function M_disconnect()
        {
            $this->conn=null;
        }
    }
?>