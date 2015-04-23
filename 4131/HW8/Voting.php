<?php
$REGD = 2;
$NEW = 1;
$msg = "";
session_start();

if(!isset($_SESSION["name"]) || !($_SESSION["email"])){
    header("Location: logout.php");
}

if(!isset($_SESSION["vote"] && !isset($_SESSION['name']))){
    header("Location: credentials.php");
}

if(!isset($_SESSION["vote"] && isset($_SESSION['name']))){
    header("Location: results.php");
}



if(!empty($_POST)){
    include "connection.php";
    
    $allowed = ["Indian","Chinese","Mexican","Italian","Thai"];
    if(!in_array($_POST["cuisine"],$allowed)){
        echo "Nice Sql Injection <br>";
        return;
    }
    $insert = $db->prepare("INSERT INTO Users VALUES (?,?)");
    $insert->bindParam(1,$_SESSION['name']);
    $insert->bindParam(2,$_SESSION['email']);
    $insert->execute();
    
    $insert2 = $db->prepare("Update Vote Set Category=?,Num_Votes = Num_Votes + 1 Where Category = ?");
    $insert2->bindParam(1,$_POST['cuisine']);
    $insert2->bindParam(2,$_POST['cuisine']);
    $insert2->execute();
    
    unset($_SESSION["vote"]);
    header("Location: Results.php");
}else{
    if(empty($_POST)){
        $msg = "Please make a selection";
    }
}


?>


<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/css/materialize.min.css">
  <link rel="stylesheet" href="css/login.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script type="text/javascript" src="js/voting.js"></script>
  <meta charset="utf-8">
</head>

<body>
    <div class="container">
        <div class="row">
            <nav>
                <div class="nav-wrapper red accent-4">
                    <a href="#" class="brand-logo">Voting</a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </nav>
              <div class="col s12">
                  <form method="POST" action="Voting.php">
                      <div class="input-field col s3 offset-s4">
                          <div class="card">
                              <div class="card-content  grey lighten-5">
                                <h5>What is your favorite cuisine?</h5>
                                <h5>
                                    <?php 
                                    if($msg != "")
                                        echo $msg;
                                    ?>
                                </h5>
                                <input class="red" name="cuisine" value="Indian" type="radio" id="r1"/>
                                <label for="r1">Indian</label>
                                <p>
                                <input name="cuisine" value="Chinese" type="radio" id="r2"/>
                                <label for="r2">Chinese</label>
                                <p>
                                <input name="cuisine" value="Mexican" type="radio" id="r3"/>
                                <label for="r3">Mexican</label>
                                <p>
                                <input name="cuisine" value="Italian" type="radio" id="r4"/>
                                <label for="r4">Italian</label>
                                <p>
                                <input name="cuisine" value="Thai" type="radio" id="r5"/>
                                <label for="r5">Thai</label>
                              </div>
                          </div>

                      </div>
                      
                      <div class="input-field col s3 offset-s5">
                          <button id="submit" class="btn red accent-4" type="submit" name="action">
                              Submit
                          </button>
                      </div>
                  </form>
              </div>
        </div>
      </div>
</body>
</html>