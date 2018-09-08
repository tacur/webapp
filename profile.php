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
$monatsstunden = 'monatsstunden';


$email1='email1';
$datum = 'datum';
$startzeit= 'startzeit';
$endzeit= 'endzeit';
$pause= 'pause';
$bemerkung = 'bemerkung';

$id = 'id';
$datum = 'datum';
$author = 'author';
$inhalt = 'inhalt';
$ankuendigungsname = 'ankuendigungsname';
$tage = array("" ,"So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");

$email = $_SESSION['email'];
$resultw = $mysqli->query("SELECT * FROM users WHERE active = '1'");
$results = $mysqli->query("SELECT * FROM users WHERE active = '0'");
$result1 = $mysqli->query("SELECT * FROM aufgaben WHERE auftragnehmer = '$email' AND DATE(deadline) >= DATE(NOW()) ORDER BY deadline ASC");
$result2 = $mysqli->query("SELECT * FROM aufgaben WHERE auftraggeber = '$email' ORDER BY deadline");
$result21 = $mysqli->query("SELECT * FROM aufgaben, announcement");
$result3 = $mysqli->query("SELECT * FROM zeit WHERE email1 ='$email'");
$result5 = $mysqli->query("SELECT * FROM announcement WHERE DATE(datum) >= DATE(NOW()) ORDER BY datum ASC");
$result51 = $mysqli->query("SELECT * FROM announcement WHERE DATE(datum) >= DATE(NOW()) ORDER BY datum ASC");
$querypie = $mysqli->query("SELECT * FROM aufgaben WHERE auftragnehmer = 'tarkan.acur@live.de'")->num_rows;
$querypie1 = $mysqli->query("SELECT * FROM aufgaben WHERE auftragnehmer = 'acur@baubetrieb.uni-hannover.de'")->num_rows;
?>

<?php
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "DU bist nicht eingeloggt!!";
  header("location: error.php");    
}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $admin = $_SESSION['admin'];
    $monatsstunden = $_SESSION['monatsstunden'];}
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
    elseif (isset($_POST['zeiten_eintragen'])) {
        
        require 'zeiten_eintragen.php';
    }
    elseif (isset($_POST['update_ankuendigungen'])) {
        
        require 'update_ankuendigungen.php';
    }
    elseif (isset($_POST['verfügbarkeit_eintragen'])) {
        
        require 'verfügbarkeit_eintragen.php';
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

<div class="well">
  <center><div class="container">
              <table>
                <tbody>
                  <tr>
                  <th><?php echo '<img class="image1" src=img/'.''. $first_name.''.$last_name.'.jpg class="rounded float-left" alt="...">'; ?></th>
                  <th><h2><?php echo $first_name.' '.$last_name; ?></h2><h6><?= $email ?></h6>
                    <?php if (!$admin){
                            echo '<h5><ins>Status</ins>: <b>Studentischer Mitarbeiter</b></h5>
                                  <h5><ins>Vertrag</ins>: '. $monatsstunden . ' h</h5>';
                    }else{  echo '<h5><ins>Status</ins>: Wissenschaftlicher Mitarbeiter</b></h5>
                                  <h5><ins>Vertrag</ins>: '. $monatsstunden . ' h</h5>';} ?>
                  </th>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
</div></center>
</div>

<div class="container">
<!-- NACHRICHT WEGEN VERIFIKATION DES ACCOUNTS -->
              <?php
                 if ($active != 1){
                  echo '<div class="alert alert-warning"><strong>ACHTUNG!</strong><ul class="list-group">
                    <li class="list-group-item list-group-item-danger">Account nicht verifiziert</li>
                    <li class="list-group-item list-group-item-warning">Account Nutzung ist sehr eingeschränkt!</li>
                  </ul></div>
                  ';
                 }else{
                  echo '';
                 }
              ?>


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
          <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                  <div class="item active"><center><img class="image2" src="img/veranstaltung1.png"></center></div>
                  <div class="item"><center><img class="image2" src="img/veranstaltung2.png"></center></div>
                  <div class="item"><center><img class="image2" src="img/veranstaltung3.png"></center></div>
              </div>
              <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                  <span class="sr-only">Zurück</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right"></span>
                  <span class="sr-only">Nächste</span>
                </a>
            </div>
<div class="container">
              <h3><ins>Schnellauswahl:</ins></h3>
              <div class="list-group">
                <a href="aufgaben.php" class="list-group-item"><span class="badge"><i class="material-icons">group_work</i></span><h4><b>Meine Aufgaben</b></h4></a>
                <a href="termine.php" class="list-group-item"><span class="badge"><i class="material-icons">timeline</i></span><h4><b>Meine Termine</b></h4></a>
                <a href="verfügbarkeiten.php" class="list-group-item"><span class="badge"><i class="material-icons">timelapse</i></span><h4><b>Meine Verfügbarkeiten</b></h4></a>
                <a href="arbeitszeiten.php" class="list-group-item"><span class="badge"><i class="material-icons">access_time</i></span><h4><b>Meine Arbeitszeiten</b></h4></a>
                <a href="aufgabenmanagement.php" class="list-group-item"><span class="badge"><i class="material-icons">supervisor_account</i></span><h4><b>Aufgabenmanagement</b></h4></a>
                <a href="zeitmanagement.php" class="list-group-item"><span class="badge"><i class="material-icons">av_timer</i></span><h4><b>Zeitmanagement</b></h4></a>
                <a href="personen.php" class="list-group-item"><span class="badge"><i class="material-icons">people_outline</i></span><h4><b>Personen im Institut</b></h4></a>
                <a href="redaktion.php" class="list-group-item"><span class="badge"><i class="material-icons">new_releases</i></span><h4><b>Redaktion</b></h4></a>
                <a href="dashboard.php" class="list-group-item"><span class="badge"><i class="material-icons">view_carousel</i></span><h4><b>Dashboard</b></h4></a>
              </div>
</div>
              <div class="container">
                <h4><u>Google Piechart</u></h4>
                 <div id="piechart"></div>
              </div>

<div class="well"> <center>
              <!-- Impressum Popup -->
              <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#impressum">Impressum</button>
              <!-- Modal -->
              <div id="impressum" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Impressum</h4>
                    </div>
                    <div class="modal-body">
                      <p>Dieses Impressum gilt für die ICoM unter der Domain icom.uni-hannover.de, inkl. aller Subdomains (Unterseiten), sowie für alle Webseiten und Dienste von ICoM, die auf dieses Impressum verlinken.</p>
                  <p><b>Institut für Baumanagement und Digitales Bauen</b><br>
                  Leibniz Universität Hannover<br>
                  Appelstraße 9a<br>
                  30167 Hannover<br></p><br><br>
                  <p>Diese WebApp wird von Tarkan Acur verwaltet. bei Fragen oder Anregungen können Sie Herrn Acur jederzeit unter folgender E-Mail Adresse kontaktieren:
                  <b><a href="mailto:acur@icom.uni-hannover.de">acur@icom.uni-hannover.de</a></b></p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Infos über Anfahrt -->
              <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#anfahrt">Anfahrt</button>
              <!-- Modal -->
              <div id="anfahrt" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Anfahrt</h4>  
                    </div>
                      <div class="modal-body">
                          <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                              <div class="panel-heading">
                                <h4 class="panel-title">
                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                  <h3><u>Anfahrt mit dem Auto</u></h3></a>
                                </h4>
                              </div>
                              <div id="collapse1" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p><b>Norden/Osten:</b> Fahren Sie auf der A2 in Richtung Dortmund. Nehmen Sie die Ausfahrt Hannover-Herrenhausen und fahren Sie anschließend Richtung Herrenhausen. Folgen Sie dem Westschnellweg (B6) bis Herrenhausen; weiteres siehe Westschnellweg.</p>
                                    <p><b>Westen:</b> Fahren Sie auf der Autobahn A2 in Richtung Berlin. Nehmen Sie die Ausfahrt Hannover-Herrenhausen und fahren Sie Richtung Herrenhausen auf dem Westschnellweg (B6); weiteres siehe Westschnellweg.</p>
                                    <p><b>Süden:</b> Fahren Sie auf der Autobahn A7 bis zum Autobahnkreuz Hannover-Ost. Dort wechseln Sie auf die A2 in Richtung Dortmund. Nach mehreren Kilometern nehmen Sie die Autobahnausfahrt Hannover-Herrenhausen und fahren in Richtung Herrenhausen auf dem Westschnellweg (B6); weiteres siehe Westschnellweg.</p>
                                    <p><b>Westschnellweg:</b> Verlassen Sie den Westschnellweg an der Ausfahrt Herrenhausen. Biegen Sie dann nach rechts in die Herrenhäuser Straße ein. Folgen Sie immer der Richtung "Universität/Zentrum". Nach ca. einem Kilometer Fahrt folgen Sie dem Straßenverlauf nach rechts in die Nienburger Straße. An der ersten Ampel biegen Sie nach links in den Schneiderberg ein. Nach ca. 600m biegen Sie nach links auf den Parkplatz der Universität ein und sehen dort auch schon das Hochhaus, Sie finden das Institut für Baumanagement und Digitales Bauen im fünften Stock im Gebäude der Appelstraße 9a.</p>
                                </div>
                              </div>
                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h4 class="panel-title">
                                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                      <h3><u>Anfahrt per Bahn</u></h3></a>
                                    </h4>
                                  </div>
                                  <div id="collapse2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                      
                                      <p>Vom Hauptbahnhof Hannover sind es ca. 5 Minuten Fußweg zum Kröpcke. Von dort aus fahren Sie 4 Stationen mit der Stadtbahnlinie 4 (Richtung Garbsen) oder 5 (Richtung Stöcken) bis zur Haltestelle "Schneiderberg/Wilhelm-Busch-Museum" (<a href="https://www.efa.de/index.php?id=home&no_cache=1#/#dateBlock" target="_blank">Fahrplanauskunft</a>). Dort angekommen gehen Sie über die Ampel geradeaus Richtung Schneiderberg bis zur nächsten Querstraße, der Callinstraße, und biegen Sie links (an der Hauptmensa) ab.</p>
                                      <p>Nach gut 150m sehen Sie rechts von sich bereits das Hochhaus Appelstraße 9a. Das Institut für Baumanagement und Digitales Bauen befindet sich im fünften Stock dieses Hochhauses.</p>
                                    </div>
                                  </div>
                                </div>
                      </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                  </div>
                </div>
              </div>
              </center>
</div>
               


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
              google.charts.load('current', {'packages':['corechart']});
              google.charts.setOnLoadCallback(drawChart);

              function drawChart() {

                var data = google.visualization.arrayToDataTable([
                  ['Aufgaben', 'Anzahl Taskss'],
                  ['Tarkan', <?php echo $querypie ?>],
                  ['Philipp', 7],
                  ['Nils',  2],
                  ['Linda', 1],
                  ['Lukas', 4]
                ]);

                var options = {
                  title: 'Studentische Aufgabenverteilung'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
              }
    </script>
  
</body>
</html>