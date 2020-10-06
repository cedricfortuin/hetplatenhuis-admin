<?php
/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
include 'config/config.php';
$new_sql = mysqli_query($link, "SELECT * FROM users WHERE USER_ID ='" . $_SESSION['id'] . "'");
$username = mysqli_fetch_array($new_sql);

$disabled = '';

if($username['USER_ROLE'] != 1)
{
    $disabled = 'disabled';
}

include '_layouts/_layout-header.phtml';
?>
            <section class="content-section">
                <?php
                $result = mysqli_query($link, "SELECT * FROM newsletter ORDER BY USER_ID ASC")
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                                <h3 class="text-dark mb-0">Nieuwsbrief gebruikers</h3>
                            </div>
                            <div>
                                <p>Zie hier de mensen die zijn geabonneerd op de nieuwsbrief</p>
                            </div>
                            <table class="table" style="color:black;">
                                <tr>
                                    <th scope="col">Email</th>
                                    <th scope="col">Voornaam</th>
                                    <th scope="col">Upload datum</th>
                                    <th scope="col"></th>
                                </tr>
                                <?php
                                $i = 0;
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <tbody style="color: black;">
                                <tr>
                                    <td><?php echo $row["USER_EMAIL"]; ?></td>
                                    <td><?php echo $row["USER_NAME"]; ?></td>
                                    <td><?php echo $row["USER_ADDED"]; ?></td>
                                    <td><a
                                           href="delete-admin.php?USER_EMAIL=<?php echo $row["USER_EMAIL"]; ?>">Verwijderen</a>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                                <h3 class="text-dark mb-0">Mail aanmaken</h3>
                            </div>
                            <div>
                                <p>Stuur een nieuwe mail naar de mensen</p>
                            </div>
                            <div class="form">
                                <form action="send-new-mail.php" method="post">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputName">Onderwerp</label>
                                            <input type="text" class="form-control" name="mail-subject" id="inputName"
                                                   autocomplete="off" <?php echo $disabled ?>>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputArtist">Jouw naam</label>
                                            <select class="form-control" name="admin-name"
                                                    id="inputArtist" autocomplete="off" <?php echo $disabled ?>>
                                                <?php
                                                $admin = mysqli_query($link, "SELECT USER_FIRSTNAME FROM users ORDER BY USER_ID ASC");
                                                $i = 0;
                                                while ($admin_item = mysqli_fetch_array($admin)) {
                                                ?>
                                                <option value="<?php echo $admin_item["USER_FIRSTNAME"]?>" name="<?php echo $admin_item["USER_FIRSTNAME"]?>"><?php echo $admin_item["USER_FIRSTNAME"]?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="inputCompany">Bericht</label>
                                            <textarea type="text" class="form-control" name="mail-text"
                                                      id="inputCompany" autocomplete="off" style="resize: vertical; min-height: 100px; max-height: 250px;" <?php echo $disabled ?>></textarea>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary disabled" <?php echo $disabled ?>>Versturen</button>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
<?php include '_layouts/_layout-footer.phtml' ?>
