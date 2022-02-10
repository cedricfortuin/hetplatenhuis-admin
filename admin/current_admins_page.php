<?php
// Initialize the session

/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

include '_layouts/_layout-header.phtml';


if (isset($_GET['admin_uuid'])) {
    $sql = "DELETE FROM admins WHERE ADMIN_UUID='" . $_GET["admin_uuid"] . "'";

    if (mysqli_query($ConnectionLink, $sql)) {
        echo "<script>window.location.href='current_admins_page.php'</script>";
    } else {
        echo "<script>window.location.href='current_admins_page.php'</script>";
    }
}

?>
            <section class="content-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                                <h3 class="text-dark mb-0">Admins</h3>
                            </div>
                            <div>
                                <p>Zie hier de huidige admins</p>
                            </div>
                            <div class="table-responsive">
                                <table class="table" style="color:black;">
                                    <tr>
                                        <th scope="col">Email</th>
                                        <th scope="col">Voornaam</th>
                                        <th scope="col">Gebruikersnaam</th>
                                        <th scope="col">Rol</th>
                                        <th scope="col">Wachtwoord ingesteld</th>
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
                                    while ($setAdmin = mysqli_fetch_array($getAdminArrayDesc)) {
                                    ?>
                                    <tbody style="color: black;">
                                    <tr>
                                        <td><a href="add_new_mail.php?adress=<?php echo $setAdmin[admin_mail]; ?>"><?php echo $setAdmin[admin_mail]; ?></a></td>
                                        <td><?php echo $setAdmin[admin_firstname]; ?></td>
                                        <td><?php echo $setAdmin[admin_username]; ?></td>
                                        <td class="text-center">
                                            <?php
                                            switch ($setAdmin[admin_role]) {
                                                case "admin":
                                                    echo '<i class="fas fa-user-lock" id="admin" title="Administrator"></i>';
                                                    break;
                                                case "subadmin":
                                                    echo '<i class="fas fa-user-cog" id="subadmin" title="Beheerder"></i>';
                                                    break;
                                                default:
                                                    echo '<i class="fas fa-eye" id="visitor" title="Bezoeker"></i>';
                                            } ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            switch (empty($setAdmin[admin_password])) {
                                                case true:
                                                    echo '<i class="fas fa-exclamation-triangle" title="Nog geen wachtwoord ingesteld"></i>';
                                                    break;
                                                case false:
                                                    echo '<i class="fas fa-user-shield" title="Wachtwoord ingesteld"></i>';
                                                    break;
                                            } ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <?php
                                        if(!$isDisabledForVisitorsAndSubadmins)
                                        { ?>
                                            <td>
                                                <?php
                                                if ($_SESSION['uuid'] !== $setAdmin[admin_uuid]) {
                                                    ?>
                                                        <a href="edit_admin_page.php?admin_uuid=<?php echo $setAdmin[admin_uuid]; ?>"><i class="fa fa-user-edit fa-fw"></i></a></td>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <a href="edit_own_profile_page.php"><i class="fa fa-user-edit fa-fw"></i></a></td>
                                                    <?php
                                                }
                                                ?>
                                            <td>
                                                <?php
                                                if ($_SESSION['uuid'] !== $setAdmin[admin_uuid]) {
                                                    ?>
                                                        <a href="current_admins_page.php?admin_uuid=<?php echo $setAdmin[admin_uuid]; ?>"><i class="fa fa-trash fa-fw"></i></a>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <i class="fa fa-times fa-fw"></i>
                                                    <?php
                                                }
                                                ?>
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
                                <p><a href="add_admin.php"><i class="fa fa-plus"></i> Nieuwe admin toevoegen</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
<?php include '_layouts/_layout-footer.phtml' ?>