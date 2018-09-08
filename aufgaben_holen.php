<?php

require 'db.php';
session_start();

$email = $_SESSION['email'];
$output = '';
$result = $mysqli->query("SELECT * FROM aufgaben WHERE auftragnehmer = '$email'");

$tage = array("" ,"So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");

$output = '

';
while($row = $result->fetch_assoc())
{
	$dt = strtotime ($row['deadline']);
    $dt = $tage[date('N' , $dt)] . ', ' . date('d.m.Y' , $dt);
 $output .= '
 <tr>
  <td>'.$row["task_name"].'</td>
  <td>'.$row["auftragnehmer"].'</td>
  <td>'.$dt.'</td>
  <td>'.$row["sollstunden"].'</td>
  <td >'.$row["arbeitsstunden"].'</td>
  <td >'.$row["status"].'</td>
 </tr>
 ';
}
$output .= '';
echo $output;
?>