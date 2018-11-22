<!DOCTYPE HTML>
<html>

    <body>

    <h1>User Information Before Edit</h1>

    <?php
        include("class_definitions.php");
        //ini_set('display_errors', 1);
        //ini_set('display_startup_errors', 1);
        //error_reporting(E_ALL);
        $userID = $userName = $firstName = $lastName = $email = $password = $isAdmin = NULL;
        if (isset($_POST['userID']) && $_POST['userID'] != 0) {
            $User = User::retrieveUser($_POST['userID']);
            
            $details = $User->getAllDetails(); 
            $userID = $details['userID'];
            $userName = $details['userName'];
            $firstName = $details['firstName'];
            $lastName = $details['lastName'];
            $email = $details['email'];
            $password = $details['password'];
            $isAdmin = $details['isAdmin']; 
        }
    ?>

    <table>
        <th>userID</th>
        <th>userName</th>
        <th>firstName</th>
        <th>lastName</th>
        <th>email</th>
        <th>password</th>
        <th>isAdmin</th>

        <tr>
            <td><?php echo $userID; ?></td>
            <td><?php echo $userName; ?></td>
            <td><?php echo $firstName; ?></td>
            <td><?php echo $lastName; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $password; ?></td>
            <td><?php echo $isAdmin; ?></td>
        </tr>

    </table>

    <h1>User Information After Edit</h1>

    <?php
        // lets pretend that these are all single quotes for consistency's sake
        edit_user_details($_POST["userID"], $_POST["userName"], $_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["password"], $_POST["isAdmin"]);
        $User = User::retrieveUser($_POST['userID']);
            
        $details = $User->getAllDetails(); 
        $userID = $details['userID'];
        $userName = $details['userName'];
        $firstName = $details['firstName'];
        $lastName = $details['lastName'];
        $email = $details['email'];
        $password = $details['password'];
        $isAdmin = $details['isAdmin']; 
    
    ?>

    <table>
        <th>userID</th>
        <th>userName</th>
        <th>firstName</th>
        <th>lastName</th>
        <th>email</th>
        <th>password</th>
        <th>isAdmin</th>

        <tr>
            <td><?php echo $userID; ?></td>
            <td><?php echo $userName; ?></td>
            <td><?php echo $firstName; ?></td>
            <td><?php echo $lastName; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $password; ?></td>
            <td><?php echo $isAdmin; ?></td>
        </tr>

    </table>

    </body>
</html>

?>