<?php
// Include config file

/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

include "config/config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = $firstname = $lastname = $email = $user_role ="";
$username_err = $password_err = $confirm_password_err = $firstname_err = $lastname_err = $email_err = $user_role_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT USER_ID FROM users WHERE USERNAME = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later. " . mysqli_error($link);
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate username
    if(empty(trim($_POST['username']))) {
        $username_err = "Please enter a username";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate firstname
    if(empty(trim($_POST['firstname']))) {
        $firstname_err = "Please enter a first name";
    } else {
        $firstname = trim($_POST["firstname"]);
    }

    //Validate lastname
    if(empty(trim($_POST['lastname']))) {
        $lastname_err = "Please enter a last name";
    } else {
        $lastname = trim($_POST['lastname']);
    }

    // Validate firstname
    if(empty(trim($_POST['email']))) {
        $email_err = "Please enter a email";
    } else {
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST['user_role']))) {
        $user_role_err = "Please enter a user role";
    } else {
        $user_role = trim($_POST["user_role"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($user_role_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (USERNAME, USER_PASSWORD, USER_ROLE, USER_FIRSTNAME, USER_LASTNAME, USER_EMAIL) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssisss", $param_username, $param_password, $param_user_role, $param_firstname, $param_lastname, $param_email);

            // Set parameters
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_email = $email;
            $param_user_role = $user_role;
            $param_password = password_hash($password, PASSWORD_BCRYPT); // Creates a password hash

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: toegevoegd.php");
            } else {
                echo "Something went wrong. Please try again later. " . mysqli_error($link);
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
