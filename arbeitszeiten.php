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
$responsible='responsible';
$telefonnummer='telefonnummer';

$email1='email1';
$datum = 'datum';
$startzeit= 'startzeit';
$endzeit= 'endzeit';
$pause= 'pause';
$bemerkung = 'bemerkung';


$active = $_SESSION['active'];
$email = $_SESSION['email'];
$resultw = $mysqli->query("SELECT * FROM users WHERE active = '1'");
$results = $mysqli->query("SELECT * FROM users WHERE active = '0'");
$result1 = $mysqli->query("SELECT * FROM aufgaben WHERE auftragnehmer = '$email'");
$result2 = $mysqli->query("SELECT * FROM aufgaben WHERE auftraggeber = '$email'");
$result3 = $mysqli->query("SELECT * FROM zeit WHERE email1 ='$email' AND id >='30' ORDER BY datum ASC");
?>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['logout'])) { 
        require 'logout.php';
    }
    elseif (isset($_POST['zeiten_eintragen'])) { 
        require 'zeiten_eintragen.php';
    }
}
?>

<?php
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "Du musst angemeldet sein um diese Aktion durchzuführen!";
  header("location: error.php");    
}
else {
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
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

          <div class="container">
             <br />
             <h2 align="center">Arbeitszeiten</h2>
             <br />
             <div class="table-responsive">
              <table class="table table-bordered" id="crud_table">
               <tr>
                <th width="10%" >E-Mail</th>
                <th width="40%">Datum</th>
                <th width="15%">Beginn</th>
                <th width="15%">Ende</th>
                <th width="10%">Pause</th>
                <th width="10%">Bemerkung</th>
               </tr>
               <tr>
                <td class="email1"><? echo $email ?></td>
                <td contenteditable='true' type="date" class="datum"></td>
                <td contenteditable='true' class="startzeit"></td>
                <td contenteditable='true' class="endzeit"></td>
                <td contenteditable='true' class="pause"></td>
                <td contenteditable='true' class="bemerkung"></td>
                <td></td>
               </tr>
              </table>
              <div align="right">
               <button type="button" name="add" id="add" class="btn btn-success btn-xs">+</button>
              </div>
              <div align="center">
               <button type="button" name="save" id="save" class="btn btn-info">Save</button>
              </div>
              <br />
             </div>
            </div>

          <div class="container">
           <div id="inserted_item_data"></div>
          </div>

            <div class="container">
              <h3>Deine übermittelten Arbeitszeiten</h3>
                    <table >
                      <thead>
                        <tr>
                          <th class="hide">ID</th>
                          <th>Datum</th>
                          <th>Startzeit</th>
                          <th>Endzeit</th>
                          <th>Pause</th>
                          <th>Bemerkung</th>
                        </tr>
                      </thead>
<?php  
              if ($result3->num_rows > 0) {
              while($row = $result3->fetch_assoc()) {
               echo'  <tbody>
                        <tr>
                          <td class="hide">' . $row["id"].'</td>
                          <td>' . $row["datum"].'</td>
                          <td>' .$row["startzeit"] . 
                          '<td>' .$row["endzeit"] . 
                          '<td>' . $row["pause"] . ' </td>
                          <td>' . $row["bemerkung"];    
              }
              } else {
              echo "0 results";
          }
          echo '</tr>
            </tbody>
          </table><br>';
?>  
</div>

</body>

<script>
$(document).ready(function(){
 var count = 1;
 $('#add').click(function(){
  count = count + 1;
  var html_code = "<tr id='row"+count+"'>";
   html_code += "<td contenteditable='true' class='datum'><input type='date' name='datum'/></td>";
   html_code += "<td contenteditable='true' class='startzeit'><input type='time' name='startzeit'/></td>";
   html_code += "<td contenteditable='true' class='endzeit'><input type='time' name='endzeit'/></td>";
   html_code += "<td contenteditable='true' class='pause'><input type='time' name='pause'/></td>";
   html_code += "<td contenteditable='true' class='bemerkung'><input type='text' name='bemerkung'/></td>";
   html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";   
   html_code += "</tr>";  
   $('#crud_table').append(html_code);
 });
 
 $(document).on('click', '.remove', function(){
  var delete_row = $(this).data("row");
  $('#' + delete_row).remove();
 });
 
 $('#save').click(function(){
  var email1 = [];
  var datum = [];
  var startzeit = [];
  var endzeit = [];
  var pause = [];
  var bemerkung = [];
  $('.email1').each(function(){
   email1.push($(this));
  });
  $('.datum').each(function(){
   datum.push($(this).text());
  });
  $('.startzeit').each(function(){
   startzeit.push($(this).text());
  });
  $('.endzeit').each(function(){
   endzeit.push($(this).text());
  });
  $('.pause').each(function(){
   pause.push($(this).text());
  });
  $('.bemerkung').each(function(){
   bemerkung.push($(this).text());
  });

  $.ajax({
   url:"arbeitszeit_speichern.php",
   method:"POST",
   data:{email1:email1, datum:datum, startzeit:startzeit, endzeit:endzeit, pause:pause, bemerkung:bemerkung },
   success:function(data){
    alert(data);
    $("td[contentEditable='false']").text("");
    for(var i=2; i<= count; i++)
    {
     $('tr#'+i+'').remove();
    }
    fetch_item_data();
   }
  });
 });
 
 function fetch_item_data()
 {
  $.ajax({
   url:"arbeitszeit_holen.php",
   method:"POST",
   success:function(data)
   {
    $('#inserted_item_data').html(data);
   }
  })
 }
 fetch_item_data();
 
});
</script>
