<?php include '_layouts/_layout-nopage.phtml';
?>
            <div class="container-fluid">
                <section class="content-section" style="color: black;">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <section class="content-section" style="color: black;">
                                    <?php
                                    $sql = "DELETE FROM posts WHERE POST_ID='" . $_GET["POST_ID"] . "'";

                                    if (mysqli_query($link, $sql)) {
                                        echo "<div class='col-md-10 mx-auto alert alert-success text-center'>De update is succesvol verwijderd.</div>";
                                    } else {
                                        echo "Oops, something went wrong: " . mysqli_error($link);
                                    }

                                    mysqli_close($link);

                                    ?>
                                </section>

                            </div>
                        </div>
                    </div>
            </div>

        </div>
<?php include '_layouts/_layout-footer.phtml' ?>