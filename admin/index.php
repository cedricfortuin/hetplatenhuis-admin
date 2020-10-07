<?php
// Initialize the session

/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

session_start();
include 'config/config.php';
$new_sql = mysqli_query($link, "SELECT * FROM users WHERE USER_ID ='" . $_SESSION['id'] . "'");
$username = mysqli_fetch_array($new_sql);

$user_role = $username['USER_ROLE'];
switch ($user_role) {
    case "admin":
        $role = 'administrator';
        break;
    case "subadmin":
        $role = 'beheerder';
        break;
    case "visitor":
        $role = 'bezoeker';
}

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
include '_layouts/_layout-header.phtml';
?>
        <div class="container-fluid">
            <section class="content-section" style="color: black;">
                <div class="container">
                    <p class="alert alert-primary">De adminomgeving is vernieuwd! Kijk gauw rond!</p>
                    <div class="row">

                        <div class="col-md-8">
                            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                                <h3 class="text-dark mb-0">Dashboard</h3>
                            </div>
                            <p><?php echo "Welkom " . $username['USER_FIRSTNAME']; ?> bij het admin-paneel. Hier kun je
                                als <?php echo $role?> het volgende doen: </p>
                            <?php
                            if ($username['USER_ROLE'] !== 'visitor') { ?>
                                <ul>
                                    <li>Het <a href="songofday.php">nummer van
                                            de dag</a>
                                        toevoegen / verwijderen
                                    </li>
                                    <li>Een <a href="update-maker.php">update</a> over de
                                        website
                                        toevoegen / verwijderen
                                    </li>
                                    <?php
                                    if ($username['USER_ROLE'] === 'visitor' || $username['USER_ROLE'] === 'subadmin') {
                                        echo '<li>Je hebt helaas niet de bevoegdheden om gebruikers toe te voegen of te wijzigen</li>';
                                    } else {
                                        ?>
                                        <li>Nieuwe <a href="toevoegen.php">gebruikers</a> aanmaken</li>
                                        <li>Huidige <a href="huidige-profielen.php">gebruikers</a> bewerken /
                                            verwijderen
                                        </li>
                                        <?php
                                    } ?>
                                </ul>
                            <?php } else { ?>
                                <ul>
                                    <li>Als <?php echo $role?> kun je alleen dingen bekijken, niks aanpassen of toevoegen.</li>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-lg-6"><br>
                            <?php
                            $resultsong = mysqli_query($link, "SELECT * FROM songofday ORDER BY SONG_ID DESC");
                            $row = mysqli_fetch_array($resultsong);
                            ?>
                            <p>Het laatste nummer van de dag. <a href="songofday.php"><i>Naar pagina</i></a></p>
                            <table class="table" style="color: black">
                                <tr>
                                    <th scope="col">Nummer</th>
                                    <th scope="col">Datum</th>
                                </tr>
                                <tbody>
                                <tr>
                                    <td scope="row"><?php echo $row["SONG_NAME"] ?></td>
                                    <td scope="row">
                                        <?php echo $row["UPLOAD_DATE"]; ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        $result = mysqli_query($link, "SELECT * FROM posts ORDER BY POST_ID DESC");
                        ?>
                        <div class="col-lg-6"><br>
                            <p>De laatste update op de website. <a href="update-maker.php"><i>Naar pagina</i></a></p>
                            <table class="table" style="color:black">
                                <tr>
                                    <th scope="col">Titel</th>
                                    <th scope="col">Datum</th>
                                </tr>
                                <?php
                                $row = mysqli_fetch_array($result)
                                ?>
                                <tbody style="color: black;">
                                <tr>
                                    <td><?php echo $row["POST_TITLE"]; ?></td>
                                    <td><?php echo $row["UPLOAD_DATE"]; ?></td>
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