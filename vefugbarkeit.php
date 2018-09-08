


<?php

require 'db.php';

$email = $_GET['email'];
$tage = array("" ,"So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");


$result = $mysqli->query('SELECT * FROM verfuegbarkeit WHERE email="' . $email . '"');
while ($row = $result->fetch_assoc()) {
	

	$dt = strtotime ($row['datum1']);
	$dt = $tage[date('N' , $dt)] . ', ' . date('d.m.Y' , $dt);

	$dt1 = strtotime ($row['datum2']);
	$dt1 = $tage[date('N' , $dt1)] . ', ' . date('d.m.Y' , $dt1);

	$dtall = $dt . ' - '  . $dt1;
	if($dt == $dt1)
	{
		$dtall = $dt;
	}

//echo date('N' , $dt) . ' - ';
    echo '<option id="' . $row['email'] . '">' . $dtall . ' '  . $row['time1'] .  'Uhr - '  . $row['time2'] . 'Uhr</option>';
                          }

?>
