<?php
//insert.php
$connect = mysqli_connect("localhost", "root", "", "accounts");
if(isset($_POST["task_name"]))
{
 $task_name = $_POST["task_name"];
 $auftragnehmer = $_POST["auftragnehmer"];
 $deadline = $_POST["deadline"];
 $sollstunden = $_POST["sollstunden"];
 $query = '';
 for($count = 0; $count<count($task_name); $count++)
 {
  $task_name_clean = mysqli_real_escape_string($connect, $task_name[$count]);
  $auftragnehmer_clean = mysqli_real_escape_string($connect, $auftragnehmer[$count]);
  $deadline_clean = mysqli_real_escape_string($connect, $deadline[$count]);
  $sollstunden_clean = mysqli_real_escape_string($connect, $sollstunden[$count]);
  if($task_name_clean != '' && $auftragnehmer_clean != '' && $deadline_clean != '' && $sollstunden_clean != '')
  {
   $query .= '
   INSERT INTO aufgaben(task_name, auftragnehmer, deadline, sollstunden) 
   VALUES("'.$task_name_clean.'", "'.$auftragnehmer_clean.'", "'.$deadline_clean.'", "'.$sollstunden_clean.'"); 
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