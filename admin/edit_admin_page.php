<?php include '_layouts/_layout-header.phtml';
$setAdminForEdit = $ConnectionLink->query("SELECT * FROM admins WHERE ADMIN_UUID='" . $_GET['admin_uuid'] . "'")->fetch_array();

$firstname = $lastname = $username = $user_role = $email = '';
$firstname_err = $lastname_err = $username_err = $user_role_err = $email_err = '';

if(isset($_POST['updateAdmin'])) {
    // Escape user inputs for security

    if (empty($_POST['firstname-edit'])) {
        $firstname_err = 'is_invalid';
    } else {
        $firstname = mysqli_real_escape_string($ConnectionLink, $_POST['firstname-edit']);
    }

    if (empty($_POST['lastname-edit'])) {
        $lastname_err = 'is_invalid';
    } else {
        $lastname = mysqli_real_escape_string($ConnectionLink, $_POST['lastname-edit']);
    }

    if (empty($_POST['username-edit'])) {
        $username_err = 'is_invalid';
    } else {
        $username = mysqli_real_escape_string($ConnectionLink, $_POST['username-edit']);
    }

    if (empty($_POST['userrole-edit'])) {
        $user_role_err = 'is_invalid';
    } else {
        $user_role = mysqli_real_escape_string($ConnectionLink, $_POST['userrole-edit']);
    }

    if (empty($_POST['email-edit'])) {
        $email_err = 'is_invalid';
    } else {
        $email = mysqli_real_escape_string($ConnectionLink, $_POST['email-edit']);
    }

    // Attempt insert query execution
    $sql = "UPDATE admins SET USERNAME =  '" . $username . "' , ADMIN_FIRSTNAME = '" . $firstname . "', ADMIN_ROLE = '" . $user_role . "', ADMIN_LASTNAME = '" . $lastname . "', ADMIN_EMAIL = '" . $email . "'  WHERE ADMIN_UUID = '" . $_GET['admin_uuid'] . "'";
    if (mysqli_query($ConnectionLink, $sql)) {
        echo "<script>window.location.href='current_admins_page.php'</script>";
    } else {
        echo "<script>window.location.href='edit_admin.php'</script>";
    }
    // Close connection
    mysqli_close($ConnectionLink);
}
?>
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
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="firstname">Voornaam</label>
                                                    <input id="firstname" type="text" name="firstname-edit" autocomplete="off" class="form-control <?php echo $firstname_err;?>" value="<?php echo $setAdminForEdit[admin_firstname]; ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="lastname">Achternaam</label>
                                                    <input id="lastname" type="text" name="lastname-edit" autocomplete="off" class="form-control <?php echo $lastname_err;?>" value="<?php echo $setAdminForEdit[admin_lastname]; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-8">
                                                    <label for="username">Gebruikersnaam</label>
                                                    <input id="username" type="text" name="username-edit" autocomplete="off" class="form-control <?php echo $username_err;?>" value="<?php echo $setAdminForEdit[admin_username]; ?>">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="userrole">Gebruikersrol</label>
                                                    <select id="userrole" class="form-control <?php echo $user_role_err;?> <?= ($isDisabledForVisitors) ? 'disabled' : '' ?>" name="userrole-edit">
                                                        <option class="nav-item" value="admin" <?= ($setAdminForEdit[admin_role] === 'admin') ? 'selected':''; ?>>Administrator</option>
                                                        <option class="nav-item" value="subadmin" <?= ($setAdminForEdit[admin_role] === 'subadmin') ? 'selected':''; ?>>Beheerder</option>
                                                        <option class="nav-item" value="visitor" <?= ($setAdminForEdit[admin_role] === 'visitor') ? 'selected':''; ?>>Bezoeker</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input id="email" type="text" name="email-edit" autocomplete="off" class="form-control <?php echo $email_err;?>" value="<?php echo $setAdminForEdit[admin_mail]; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary <?= ($isDisabledForVisitors) ? 'disabled' : '' ?>" value="<?php echo $setAdminForEdit[admin_firstname] . ' bewerken'?>" name="updateAdmin">
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
<?php include '_layouts/_layout-footer.phtml'; ?>