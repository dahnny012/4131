<?php
    $REGD = 2;
    $NEW = 1;
    session_start();
    ini_set('display_errors','1'); error_reporting(E_ALL);
    $errorFlag = false;
    
    if(isset($_SESSION["vote"] && isset($_SESSION['name']))){
        header("Location: Voting.php");
    }
    
    if(!isset($_SESSION["vote"] && isset($_SESSION['name']))){
        header("Location: Results.php");
    }
    
    
    $status = valid($_POST);
    
    if(!empty($_POST) && $status == $NEW){
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['vote'] = true;
        header("Location: Voting.php");
    }else{
        if($status == $REGD){
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['name'] = $_POST['name'];
            header("Location: Results.php");
        }
        else{
            $errorFlag = true;
        }
    }
    
    function valid($info){
        if(strlen($info['name']) <= 0 
        || !preg_match("/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/",$info["email"] 
        || !preg_match("/^[A-z ]+$/",$info["name"] 
        || strlen($info['email'] <= 0))){
            return 0;
        }
        include "connection.php";
        $exists = $db->prepare("Select Name,Email from Users where Name = ? and Email = ?");
        $exists->bindParam(1,$info["name"]);
        $exists->bindParam(2,$info["email"]);
        $exists->execute();
        if($count = $exists->rowCount()){
            return $REGD;    
        }
            return $NEW;
    }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Registration</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/css/materialize.min.css">
  <link rel="stylesheet" href="css/login.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/js/materialize.min.js"></script>
  <script type="text/javascript" src="js/login.js"></script>
  <meta charset="utf-8">
</head>

<body>
    <div class="container">
        <div class="row">
            <nav>
                <div class="nav-wrapper red accent-4">
                    <a href="#" class="brand-logo">Voting Registration</a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                    </ul>
                </div>
            </nav>
              <div class="col s12">
                  <div class="input-field col s3 offset-s4" id="msg">
                      <?php 
                        if($errorFlag)
                            echo "name or email was invalid";       
                      ?>
                  </div>
                  <form method="POST" action="credentials.php">
                      <div class="input-field col s3 offset-s4">
                          <input name ="name" class="tooltipped validate" id="name" 
                          type="text" data-tooltip="Alpha characters " data-position="right"
                          autocomplete="off">
                          <label for="name">Name</label>
                      </div>
                      <div class="input-field col s3 offset-s4">
                          <input name="email" class="tooltipped validate" id="email" 
                          type="email" data-tooltip="Valid Email Address Please" data-position="right"
                          autocomplete="off">
                          <label for="email">Email Address</label>
                      </div>
                      <div class="input-field col s3 offset-s4">
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