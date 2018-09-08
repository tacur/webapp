<?php 

$_SESSION['datum'] = $_POST['datum'];
$_SESSION['startzeit'] = $_POST['startzeit'];
$_SESSION['endzeit'] = $_POST['endzeit'];
$_SESSION['pause'] = $_POST['pause'];
$_SESSION['bemerkung'] = $_POST['bemerkung'];

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
    
$datum = $mysqli->escape_string($_POST['datum']);
$startzeit = $mysqli->escape_string($_POST['startzeit']);
$endzeit = $mysqli->escape_string($_POST['endzeit']);
$pause = $mysqli->escape_string($_POST['pause']);
$bemerkung = $mysqli->escape_string($_POST['bemerkung']);


$result = $mysqli->query("SELECT * FROM zeit") or die($mysqli->error());

if ( $result->num_rows >= 0 ) {

    $sql = "INSERT INTO zeit (email1, datum, startzeit, endzeit, pause, bemerkung)" 
            . "VALUES ('$email','$datum','$startzeit','$endzeit','$pause','$bemerkung')";

    if ( $mysqli->query($sql) ){

        echo "<script>";
        echo " alert('Arbeitszeit wurde erfolgreich eingetragen!');</script>";
    }
    else { 

    echo "<script>";
    echo " alert('Arbeitszeit wurde nicht eingetragen!');</script>";
    }
}
    else {
        $_SESSION['message'] = 'Datenbankabfrage fehlgeschlagen!';
        header("location: error.php");
    }
?>