<?php
define("host", "localhost");
define("user_name", "root");
define("pass", "");
define("db", "mrbook");

class Database {
    private function connec() {
        try {
            $connection = mysqli_connect(host, user_name, pass, db);
            if (!$connection) {
                throw new Exception("Connection failed: " . mysqli_connect_error());
            }
            return $connection;
        } catch (Exception $e) {
            return null;
        }
    }

    function read($query) {
        $conn = $this->connec();
        if ($conn === null) {
            return false;
        }
        try {
            $result = mysqli_query($conn, $query);
            
            if (!$result) {
                throw new Exception("Query failed: " . mysqli_error($conn));
            }
            $data = array();
            
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
                
            }
            
            mysqli_close($conn);
            return $data;
        } catch (Exception $e) {
            return false;
        }
    }

    function save($query) {
        $conn = $this->connec();
        if ($conn === null) {
            return false;
        }
        try {
            $result = mysqli_query($conn, $query);
            if (!$result) {
                throw new Exception("Query failed: " . mysqli_error($conn));
            }
            mysqli_close($conn);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function escape_string($string) {
        $conn = $this->connec();
        if ($conn !== null) {
            return mysqli_real_escape_string($conn, $string);
        }
        return $string;
    }
}
