<?php 

$_SESSION['task_name'] = $_POST['task_name'];
$_SESSION['auftragnehmer'] = $_POST['auftragnehmer'];
$_SESSION['status'] = $_POST['status'];
$_SESSION['deadline'] = $_POST['deadline'];
$_SESSION['sollstunden'] = $_POST['sollstunden'];
$_SESSION['arbeitsstunden'] = $_POST['arbeitsstunden'];
$_SESSION['auftraggeber'] = $_POST['auftraggeber'];




if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "Du musst angemeldet sein um diese Aktion durchzuführen!";
  header("location: error.php");    
}
else {
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $admin = $_SESSION['admin'];
    }

$task_name = $mysqli->escape_string($_POST['task_name']);
$auftragnehmer = $mysqli->escape_string($_POST['auftragnehmer']);
$status = $mysqli->escape_string($_POST['status']);
$deadline = $mysqli->escape_string($_POST['deadline']);
$sollstunden = $mysqli->escape_string($_POST['sollstunden']);
$arbeitsstunden =$mysqli->escape_string($_POST['arbeitsstunden']);
$auftraggeber =$mysqli->escape_string($_POST['auftraggeber']);


$result = $mysqli->query("SELECT * FROM aufgaben") or die($mysqli->error());
if ( $result->num_rows >= 0 ) {
    $sql = "INSERT INTO aufgaben (task_name, auftragnehmer, status, deadline, sollstunden, arbeitsstunden, auftraggeber) " 
            . "VALUES ('$task_name','$auftragnehmer','$status','$deadline', '$sollstunden','$arbeitsstunden','$auftraggeber')";      
    if ( $mysqli->query($sql) ){

        $to      = $auftragnehmer;
        $subject = 'Neue Aufgabe erhalten ( Institut für Baumanagement und Digitales Bauen )';
        $message_body = 'Lieber Mitarbeiter,

Ich bitte Dich in naechster Zeit deine Aufgaben auf unserer Webapp anzuschauen.
Ueber folgenden Link gelangst du zu deiner neuen Aufgabe:

http://192.168.2.113/ibbapp/profile.php

Mit besten Grüßen,
'

. $first_name . ' '. $last_name;

        mail( $to, $subject, $message_body );

        echo "<script>";
        echo " alert('Aufgabe wurde erfolgreich eingetragen! Auftragnehmer wurde per E-Mail benachrichtigt.');</script>";
   
    }
    else {
        echo "<script>";
        echo " alert('Aufgabe wurde nicht eingetragen!');</script>";
    }
}
    else {
        $_SESSION['message'] = 'Datenbankabfrage fehlgeschlagen!';
        header("location: error.php");
    }
?>
