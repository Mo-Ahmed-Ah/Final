<?php 
class Database{
    private $host = "localhost";
    private $user_name = "root";
    private $pass = "";
    private $db = "MrBook";
    
    private function connec(){
        try {
            $connection = mysqli_connect($this->host, $this->user_name, $this->pass, $this->db);
            if (!$connection) {
                throw new Exception("Connection failed: " . mysqli_connect_error());
            }
            return $connection;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    function read($query){
        $conn = $this->connec();
        try {
            $result = mysqli_query($conn, $query);
            if (!$result) {
                throw new Exception("Query failed: " . mysqli_error($conn));
            }
            $data = array(); // Initialize the array
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $data;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    function save($query){
        $conn = $this->connec();
        try {
            $result = mysqli_query($conn, $query);
            if (!$result) {
                throw new Exception("Query failed: " . mysqli_error($conn));
            }
            return true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
