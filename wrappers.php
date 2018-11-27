
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
    // return number of rows matching query
    function num_rows_matching($stmt) {
        $conn = open_connection();
        $result = $conn->query($stmt) or trigger_error("Query Failed! SQL: $stmt - Error: ".mysqli_error($conn), E_USER_ERROR);
        return $result->num_rows;
    }
    // returns an array of rows for the output of the statement
    function get_array($stmt) {
        $conn = open_connection();
        $result = $conn->query($stmt) or trigger_error("Query Failed! SQL: $stmt - Error: ".mysqli_error($conn), E_USER_ERROR);
        return resultToArray($result);
    }
    // wrapper function for executing a delete without foreign key constraints
    function delete_without_constraints($stmt) {
        $full_statement = "SET foreign_key_checks = 0; " . $stmt . " SET foreign_key_checks = 1;";
        $conn = open_connection();
        $conn->multi_query($full_statement) or trigger_error("Query Failed! SQL: $full_statement - Error: ".mysqli_error($conn), E_USER_ERROR);
    }
    //  returns one-dimensional array corresponding to the values in the given column for the given query
    function get_list_from_column($stmt, $columnName) {
        $conn = open_connection();
        $result = $conn->query($stmt) or trigger_error("Query Failed! SQL: $stmt - Error: ".mysqli_error($conn), E_USER_ERROR);
        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row["$columnName"];
        }
        return $rows;
    }
    // returns first value corresponding to the value in the given column for the given query
    function get_single_specific_value($stmt, $columnName) {
        $conn = open_connection();
        $result = $conn->query($stmt) or trigger_error("Query Failed! SQL: $stmt - Error: ".mysqli_error($conn), E_USER_ERROR);
        $row = $result->fetch_assoc();
        return $row["$columnName"];
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
    function check_password($userName, $token) {
        $conn = open_connection();
        $result = $conn->query("SELECT *
                                    FROM Users
                                    WHERE userName = '$userName' AND
                                    `password` = '$token'");
        return $result;
    }
?>