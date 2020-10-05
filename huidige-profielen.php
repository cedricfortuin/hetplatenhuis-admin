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

$result = mysqli_query($link, "SELECT * FROM users ORDER BY USER_ID ASC");

include '_layouts/_layout-header.phtml';
?>
            <section class="content-section">
                <div class="container">
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
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <?php
                                        if ($username['USER_ROLE'] == 1) {
                                            echo '<th scope="col"></th>';
                                            echo '<th scope="col"></th>';
                                        }

                                        ?>
                                    </tr>
                                    <?php
                                    $i = 0;
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <tbody style="color: black;">
                                    <tr>
                                        <td><a href="mailto:<?php echo $row["USER_EMAIL"]; ?>"><?php echo $row["USER_EMAIL"]; ?></a></td>
                                        <td><?php echo $row["USER_FIRSTNAME"]; ?></td>
                                        <td><?php echo $row["USERNAME"]; ?></td>
                                        <td></td>
                                        <td></td>
                                        <?php
                                        $showAlert = false;
                                        if($username['USER_ROLE'] == 1)
                                        { ?>
                                            <td><a
                                                        href="edit-profiles.php?USER_FIRSTNAME=<?php echo $row["USER_FIRSTNAME"]; ?>">Bewerken</a></td>
                                            <td><a
                                                        href="delete-admin.php?USER_ID=<?php echo $row["USER_ID"]; ?>">Verwijderen</a>
                                            </td>
                                        <?php } else {
                                            $showAlert = true;
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                    $i++;
                                    }
                                    if ($showAlert){
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