<?php
    function open_connection() {
        $conn = new mysqli($hostname, $username, $password, $database);
        if ($conn->connection_errno) {
            echo "Error: Failed to make a MySQL connection, here is why: \n";
            echo "Errno: " . $conn->connect_errno . "\n";
            echo "Error: " . $conn->connect_error . "\n";
            exit;
        }
        return $conn;
    }
    // returns an array of rows for the output of the statement
    function get_array($stmt) {
        $conn = open_connection();
        $result = $conn->query($stmt);
        return $result->fetch_array();
    }
    // performs a query that doesn't expect any output
    function do_query($stmt) {
        $conn = open_connection();
        $conn->query($stmt);
    }
    // ONLY checks if a user exists by username
    function check_user_record($userName) {
        $conn = open_connection();
        $conn->query("SELECT EXISTS(SELECT * 
                                    FROM Users
                                    WHERE userName = $userName)");
        
        return $result->fetch_array();
    }
    function check_password($userID, $token) {
        $conn = open_connectioN();
        $conn->query("SELECT EXISTS(SELECT *
                                    FROM Users
                                    WHERE userID = $userID AND
                                    `password` = $token)");
        return $result->fetch_array();
    }
?>