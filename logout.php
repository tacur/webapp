<?php
/* Log out process, unsets and destroys session variables */
session_start();
session_unset();
session_destroy(); 
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <title>Auf Wiedersehen!</title>
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
.image3 {
  padding: 3px;
  max-height: 50px;
}
</style>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <center><div class="navbar-header">
      <img class="image3" src="img/logo_klein.png">
      <a class="navbar-brand" href="profile.php"><b>ICoM</b> Management</a>
    </div>
    </center>
</div>
</nav>
<div class="well">
          <center><h1>Danke für ihren Besuch!</h1>
          <p><?php echo 'Sie sind ausgeloggt!'; ?></p> <br></div></center>
          <form action="index.php" method="post" autocomplete="off">
               <center> <button class="btn btn-success" name="startseite"/>Zurück zur Startseite</button></center>
          </form>    

</body>
</html>
