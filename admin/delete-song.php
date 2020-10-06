<?php
include '_layouts/_layout-nopage.phtml';?>
            <div class="container-fluid">
                <section class="content-section" style="color: black;">
                    <div class="container">
                        <div class="col-md-12 mx-auto">
                           <?php
                                $sql = "DELETE FROM songofday WHERE SONG_ID='" . $_GET["SONG_ID"] . "'";

                                if (mysqli_query($link, $sql)) {
                                    echo "<div class='col-md-10 mx-auto alert alert-success text-center'>Het nummer is succesvol verwijderd. Ga terug.</div>";
                                } else {
                                    echo "Oops, something went wrong: " . mysqli_error($link);
                                }

                                mysqli_close($link);
                                ?>
                        </div>
                    </div>
                    <section class="content-section">

                        <div class="container">
                            <div class="row">

                            </div>
                        </div>
                    </section>
                </section>
            </div>
        </div>
<?php
include './_layouts/_layout-footer.phtml'
?>