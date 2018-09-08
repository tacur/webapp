<?php
/* Registration process, inserts user info into the database 
   and sends account confirmation email message
 */
// Set session variables to be used on profile.php page
$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];
$_SESSION['studiengang'] = $_POST['studiengang'];
$_SESSION['telefonnummer'] = $_POST['telefonnummer'];
$_SESSION['verantwortlicher'] = $_POST['verantwortlicher'];

// Escape all $_POST variables to protect against SQL injections
$first_name = $mysqli->escape_string($_POST['firstname']);
$last_name = $mysqli->escape_string($_POST['lastname']);
$email = $mysqli->escape_string($_POST['email']);
$studiengang = $mysqli->escape_string($_POST['studiengang']);
$telefonnummer = $mysqli->escape_string($_POST['telefonnummer']);
$verantwortlicher = $mysqli->escape_string($_POST['verantwortlicher']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );

// Check if user with that email already exists
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());
// We know user email exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {
    $_SESSION['message'] = 'Diese E-Mail Adresse wird bereits verwendet!';
    header("location: error.php");
}
else { // Email doesn't already exist in a database, proceed...

    // active is 0 by DEFAULT (no need to include it here)
    $sql = "INSERT INTO users (first_name, last_name, email, studiengang, telefonnummer, verantwortlicher, password, hash) " 
            . "VALUES ('$first_name','$last_name','$email','$studiengang','$telefonnummer','$verantwortlicher','$password', '$hash')";

    // Add user to the database
    if ( $mysqli->query($sql) ){
        
        $_SESSION['active'] = 0; //0 until user activates their account with verify.php
        $_SESSION['logged_in'] = true; // So we know the user has logged in
        $_SESSION['message'] =
            "Bestaetigungsmail wurde an $email gesendet, bitte klicke auf den 
            Link in der Nachricht, um deine Registrierung abzuschließen!";
        // Send registration confirmation link (verify.php)
        $to      = $email;
        $subject = 'Account Verifikation (Institut für Baumanagement und Digitales Bauen)';
        $message_body = '
        Sehr geehrte/r Mitarbeiter/in '.$last_name.',
        Vielen Dank für die Registrierung!
        Drücke bitte auf den folgenden Link, um dein Account zu aktivieren:
        http://localhost/ibbapp/verify.php?email='.$email.'&hash='.$hash;  

        mail( $to, $subject, $message_body );
        header("location: profile.php"); 
    }
    else {
        $_SESSION['message'] = 'Registrierung fehlgeschlagen!';
        header("location: error.php");
    }

}