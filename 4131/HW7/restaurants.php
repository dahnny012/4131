<?php
    session_start();
    
    
    if(!isset($_SESSION['user'])){
        header('Location: login.php');
    }

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
            $file = "restaurants.json";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>My top 5 Restaurants</title>
        <link rel="stylesheet" type="text/css" href="css/restaurants.css">
        <script src="js/script.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/css/materialize.min.css">
        <meta charset="utf-8">
    </head>
    <body>
    <nav>
    <div class="nav-wrapper black-text yellow accent-4">
        <spa id="header">Welcome <?php echo $_SESSION['user'] ?></span>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a class="black-text" href="Form.html">Add a Suggestion</a></li>
            <li><a class="black-text" href="logout.php">Logout</a></li>
          </ul>
    </div>
    </nav>
        <table border="1">
          <tr>
            <th class="card-panel  brown darken-4">Restaurant</th>
            <th class="card-panel  brown darken-4">Picture</th>
            <th class="card-panel  brown darken-4">Description</th>	
            <th class="card-panel  brown darken-4" >Address</th>
            <th class="card-panel  brown darken-4" >Contact Number</th>
            <th class="card-panel  brown darken-4" >Rating</th>
            <th class="card-panel  brown darken-4" >Weekly Schedule</th>
                                             
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
                "<a class='btn brown darken-4' href=\"".$element->url."\">".
                    $element->name.
                "</a>".
                "</td>".
                "<td id=\"".$element->code."\">".
                    "<button class='btn grey lighten-5 black-text' onclick='showPicture(\"$element->code\",\"$element->hint\")'>+</button>".
                "</td>".
                "<td><span class='card-panel white-text brown darken-4'>".$element->type."</span></td>".
                "<td><span class='card-panel white-text brown darken-4'>".$element->address."</span></td>".
                "<td><span class='card-panel white-text brown darken-4'>".$element->phone."</span></td>".
                "<td><span class='card-panel white-text brown darken-4'>".$element->rating."</span></td>".
                "<td class=\"time\">".
                    getHours($element->hours).
                "</td>".
             "</tr>";
           
    }
    
    function getHours($hours){
        $schedule = "<ul class='collection'>";
        foreach($hours as $hour){
            $schedule .= "<li class='white-text brown darken-4 collection-item'>".
            $hour->day. " ".$hour->time
            ."</li>";
        }
        return $schedule."</ul>";
    }
?>

