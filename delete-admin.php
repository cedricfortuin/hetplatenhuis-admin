<?php
include '_layouts/_layout-nopage.phtml';
?>
            <div class="container-fluid">
                <section class="content-section" style="color: black;">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <section class="content-section" style="color: black;">
                                    <?php
                                    $sql = "DELETE FROM users WHERE USER_ID='" . $_GET["USER_ID"] . "'";

                                    if (mysqli_query($link, $sql)) {
                                        echo "<div class='col-md-10 mx-auto alert alert-success text-center'>Admin succesvol verwijderd.</div>";
                                    } else {
                                        echo "<div class='col-md-10 mx-auto alert alert-danger text-center'>" . mysqli_error($link) . " <br><h4>Neem contact op met de Administrator</h4></div>";
                                    }

                                    mysqli_close($link);

                                    ?>
                                </section>

                            </div>
                        </div>
                    </div>
            </div>

        </div>
<?php
include '_layouts/_layout-footer.phtml';
?>