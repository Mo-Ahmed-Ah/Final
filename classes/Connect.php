<?php
define("HOST", "localhost");
define("USER_NAME", "root");
define("PASS", "");
define("DB", "mrbook");

class Database {
    private $conn;

    private function connect() {
        $this->conn = mysqli_connect(HOST, USER_NAME, PASS, DB);
        if (!$this->conn) {
            throw new Exception("Connection failed: " . mysqli_connect_error());
        }
    }

    private function close() {
        if ($this->conn) {
            mysqli_close($this->conn);
            $this->conn = null;
        }
    }

    function read($query) {
        try {
            $this->connect();
            $result = mysqli_query($this->conn, $query);

            if ($result === false) {
                throw new Exception("Query failed: " . mysqli_error($this->conn));
            }

            if (is_bool($result)) {
                return $result;
            }

            $data = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            mysqli_free_result($result); 
            $this->close(); 
            return $data;
        } catch (Exception $e) {
            $this->close(); 
            throw new Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function save($query) {
        try {
            $this->connect(); // تأكد من فتح الاتصال
            
            $stmt = mysqli_query($this->conn, $query);
            
            if ($stmt === false) {
                throw new Exception("Statement execution failed: " . mysqli_error($this->conn));
            }


            mysqli_free_result($stmt); 
            $this->close(); 
            
            return true;
        } catch (Exception $e) {
            echo "<script>
                    alert('{$e->getMessage()}');
                    window.location.href = '';
                </script>";
            $this->close(); 
            exit();
        }
    }
}
