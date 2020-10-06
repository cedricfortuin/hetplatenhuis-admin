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

$UPDATE_SUCCESS = false;
if (isset($_GET['UPDATE_SUCCESS']))
{
    $UPDATE_SUCCESS = true;
} elseif (!isset($_GET['UPDATE_SUCCESS']))
{
    $UPDATE_SUCCESS = false;
} else {
    $UPDATE_SUCCESS = false;
}

$ADD_SUCCESS = false;
if (isset($_GET['ADD_SUCCESS']))
{
    $ADD_SUCCESS = true;
} elseif (!isset($_GET['ADD_SUCCESS']))
{
    $ADD_SUCCESS = false;
} else {
    $ADD_SUCCESS = false;
}

$DELETE_SUCCESS = false;
if (isset($_GET['DELETE_SUCCESS']))
{
    $DELETE_SUCCESS = true;
} elseif (!isset($_GET['DELETE_SUCCESS']))
{
    $DELETE_SUCCESS = false;
} else {
    $DELETE_SUCCESS = false;
}


$result = mysqli_query($link, "SELECT * FROM users ORDER BY USER_ID ASC");
if($username['USER_ROLE'] === 'visitor')
{
    $disabled = 'disabled';
} else {
    $disabled = '';
}

include '_layouts/_layout-header.phtml';
?>
            <section class="content-section">
                <div class="container">
                    <?php
                    if ($UPDATE_SUCCESS)
                        { ?>
                            <p class="alert alert-success alert-dismissible">De gebruiker is succesvol aangepast!<button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button></p>
                       <?php }
                    if ($ADD_SUCCESS)
                    { ?>
                        <p class="alert alert-success alert-dismissible">De gebruiker is succesvol toegevoegd!<button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button></p>
                    <?php }
                    if ($DELETE_SUCCESS) { ?>
                        <p class="alert alert-success alert-dismissible">De beheerder is succesvol verwijderd!
                            <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                        </p>
                    <?php }
                    ?>
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
                                        if ($username['USER_ROLE'] === 'admin') {
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
                                        <td class="text-center"><?php $user_role = $row['USER_ROLE'];
                                            switch ($user_role) {
                                                case "admin":
                                                    echo '<i class="fas fa-user-lock" id="admin"></i>';
                                                    break;
                                                case "subadmin":
                                                    echo '<i class="fas fa-user-check" id="subadmin"></i>';
                                                    break;
                                                case "visitor":
                                                    echo '<i class="fas fa-eye" id="visitor"></i>';
                                            } ?></td>
                                        <td></td>
                                        <td></td>
                                        <?php
                                        $showAlert = false;
                                        if($username['USER_ROLE'] === 'admin')
                                        { ?>
                                            <td><a
                                                        href="edit-profiles.php?USER_ID=<?php echo $row["USER_ID"]; ?>">Bewerken</a></td>
                                            <td><a
                                                        href="delete-admin.php?USER_ID=<?php echo $row["USER_ID"]; ?>">Verwijderen</a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $i++;
                                    }
                                    if ($username['USER_ROLE'] === 'visitor' || $username['USER_ROLE'] === 'subadmin'){
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