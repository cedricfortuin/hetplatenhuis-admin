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
                                    <div class="login-form <?php echo $disabled?>">
                                        <div class="d-sm-flex justify-content-between align-items-center mb-4">
                                            <h3 class="text-dark mb-0">Gebruiker aanpassen</h3>
                                        </div>
                                        <div>
                                            <p><?php echo 'Je staat op het punt om <i>' . $_GET['USER_FIRSTNAME'] . '</i> aan te passen. Dit heeft effect in de database!'?></p>
                                        </div>
                                        <form action="edit-profiles-handler.php?USER_ID=<?php echo $_GET['USER_FIRSTNAME'];?>" method="post">
                                            <?php
                                            $result = mysqli_query($link,"SELECT * FROM users WHERE USER_FIRSTNAME='" . $_GET['USER_FIRSTNAME'] . "'");
                                            $row= mysqli_fetch_array($result);

                                            $_SESSION['user-edit'] = $_GET['USER_FIRSTNAME'];
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
                                                    <select id="userrole" class="form-control" name="userrole-edit">
                                                        <option class="nav-item" value="admin">Administrator</option>
                                                        <option class="nav-item" value="subadmin">Beheerder</option>
                                                        <option class="nav-item" value="visitor">Bezoeker</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input id="email" type="text" name="email-edit" autocomplete="off" class="form-control" value="<?php echo $row['USER_EMAIL']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="<?php echo $_GET['USER_FIRSTNAME'] . ' bewerken'?>">
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