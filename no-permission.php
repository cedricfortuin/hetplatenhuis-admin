<?php include '_layouts/_layout-nopage.phtml';
include_once 'config/config.php';
$result = mysqli_query($link, "SELECT * FROM users WHERE USER_ID='" . $_SESSION['id'] . "'");
$row = mysqli_fetch_array($result);
?>
    <div class="container-fluid">
        <section class="content-section" style="color: black;">
            <div class="container">
            </div>
            <section class="content-section">
                <?php ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <p class="alert alert-danger text-center">
                                Whoops, deze pagina is blijkbaar geblokkeerd.
                                Ga terug naar het dashboard en probeer een andere pagina. (403)
                            </p>
                        </div>
                        <div class="col-md-3 mx-auto text-center">
                            <img src="./assets/img/functional/enable-sound.png" class="img-profile"
                                 style="height: 25%;margin:0;padding:0;filter: opacity(30%)">
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </div>
<?php include './_layouts/_layout-footer.phtml' ?>