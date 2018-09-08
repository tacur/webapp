<?php 
/* Reset your password form, sends reset.php password link */
require 'db.php';
session_start();

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) 
{   
    $email = $mysqli->escape_string($_POST['email']);
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

    if ( $result->num_rows == 0 ) // User doesn't exist
    { 
        $_SESSION['message'] = "Benutzer mit dieser E-Mail existiert nicht!!";
        header("location: error.php");
    }
    else { // User exists (num_rows != 0)

        $user = $result->fetch_assoc(); // $user becomes array with user data
        
        $email = $user['email'];
        $hash = $user['hash'];
        $first_name = $user['first_name'];

        // Session message to display on success.php
        $_SESSION['message'] = "<p>Bitte kontrolliere deine E-Mail <span>$email</span>"
        . " um das Passwort zu vervollständigen!!</p>";

        // Send registration confirmation link (reset.php)
        $to      = $email;
        $subject = 'Passwort Reset Link ( Institut für Baumanagement und Digitales Bauen)';
        $message_body = '
        Sehr geehrte/r '.$last_name.',

        Sie haben eine Passwort-Änderung gewünscht!

        Klicken Sie auf den folgenden Link um Ihr Passwort zu ändern:

        http://localhost/icomapp/reset.php?email='.$email.'&hash='.$hash;  

        mail($to, $subject, $message_body);

        header("location: success.php");
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <title>Willkommen <?= $first_name.' '.$last_name ?></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/myapp.js"></script>

  </head>
  <body>

<style>
.image1 {
    border: 1px solid #ddd; 
    border-radius: 4px;  
    padding: 5px; 
     margin-right: 10px; 
    width: 100px;
}
.image2 {

  max-height: 160px;
}
.image3 {
  padding: 3px;
  max-height: 50px;
}
/* Add a hover effect (blue shadow) 
img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
*/
</style>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <center><div class="navbar-header">
      <img class="image3" src="img/logo_klein.png">
      <a class="navbar-brand" href="profile.php"><b>ICoM</b> Management</a>
    </div></center>
  </div>
</nav>


<div class="well">
    <h1>Passwort zurücksetzen!</h1>
    <form action="forgot.php" method="post">
     <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
    <input id="email" type="text" class="form-control" name="email" placeholder="Email">
    </div>
</div>

<center><button type="submit" class="btn btn-danger"/>Reset</button></center>
</form>
          
</body>

</html>
