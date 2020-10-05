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
                                    <h3 class="text-dark mb-0">Post aanpassen</h3>
                                </div>
                                <form action="post-edit-handler.php" method="post">
                                    <?php
                                    $result = mysqli_query($link, "SELECT * FROM posts WHERE POST_ID='" . $_GET['POST_ID'] . "'");
                                    $row = mysqli_fetch_array($result);

                                    $_SESSION['post-edit'] = $_GET['POST_ID'];
                                    ?>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="firstname">Titel</label>
                                            <input id="firstname" type="text" name="title-edit" autocomplete="off"
                                                   class="form-control"
                                                   value="<?php echo $row['POST_TITLE']; ?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="lastname">Auteur</label>
                                            <input id="lastname" type="text" name="author-edit" autocomplete="off"
                                                   class="form-control"
                                                   value="<?php echo $row['POST_TEXT']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-8">
                                            <label for="username">Text</label>
                                            <textarea id="username" style="height: auto;" type="text" name="text-edit"
                                                      autocomplete="off" class="form-control"
                                                      required><?php echo $row['POST_AUTHOR']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" value='Post bewerken'>
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