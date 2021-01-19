<?php

class db {
    private $host = "localhost";
    private $user = "root";
    private $pass = "root123456";
    private $db = "react_db";
    public $conn = NULL;

    function __construct() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass) or
                die("Could not connect to server. Please check Username and Password again or contact administrator !" . mysqli_error());
        mysqli_select_db($this->conn, $this->db) or
                die('Could not connect to database. Please contact administrator !' . mysql_error());
        mysqli_query($this->conn, "SET SESSION group_concat_max_len = 30000000");
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $_SESSION['Limit'] = (isset($_SESSION['Limit'])) ? $_SESSION['Limit'] : 25; //Lấy session default 10
        set_time_limit(5000);
    }
    function Query($qr) {
        if (!empty($qr)) {
            $result = mysqli_query($this->conn, $qr);
            return $result;
            //mysqli_close();
        }
    }
    function NumRows($qr) {
        if (!empty($qr)) {
            return mysqli_num_rows($qr);
        }
    }
    function FetchArray($qr) {
        if (!empty($qr)) {
            return mysqli_fetch_assoc($qr);
        }
    }
    function Disconnect() {
        mysqli_close($this->conn);
    }
    public function pre($data) {
        echo '<pre>';
        print_r($data);
        die();
    }

    function OrderByidKey($idKey, $tableName) { // Lấy Primary Key cuối cùng
        $sqlSelect = "SELECT $idKey FROM $tableName ORDER BY $idKey DESC LIMIT 0,1";
        //echo $sqlSelect;
        $sqlQuery = $this->Query($sqlSelect);
        $Arr = $this->FetchArray($sqlQuery);
        return $Arr[$idKey] + 1;
    }

    public function pri($data) {
        echo '<pre>';
        print_r($data);
        echo "<br/>";
    }

}

?>