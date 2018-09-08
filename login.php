
<?php
/* User login process, checks if user exists and password is correct */

// Escape email to protect against SQL injections
$email = $mysqli->escape_string($_POST['email']);
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
$result1 = $mysqli->query("SELECT * FROM aufgaben");

if ( $result->num_rows == 0 ){ // User doesn't exist
    $_SESSION['message'] = "Benutzer mit dieser E-mail Adresse existiert nicht!";
    header("location: error.php");
}
else { // User exists
    $user = $result->fetch_assoc();

    if ( password_verify($_POST['password'], $user['password']) ) {
        
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['active'] = $user['active'];
        $_SESSION['admin'] = $user['admin'];
        $_SESSION['monatsstunden'] = $user['monatsstunden'];
        $_SESSION['studiengang'] = $user['studiengang'];
        $_SESSION['telefonnummer'] = $user['telefonnummer'];
        $_SESSION['verantwortlicher'] = $user['verantwortlicher'];
        // This is how we'll know the user is logged in
        $_SESSION['logged_in'] = true;

        header("location: profile.php");
    }
    else {
        $_SESSION['message'] = "Falsches Passwort! Versuchen Sie es nochmal!";
        header("location: error.php");
    }
}

