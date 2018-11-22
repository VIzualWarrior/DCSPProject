<!DOCTYPE html>
<html>
    <body>
        <h1>Search Results</h1>

        <table style="width:100%">
            <th>Name</th>
            <th>Cuisine</th>
            <th>Address</th>
            <th>Business Hours</th>
            <th>Menu</th>

            <?php
                include("class_definitons.php");
                $Search = new Search($_POST["query"]);
                $result = $Search->getDetails();
                foreach ($result as $row) {
                    echo("<tr><td>" . $row['restaurantName'] . "</td><td>" . $row['cuisineType'] . "</td><td>" . $row['address'] . "</td><td>" . $row['hoursOpen'] . "</td><td>" . $row['menu'] . "</td></tr>");
                }
            ?>

        </table>

    </body>
</html>