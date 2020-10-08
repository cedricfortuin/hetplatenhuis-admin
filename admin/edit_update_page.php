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
                                    <h3 class="text-dark mb-0">Update aanpassen</h3>
                                </div>
                                <form action="" method="post">
                                    <?php
                                    $getUpdateFromSelected = mysqli_fetch_array($ConnectionLink->query("SELECT * FROM updates WHERE UPDATE_ID='" . $_GET['UPDATE_ID'] . "'"));
                                    ?>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="firstname">Titel</label>
                                            <input id="firstname" type="text" name="title-edit" autocomplete="off"
                                                   class="form-control"
                                                   value="<?php echo $getUpdateFromSelected['UPDATE_TITLE']; ?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="lastname">Auteur</label>
                                            <input id="lastname" type="text" name="author-edit" autocomplete="off"
                                                   class="form-control"
                                                   value="<?php echo $getUpdateFromSelected['UPDATE_AUTHOR']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-8">
                                            <label for="username">Tekst</label>
                                            <textarea id="username" style="height: auto;" type="text" name="text-edit"
                                                      autocomplete="off" class="form-control"
                                                      required><?php echo $getUpdateFromSelected['UPDATE_TEXT']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" value='Update bewerken' name="editUpdate">
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

if (isset($_POST['editUpdate']))
{
    // Escape user inputs for security
    $title = mysqli_real_escape_string($ConnectionLink, $_POST['title-edit']);
    $author = mysqli_real_escape_string($ConnectionLink, $_POST['author-edit']);
    $text = mysqli_real_escape_string($ConnectionLink, $_POST['text-edit']);

    // Attempt insert query execution
    $sql = "UPDATE updates SET UPDATE_TITLE =  '".$title."' , UPDATE_AUTHOR = '".$author."', UPDATE_TEXT = '".$text."'  WHERE UPDATE_ID = '". $_GET['UPDATE_ID'] ."'";
    if (mysqli_query($ConnectionLink, $sql)) {
        echo "<script>window.location.href='update_page.php?SHOW_ALERT=ON_EDIT'</script>";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($ConnectionLink);
    }

    // Close connection
    $ConnectionLink->close();
}


?>