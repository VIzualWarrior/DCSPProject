<?php
    // long function names 1: origins
    function open_connection() {
        include("log_in.php");
        $conn = new mysqli($hostname, $userName, $password, $database);
        return $conn;
    }
     // https://stackoverflow.com/questions/12272017/returning-multiple-rows-with-mysqli-and-arrays
     // convert mysqli result to array of rows
     function resultToArray($result) {
        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    // returns an array of rows for the output of the statement
    function get_array($stmt) {
        $conn = open_connection();
        $result = $conn->query($stmt) or trigger_error("Query Failed! SQL: $stmt - Error: ".mysqli_error($conn), E_USER_ERROR);
        return resultToArray($result);
    }
    // performs a query (normally, an insertion query) and returns the auto-generated id of the inserted tuple
    function do_query_get_last_id($stmt) {
        $conn = open_connection();
        $conn->query($stmt) or trigger_error("Query Failed! SQL: $stmt - Error: ".mysqli_error($conn), E_USER_ERROR);
        return $conn->insert_id;
    }
    // performs a query that doesn't expect any output
    function do_query($stmt) {
        $conn = open_connection();
        $conn->query($stmt) or trigger_error("Query Failed! SQL: $stmt - Error: ".mysqli_error($conn), E_USER_ERROR);
    }
    // ONLY checks if a user exists by userName
    function check_user_record($userName) {
        $conn = open_connection();
        $conn->query("SELECT EXISTS(SELECT * 
                                    FROM Users
                                    WHERE userName = $userName)");
        
        return $result->fetch_array();
    }
    function check_password($userName, $token) {
        $conn = open_connection();
        $result = $conn->query("SELECT *
                                    FROM Users
                                    WHERE userName = '$userName' AND
                                    `password` = '$token'");
        return $result;
    }
?>