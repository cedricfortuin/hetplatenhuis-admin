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
                                        <form action="edit-profiles-handler.php?USER_ID=<?php echo $_GET['USER_ID'];?>" method="post">
                                            <?php
                                            $result = mysqli_query($link,"SELECT * FROM users WHERE USER_ID='" . $_GET['USER_ID'] . "'");
                                            $row= mysqli_fetch_array($result);
                                            ?>
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
                                                <div class="form-group col-md-8">
                                                    <label for="username">Gebruikersnaam</label>
                                                    <input id="username" type="text" name="username-edit" autocomplete="off" class="form-control" value="<?php echo $row['USERNAME']; ?>" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="userrole">Gebruikersrol</label>
                                                    <select id="userrole" class="form-control <?php echo $disabled?>" name="userrole-edit">
                                                        <option class="nav-item" value="admin" <?= ($row['USER_ROLE'] === 'admin') ? 'selected':''; ?>>Administrator</option>
                                                        <option class="nav-item" value="subadmin" <?= ($row['USER_ROLE'] === 'subadmin') ? 'selected':''; ?>>Beheerder</option>
                                                        <option class="nav-item" value="visitor" <?= ($row['USER_ROLE'] === 'visitor') ? 'selected':''; ?>>Bezoeker</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input id="email" type="text" name="email-edit" autocomplete="off" class="form-control" value="<?php echo $row['USER_EMAIL']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="<?php echo $row['USER_FIRSTNAME'] . ' bewerken'?>">
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
<?php include '_layouts/_layout-footer.phtml' ?>