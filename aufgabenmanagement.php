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

$active = $_SESSION['active'];
$email = $_SESSION['email'];

$resulta = $mysqli->query("SELECT * FROM users WHERE email != '$email'");
$resultw = $mysqli->query("SELECT * FROM users WHERE active = '1'");
$results = $mysqli->query("SELECT * FROM users WHERE active = '0'");
$result1 = $mysqli->query("SELECT * FROM aufgaben WHERE auftragnehmer = '$email'");
$result2 = $mysqli->query("SELECT * FROM aufgaben WHERE auftraggeber = '$email'");
$result3 = $mysqli->query("SELECT * FROM zeit WHERE email1 ='$email'");
$result4 = $mysqli->query("SELECT * FROM aufgaben");

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
    $admin = $_SESSION['admin'];
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
          
        <h2>Willkommen im Aufgabenmanagement!</h2>
         <?php 
          if ( !$admin ){
              echo
              '<div class="info">
              Ihr Account ist nicht dazu berechtigt diesen Bereich nutzen zu können.
              </div>';
          }
          else{
            echo
        '<form action="profile.php" method="post" autocomplete="off">
          <div class="container">
                  <div class="well">
                        <select name="auftraggeber"><option>' . $email . '</option></select>
                        <select name="auftragnehmer" id="auftragnehmer" onchange="auftragnehmer_changes(this);" >';
                        if ($resulta->num_rows >0){
                          while ($row = $resulta->fetch_assoc()) {
                            echo '<option value="' . $row['email'] . '" >'  . $row['email'] . '</option>';
                          }
                        }else {echo '<option>Keine Mitarbeiter eingetragen!</option>';}
                          echo '
                          
                        </select>
                      Studenten:
                        <select name="angegebene_zeit" id="angegebene_zeit">
                        </select><br>
                        <input type="text" placeholder="Aufgabenname" name="task_name"><br>
                      Deadline:
                        <input type="date" placeholder="Deadline" name="deadline">
                        <input type="text" placeholder="Sollstunden [h]" name="sollstunden">
            <br>            
          <button type="submit" class="button button button-fill color-green" name="aufgaben_eintragen" />Aufgabe vergeben</button><br>
        </div>
        </div>
      </form>'; 

      echo ' Vergebene Aufgaben:
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Aufgabenname</th>
                          <th >Auftragnehmer</th>
                          <th >Deadline</th>
                          <th >Arbeitsstunden</th>
                          <th >Sollstunden</th>
                          <th >Status</th>
                        </tr>
                      </thead>';

             

              if ($result2->num_rows > 0) {
                // output data of each row
              while($row = $result2->fetch_assoc()) {
               echo'  <tbody>
                        <tr>
                          <td>' . $row["task_name"].'</td>
                          <td ><br>' .$row["auftragnehmer"] . 
                          '<td >' . $row["deadline"] . ' </td>
                          <td >' . $row["arbeitsstunden"] . ' </td>
                          <td >' . $row["sollstunden"]. ' </td>
                          <td >' . $row["status"] . '%<li class="item-content">
                                                    <div class="item-inner"><div data-progress="' . $row["status"] . '" class="progressbar ';
               if ($row["status"] <= 30){
                    echo 'color-red';           
                }elseif ($row["status"] > 99 ){ 
                    echo 'color-blue';}
                 else{ echo 'color-green'; } 
              echo '">' . $row["status"]. '</div></div></li><br></td>';             
              }
              } else {
              echo "<br>Keine vergebenen Aufgaben !";
          }
          echo '</tr>
            </tbody>
          </table><br>    </div>
    </div>';

           echo '<br> 
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Aufgabenname</th>
                          <th >Auftragnehmer</th>
                          <th >Auftraggeber</th>
                          <th >Deadline</th>
                          <th >Arbeitsstunden</th>
                          <th >Sollstunden</th>
                          <th >Status</th>
                        </tr>
                      </thead>';

              if ($result4->num_rows > 0) {
                // output data of each row
              while($row = $result4->fetch_assoc()) {
               echo'  <tbody>
                        <tr>
                          <td>' . $row["task_name"].'</td>
                          <td ><br>' .$row["auftragnehmer"] . 
                          '<td ><br>' .$row["auftraggeber"] . 
                          '<td >' . $row["deadline"] . ' </td>
                          <td >' . $row["arbeitsstunden"] . ' </td>
                          <td >' . $row["sollstunden"]. ' </td>
                          <td >' . $row["status"] . '%<li>
                                                    <div ><data-progress="' . $row["status"] . '';
               if ($row["status"] <= 30){
                    echo 'color-red';           
                }elseif ($row["status"] > 99 ){ 
                    echo 'color-blue';}
                 else{ echo 'color-green'; } 
              echo '">' . $row["status"]. '</li><br></td>';             
              }
              } else {
              echo "0 results";
          }
          echo '</tr>
            </tbody>
          </table><br>';}
    ?>

        </div>
      </div>
    </div>
  </div>
</div>
