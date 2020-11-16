<?php
/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

include '_layouts/_layout-header.phtml';
include 'config/mail_config.php';

$username = $firstname = $lastname = $email = $user_role = "";
$username_err = $firstname_err = $lastname_err = $email_err = $user_role_err = "";

if(isset($_POST['sendMailAndAddAdmin']))
{
    if(empty(trim($_POST['username'])))
    {
        $username_err = 'is-invalid';
    } else {
        $username = mysqli_real_escape_string($ConnectionLink, $_POST['username']);
    }

    if(empty(trim($_POST['firstname'])))
    {
        $firstname_err = 'is-invalid';
    } else {
        $firstname = mysqli_real_escape_string($ConnectionLink, $_POST['firstname']);
    }

    if(empty(trim($_POST['lastname'])))
    {
        $lastname_err = 'is-invalid';
    } else {
        $lastname = mysqli_real_escape_string($ConnectionLink, $_POST['lastname']);
    }

    if(empty(trim($_POST['email'])))
    {
        $email_err = 'is-invalid';
    } else {
        $email = mysqli_real_escape_string($ConnectionLink, $_POST['email']);
    }

    if(empty(trim($_POST['user_role'])))
    {
        $user_role_err = 'is-invalid';
    } else {
        $user_role = mysqli_real_escape_string($ConnectionLink, $_POST['user_role']);
    }

    if (empty($username_err) && empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($user_role_err))
    {
        $sqlInsertUserInput = "INSERT INTO admins (USERNAME, ADMIN_UUID, ADMIN_FIRSTNAME, ADMIN_LASTNAME, ADMIN_EMAIL, ADMIN_ROLE, ADMIN_RESET_TOKEN) VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($ConnectionLink, $sqlInsertUserInput))
        {
            mysqli_stmt_bind_param($stmt, "sssssss", $param_username,$param_uuid, $param_firstname, $param_lastname, $param_email, $param_user_role, $param_reset_token);

            // Set parameters
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_email = $email;
            $param_uuid = uniqid();
            $param_user_role = $user_role;
            $param_reset_token = bin2hex(openssl_random_pseudo_bytes(16));

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        $message = file_get_contents('mails/old-admin-mail/add-admin.html');
        $message = str_replace('{mail_receiver_name}', $firstname, $message);
        $message = str_replace('{generated_token}', $param_reset_token, $message);
        $message = str_replace('{admin_uuid}', $param_uuid, $message);


        $mail->setFrom('info@hetplatenhuis.nl', 'Het Platenhuis');
        $mail->addAddress($email, $firstname);
        $mail->addBCC('administrator@hetplatenhuis.nl');

        $mail->isHTML(true);
        $mail->CharSet = "utf-8";

        $mail->MsgHTML($message);
        $mail->Subject = 'Een beheerder heeft je toegevoegd';

        if($mail->send()){
            echo "<script>window.location.href='current_admins_page.php'</script>";
        } else {
            echo "Mail niet verzonden: " . $mail->isError() . '<br/>';
        }
    }
} ?>
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
                            <?php

                            if (!$isDisabledForVisitorsAndSubadmins) {
                                ?>
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="firstname">Voornaam</label>
                                            <input id="firstname" type="text" name="firstname" autocomplete="off" class="form-control <?php echo $firstname_err?>" <?php echo ($isDisabledForVisitorsAndSubadmins) ? 'disabled' : '' ?> >
                                            <p class="invalid-feedback">Dit veld is verplicht.</p>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="lastname">Achternaam</label>
                                            <input id="lastname" type="text" name="lastname" autocomplete="off" class="form-control <?php echo $lastname_err?>" <?php echo ($isDisabledForVisitorsAndSubadmins) ? 'disabled' : '' ?>>
                                            <p class="invalid-feedback">Dit veld is verplicht.</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="username">Gebruikersnaam</label>
                                            <input id="username" type="text" name="username" autocomplete="off" class="form-control <?php echo $username_err?>" <?php echo ($isDisabledForVisitorsAndSubadmins) ? 'disabled' : '' ?>>
                                            <p class="invalid-feedback">Dit veld is verplicht.</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="email">Email</label>
                                            <input id="email" type="email" name="email" autocomplete="off" class="form-control <?php echo $email_err?>" <?php echo ($isDisabledForVisitorsAndSubadmins) ? 'disabled' : '' ?>>
                                            <p class="invalid-feedback">Dit veld is verplicht.</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="userrole">Gebruikersrol</label>
                                            <select id="userrole" class="form-control" name="user_role" <?php echo ($isDisabledForVisitorsAndSubadmins) ? 'disabled' : '' ?>>
                                                <option class="nav-item" value="admin">Administrator</option>
                                                <option class="nav-item" value="subadmin">Beheerder</option>
                                                <option class="nav-item" value="visitor">Bezoeker</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-outline-primary" value="Toevoegen" <?php echo ($isDisabledForVisitorsAndSubadmins) ? 'disabled' : '' ?> name="sendMailAndAddAdmin">
                                    </div>
                                </form>
                            <?php
                            } else {
                                ?>
                                <p class="alert alert-warning text-center">Je hebt niet de bevoegdheden voor deze functie.</p>
                                <?php
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php include '_layouts/_layout-footer.phtml';?>