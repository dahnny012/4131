<?php 
session_start();
ini_set('display_errors','1'); error_reporting(E_ALL);

if(!isset($_SESSION["email"]) || !isset($_SESSION['name'])){
    header("Location: credentials.php");
}


if(isset($_SESSION["vote"]) && isset($_SESSION['name'])){
    header("Location: Voting.php");
}

$msg="";
if(!isset($_SESSION["vote"])){
    $msg = "You have already voted";
}

?>


<!DOCTYPE html>
<html>
<head>
  <title>Results</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/css/materialize.min.css">
  <link rel="stylesheet" href="css/login.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script type="text/javascript" src="js/results.js"></script>
  <meta charset="utf-8">
</head>

<body>
    <div class="container">
        <div class="row">
            <nav>
                <div class="nav-wrapper red accent-4">
                    <a href="#" class="brand-logo">Results</a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </nav>
              <div class="row container">
                  <div class="col s5 offset-s7">
                 <?php 
                    if($msg != ""){
                        echo $msg;
                    }
                 ?>
                 </div>
                 <div class="col card grey lighten-5 s10 offset-s4">
                     <?php
                     include "connection.php";
                     makeGraph($db);
                     function makeGraph($db){
                         $select = $db->prepare("SELECT * from VOTES");
                         $select->execute();
                         $values= array();
                         $total = 0;
                         while($row=  $select->fetch(PDO::FETCH_ASSOC)){
                             $values[$row['Category']] = $row['Num_Votes'];
                             $total += intval($row['Num_Votes']);
                         }
                         foreach($values as $key => $val){
                             makeRow($key,$total,$val,$db);
                         }
                     }
                     
                     function makeRow($label,$total,$votes,$db){
						 $percent = floatval($votes/$total)*100;
						 echo $label." : ".$votes." Votes" ;
                         ?>
                         <div class="progress red lighten-5">
                              <div class="determinate red" style="width: <?php echo $percent."%"; ?>;"></div>
                         </div>
                         <?php
                     }
                     ?>
                 </div>
              </div>
        </div>
      </div>
</body>
</html>
