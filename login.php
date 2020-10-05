<?php
// Initialize the session

/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Include config file from the root directory
require_once "config/config.php";

// Set the variables to empty
$password = $username = "";
$password_err = $username_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username (firstname) is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "<div class='alert alert-warning text-center'><i class='fa fa-exclamation fa-fw'></i> Vul je gebruikersnaam in.</div>";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "<div class='alert alert-warning text-center'><i class='fa fa-exclamation fa-fw'></i> Vul je wachtwoord in.</div>";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT USER_ID, USERNAME, USER_PASSWORD FROM users WHERE USERNAME = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            // This creates cookies which make logging in and using the admin panel, working
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION['loggedin_time'] = time();

                            // Redirect user to welcome page
                            header("location: index.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "<div class='alert alert-danger text-center'><i class='fa fa-exclamation-triangle fa-fw'></i> Gebruikersnaam of wachtwoord niet correct.</div>";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "<div class='alert alert-danger text-center'><i class='fa fa-exclamation-triangle fa-fw'></i> Gebruikersnaam of wachtwoord niet correct.</div>";
                }
            } else {
                echo "<div class='alert alert-danger text-center'>Oops! Something went wrong. Please try again later. O_o</div>";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Het Platenhuis</title>
    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    <link rel="shortcut icon" href="./assets/img/functional/song.png" type="image/x-icon"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="./assets/fonts/fontawesome-all.min.css">
</head>

<body class="bg-gradient-primary">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-12 col-xl-10">
            <div class="card shadow-lg o-hidden border-0 my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-flex">
                            <div class="flex-grow-1 bg-login-image"
                                 style="background-image: url(./assets/img/custom/record-holding.jpg);"></div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h4 class="text-dark mb-4"><?php echo "Welkom!" ?></h4>
                                </div>
                                <div class="login-form">
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <h4 class="modal-title text-center">Login met je admin account</h4><br>
                                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                            <label for="email-label">Gebruikersnaam</label>
                                            <input id="email-label" type="text" name="username" class="form-control"
                                                   placeholder="" autocomplete="off">
                                        </div>
                                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                            <label for="password-label">Wachtwoord</label>
                                            <input id="password-label" type="password" name="password"
                                                   class="form-control"
                                                   placeholder="" autocomplete="off">
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-block btn-lg" value="Login">
                                        <div class="text-sm-center"><br>
                                            <a href="mailto:administrator@hetplatenhuis.nl">Wachtwoord vergeten?</a>
                                        </div>
                                        <br>
                                        <p class="help-block text-center"
                                           style="color:red;"><?php echo $username_err; ?></p>
                                        <p class="help-block text-center"
                                           style="color:red;"><?php echo $password_err; ?></p>
                                        <h6 class="text-center">Geen admin? <a href="https://hetplatenhuis.nl">Terug
                                                naar de site</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="./assets/js/theme.js"></script>
</body>

</html>