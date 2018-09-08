<?php



$_SESSION['datum'] = $_POST['datum'];
$_SESSION['author'] = $_POST['author'];
$_SESSION['ankuendigungsname'] = $_POST['ankuendigungsname'];
$_SESSION['inhalt'] = $_POST['inhalt'];


// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "Du musst angemeldet sein um diese Aktion durchzuführen!";
  header("location: error.php");    
}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $admin = $_SESSION['admin'];
    }



$datum = $mysqli->escape_string($_POST['datum']);
$author = $mysqli->escape_string($_POST['author']);
$ankuendigungsname = $mysqli->escape_string($_POST['ankuendigungsname']);
$inhalt = $mysqli->escape_string($_POST['inhalt']);



$result = $mysqli->query("SELECT * FROM announcement") or die($mysqli->error());

if ( $result->num_rows >= 0 ) {

    $sql = "INSERT INTO announcement (author, datum, ankuendigungsname, inhalt) " 
            . "VALUES ('$author','$datum','$ankuendigungsname','$inhalt')";      
    if ( $mysqli->query($sql) ){

        echo "<script>";
        echo " alert('Ankündigung wurde erfolgreich eingetragen!');</script>";
    }
    else {
        echo "<script>";
        echo " alert('Ankündigung wurde nicht eingetragen!');</script>";
    }
}
    else {
        $_SESSION['message'] = 'Datenbankabfrage fehlgeschlagen!';
        header("location: error.php");
    }
?>