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

$datum = 'datum';
$ankuendigungsname= 'ankuendigungsname';
$author= 'author';
$inhalt= 'inhalt';


$active = $_SESSION['active'];
$email = $_SESSION['email'];
$resultw = $mysqli->query("SELECT * FROM users WHERE active = '1'");
$results = $mysqli->query("SELECT * FROM users WHERE active = '0'");
$result1 = $mysqli->query("SELECT * FROM aufgaben WHERE auftragnehmer = '$email'");
$result2 = $mysqli->query("SELECT * FROM aufgaben WHERE auftraggeber = '$email'");
$result3 = $mysqli->query("SELECT * FROM zeit WHERE email1 ='$email'");
$result5 = $mysqli->query("SELECT * FROM announcement WHERE DATE(datum) >= DATE(NOW()) ORDER BY datum ASC");
$result51 = $mysqli->query("SELECT * FROM announcement WHERE DATE(datum) >= DATE(NOW()) ORDER BY datum ASC;");
$querypie = $mysqli->query("SELECT * FROM aufgaben WHERE auftragnehmer = 'tarkan.acur@live.de'")->num_rows;
$querypie1 = $mysqli->query("SELECT * FROM aufgaben WHERE auftragnehmer = 'acur@baubetrieb.uni-hannover.de'")->num_rows;
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


<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">

    <title>Admin: <?= $first_name.' '.$last_name ?></title>
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
    <div id="chart_div" ></div>

   <h2 align="center">Dashboard</h2>
   <br/>
   <div class="container">
   <div class="table-responsive">
    <table class="table table-bordered" id="crud_table">
     <tr>
      <th width="30%">Item Name</th>
      <th width="10%">Item Code</th>
      <th width="45%">Description</th>
      <th width="10%">Price</th>
      <th width="5%"></th>
     </tr>
     <tr>
      <td contenteditable="true" class="item_name"></td>
      <td contenteditable="true" class="item_code"></td>
      <td contenteditable="true" class="item_desc"></td>
      <td contenteditable="true" class="item_price"></td>
      <td></td>
     </tr>
    </table>
    <div align="right">
     <button type="button" name="add" id="add" class="btn btn-success btn-xs">+</button>
    </div>
    <div align="center">
     <button type="button button-raised button-fill color-green" name="save" id="save" class="btn btn-info">Save</button>
    </div>
    <br />
    <div id="inserted_item_data"></div>
   </div>
  </div>

  <div class="container">
  <div class="well">
          <button type="button"onclick="document.getElementById('demo').innerHTML = Date()">Click me to display Date and Time.</button>
          <button type="button"onclick="document.getElementById('demo1').innerHTML = Date()">Click me to display Date and Time.</button>
          <p id="demo"></p>
  </div>
  </div>
          <!-- PIECHART -->
                                    <div id="piechart"></div>
          <!-- PIECHART -->
<?php 
                if ( !$admin ){
                    echo
                    '<div class="info">
                    Ihr Account ist nicht dazu berechtigt diesen Bereich nutzen zu können.
                    </div>';
                }
                else{
                  echo' <h3>Kamera Test</h3>                    
                        <input capture="camera" accept="image/*" type="file" name="bildAufnehmen" />
                        <p id="demo1"></p>'; 
                }
?>
            </div>
          </div>
        </div>
      </div>
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

<script>
$(document).ready(function(){
 var count = 1;
 $('#add').click(function(){
  count = count + 1;
  var html_code = "<tr id='row"+count+"'>";
   html_code += "<td contenteditable='true' class='item_name'></td>";
   html_code += "<td contenteditable='true' class='item_code'></td>";
   html_code += "<td contenteditable='true' class='item_desc'></td>";
   html_code += "<td contenteditable='true' class='item_price' ></td>";
   html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";   
   html_code += "</tr>";  
   $('#crud_table').append(html_code);
 });
 
 $(document).on('click', '.remove', function(){
  var delete_row = $(this).data("row");
  $('#' + delete_row).remove();
 });
 
 $('#save').click(function(){
  var item_name = [];
  var item_code = [];
  var item_desc = [];
  var item_price = [];
  $('.item_name').each(function(){
   item_name.push($(this).text());
  });
  $('.item_code').each(function(){
   item_code.push($(this).text());
  });
  $('.item_desc').each(function(){
   item_desc.push($(this).text());
  });
  $('.item_price').each(function(){
   item_price.push($(this).text());
  });
  $.ajax({
   url:"insert.php",
   method:"POST",
   data:{item_name:item_name, item_code:item_code, item_desc:item_desc, item_price:item_price},
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
   url:"fetch.php",
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