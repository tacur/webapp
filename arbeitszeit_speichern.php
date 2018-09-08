<?php

require 'db.php';
session_start();

$tage = array("" ,"So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");

$connect = mysqli_connect("localhost", "root", "", "accounts");
if(isset($_POST["datum"]))
{
 $email1= $_POST["email1"];
 $datum = $_POST["datum"];
 $startzeit = $_POST["startzeit"];
 $endzeit = $_POST["endzeit"];
 $pause = $_POST["pause"];
 $bemerkung = $_POST["bemerkung"];
 $query = '';
 for($count = 0; $count<count($datum); $count++)
 {
  $email1_clean = mysqli_real_escape_string($connect, $email1[$count]);
  $datum_clean = mysqli_real_escape_string($connect, $datum[$count]);
  $startzeit_clean = mysqli_real_escape_string($connect, $startzeit[$count]);
  $endzeit_clean = mysqli_real_escape_string($connect, $endzeit[$count]);
  $pause_clean = mysqli_real_escape_string($connect, $pause[$count]);
  $bemerkung_clean = mysqli_real_escape_string($connect, $bemerkung[$count]);
  if($datum_clean != '' && $startzeit_clean != '' && $endzeit_clean != '' && $pause_clean != '' && $bemerkung_clean != '')
  {
   $query .= '
   INSERT INTO zeit(email1, datum, startzeit, endzeit, pause, bemerkung) 
   VALUES("'.$email1_clean.'","'.$datum_clean.'", "'.$startzeit_clean.'", "'.$endzeit_clean.'", "'.$pause_clean.'" , "'.$bemerkung_clean.'"); 
   ';
  }
 }
 if($query != '')
 {
  if(mysqli_multi_query($connect, $query))
  {
   echo 'Item Data Inserted';
  }
  else
  {
   echo 'Error';
  }
 }
 else
 {
  echo 'All Fields are Required';
 }
}
?>