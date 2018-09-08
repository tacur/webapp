<?php 

$_SESSION['datum1'] = $_POST['datum1'];
$_SESSION['datum2'] = $_POST['datum2'];
$_SESSION['time1'] = $_POST['time1'];
$_SESSION['time2'] = $_POST['time2'];


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

$datum1 = $mysqli->escape_string($_POST['datum1']);
$datum2 = $mysqli->escape_string($_POST['datum2']);
$time1 = $mysqli->escape_string($_POST['time1']);
$time2 = $mysqli->escape_string($_POST['time2']);


$result = $mysqli->query("SELECT * FROM verfuegbarkeit") or die($mysqli->error());


if ( $result->num_rows >= 0 ) {

    $sql = "INSERT INTO verfuegbarkeit (email, datum1, datum2, time1, time2)" 
            . "VALUES ('$email','$datum1','$datum2','$time1','$time2')";

    if ( $mysqli->query($sql) ){
    
        echo "<script>";
        echo " alert('Zeitraum wurde erfolgreich eingetragen!');</script>";
        }
        else { 
        echo "<script>";
        echo " alert('Zeitraum wurde nicht eingetragen!');</script>";
    }
    
    
}
    else {
        $_SESSION['message'] = 'Datenbankabfrage fehlgeschlagen!';
        header("location: error.php");
}
?>