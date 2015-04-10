<?php
    $file;        
    switch($_GET['source']){
        case 1:
            $file = "restaurants.json";
            break;
        case 2:
            $file = "new_restaurants.json";
            break;
        case 3:
            $file = "final_restaurants.json";
            break;
        default:
            die("Enter a valid source");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>My top 5 Restaurants</title>
        <link rel="stylesheet" type="text/css" href="restaurants.css">
        <script src="Script.js"></script>
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
        
        $json = file_get_contents($file);
        $data = json_decode($json)->restaurants;
        foreach($data as $entry){
            $entry->code =  $entry->picture;//preg_replace('/.jpg|.png|.gif/',"",$entry->picture);
            makeRow($entry);
        }
?>
        </table>
        
        <p>Used chrome</p>
    </body>
</html>





<?php 
    function makeRow($element){
        $element->code = addslashes($element->code);
        $element->hint = addslashes($element->code);
        echo "<tr>".
                "<td class='name'>".
                "<a href=\"".$element->url."\">".
                    $element->name.
                "</a>".
                "</td>".
                "<td id=\"".$element->code."\">".
                    "<button onclick='showPicture(\"$element->code\",\"$element->hint\")'>Picture</button>".
                "</td>".
                "<td>".$element->type."</td>".
                "<td>".$element->address."</td>".
                "<td>".$element->phone."</td>".
                "<td>".$element->rating."</td>".
                "<td class=\"time\">".
                    getHours($element->hours).
                "</td>".
             "</tr>";
           
    }
    
    function getHours($hours){
        $schedule = "<ul>";
        foreach($hours as $hour){
            $schedule .= "<li>".
            $hour->day. " ".$hour->time
            ."</li>";
        }
        return $schedule."</ul>";
    }
?>

