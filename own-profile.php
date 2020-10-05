<?php include '_layouts/_layout-nopage.phtml';?>
            <div class="container-fluid">
                <section class="content-section" style="color: black;">
                    <div class="container">
                        <div class="col-md-12 mx-auto">


                        </div>
                    </div>
                    <section class="content-section">
                        <?php
                        $result = mysqli_query($link,"SELECT * FROM users WHERE USER_ID='" . $_SESSION['id'] . "'");
                        $row= mysqli_fetch_array($result);

                        ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="login-form">
                                        <div class="d-sm-flex justify-content-between align-items-center mb-4">
                                            <h3 class="text-dark mb-0">Je profiel aanpassen</h3>
                                        </div>
                                        <div>
                                            <p><?php echo 'Hoi ' . $row['USER_FIRSTNAME'] . ', je kunt hier je profiel aanpassen'?></p>
                                        </div>
                                        <form action="edit-own-profile.php" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="firstname">Voornaam</label>
                                                    <input id="firstname" type="text" name="firstname-edit" autocomplete="off" class="form-control" value="<?php echo $row['USER_FIRSTNAME']; ?>" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="lastname">Achternaam</label>
                                                    <input id="lastname" type="text" name="lastname-edit" autocomplete="off" class="form-control" value="<?php echo $row['USER_LASTNAME']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="username">Gebruikersnaam</label>
                                                    <input id="username" type="text" name="username-edit" autocomplete="off" class="form-control" value="<?php echo $row['USERNAME']; ?>" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="email">Email</label>
                                                    <input id="email" type="text" name="email-edit" autocomplete="off" class="form-control" value="<?php echo $row['USER_EMAIL']; ?>" required>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-outline-primary" value="Je profiel bewerken">
                                            </div>
                                            <p><i>Helaas kun je niet je eigen wachtwoord aanpassen</i></p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </div>
        </div>
<?php include '_layouts/_layout-footer.phtml' ?>