<?php
    class DbFunctions{

        private $conn;

        function __construct()
        {
            require_once 'DbConfig.php';
            $database = new DbConfig();

            $this->conn = $database->connect();
        }


        /**
         * add special occasions
         */
        public function add_special_occasions($so_name,$so_acr,$so_date_start,$so_date_end){
            
            $sql = "INSERT INTO special_occasions(so_name,so_acr,so_date_start,so_date_end)VALUES(?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array($so_name,$so_acr,$so_date_start,$so_date_end));
            $result = $stmt->fetch();
            return $result;
        }

        /**
         * Check Special Occassions
         */
        public function check_occasion($so_name){

            $sql = "SELECT * FROM special_occasions WHERE so_name = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array($so_name));
            $result = $stmt->fetch();
            return $result;
        }
        
        /**
         * get all employee
         */
        public function get_all_employee(){
            $sql = "SELECT * FROM emp";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array());
            $result = $stmt->fetchAll();
            return $result;
        }

        public function get_employee(){
            $sql = "SELECT emp_fname, emp_contact_num FROM emp WHERE emp_cont_verified=1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array());
            $result = $stmt->fetchAll();
            return $result;
        }

        public function get_time($time){
            $sql = "SELECT DATE_FORMAT('$time','%M %e,%Y'),DATE_FORMAT('$time','%h:%i')";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array($time));
            $result = $stmt->fetch();
            return $result;
        }

        public function get_cur_time(){
            $sql = "SELECT CONCAT(DATE_FORMAT(CURRENT_TIME,'%Y-%m-%e'),'T',DATE_FORMAT(CURRENT_TIME,'%h:%i')) as dt";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }
    }
?>