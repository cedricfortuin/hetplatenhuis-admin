<?php include '_layouts/_layout-nopage.phtml';
?>
            <div class="container-fluid">
                <section class="content-section" style="color: black;">
                    <?php
                    // Check connection
                    if ($link === false) {
                        die("ERROR: Could not connect. " . mysqli_connect_error());
                    }

                    // Escape user inputs for security
                    $title = mysqli_real_escape_string($link, $_REQUEST['title-edit']);
                    $author = mysqli_real_escape_string($link, $_REQUEST['text-edit']);
                    $text = mysqli_real_escape_string($link, $_REQUEST['author-edit']);

                    // Attempt insert query execution
                    $sql = "UPDATE posts SET POST_TITLE =  '".$title."' , POST_AUTHOR = '".$author."', POST_TEXT = '".$text."'  WHERE POST_TITLE = '". $_SESSION['post-edit'] ."'";
                    if (mysqli_query($link, $sql)) {
                        echo "<div class='col-md-10 mx-auto alert alert-success text-center'>De post is succesvol gewijzigd!</div>";
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