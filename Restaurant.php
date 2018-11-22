<!DOCTYPE html>
<html>
<head>
    <title>Restaurants</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            var movementStrength = 25;
            var height = movementStrength / $(window).height();
            var width = movementStrength / $(window).width();
            $("#top-image").mousemove(function (e) {
                var pageX = e.pageX - ($(window).width() / 2);
                var pageY = e.pageY - ($(window).height() / 2);
                var newvalueX = width * pageX * -1 - 25;
                var newvalueY = height * pageY * -1 - 50;
                $('#top-image').css("background-position", newvalueX + "px     " + newvalueY + "px");
            });
        });
    </script>
    <style type="text/css">
        input[type=text], select {
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .button_example {
            border: 1px solid #72021c;
            width: 60px;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            font-size: 12px;
            font-family: arial, helvetica, sans-serif;
            padding: 10px 10px 10px 10px;
            text-decoration: none;
            display: inline-block;
            text-shadow: -1px -1px 0 rgba(0,0,0,0.3);
            font-weight: bold;
            color: #FFFFFF;
            background-color: #a90329;
            background-image: -webkit-gradient(linear, left top, left bottom, from(#a90329), to(#6d0019));
            background-image: -webkit-linear-gradient(top, #a90329, #6d0019);
            background-image: -moz-linear-gradient(top, #a90329, #6d0019);
            background-image: -ms-linear-gradient(top, #a90329, #6d0019);
            background-image: -o-linear-gradient(top, #a90329, #6d0019);
            background-image: linear-gradient(to bottom, #a90329, #6d0019);
            filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#a90329, endColorstr=#6d0019);
        }

            .button_example:hover {
                border: 1px solid #450111;
                background-color: #77021d;
                background-image: -webkit-gradient(linear, left top, left bottom, from(#77021d), to(#3a000d));
                background-image: -webkit-linear-gradient(top, #77021d, #3a000d);
                background-image: -moz-linear-gradient(top, #77021d, #3a000d);
                background-image: -ms-linear-gradient(top, #77021d, #3a000d);
                background-image: -o-linear-gradient(top, #77021d, #3a000d);
                background-image: linear-gradient(to bottom, #77021d, #3a000d);
                filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#77021d, endColorstr=#3a000d);
            }

        #grad1 {
            height: 100px;
            width: 100%;
            margin: 0;
            background-color: red; /* For browsers that do not support gradients */
            background-image: linear-gradient(to bottom, #a90329, #6d0019); /* Standard syntax (must be last) */
            position: fixed;
        }

        #top-image {
            background: url("https://images.unsplash.com/photo-1536510233921-8e5043fce771?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=f22664491a6234b6907fc877cec156b7&w=1000&q=80");
            position: fixed;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            background-size: calc(100% + 50px);
        }
    </style>

</head>
<body id="top-image">
<?PHP
include("class_definitions.php");
session_start();
$logstatus = "Log In";
$log = "Login.php";
if (isset($_SESSION['login'])){
$name = $_SESSION['name'];
$logstatus = "Log Out";
$log = "Logout.php";

 }
?>

    <center>
        <h1 id="grad1" style="color:white">
        <a class="button_example" href="HomePage.php">Home</a>
        <a class="button_example" href="Groups.php">Groups</a>
        <a class="button_example" href="Vote.php">Vote</a>
        <a class="button_example" href="Suggest.php">Suggest</a>
        <a class="button_example" href=<?PHP echo $log; ?>><?PHP echo $logstatus; ?></a>
        <br>
        <?PHP if (isset($_SESSION['name'])){ echo "Hello, '$name'!";} ?>
        </h1>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p style="color:white">Available Restaurants:</p>
        <br />
        <p style="color:white">Add a restaurant (only admins will see this):</p>
        <input type="text" placeholder="Name" width="50">
        <br>
        <input type="text" placeholder="Cuisine Type" width="50">
        <br>
        <input type="text" placeholder="Hours" width="50">
        <br>
        <input type="text" placeholder="User ID" width="50">
        <br />
        <br />
    </center>
</body>
<?php


?>
</html>