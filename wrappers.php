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
    // wrapper function SPECIFICALLY for get_id_from_group_name() in db_functions
    function get_id_from_group_name_WRAPPER($stmt) {
        $conn = open_connection();
        $result = $conn->query($stmt) or trigger_error("Query Failed! SQL: $stmt - Error: ".mysqli_error($conn), E_USER_ERROR);
        $row = $result->fetch_assoc();
        return $row['groupID'];
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
    function check_password($userID, $token) {
        $conn = open_connection();
        $result = $conn->query("SELECT *
                                    FROM Users
                                    WHERE userName = '$userID' AND
                                    `password` = '$token'");
        return $result;
    }
?>