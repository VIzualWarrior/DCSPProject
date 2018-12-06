<!DOCTYPE html>
<html>
<head><title>Voting</title>
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
//        ini_set('display_startup_errors', 1);
 //      error_reporting(E_ALL);
include("PollClass.php");
session_start();
$logstatus = "Log In";
$log = "Login.php";
$currentrestaurant = "";
if (isset($_SESSION['login'])){
$name = $_SESSION['name'];
$logstatus = "Log Out";
$log = "Logout.php";
$grouplist = get_group_names_from_user($_SESSION['id']);
$restaurantlist = get_restaurant_names();
$PollOpen = 0;
$user = User::retrieveUser($_SESSION['id']);
if(count($user->listOpenPolls()) > 0)
{
$PollOpen = 1;
$currentpoll = Poll::retrievePoll($user->listOpenPolls()[0]);
$currentpoll->setOpen();
if (count($currentpoll->userNamesVotedYes()) + count($currentpoll->userNamesVotedNo()) == count($grouplist)){
  $currentpoll->setClosed();
  header("Vote.php");
}
}
if(isset($_POST['groupName'], $_POST['restaurant']))
  {
   $cPoll = new Poll();
   $cGroup = Group::retrieveGroupByName($_POST['groupName']);
   $cGroupid = $cGroup->id();
   $cPoll::createNewPoll($cGroupid, $_POST['restaurant']);
   $cPoll->setOpen();
   header("Refresh:0");
  }


 }
?>

        <center>
        <h1 id="grad1">
        <a class="button_example" href="Groups.php">Groups</a>
        <a class="button_example" href="HomePage.php">Home</a>
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
        </center>
<?PHP
if (isset($_SESSION['login'])) {
    if ($PollOpen == 0) {
        echo '
        <center>
        <p style="color:white">Start a poll:</p><br><form method = "post"><select name="groupName" value="groupName">';
        foreach ($grouplist as $item) {
            echo '<option>', $item, '</option>';
        }
        echo '</select><p style = "color:white"> will vote to go to </p><select name = "restaurant" value = "restaurant">';
        foreach ($restaurantlist as $restaurant) {
            echo '<option>', $restaurant, '</option>';
        }
        echo '<select><br><input type ="submit" value = "Start" action = "Vote.php"></form></center>';
    }
    if ($PollOpen == 1) {
    $currentrestaurant = $currentpoll->restaurant();
    $GroupVotingID = $currentpoll->group();
    $GroupVoting = Group::retrieveGroup($GroupVotingID);
    $Memberlist = $GroupVoting->getUserNames();
    $MemberIDs = $GroupVoting->getUserIDs();
    $user_vote = "";
    if(in_array($_SESSION['name'], $currentpoll->userNamesVotedYes())){
    $user_vote = "<p style ='color:green'>YES</p>";
    } else if(in_array($_SESSION['name'], $currentpoll->userNamesVotedNo())){
    $user_vote = "<p style ='color:red'>NO</p>";
    } else{
    $user_vote = '<form method = "post"><input type = "submit" name = "Yes" value = "Yes" action = "Vote.php"><input type ="submit"  name = "No" value ="No" action = "Vote.php"></form>';
    }
    if (isset($_POST['Yes'])){
    $currentpoll->vote($_SESSION['id'], 1);
    header("Refresh:0");
    }
     if (isset($_POST['No'])){
     $currentpoll->vote($_SESSION['id'], 0);
     header("Refresh:0");
     }
        echo '<center><p style="color:white">Current poll:</p><br>';
        echo '<p style = "color:white">Would you like to go to ', $currentrestaurant, '?</p><br>';
        foreach ($Memberlist as $member) {
            echo '<p style="color:white">', $member, '<br>';
            if ($member == $_SESSION['name']) {
                
                echo $user_vote;
                
            } else {
               if (in_array($member, $currentpoll->userNamesVotedYes())) {
                    echo "<p style = 'color:green'>YES</p>";
} else if (in_array($member, $currentpoll->userNamesVotedNo())) {
                    echo "<p style = 'color:red'>NO</p>";
} else  {
                    echo "<p style = 'color:white'>---</p>";
}
            }
            echo "</p><br>";
        }
        echo "</center>";
    }
    echo '<br>
        <br>
        <br>
        <br>';
} else {
    echo "<center><span style ='color:white'>You must be signed in to use this feature!</span></center>";
}

?>
</body>
</html>