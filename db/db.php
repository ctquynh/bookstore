<?php
require_once("config.php");

class DB {
    var $conn;
    function __construct()
    {
        $this->conn = mysqli_connect(host, username, password, dbname);
    }
    function execute($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        return $result;
        mysqli_close($this->conn);
    }
}



?>