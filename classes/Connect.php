<?php 
define("host" , "localhost");
define("user_name" , "root");
define("pass" , "");
define("db" , "mrbook");
class Database{    
    private function connec(){
        try {
            $connection = mysqli_connect(host, user_name, pass, db);
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
            mysqli_close($conn);    
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
            mysqli_close($conn);
            return true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
