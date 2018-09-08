<?php 
require 'db.php';
session_start();

$task_id = 'task_id';
$task_name= 'task_name';
$auftraggeber= 'auftraggeber';
$status= 'status';
$deadline = 'deadline';
$sollstunden = 'sollstunden';
$arbeitsstunden ='arbeitsstunden';
$auftragnehmer='auftragnehmer';
$verantwortlicher='verantwortlicher';
$telefonnummer='telefonnummer';
$monatsstunden='monatsstunden';

$email1='email1';
$datum = 'datum';
$startzeit= 'startzeit';
$endzeit= 'endzeit';
$pause= 'pause';
$bemerkung = 'bemerkung';

$email = $_SESSION['email'];
$resulta = $mysqli->query("SELECT * FROM users");
$resultw = $mysqli->query("SELECT * FROM users WHERE admin = '1'");
$results = $mysqli->query("SELECT * FROM users WHERE admin = '0'");
$result1 = $mysqli->query("SELECT * FROM aufgaben WHERE auftragnehmer = '$email'");
$result2 = $mysqli->query("SELECT * FROM aufgaben WHERE auftraggeber = '$email'");
$result3 = $mysqli->query("SELECT * FROM zeit WHERE email1 ='$email'");
?>
<?php
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "Du bist nicht eingeloggt!!";
  header("location: error.php");    
}
else {
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $admin = $_SESSION['admin'];
    $monatsstunden = $_SESSION['monatsstunden'];}
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

<?php 
if ($active!= 1){
  echo
              '<div class="alert alert-warning"><strong>ACHTUNG!</strong> Kein Zugriff solange Account nicht verifiziert!
              </div>';
}
else{
echo'<div class="container">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Foto</th>
                          <th>Name</th>
                          <th>E-Mail</th>
                          <th>Telefonnummer</th>
                          <th>Verantwortlicher</th>
                          <th>Vertrag</th>
                        </tr>
                      </thead> ';
            if ($resultw->num_rows > 0) {
            while($row = $resultw->fetch_assoc()) {
            echo '
                  <tbody>
                    <tr>
                      <td ><a href="img/' . $row["first_name"].''.$row["last_name"] .'.jpg"><img class="image1" src=img/'. $row["first_name"].''.$row["last_name"] .'.jpg></a></td>
                      <td ><h2>' . $row["first_name"].' '.$row["last_name"] .'</h2><br></td>
                      <td ><h6>' . $row["email"] . '</h6></td>
                      <td ><h6>' . $row["telefonnummer"] . '</h6></td>
                      <td ><h6>' . $row["verantwortlicher"] . '</h6></td>
                      <td ><h6>' . $row["monatsstunden"] . 'h/Monat</h6></td>';}
}
else {
      echo '<p>Keine wissenschaftlichen Mitarbeiter gespeichert!</p>';
    }
echo '</tr>
    </tbody>
   </table></div>';

echo'<div class="container">
                   <table class="table table-hover">
                      <thead>
                        <tr>
                          <th >Foto</th>
                          <th >Name</th>
                          <th >E-Mail</th>
                          <th >Telefonnummer</th>
                          <th >Verantwortlicher</th>
                          <th >Vertrag</th>
                        </tr>
                      </thead> ';
            if ($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
            echo '<tbody>
                    <tr>
                      <td ><a href="img/' . $row["first_name"].''.$row["last_name"] .'.jpg"><img class="image1" src=img/'. $row["first_name"].''.$row["last_name"] .'.jpg></a></td>
                      <td ><h2>' . $row["first_name"].' '.$row["last_name"] .'</h2><br></td>
                      <td ><h6>' . $row["email"] . '</h6></td>
                      <td ><h6>' . $row["telefonnummer"] . '</h6></td>
                      <td ><h6>' . $row["verantwortlicher"] . '</h6></td>
                      <td ><h6>' . $row["monatsstunden"] . 'h/Monat</h6></td>';}
}
else {
      echo '<p>Keine studentischen Mitarbeiter gespeichert!</p>';
    }
echo '</tr>
    </tbody>
   </table></div>';
}
?>
</body>
</html>