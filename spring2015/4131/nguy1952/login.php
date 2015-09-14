<?php
    session_start();
    ini_set('display_errors','1'); error_reporting(E_ALL);
    $errorFlag = false;
    
    if(isset($_SESSION['user'])){
        header("Location: restaurants.php");
    }
    
    if(!empty($_POST) && authenticate($_POST)){
        header("Location: restaurants.php");
    }else{
        if(!empty($_POST)){
            $errorFlag = true;
        }
    }
    
    
    function authenticate($info){
        if(strlen($info['user']) <= 0 || preg_match("/[^A-z0-9]/",$info['user']) || strlen($info['password']) < 6){
            return 0;
        }
        $xml=simplexml_load_file("details.xml");
        foreach($xml as $entry){
            if($info['user'] == $entry->user
            && $info['password'] == $entry->pass){
                $_SESSION['user'] = (string)$entry->user; 
                return 1;
            }
        }
        return 0;
    }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
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
                    <a href="#" class="brand-logo">Top 5 Restaurants</a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </nav>
              <div class="col s12">
                  <div class="input-field col s3 offset-s4" id="msg">
                      <?php 
                        if($errorFlag)
                            echo "Your username/password did not match any accounts";        
                      ?>
                  </div>
                  <form method="POST" action="login.php">
                      <div class="input-field col s3 offset-s4">
                          <input name ="user" class="tooltipped validate" id="user" 
                          type="text" data-tooltip="Alpha-Numeric and Underscores Only" data-position="right"
                          autocomplete="off">
                          <label for="user">Username</label>
                      </div>
                      <div class="input-field col s3 offset-s4">
                          <input name="password" class="tooltipped validate" id="password" 
                          type="password" data-tooltip="At least 6 characters" data-position="right"
                          autocomplete="off">
                          <label for="password">Password</label>
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