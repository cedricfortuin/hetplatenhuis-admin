<?php
// Initialize the session

/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

session_start();
include 'config/config.php';

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$getAdmin = $ConnectionLink->query("SELECT * FROM users ORDER BY USER_ID ASC");

include 'collect_all_datahandlers.php';
include '_layouts/_layout-header.phtml'; ?>
            <section class="content-section">
                <div class="container">
                    <?php
                    if(isset($_GET['SHOW_ALERT']))
                    {
                        switch ($_GET['SHOW_ALERT'])
                        {
                            case 'ON_SUBMIT': ?>
                                <p class="alert alert-success alert-dismissible fade show">De beheerder is succesvol toegevoegd!
                                    <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                                </p>
                                <?php
                                break;
                            case 'ON_DELETE': ?>
                                <p class="alert alert-success alert-dismissible fade show">De beheerder is succesvol verwijderd!
                                    <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                                </p>
                                <?php
                                break;
                            case 'ON_EDIT': ?>
                                <p class="alert alert-success alert-dismissible fade show">De beheerder is succesvol gewijzigd!
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
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                                <h3 class="text-dark mb-0">Profielen</h3>
                            </div>
                            <div>
                                <p>Zie hier de huidige gebruikers</p>
                            </div>
                            <div class="table-responsive">
                                <table class="table" style="color:black;">
                                    <tr>
                                        <th scope="col">Email</th>
                                        <th scope="col">Voornaam</th>
                                        <th scope="col">Gebruikersnaam</th>
                                        <th scope="col">Rol</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <?php
                                        if (!$isDisabledForVisitorsAndSubadmins) {
                                            echo '<th scope="col"></th>';
                                            echo '<th scope="col"></th>';
                                        }

                                        ?>
                                    </tr>
                                    <?php
                                    $i = 0;
                                    while ($setAdmin = mysqli_fetch_array($getAdmin)) {
                                    ?>
                                    <tbody style="color: black;">
                                    <tr>
                                        <td><a href="mailto:<?php echo $setAdmin["USER_EMAIL"]; ?>"><?php echo $setAdmin["USER_EMAIL"]; ?></a></td>
                                        <td><?php echo $setAdmin["USER_FIRSTNAME"]; ?></td>
                                        <td><?php echo $setAdmin["USERNAME"]; ?></td>
                                        <td class="text-center">
                                            <?php
                                            switch ($setAdmin["USER_ROLE"]) {
                                                case "admin":
                                                    echo '<i class="fas fa-user-lock" id="admin"></i>';
                                                    break;
                                                case "subadmin":
                                                    echo '<i class="fas fa-user-cog" id="subadmin"></i>';
                                                    break;
                                                default:
                                                    echo '<i class="fas fa-eye" id="visitor"></i>';
                                            } ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <?php
                                        if(!$isDisabledForVisitorsAndSubadmins)
                                        { ?>
                                            <td><a
                                                        href="edit-profiles.php?USER_ID=<?php echo $setAdmin["USER_ID"]; ?>">Bewerken</a></td>
                                            <td><a
                                                        href="delete-admin.php?USER_ID=<?php echo $setAdmin["USER_ID"]; ?>">Verwijderen</a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $i++;
                                    }
                                    if ($isDisabledForVisitorsAndSubadmins){
                                        echo '<div><p class="alert alert-warning text-center alert-dismissible">Je mag helaas de beheerders niet aanpassen of verwijderen.<button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button></p></div>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
<?php include '_layouts/_layout-footer.phtml' ?>