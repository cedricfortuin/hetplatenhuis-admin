<?php include '_layouts/_layout-nopage.phtml';?>
    <div class="container-fluid">
        <section class="content-section" style="color: black;">
            <?php
            // Check connection
            if ($link === false) {
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            // Escape user inputs for security
            $record_name = mysqli_real_escape_string($link, $_REQUEST['record_name']);
            $record_artist = mysqli_real_escape_string($link, $_REQUEST['record_artist']);
            $record_owner = mysqli_real_escape_string($link, $_REQUEST['record_owner']);

            // Attempt insert query execution
            $sql = "INSERT INTO collection (RECORD_NAME, RECORD_ARTIST, RECORD_OWNER) VALUES ('$record_name', '$record_artist', '$record_owner')";
            if (mysqli_query($link, $sql)) {
                echo "<script>window.location.href='collection.php?UPDATE_SUCCESS=true'</script>";
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