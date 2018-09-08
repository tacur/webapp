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

$email1='email1';
$datum = 'datum';
$startzeit= 'startzeit';
$endzeit= 'endzeit';
$pause= 'pause';
$bemerkung = 'bemerkung';

$tage = array("" ,"So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");

$active = $_SESSION['active'];
$email = $_SESSION['email'];
$resultw = $mysqli->query("SELECT * FROM users WHERE active = '1'");
$results = $mysqli->query("SELECT * FROM users WHERE active = '0'");
$result1 = $mysqli->query("SELECT * FROM aufgaben WHERE auftragnehmer = '$email'");
$result2 = $mysqli->query("SELECT * FROM aufgaben WHERE auftraggeber = '$email'");
$result3 = $mysqli->query("SELECT * FROM verfuegbarkeit WHERE DATE(datum1) >= DATE(NOW()) ORDER BY datum1 ASC");
$result4 = $mysqli->query("SELECT * FROM verfuegbarkeit ORDER BY datum1 ASC");
$result5 = $mysqli->query("SELECT * FROM users WHERE email = '$email'");
 

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: error.php");    
}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $admin = $_SESSION['admin'];
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

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        if (isset($_POST['logout'])) { //user logging in

            require 'logout.php';
        }
        elseif (isset($_POST['verfügbarkeit_eintragen'])) { //user registering
            
            require 'verfügbarkeit_eintragen.php';
        }
    }
?>


<div class="container">
<?php 
          if ( !$admin ){
              echo
              '<div class="info">
              Ihr Account ist nicht dazu berechtigt diesen Bereich nutzen zu können.
              </div>';
          }
          else{
            echo'<h4><u>Verfügbarkeiten der Studenten:</u></h4>
                  <div class="container">
                    <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>Student</th>
                                  <th>Datum</th>
                                  <th>Zeitraum</th>
                                </tr>
                              </thead>';

                      if ($result3->num_rows > 0) {
                      while($row = $result3->fetch_assoc()) {
                        $dt = strtotime ($row['datum1']);
                        $dt = $tage[date('N' , $dt)] . ', ' . date('d.m.Y' , $dt);
                        $dt1 = strtotime ($row['datum2']);
                        $dt1 = $tage[date('N' , $dt1)] . ', ' . date('d.m.Y' , $dt1);
                        $dtall = $dt . ' - '  . $dt1;
                        if($dt == $dt1)
                        {
                          $dtall = $dt;
                        }
                       echo'  <tbody>
                                <tr>
                                  <td>' . $row["email"] .'</td>
                                  <td>' . $dtall.'</td>
                                  <td>' .$row["time1"] . 'Uhr - ' .$row["time2"] . 'Uhr</td>';          
                      }
                      } else {
                      echo "Keine Zeiträume eingetragen!";
                  }
                  echo '</tr>
                    </tbody>
                  </table><br></div>';
                  echo'<h4><u>Alle Verfügbarkeiten der Studenten:</u></h4>
                   <div class="container">
                    <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>Student</th>
                                  <th>Tag</th>
                                  <th>Zeitraum</th>
                                </tr>
                              </thead>';
                              
                      if ($result4->num_rows > 0) {
                      while($row = $result4->fetch_assoc()) {
                        $dt = strtotime ($row['datum1']);
                        $dt = $tage[date('N' , $dt)] . ', ' . date('d.m.Y' , $dt);
                        $dt1 = strtotime ($row['datum2']);
                        $dt1 = $tage[date('N' , $dt1)] . ', ' . date('d.m.Y' , $dt1);
                        $dtall = $dt . ' - '  . $dt1;
                        if($dt == $dt1)
                        {
                          $dtall = $dt;
                        }
                       echo'  <tbody>
                                <tr>
                                  <td>' . $row["email"] . '</td>
                                  <td>' . $dtall. '</td>
                                  <td>' .$row["time1"] . 'Uhr - ' .$row["time2"] . 'Uhr</td>';          
                      }
                      } else {
                      echo "Keine einzelnen Tage eingetragen!";
                  }
                  echo '</tr>
                    </tbody>
                  </table><br></div>';
                }
?>  
</div>
</body>

</html>

                  
