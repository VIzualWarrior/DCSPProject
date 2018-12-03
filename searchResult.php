<!DOCTYPE html>
<html>
<head><title>Welcome!</title>
    <style type="text/css">
  
  html {
    height: 100%;
    overflow: scroll;
  }
  
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
                 
                 width: 100%; 
                 height: 100%; 
                 background-repeat: repeat-y; 
                 margin: 0;
                 padding: 0; 
                 background-size: calc(100% + 50px); }
         
  table {color:white;}
  th {color:white;}
  tr {color:white;}
  td {color:white;}
    </style>
   
</head>
<body id="top-image">
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