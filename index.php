<?php 
require 'db.php';
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <title>Aufgabenmanagement ICoM</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
 	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 	  <!-- jQuery library -->
 	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 	  <!-- Latest compiled JavaScript -->
 	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['login'])) { 
        require 'login.php';
    }
    elseif (isset($_POST['register'])) {
        require 'register.php';
    }
}
?>
<style>
  .image1 {
    display: block;
  max-height: 60px;
  margin-left: auto;
  margin-right: auto;
}
</style>
<style>
  h2{
    color: #084B8A;
  }
</style>
<body>
  <div class="well"><img src="img/logo.png" class="image1"></div> 
  <center><h2>Willkommen bei ICoM</h2></center>
<div class="container">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#login">Anmeldung</a></li>
    <li><a data-toggle="tab" href="#registrierung">Registrierung</a></li>
  </ul>

  <div class="tab-content">
    <div id="login" class="tab-pane fade in active">
      <div class="well">
      <h3>Anmeldung</h3>
      	<form action="index.php" method="post" autocomplete="on">
 			<div class="input-group">
 			    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
 			    <input id="email" type="text" class="form-control" name="email" placeholder="Email">
 			</div>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="password" type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <br>
            <div class="col-50">
            <button type="submit" class="btn btn-success" name="login" />Anmelden</button>
            </div><br><br>
 		     </form>
 			<br>

            <a href="forgot.php"><button class="btn btn-danger" />Passwort vergessen?</button></a>
          </div>
    </div>

    <div id="registrierung" class="tab-pane fade">
      <div class="well">
      <h3>Registrierung</h3>
      <form action="index.php" method="post" autocomplete="off">
      	<div class="input-group">
 			    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
 			    <input id="firstname" type="text" class="form-control" name="firstname" placeholder="Vorname">
 		</div>
 		<div class="input-group">
 			    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
 			    <input id="lastname" type="text" class="form-control" name="lastname" placeholder="Nachname">
 		</div>
 		<div class="input-group">
 			    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
 			    <input id="email" type="email" class="form-control" name="email" placeholder="E-Mail">
 		</div>
 		<div class="input-group">
 			    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
 			    <input id="password" type="password" class="form-control" name="password" placeholder="Passwort">
 		</div>
 		<div class="input-group">
 			    <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
 			    <input id="studiengang" type="test" class="form-control" name="studiengang" placeholder="Studiengang">
 		</div>
 		<div class="input-group">
 			    <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
 			    <input id="telefonnummer" type="test" class="form-control" name="telefonnummer" placeholder="Telefonnummer">
 		</div>
 		<div class="input-group">
 			    <span class="input-group-addon"><i class="glyphicon glyphicon-king"></i></span>
 			    <input id="verantwortlicher" type="test" class="form-control" name="verantwortlicher" placeholder="Verantwortlicher Mitarbeiter">
 		</div>
 		<br><button type="submit" class="btn btn-info" name="register" />Registrieren</button>
 		</form>
      </div>
    </div>
  </div>
</div>

</body>
</html>