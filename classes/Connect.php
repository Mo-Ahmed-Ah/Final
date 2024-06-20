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
        }
    }

    function read($query) {
        try {
            $this->connect();
            $result = mysqli_query($this->conn, $query);

            if (!$result) {
                throw new Exception("Query failed: " . mysqli_error($this->conn));
            }

            $data = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            $this->close();
            return $data;
        } catch (Exception $e) {
            $this->close();
            return false;
        }
    }

    public function save($query, $params = []) {
        try {
            $this->connect();
            $stmt = $this->conn->prepare($query);

            if ($stmt === false) {
                throw new Exception("Statement preparation failed: " . mysqli_error($this->conn));
            }

            // Binding parameters dynamically
            if ($params) {
                $types = str_repeat('s', count($params)); // Assuming all parameters are strings
                $stmt->bind_param($types, ...$params);
            }

            $result = $stmt->execute();
            $this->close();
            return $result;
        } catch (Exception $e) {
            $this->close();
            return false;
        }
    }

    function escape_string($string) {
        try {
            $this->connect();
            $escapedString = mysqli_real_escape_string($this->conn, $string);
            $this->close();
            return $escapedString;
        } catch (Exception $e) {
            return $string;
        }
    }
}
