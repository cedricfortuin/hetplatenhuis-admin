<?php
// Initialize the session

/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

session_start();
include 'config/config.php';
$new_sql = mysqli_query($link,  "SELECT * FROM users WHERE USER_ID ='". $_SESSION['id'] ."'");
$username = mysqli_fetch_array($new_sql);

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$disabled = '';

if($username['USER_ROLE'] != 1)
{
    $disabled = 'disabled';
}

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
                            <form action="register-handler.php" method="post">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="firstname">Voornaam</label>
                                        <input id="firstname" type="text" name="firstname" autocomplete="off" class="form-control" <?php echo $disabled ?> >
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="lastname">Achternaam</label>
                                        <input id="lastname" type="text" name="lastname" autocomplete="off" class="form-control" <?php echo $disabled ?>>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-5">
                                        <label for="username">Gebruikersnaam</label>
                                        <input id="username" type="text" name="username" autocomplete="off" class="form-control" <?php echo $disabled ?>>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="email">Email</label>
                                        <input id="email" type="text" name="email" autocomplete="off" class="form-control" <?php echo $disabled ?>>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="rol">Rol</label>
                                        <input id="rol" type="number" name="user_role" min="1" minlength="1" max="3" maxlength="1" autocomplete="off" class="form-control" <?php echo $disabled ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Wachtwoord</label>
                                    <input id="password" type="password" name="password" autocomplete="off" class="form-control" <?php echo $disabled ?>>
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">Bevestig wachtwoord</label>
                                    <input id="password-confirm" type="password" name="confirm_password" autocomplete="off"
                                           class="form-control" <?php echo $disabled ?>>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-outline-primary" value="Toevoegen" <?php echo $disabled ?>>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php include '_layouts/_layout-footer.phtml' ?>