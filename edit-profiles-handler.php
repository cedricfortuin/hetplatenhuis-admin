<?php
include '_layouts/_layout-nopage.phtml';?>
            <div class="container-fluid">
                <section class="content-section" style="color: black;">
                    <?php

                    // Check connection
                    if ($link === false) {
                        die("ERROR: Could not connect. " . mysqli_connect_error());
                    }

                    // Escape user inputs for security
                    $first_name = mysqli_real_escape_string($link, $_REQUEST['firstname-edit']);
                    $last_name = mysqli_real_escape_string($link, $_REQUEST['lastname-edit']);
                    $username = mysqli_real_escape_string($link, $_REQUEST['username-edit']);
                    $user_role = mysqli_real_escape_string($link, $_REQUEST['userrole-edit']);
                    $email = mysqli_real_escape_string($link, $_REQUEST['email-edit']);

                    // Attempt insert query execution
                    $sql = "UPDATE users SET USERNAME =  '".$username."' , USER_FIRSTNAME = '".$first_name."', USER_ROLE = '".$user_role. "', USER_LASTNAME = '".$last_name."', USER_EMAIL = '".$email."'  WHERE USER_FIRSTNAME = '". $_SESSION['user-edit'] ."'";
                    if (mysqli_query($link, $sql)) {
                        echo "<div class='col-md-10 mx-auto alert alert-success text-center'>" . $_SESSION['user-edit'] . " is succesvol gewijzigd! Ga terug.</div>";
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