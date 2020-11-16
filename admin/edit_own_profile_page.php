<?php include '_layouts/_layout-header.phtml';
?>
            <div class="container-fluid">
                <section class="content-section" style="color: black;">
                    <section class="content-section">
                        <div class="container">
                            <?php
                            if(isset($_GET['SHOW_ALERT']))
                            {
                                $showAlert = $_GET['SHOW_ALERT'];
                                switch ($showAlert)
                                {
                                    case 'ON_EDIT': ?>
                                        <p class="alert alert-success alert-dismissible fade show">Je profiel is succesvol gewijzigd!
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
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="login-form">
                                        <div class="d-sm-flex justify-content-between align-items-center mb-4">
                                            <h3 class="text-dark mb-0">Je profiel aanpassen</h3>
                                        </div>
                                        <div>
                                            <p><?php echo 'Hoi ' . $getAdminBySessionIdArray[admin_firstname] . ', je kunt hier je profiel aanpassen'?></p>
                                        </div>
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="firstname">Voornaam</label>
                                                    <input id="firstname" type="text" name="firstname-edit" autocomplete="off" class="form-control" value="<?php echo $getAdminBySessionIdArray[admin_firstname] ?>" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="lastname">Achternaam</label>
                                                    <input id="lastname" type="text" name="lastname-edit" autocomplete="off" class="form-control" value="<?php echo $getAdminBySessionIdArray[admin_lastname] ?>" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="username">Gebruikersnaam</label>
                                                    <input id="username" type="text" name="username-edit" autocomplete="off" class="form-control" value="<?php echo $getAdminBySessionIdArray[admin_username] ?>" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="email">Email</label>
                                                    <input id="email" type="text" name="email-edit" autocomplete="off" class="form-control" value="<?php echo $getAdminBySessionIdArray[admin_mail] ?>" required>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-outline-primary" value="Je profiel bewerken" name="editOwnProfile">
                                            </div>
                                            <p><i>Helaas kun je je eigen wachtwoord nog niet aanpassen.</i></p>
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

if(isset($_POST['editOwnProfile']))
{
    // Escape user inputs for security
    $first_name = mysqli_real_escape_string($ConnectionLink, $_POST['firstname-edit']);
    $last_name = mysqli_real_escape_string($ConnectionLink, $_POST['lastname-edit']);
    $username = mysqli_real_escape_string($ConnectionLink, $_POST['username-edit']);
    $email = mysqli_real_escape_string($ConnectionLink, $_POST['email-edit']);

    // Attempt insert query execution
    $sql = "UPDATE admins SET USERNAME =  '".$username."' , ADMIN_FIRSTNAME = '".$first_name."', ADMIN_LASTNAME = '".$last_name."', ADMIN_EMAIL = '".$email."'  WHERE ADMIN_ID = '". $_SESSION['id'] ."'";
    if (mysqli_query($ConnectionLink, $sql)) {
        echo "<script>window.location.href='edit_own_profile_page.php?SHOW_ALERT=ON_EDIT'</script>";
    } else {
        echo "<script>window.location.href='edit_own_profile_page.php?SHOW_ALERT=ON_ERROR'</script>";
    }

    // Close connection
    $ConnectionLink->close();
}

?>