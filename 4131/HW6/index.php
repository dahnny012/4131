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
        $json = file_get_contents("new_restaurants.json");
        $data = json_decode($json);
        foreach($data as $entry){
            $entry['code'] = preg_replace('/.jpg/',"",$entry['picture']);
            makeRow($entry);
        }
?>
        </table>
        
        <p>Used chrome</p>
    </body>
</html>


<script src="Script.js"></script>


<?php 
    function makeRow($element){
        echo "<tr>
                <td class=name>".
                "<a href=\"".$element['url']."\">".
                    $element['name'].
                "</a>".
                "</td>".
                "<td id=\"".$element['code']."\">".
                    "<button onclick=\"showPicture('".$element['code']."')>Picture</button>".
                "</td>".
                "<td>".$element['type']."</td>".
                "<td>".$element['address']."</td>
                <td>".$element['phone']."</td>
                <td>".$element['rating']."</td>
                <td class=\"time>".
                    getHours($element['hours'])
                ."</td>
             </tr>";
           
    }
    
    function getHours($hours){
        echo "<ul>";
        foreach($hours as $hour){
            echo "<li>".
            $hour
            ."</li>";
        }
        echo "</ul>";
    }
?>

