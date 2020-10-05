<?php include '_layouts/_layout-nopage.phtml';?>
            <div class="container-fluid">
                <section class="content-section" style="color: black;">
                    <?php
                    // Check connection
                    if ($link === false) {
                        die("ERROR: Could not connect. " . mysqli_connect_error());
                    }

                    // Escape user inputs for security
                    $first_name = mysqli_real_escape_string($link, $_REQUEST['song']);
                    $last_name = mysqli_real_escape_string($link, $_REQUEST['band']);
                    $spotify_link = mysqli_real_escape_string($link, $_REQUEST['spotify']);
                    $song_reason = mysqli_real_escape_string($link, $_REQUEST['reason']);

                    // Attempt insert query execution
                    $sql = "INSERT INTO songofday (SONG_NAME, SONG_ARTIST, SPOTIFY_LINK, SONG_REASON) VALUES ('$first_name', '$last_name', '$spotify_link', '$song_reason')";
                    if (mysqli_query($link, $sql)) {
                        echo "<div class='col-md-10 mx-auto alert alert-success text-center'>Het nummer is succesvol toegevoegd. Ga terug.</div>";
                    } else {
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }

                    // Close connection
                    mysqli_close($link);
                    ?>
                </section>
            </div>
        </div>
<?php include '_layouts/_layout-footer.phtml' ?>