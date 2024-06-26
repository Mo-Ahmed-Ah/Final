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
            $this->connect(); // تأكد من فتح الاتصال
            $result = mysqli_query($this->conn, $query);

            if ($result === false) {
                throw new Exception("Query failed: " . mysqli_error($this->conn));
            }

            // Handle DELETE or other non-select queries
            if (is_bool($result)) {
                return $result; // Return true/false for non-select queries
            }

            $data = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            mysqli_free_result($result); // حرر النتائج بعد استخدامها
            $this->close(); // أغلق الاتصال
            return $data;
        } catch (Exception $e) {
            $this->close(); // أغلق الاتصال في حالة الخطأ أيضًا
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
            $this->close(); // أغلق الاتصال
            return true;
        } catch (Exception $e) {
            echo "<script>
                    alert('{$e->getMessage()}');
                    window.location.href = '';
                </script>";
            $this->close(); // أغلق الاتصال في حالة الخطأ أيضًا
            exit();
        }
    }
}
