<?php include '_layouts/_layout-nopage.phtml';?>
            <div class="container-fluid">
                <section class="content-section" style="color: black;">
                    <div class="container">
                        <div class="col-md-12 mx-auto">
                        </div>
                    </div>
                    <section class="content-section">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="login-form">
                                        <div class="d-sm-flex justify-content-between align-items-center mb-4">
                                            <h3 class="text-dark mb-0">Gebruiker aanpassen</h3>
                                        </div>
                                        <form action="" method="post">
                                            <?php
                                            $setAdminForEdit = mysqli_fetch_array($ConnectionLink->query("SELECT * FROM users WHERE USER_ID='" . $_GET['USER_ID'] . "'"));
                                            ?>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="firstname">Voornaam</label>
                                                    <input id="firstname" type="text" name="firstname-edit" autocomplete="off" class="form-control" value="<?php echo $setAdminForEdit['USER_FIRSTNAME']; ?>" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="lastname">Achternaam</label>
                                                    <input id="lastname" type="text" name="lastname-edit" autocomplete="off" class="form-control" value="<?php echo $setAdminForEdit['USER_LASTNAME']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-8">
                                                    <label for="username">Gebruikersnaam</label>
                                                    <input id="username" type="text" name="username-edit" autocomplete="off" class="form-control" value="<?php echo $setAdminForEdit['USERNAME']; ?>" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="userrole">Gebruikersrol</label>
                                                    <select id="userrole" class="form-control <?= ($isDisabledForVisitors) ? 'disabled' : '' ?>" name="userrole-edit">
                                                        <option class="nav-item" value="admin" <?= ($setAdminForEdit['USER_ROLE'] === 'admin') ? 'selected':''; ?>>Administrator</option>
                                                        <option class="nav-item" value="subadmin" <?= ($setAdminForEdit['USER_ROLE'] === 'subadmin') ? 'selected':''; ?>>Beheerder</option>
                                                        <option class="nav-item" value="visitor" <?= ($setAdminForEdit['USER_ROLE'] === 'visitor') ? 'selected':''; ?>>Bezoeker</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input id="email" type="text" name="email-edit" autocomplete="off" class="form-control" value="<?php echo $setAdminForEdit['USER_EMAIL']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary <?= ($isDisabledForVisitors) ? 'disabled' : '' ?>" value="<?php echo $setAdminForEdit['USER_FIRSTNAME'] . ' bewerken'?>" name="updateAdmin">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </div>
        </div>
<?php include '_layouts/_layout-footer.phtml';

if(isset($_POST['updateAdmin'])) {
    // Escape user inputs for security
    $first_name = mysqli_real_escape_string($ConnectionLink, $_POST['firstname-edit']);
    $last_name = mysqli_real_escape_string($ConnectionLink, $_POST['lastname-edit']);
    $username = mysqli_real_escape_string($ConnectionLink, $_POST['username-edit']);
    $user_role = mysqli_real_escape_string($ConnectionLink, $_POST['userrole-edit']);
    $email = mysqli_real_escape_string($ConnectionLink, $_POST['email-edit']);

    // Attempt insert query execution
    $sql = "UPDATE users SET USERNAME =  '" . $username . "' , USER_FIRSTNAME = '" . $first_name . "', USER_ROLE = '" . $user_role . "', USER_LASTNAME = '" . $last_name . "', USER_EMAIL = '" . $email . "'  WHERE USER_ID = '" . $_GET['USER_ID'] . "'";
    if (mysqli_query($ConnectionLink, $sql)) {
        echo "<script>window.location.href='current_admins_page.php?SHOW_ALERT=ON_EDIT'</script>";
    } else {
        echo "<script>window.location.href='current_admins_page.php?SHOW_ALERT=ON_ERROR'</script>";
    }

    // Close connection
    mysqli_close($ConnectionLink);
}?>