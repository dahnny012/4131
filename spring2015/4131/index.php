<!DOCTYPE html>
<html>
    <head>
        <title>My top 5 Restaurants</title>
        <link rel="stylesheet" type="text/css" href="Style.css">
        <meta charset="utf-8">
    </head>
    <body>
        <h1>5 Restaurants I like</h1>
          <a href="Form.html">Add a Suggestion</a>
        <table border="1">
          <tr>
            <th>Restaurant</th>
            <th>Picture</th>
            <th>Description</th>	
            <th>Address</th>
            <th>Contact Number</th>
            <th>Rating</th>
            <th>Weekly Schedule</th>
            
          </tr>
<?php
        // read json
        $json = file_get_contents("rest.json");
        $data = 0;
        // loop for each element in array
        // print html
?>
        </table>
        
        <p>Used chrome</p>
    </body>
</html>


<script src="Script.js"></script>


