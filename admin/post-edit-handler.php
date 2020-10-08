<?php include '_layouts/_layout-nopage.phtml';
?>
            <div class="container-fluid">
                <section class="content-section" style="color: black;">
                    <?php
                    // Check connection
                    if ($ConnectionLink === false) {
                        die("ERROR: Could not connect. " . mysqli_connect_error());
                    }


                    ?>
                </section>
            </div>
        </div>
    <?php include '_layouts/_layout-footer.phtml' ?>