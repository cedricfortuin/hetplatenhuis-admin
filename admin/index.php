<?php
// Initialize the session

/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Check if the user is logged in, if not then redirect him to login page
include '_layouts/_layout-header.phtml';
include 'collect_all_datahandlers.php';
?>
        <div class="container-fluid">
            <section class="content-section" style="color: black;">
                <div class="container">
                    <p class="alert alert-primary alert-dismissible">De adminomgeving is vernieuwd! Kijk gauw rond! <a
                                href="new_features.php">Wat is er nieuw...</a></p>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                                <h3 class="text-dark mb-0">Dashboard</h3>
                            </div>
                            <p><?php echo "Welkom " . userFirstname; ?> bij het admin-paneel. Hier kun je
                                als <?php echo userRole?> het volgende doen: </p>
                            <ul>
                                <?php
                                switch (userRole)
                                {
                                    case ('admin'):
                                        ?>
                                        <li>Het <a href="songofday_page.php">nummer van de dag</a> toevoegen / verwijderen</li>
                                        <li>Een <a href="update_page.php">update</a> over de website toevoegen / verwijderen</li>
                                        <li>Nieuwe <a href="add_admin.php">gebruikers</a> aanmaken</li>
                                        <li>Huidige <a href="current_admins_page.php">gebruikers</a> bewerken / verwijderen</li>
                                        <?php
                                        break;
                                    case ('subadmin'):
                                        ?>
                                        <li>Het <a href="songofday_page.php">nummer van de dag</a> toevoegen / verwijderen</li>
                                        <li>Een <a href="update_page.php">update</a> over de website toevoegen / verwijderen</li>
                                        <?php
                                        break;
                                    default:
                                        ?>
                                        <li>Als bezoeker kan je helaas niks binnen het systeem doen. Neem contact op met de beheerder als dat wel zo moet zijn.</li>
                                    <?php
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-lg-6"><br>
                            <p>Het laatste nummer van de dag. <a href="songofday_page.php"><i>Naar pagina</i></a></p>
                            <table class="table" style="color: black">
                                <tr>
                                    <th scope="col">Nummer</th>
                                    <th scope="col">Datum</th>
                                </tr>
                                <tbody>
                                <tr>
                                    <td scope="row"><?php echo songNameDesc ?></td>
                                    <td scope="row"><?php echo songAddedAtDesc ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6"><br>
                            <p>De laatste update op de website. <a href="update_page.php"><i>Naar pagina</i></a></p>
                            <table class="table" style="color:black">
                                <tr>
                                    <th scope="col">Titel</th>
                                    <th scope="col">Datum</th>
                                </tr>
                                <tbody style="color: black;">
                                <tr>
                                    <td><?php echo updateTitleDesc; ?></td>
                                    <td><?php echo updateAddedAtDesc; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p><i>Hier komen de statistieken van de webshop te staan!</i></p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
<?php include './_layouts/_layout-footer.phtml' ?>