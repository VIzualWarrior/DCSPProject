<!DOCTYPE html>
<html>
<head><title>Register/Login</title>
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

    #top-image { background: url("https://images.unsplash.com/photo-1536510233921-8e5043fce771?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=f22664491a6234b6907fc877cec156b7&w=1000&q=80");
                 position: fixed; 
                 width: 100%; 
                 height: 100%; 
                 background-repeat: no-repeat; 
                 margin: 0;
                 padding: 0; 
                 background-size: calc(100% + 50px); }
    </style>
   
</head>
<body id="top-image">
 <?PHP
        ob_start();
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        session_start();
   
        ?>

        <?PHP
         require_once 'class_definitions.php';
         $name = "";
         $pass ="";
         $errormessage ="";
         $query = "";
         $row = "";
         $result = "";
         $user = '';
         if(isset($_POST["username"])) 
        {     
         $name = $_POST["username"]; 
        
   
        if(isset($_POST["password"])) 
        {     
         $password = $_POST["password"]; 
        }
          $query = check_password($name, $password);
          $result = $query->fetch_array();
          

         if($result['userName'] == $name && $result['password'] == $password)
         {
          session_start();
          $user = new User();
          $user->retrieveUser($result['userID']);
          $_SESSION['login'] = true;
          $_SESSION['user'] = $user;
          $_SESSION['name'] = $result['userName'];
          $_SESSION['type'] = $result['isAdmin'];
          header("Location: HomePage.php"); 
         }
         
          
          
        else 
         {
         $errormessage = "Invalid username or password";
         $name = $_POST["username"];
         $pass = $_POST["password"];
         }
         }
        ?>
        <center>
        <h1 id="grad1">
        <a class="button_example" href="Restaurant.php">Restaurants</a>
        <a class="button_example" href="Groups.php">Groups</a>
        <a class="button_example" href="Vote.php">Vote</a>
        <a class="button_example" href="Suggest.php">Suggest</a>
        <a class="button_example" href="HomePage.php">Home</a>
        <br>
        </h1>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p style="color:white">Welcome to the Food Critics!</p><br>
        <p style="color:white">This website helps its users set up groups to decide on which restaurants to go to.</p>
        <p style="color:white">Start by logging in here:</p>
        <br>
        <br>
        <br>
        <br>
        <p style="color:white">Log In:</p>
        <form method="post" action="Login.php">
        <input type="text" placeholder="username" name = "username" width="50" value = <?PHP echo $name; ?> ><br>
        <input type="password" placeholder="password" name = "password"  width="50" value = <?PHP echo $pass; ?> ><br>
        <input type="submit" value="Log In">
        </form>
        <p style="color: red">
        <?PHP echo $errormessage; ?>
        </p>
        
 
        </center>
</body>
</html>