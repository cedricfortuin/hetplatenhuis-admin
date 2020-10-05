<?php include '_layouts/_layout-nopage.phtml';
?>
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                <div class="container-fluid">
                    <button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i
                            class="fas fa-bars"></i></button>
                    <ul class="nav navbar-nav flex-nowrap ml-auto">
                        <div class="d-none d-sm-block topbar-divider"></div>
                        <li class="nav-item dropdown no-arrow" role="presentation">
                            <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link"
                                                                       data-toggle="dropdown" aria-expanded="false"
                                                                       href="#"><span
                                        class="d-none d-lg-inline mr-2 text-center text-gray-600 small"><?php echo "Welkom " . $_SESSION['username']; ?><p
                                            id="time-home"></p></span></a>
                                <div
                                    class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu">
                                    <a class="dropdown-item" role="presentation" href="own-profile.php"><i
                                            class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profiel</a>
                                    <a
                                        class="dropdown-item" role="presentation" href="update-maker.php"><i
                                            class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Updates</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" role="presentation" href="logout.php"><i
                                            class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
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