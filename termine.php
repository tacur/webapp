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

$tage = array("" ,"So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");

$email1='email1';
$datum = 'datum';
$startzeit= 'startzeit';
$endzeit= 'endzeit';
$pause= 'pause';
$bemerkung = 'bemerkung';

$datum = 'datum';
$author = 'author';
$inhalt = 'inhalt';
$ankuendigungsname = 'ankuendigungsname';


$email = $_SESSION['email'];
$resultw = $mysqli->query("SELECT * FROM users WHERE active = '1'");
$results = $mysqli->query("SELECT * FROM users WHERE active = '0'");
$result1 = $mysqli->query("SELECT * FROM aufgaben WHERE auftragnehmer = '$email'");
$result2 = $mysqli->query("SELECT * FROM aufgaben WHERE auftraggeber = '$email' ORDER BY deadline DESC");
$result21 = $mysqli->query("SELECT * FROM aufgaben, announcement");
$result3 = $mysqli->query("SELECT * FROM zeit WHERE email1 ='$email'");
$result5 = $mysqli->query("SELECT * FROM announcement WHERE DATE(datum) >= DATE(NOW());");
$result51 = $mysqli->query("SELECT * FROM announcement WHERE DATE(datum) >= DATE(NOW());");
?>

<?php
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: error.php");    
}
else {
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    }
?>
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['logout'])) {

        require 'logout.php';
    }
    elseif (isset($_POST['aufgaben_eintragen'])) {
        
        require 'aufgaben_eintragen.php';
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
<h3><u>Institutsankündigungen:</u></h3>
  <?php 
      if($result5->num_rows > 0){
        while ( $row = $result5->fetch_assoc() ) {
          $dt = strtotime ($row['datum']);
          $dt = $tage[date('N' , $dt)] . ', ' . date('d.m.Y' , $dt);
          echo '<div class="panel-gruop">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                        <a data-toggle="collapse" href="#' . $row['id'] . '">' . $dt . ': ' . $row['ankuendigungsname'] . '</a></h4>
                      </div>
                          <div id="'. $row['id'] . '" class="panel-collapse collapse">
                            <div class="panel-body">' . $row['inhalt'] .  '</div>
                            <div class="panel-footer">' . $row['author'] . '</div>
                          </div> 
                      </div>
                    </div>';}
      }else{
        echo 'Keine aktuellen Ankündigungen vorhaden';
      }
?>
</div>

<div class="container">
  <h3><u>Aufgaben:</u></h3>
  <?php 
      if($result1->num_rows > 0){
        while ( $row = $result1->fetch_assoc() ) {
          $dt = strtotime ($row['deadline']);
          $dt = $tage[date('N' , $dt)] . ', ' . date('d.m.Y' , $dt);
          echo '<div class="panel-gruop">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                        <a data-toggle="collapse" href="#' . $row['task_id'] . '">' . $dt . ': ' . $row['task_name'] . '
                        </a></h4>
                      </div>
                        <div id="'. $row['task_id'] . '" class="panel-collapse collapse">
                          <div class="panel-body">' . $row['arbeitsstunden'] . 'h/' . $row['sollstunden'] . 'h </div>                            
                          <div class="panel-footer">' . $row['status'] . '%</div>
                        </div> 
                    </div>
                </div>';}
      }else{
        echo 'Keine aktuellen Aufgaben vorhanden';
      }
      ?>
</div><br>

</body>
</html>