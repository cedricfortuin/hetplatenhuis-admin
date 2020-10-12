<?php
// Initialize the session

/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

session_start();
include_once 'config/config.php';
include_once 'config/mail_config.php';
$new_sql = mysqli_query($ConnectionLink,  "SELECT * FROM users WHERE USER_ID ='". $_SESSION['id'] ."'");
$username = mysqli_fetch_array($new_sql);

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

include '_layouts/permissions_layout.php';
include '_layouts/_layout-header.phtml';
?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <div class="login-form">
                            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                                <h3 class="text-dark mb-0">Gebruiker aanmaken</h3>
                            </div>
                            <div>
                                <p>Maak hier een nieuwe gebruiker aan</p>
                            </div>
                            <form action="" method="post">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="firstname">Voornaam</label>
                                        <input id="firstname" type="text" name="firstname" autocomplete="off" class="form-control" <?= ($isDisabledForVisitorsAndSubadmins) ? 'disabled' : '' ?> >
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="lastname">Achternaam</label>
                                        <input id="lastname" type="text" name="lastname" autocomplete="off" class="form-control" <?= ($isDisabledForVisitorsAndSubadmins) ? 'disabled' : '' ?>>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="username">Gebruikersnaam</label>
                                        <input id="username" type="text" name="username" autocomplete="off" class="form-control" <?= ($isDisabledForVisitorsAndSubadmins) ? 'disabled' : '' ?>>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" name="email" autocomplete="off" class="form-control" <?= ($isDisabledForVisitorsAndSubadmins) ? 'disabled' : '' ?>>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="userrole">Gebruikersrol</label>
                                        <select id="userrole" class="form-control" name="user_role" <?= ($isDisabledForVisitorsAndSubadmins) ? 'disabled' : '' ?>>
                                            <option class="nav-item" value="admin">Administrator</option>
                                            <option class="nav-item" value="subadmin">Beheerder</option>
                                            <option class="nav-item" value="visitor">Bezoeker</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-outline-primary" value="Toevoegen" <?= ($isDisabledForVisitorsAndSubadmins) ? 'disabled' : '' ?> name="sendMailAndAddAdmin">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php include '_layouts/_layout-footer.phtml';

$username = $firstname = $lastname = $email = $user_role = "";
$username_err = $firstname_err = $lastname_err = $email_err = $user_role_err = "";

$generatedToken = bin2hex(openssl_random_pseudo_bytes(16));

if(isset($_POST['sendMailAndAddAdmin']))
{
    if(empty(trim($_POST['username'])))
    {
        $username_err = 'Error in username';
    } else {
        $username = $_POST['username'];
    }

    if(empty(trim($_POST['firstname'])))
    {
        $firstname_err = 'Error in firstname';
    } else {
        $firstname = $_POST['firstname'];
    }

    if(empty(trim($_POST['lastname'])))
    {
        $lastname_err = 'Error in lastname';
    } else {
        $lastname = $_POST['lastname'];
    }

    if(empty(trim($_POST['email'])))
    {
        $email_err = 'Error in mail';
    } else {
        $email = $_POST['email'];
    }

    if(empty(trim($_POST['user_role'])))
    {
        $user_role_err = 'Error in role';
    } else {
        $user_role = $_POST['user_role'];
    }

    if (empty($username_err) && empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($user_role_err))
    {

        $sqlInsertUserInput = "INSERT INTO users (USERNAME, USER_FIRSTNAME, USER_LASTNAME, USER_EMAIL, USER_ROLE) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($ConnectionLink, $sqlInsertUserInput))
        {
            mysqli_stmt_bind_param($stmt, "sssss", $param_username, $param_firstname, $param_lastname, $param_email, $param_user_role);

            // Set parameters
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_email = $email;
            $param_user_role = $user_role;

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    // Insert token into database
    $sqlTokenInput = "INSERT INTO reset_password (USER_TOKEN_MAIL, USER_TOKEN) VALUES ('$email', '$generatedToken')";
    if(mysqli_query($ConnectionLink, $sqlTokenInput))
    {
        $mail_receiver_email = $email;
        $mail_receiver_name = $firstname;
        $button_link = "http://localhost/hetplatenhuis-admin/admin/password/reset_mail.php?token={$generatedToken}&email={$email}";
        $bootstrap_link = "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css";
        $font_link = "https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap";
        $font = "{font-family: 'Ubuntu', sans-serif;}";
        $mail_subject = 'Wachtwoord instellen';
        $mail_text = "<link href={$font_link} rel='stylesheet'>
                        <link href={$bootstrap_link} rel='stylesheet'>
                        <style>
                            h4, p, a {$font};
                        </style>
                        <div class='container-fluid'>
                            <div class='row'>
                                <div class='col-md-12'>
                                    <h4>Hoi {$firstname},</h4>
                                    <p>Je bent door een beheerder aangemeld bij de adminomgeving van Het Platenhuis. <br/>
                                        Dit is je gebruikersnaam: {$username}. <br/>
                                        Klik op de volgende link om je wachtwoord in te stellen: </p>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12 justify-content-center'>
                                    <a class='btn btn-sm btn-outline-primary text-center' href={$button_link}>Wachtwoord instellen</a><br/><br/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                    <p>Met vriendelijke groet,<br/> Het Platenhuis<br/>
                                    <small><i>Let op, deze mail is persoonlijk. Deel deze dus niet!</i></small></p>
                                </div>
                            </div>
                        </div>";

        $mail->setFrom('info@hetplatenhuis.nl', 'Het Platenhuis');
        $mail->addAddress($mail_receiver_email, $mail_receiver_name);

        $mail->isHTML(true);

        $mail->Subject = $mail_subject;
        //$mail->addEmbeddedImage('path/to/image_file.jpg', 'image_cid');
        $mail->Body = $mail_text;
        //$mail->AltBody = $mail_text;

        if($mail->send()){
            echo "<script>window.location.href='current_admins_page.php?SHOW_ALERT=ON_SUBMIT'</script>";
        } else {
            echo "Mail niet verzonden: " . $mail->isError() . '<br/>';
        }

    } else {
        echo 'Something went wrong: ' . mysqli_error($ConnectionLink) . '<br/>';
    }

    $ConnectionLink->close();
}

?>