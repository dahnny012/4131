<?php
    if(isset($_SESSION['user'])){
        header("Location: restaurants.php");
    }
    
    if(authenticate($_POST['login'])){
        header("Location: restaurants.php");
    }
    
    
    function authenticate($info){
        // authenticate here
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
                  </div>
                  <form method="post" action="login.php">
                      <div class="input-field col s3 offset-s4">
                          <input class="tooltipped validate" id="user" type="text" data-tooltip="Alpha-Numeric and Underscores Only" data-position="right">
                          <label for="user">Username</label>
                      </div>
                      <div class="input-field col s3 offset-s4">
                          <input class="tooltipped validate" id="password" type="password" data-tooltip="At least 6 characters" data-position="right">
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