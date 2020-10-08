<?php
// Initialize the session

/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
include 'config/mail_config.php';
include 'collect_all_datahandlers.php';
include '_layouts/_layout-header.phtml';
?>
    <section class="content-section" style="color: black;">
        <div class="container">
            <p class="alert alert-warning text-center">Let op, deze functie is nog in ontwikkeling!</p>
            <?php
            if(isset($_GET['SHOW_ALERT']))
            {
                switch ($_GET['SHOW_ALERT'])
                {
                    case 'ON_SENT': ?>
                        <p class="alert alert-success alert-dismissible fade show">De mail is verzonden!
                            <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                        </p>
                        <?php
                        break;
                    case 'ON_ERROR': ?>
                        <p class="alert alert-danger alert-dismissible fade show">Er is iets fout gegaan, probeer het later opnieuw.
                            <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                        </p>
                        <?php
                        break;
                }
            } ?>
            <div class="col-md-12 mx-auto">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark mb-0">Mail</h3>
                </div>
                <div>
                    <p>Stuur hier een mail<br/><small>Mails worden verstuurd vanuit <i>info@hetplatenhuis.nl.</i></small></p>
                </div>
                <div class="form">
                    <form action="" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName">Ontvanger</label>
                                <input type="text" class="form-control" name="mail_receiver" id="inputName"
                                       autocomplete="off" <?= ($isDisabledForVisitors) ? 'disabled' : '' ?> required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCompany">Onderwerp</label>
                                <input type="text" class="form-control" name="mail_subject" id="inputCompany"
                                       autocomplete="off" <?= ($isDisabledForVisitors) ? 'disabled' : '' ?> required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputEmail">Inhoud van de mail</label>
                                <textarea style="resize: none;height: 200px;" type="text" class="form-control" name="mail_text"
                                          id="inputEmail" autocomplete="off" <?= ($isDisabledForVisitors) ? 'disabled' : '' ?> required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary" <?= ($isDisabledForVisitors) ? 'disabled' : '' ?> name="sendNewMail">Versturen</button>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <br><br>
    </div>
<?php include '_layouts/_layout-footer.phtml';

if (isset($_POST['sendNewMail']))
{
    $mail_receiver = mysqli_real_escape_string($ConnectionLink, $_POST['mail_receiver']);
    $mail_subject = mysqli_real_escape_string($ConnectionLink, $_POST['mail_subject']);
    $mail_text = mysqli_real_escape_string($ConnectionLink, $_POST['mail_text']);

    $mail->setFrom('info@hetplatenhuis.nl', 'Het Platenhuis');
    $mail->addAddress($mail_receiver);

    $mail->isHTML(false);

    $mail->Subject = $mail_subject;
    //$mail->addEmbeddedImage('path/to/image_file.jpg', 'image_cid');
    $mail->Body = $mail_text;
    //$mail->AltBody = $mail_text;

    if(!$mail->send()){
        echo "<script>window.location.href='add_new_mail.php?SHOW_ALERT=ON_ERROR'</script>";
    }else {
        echo "<script>window.location.href='add_new_mail.php?SHOW_ALERT=ON_SENT'</script>";
    }

}


?>