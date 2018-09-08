<!-- We don't need full layout here, because this page will be parsed with Ajax-->
<!-- Top Navbar-->
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

$email = $_SESSION['email'];
$resultw = $mysqli->query("SELECT * FROM users WHERE active = '1'");
$results = $mysqli->query("SELECT * FROM users WHERE active = '0'");
$result1 = $mysqli->query("SELECT * FROM aufgaben WHERE auftragnehmer = '$email'");
$result2 = $mysqli->query("SELECT * FROM aufgaben WHERE auftraggeber = '$email'");
$result3 = $mysqli->query("SELECT * FROM zeit WHERE email1 ='$email'");
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
    <!-- Data-Tables -->
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    
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
  </head>
  <body>

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
             <h2 align="center">Aufgabe Test</h2>
             <br />
             <div class="table-responsive">
              <table class="table table-bordered" id="crud_table">
               <tr>
                <th width="30%">Aufgabe</th>
                <th width="10%">Auftragnehmer</th>
                <th width="45%">Deadline</th>
                <th width="10%">Sollstunden</th>
               </tr>
               <tr>
                <td contenteditable="true" class="task_name"></td>
                <td contenteditable="true" class="auftragnehmer"></td>
                <td contenteditable="true" class="deadline"></td>
                <td contenteditable="true" class="sollstunden"></td>
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

          <h1>Deine Aufgaben:</h1>

           <div id="inserted_item_data" ></div>
         

</body>
</html>


<script>

$(document).ready(function() {
    $('#example').DataTable();
} );

$(document).ready(function(){
  
  fetch_data();

  function fetch_data()
  {
   var dataTable = $('#user_data').DataTable({
    "processing" : true,
    "serverSide" : true,
    "order" : [],
    "ajax" : {
     url:"fetch.php",
     type:"POST"
    }
   });
  }

$(document).ready(function(){
 var count = 1;
 $('#add').click(function(){
  count = count + 1;
  var html_code = "<tr id='row"+count+"'>";
   html_code += "<td contenteditable='true' class='task_name'></td>";
   html_code += "<td contenteditable='true' class='auftragnehmer'></td>";
   html_code += "<td contenteditable='true' class='deadline'></td>";
   html_code += "<td contenteditable='true' class='sollstunden' ></td>";
   html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";   
   html_code += "</tr>";  
   $('#crud_table').append(html_code);
 });
 
 $(document).on('click', '.remove', function(){
  var delete_row = $(this).data("row");
  $('#' + delete_row).remove();
 });
 
 $('#save').click(function(){
  var task_name = [];
  var auftragnehmer = [];
  var deadline = [];
  var sollstunden = [];
  $('.task_name').each(function(){
   task_name.push($(this).text());
  });
  $('.auftragnehmer').each(function(){
   auftragnehmer.push($(this).text());
  });
  $('.deadline').each(function(){
   deadline.push($(this).text());
  });
  $('.sollstunden').each(function(){
   sollstunden.push($(this).text());
  });
  $.ajax({
   url:"aufgaben_speichern.php",
   method:"POST",
   data:{task_name:task_name, auftragnehmer:auftragnehmer, deadline:deadline, sollstunden:sollstunden},
   success:function(data){
    alert(data);
    $("td[contentEditable='true']").text("");
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
   url:"aufgaben_holen.php",
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
