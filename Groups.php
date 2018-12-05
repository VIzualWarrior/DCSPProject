<!DOCTYPE html>
<html>
<head><title>Groups</title>
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
//ini_set('display_errors', 1);
  //      ini_set('display_startup_errors', 1);
    //   error_reporting(E_ALL);
include("GroupClass.php");
session_start();
$logstatus = "Log In";
$log = "Login.php";

if (isset($_SESSION['login'])){
$errormessage = "";
$err2 = "";
$name = $_SESSION['name'];
$logstatus = "Log Out";
$log = "Logout.php";
$grouplist = get_group_names_from_user($_SESSION['id']);
if (isset($_POST['groupCreate']))
  {
  if(is_groupname_available($_POST['groupCreate'])== True){
  $newGroup = Group::createNewGroup($_POST['groupCreate']);
  $newGroup->addUser($_SESSION['id']);
  header("Refresh:0");
  }
  else
  $err2 = "Error: Group already exists!";
  }
 }
 if (isset($_POST['groupAdd']))
{
if (is_groupname_available($_POST['groupAdd']) == True || $_POST['groupAdd'] == "")
  {
  $errormessage = "Invalid group name!";
  }
  else
  {
  $checkAdd = $_POST['groupAdd'];
  $checkgroup = Group::retrieveGroupByName($checkAdd);
  if ($checkgroup->name() == $_POST['groupAdd'])
  {
    $checkgroup->addUser($_SESSION['id']);
    header("Refresh:0");
  }
  else
  {
    $errormessage = "Invalid group name!";
  }
  }
}
?>

        <center>
        <h1 id="grad1">
        <a class="button_example" href="HomePage.php">Home</a>
        <a class="button_example" href="Vote.php">Vote</a>
        <a class="button_example" href=<?PHP echo $log; ?>><?PHP echo $logstatus; ?></a>
         <?PHP
        if($log == "Login.php")
          {
         echo "<a class = 'button_example' href = 'Register.php'>Register</a>";
          }
        if($log =="Logout.php")
          {
         echo "<a class = 'button_example' href = 'closedPolls.php'>Results</a>";
          }
         ?>
        <br>
        <?PHP if (isset($_SESSION['name']) && $_SESSION['type'] == 0){ echo "<span style ='color:white';> Hello, $name!</span>";} if (isset($_SESSION['name']) && $_SESSION['type'] == 1){ echo "<span style ='color:white';>Hello, Admin $name!</span>";} ?>
        </h1>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <?PHP if(isset($_SESSION['login'])){echo 
        '
        <p style="color:white">Group(s) you are currently in:</p><br>';
        foreach($grouplist as $group){echo '<span style="color:white">', $group, '</span><br>';};
        echo  '<br>
        <br>
        <br>
        <form method = "post" action = "Groups.php">
        <input type="text" name="groupAdd" placeholder="Add yourself to a group"  size="100"><br>
        <span style = "color:red";>'; echo $errormessage; echo '</span><br>
        <input type="Submit" value = "Add">
        </form>
        <form method = "post" action = "Groups.php" onsubmit = "window.location.hrefwindow.location.href">
        <input type="text" name="groupCreate" placeholder="Create a group"  size="100"><br>
        <input type="Submit" value = "Create"><br>
        <span style = "color:red";>'; echo $err2; echo '</span><br>
        </form>
        <br>
        </center>';}
        else{
        echo '<p style = "color:white">You must be signed in to use this feature!</p>';
            }
        ?>
</body>
</html>