<!DOCTYPE HTML>
<html>

    <?php
        include("class_definitions.php");
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

    <body>

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

        <form action="viewUser.php" method="post">
            Look up user information
            <input type="text" name="userID"><br>
            <input type="submit" value = "Submit">
        </form>
    </body>
</html>