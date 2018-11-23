<?php
        session_start();
        session_destroy();
        session_unset();
        $_SESSION['login'] == false;
        $_SESSION['name'] == "";
        $_SESSION = [];
        header("Location: HomePage.php");  
?>