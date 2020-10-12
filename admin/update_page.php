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
include 'collect_all_datahandlers.php';
include '_layouts/_layout-header.phtml';
?>
            <section class="content-section" style="color: black;">
                <div class="container">
                    <?php
                    if(isset($_GET['SHOW_ALERT']))
                    {
                        $showAlert = $_GET['SHOW_ALERT'];
                        switch ($showAlert)
                        {
                            case 'ON_SUBMIT': ?>
                                <p class="alert alert-success alert-dismissible fade show">De update is succesvol toegevoegd!
                                    <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                                </p>
                            <?php
                            break;
                            case 'ON_DELETE': ?>
                                <p class="alert alert-success alert-dismissible fade show">De update is succesvol verwijderd!
                                    <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                                </p>
                            <?php
                            break;
                            case 'ON_EDIT': ?>
                                <p class="alert alert-success alert-dismissible fade show">De update is succesvol gewijzigd!
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
                            <h3 class="text-dark mb-0">Updates</h3>
                        </div>
                        <div>
                            <p>Zie hier de huidige updates op de site</p>
                        </div>
                        <div class="form">
                            <?php

                            if (!$isDisabledForVisitors) {
                                ?>
                                <form action="" method="post">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputName">Titel</label>
                                            <input type="text" class="form-control" name="update_title" id="inputName"
                                                   autocomplete="off" <?= ($isDisabledForVisitors) ? 'disabled' : '' ?> required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputCompany">Auteur</label>
                                            <input type="text" class="form-control" name="update_author" id="inputCompany"
                                                   autocomplete="off" <?= ($isDisabledForVisitors) ? 'disabled' : '' ?> required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail">Tekst om weer te geven</label>
                                            <textarea style="resize: none;height: 200px;" type="text" class="form-control" name="update_text"
                                                      id="inputEmail" autocomplete="off" <?= ($isDisabledForVisitors) ? 'disabled' : '' ?> required></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-outline-primary" <?= ($isDisabledForVisitors) ? 'disabled' : '' ?> name="addUpdate">Uploaden</button>
                                    <br>
                                </form>
                                <?php
                            }  else {
                                ?>
                                <p class="alert alert-warning text-center">Je hebt niet de bevoegdheden voor deze functie.</p>
                                <?php
                            }?>
                        </div>
                    </div>
                </div>
            </section>
            <br><br>
            <section class="content-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <div class="table-responsive">
                                <table class="table" style="color:black;">
                                    <tr>
                                        <th scope="col">Titel</th>
                                        <th scope="col">Tekst</th>
                                        <th scope="col">Auteur</th>
                                        <th scope="col">Datum</th>
                                        <?php
                                        if (!$isDisabledForVisitors)
                                        { ?>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $i = 0;
                                    $result = mysqli_query($ConnectionLink, "SELECT * FROM updates ORDER BY UPDATE_ID DESC");
                                    while ($getUpdateForTable = mysqli_fetch_array($result)) {
                                    ?>
                                    <tbody style="color: black">
                                    <tr>
                                        <td><?php echo $getUpdateForTable["UPDATE_TITLE"]; ?></td>
                                        <td><?php echo $getUpdateForTable["UPDATE_TEXT"]; ?></td>
                                        <td><?php echo $getUpdateForTable["UPDATE_AUTHOR"]; ?></td>
                                        <td><?php echo $getUpdateForTable["UPDATE_DATE"]; ?></td>
                                        <?php
                                        if (!$isDisabledForVisitors)
                                        { ?>
                                            <td><a
                                                        href="edit_update_page.php?UPDATE_ID=<?php echo $getUpdateForTable["UPDATE_ID"]; ?>">Bewerken</a>
                                            </td>
                                            <td><a
                                                        href="delete_update_handler.php?UPDATE_ID=<?php echo $getUpdateForTable["UPDATE_ID"]; ?>">Verwijderen</a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $i++;
                                    }
                                    if ($isDisabledForVisitors){
                                        echo '<div><p class="alert alert-warning text-center alert-dismissible fade show">Je mag helaas de updates niet aanpassen of verwijderen.<button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button></p></div>';
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
<?php include '_layouts/_layout-footer.phtml';

    if (isset($_POST['addUpdate']))
    {
        // Escape the values for security.
        $update_title = mysqli_real_escape_string($ConnectionLink, $_POST['update_title']);
        $update_author = mysqli_real_escape_string($ConnectionLink, $_POST['update_author']);
        $update_text = mysqli_real_escape_string($ConnectionLink, $_POST['update_text']);

        // Insert the data into the database.
        $sql = "INSERT INTO updates (UPDATE_TITLE, UPDATE_AUTHOR, UPDATE_TEXT) VALUES ('$update_title', '$update_author', '$update_text')";
        if (mysqli_query($ConnectionLink, $sql)) {
            echo "<script>window.location.href='update_page.php?SHOW_ALERT=ON_SUBMIT'</script>";
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($ConnectionLink);
        }

        // Close connection.
        $ConnectionLink->close();
    }


?>