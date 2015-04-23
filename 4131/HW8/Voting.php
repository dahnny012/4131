<?php
ini_set('display_errors','1'); error_reporting(E_ALL);
define("REGD", 1);
define("NEWD", 2);
$msg = "";
session_start();

if(!isset($_SESSION["name"]) || !($_SESSION["email"])){
    header("Location: logout.php");
}

if(!isset($_SESSION["vote"]) && !isset($_SESSION['name'])){
    header("Location: credentials.php");
}

if(!isset($_SESSION["vote"]) && isset($_SESSION['name'])){
    header("Location: Results.php");
}



if(!empty($_POST)){
    include "connection.php";
    

    $insert = $db->prepare("INSERT INTO USER VALUES (?,?)");
    $insert->bindParam(1,$_SESSION['email']);
    $insert->bindParam(2,$_SESSION['name']);
    $insert->execute();
    if($insert->rowCount() == 1){
		$insert2 = $db->prepare("Update VOTES Set Num_Votes = Num_Votes + 1 Where Category = ?");
		$insert2->bindParam(1,$_POST['cuisine']);
		$insert2->execute();
		
		if($insert2->rowCount() < 1){
			$backtrack = $db->prepare("DELTE FROM USER WHERE Email = ?");
			$backtrack->bindParam(1,$_SESSION['email']);
			$backtrack->execute();
			$msg = "Could not add your vote";
		}else{
			unset($_SESSION["vote"]);
			header("Location: Results.php");
		}
	}else{
		$msg = "Could not add your vote";
	}
    
    
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
                      <div class="input-field col s5 offset-s4">
                          <div class="card">
                              <div class="card-content  grey lighten-5">
                                <h5>What is your favorite cuisine?</h5>
                                <div>
                                    <?php 
                                    if($msg != "")
                                        echo $msg;
                                    ?>
                                </div>
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
                      
                      <div class="input-field col s5 offset-s4">
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
