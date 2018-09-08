<?php
/* The password reset form, the link to this page is included
   from the forgot.php email message
*/
require 'db.php';
session_start();

// Make sure email and hash variables aren't empty
if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
    $email = $mysqli->escape_string($_GET['email']); 
    $hash = $mysqli->escape_string($_GET['hash']); 

    // Make sure user email with matching hash exist
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email' AND hash='$hash'");

    if ( $result->num_rows == 0 )
    { 
        $_SESSION['message'] = "Diese URL ist falsch! Bitte kontaktiere den Admin: acur@icom.uni-hannover.de";
        header("location: error.php");
    }
}
else {
    $_SESSION['message'] = "Entschuldigung Sie, Ihre Verifikation ist fehlgeschlagen. Versuchen Sie es nochmal!";
    header("location: error.php");  
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
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
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <img class="image3" src="img/logo_klein.png">
      <a class="navbar-brand" href="profile.php"><b>ICoM</b> Management</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Startseite</a></li>
        <li><a href="aufgaben.php">Meine Aufgaben</a></li>
        <li><a href="termine.php">Meine Termine</a></li> 
        <li><a href="verfügbarkeiten.php">Meine Verfügbarkeiten</a></li>
        <li><a href="arbeitszeiten.php" >Meine Arbeitszeiten</a></li> 
        <li><a href="aufgabenmanagement.php" >Aufgabenmanagement</a></li> 
        <li><a href="zeitmanagement.php" >Zeitmanagement </a></li> 
        <li><a href="personen.php">Personen im Institut </a></li> 
        <li><a href="redaktion.php" >Redaktion </a></li> 
        <li><a href="dashboard.php" >Dashboard </a></li>   
      </ul>
      <ul class="nav navbar-nav navbar navbar-right ">
        <li><a href="logout.php" class="btn btn-danger" method="post" name="logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="a">
<nav class="navbar-footer navbar-default navbar-fixed-bottom">
   <a href="logout.php" class="btn btn-danger" method="post" name="logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
</nav>
</div>

<div class="container">
    <div class="form">

          <h1>Wählen Sie ein neues Passwort</h1>
          
          <form action="reset_password.php" method="post">
              
          <div class="field-wrap">
            <label>
              Neues Passwort<span class="req">*</span>
            </label>
            <input type="password"required name="newpassword" autocomplete="off"/>
          </div>
              
          <div class="field-wrap">
            <label>
              Neues Passwort erneut eingeben<span class="req">*</span>
            </label>
            <input type="password"required name="confirmpassword" autocomplete="off"/>
          </div>
          
          <!-- This input field is needed, to get the email of the user -->
          <input type="hidden" name="email" value="<?= $email ?>">    
          <input type="hidden" name="hash" value="<?= $hash ?>">    
              
          <button class="button button-block"/>Bestätigen</button>
          
          </form>
</div>

</body>
</html>
