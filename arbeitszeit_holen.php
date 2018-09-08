<?php

require 'db.php';
session_start();

$email = $_SESSION['email'];
$output = '';
$result = $mysqli->query("SELECT * FROM zeit WHERE email1 = '$email' Order by datum ASC");

$tage = array("" ,"So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");

$output = '
<br />
<h3 align="center">Deine übermittelte Arbeitszeiten</h3>
<table class="table table-bordered table-striped">
 <tr>
  <th class="hide" width="5%">ID</th>
  <th width="40%">Datum</th>
  <th width="15%">Beginn</th>
  <th width="15%">Ende</th>
  <th width="10%">Pause</th>
  <th width="15%">Notiz</th>
 </tr>';
while($row = $result->fetch_assoc())
{
	$dt = strtotime ($row['datum']);
  $dt = $tage[date('N' , $dt)] . ', ' . date('d.m.Y' , $dt);
 $output .= '
 <tr>
  <td class="hide">'.$row["id"].'</td>
  <td>'.$dt.'</td>
  <td>'.$row["startzeit"].'</td>
  <td>'.$row["endzeit"].'</td>
  <td>'.$row["pause"].'</td>
  <td >'.$row["bemerkung"].'</td>
 </tr>
 ';
}
$output .= '</table>';
echo $output;
?>