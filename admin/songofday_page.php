<?php
/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */
include '_layouts/_layout-header.phtml';

// Get the total number of records from our table "students".
$num_results_on_page = $getConfigDataSOTDList['CONFIG_VALUE'];
// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
if ($stmt = $ConnectionLink->prepare('SELECT * FROM songofday ORDER BY SONG_ID DESC LIMIT ?,?')) {
    // Calculate the page to get the results we need from our table.
    $calc_page = ($page - 1) * $num_results_on_page;
    $stmt->bind_param('ii', $calc_page, $num_results_on_page);
    $stmt->execute();
    // Get the results...
    $result = $stmt->get_result();?>

    <div class="container-fluid">
        <section class="content-section">
            <div class="container">
                <?php
                if(isset($_GET['SHOW_ALERT']))
                {
                    $showAlert = $_GET['SHOW_ALERT'];
                    switch ($showAlert)
                    {
                        case 'ON_SUBMIT': ?>
                            <p class="alert alert-success alert-dismissible fade show">Het nummer is succesvol toegevoegd!
                                <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                            </p>
                        <?php
                        break;
                        case 'ON_DELETE': ?>
                            <p class="alert alert-success alert-dismissible fade show">Het nummer is succesvol verwijderd!
                                <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                            </p>
                        <?php
                        break;
                        case 'ON_ERROR': ?>
                            <p class="alert alert-danger alert-dismissible fade show">Er is iets fout gegaan, probeer het later opnieuw.
                                <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                            </p>
                        <?php
                        break;
                    }
                }
                if ($isDisabledForVisitors){
                    echo '<div><p crelass="alert alert-warning text-center alert-dismissible fade show">Je mag helaas de nummers niet verwijderen.<button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button></p></div>';
                }
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-row col-6 text-center">
                            <div class="form-group justify-content-end">
                                <p>Aantal nummers van de dag: <?php echo $total_pages?> nummers</p>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <?php include '_layouts/_layout-songofday-list.phtml';?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mx-auto">
                        <style>
                            .harry {
                                margin-left: 5px;
                                margin-right: 5px;
                            }
                        </style>
                        <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                            <ul class="pagination list-group list-group-horizontal text-center">
                                <?php if ($page > 1): ?>
                                    <li class="prev">
                                        <a class="btn btn-outline-primary harry"
                                           href="songofday_page.php?page=<?php echo $page - 1 ?>">Vorige</a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                    <li class="next">
                                        <a class="btn btn-outline-primary harry"
                                           href="songofday_page.php?page=<?php echo $page + 1 ?>">Volgende</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <hr>
        <section class="content-section" style="color: black;">
            <div class="container">
                <div class="col-md-12 mx-auto">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Nummer van de dag</h3>
                    </div>
                    <div>
                        <p>Voeg hier een nieuw nummer van de dag toe</p>
                    </div>
                    <div class="form">
                        <?php

                        if (!$isDisabledForVisitors) {
                            ?>
                        <form action="" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputName">Naam</label>
                                    <input type="text" class="form-control" name="song" id="inputName" value="<?php echo (isset($song_name)) ? $song_name : '';?>"
                                           autocomplete="off" <?= ($isDisabledForVisitors) ? 'disabled' : '' ?> required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputArtist">Band of Artiest</label>
                                    <input type="text" class="form-control" name="band" value="<?php echo (isset($song_artist)) ? $song_artist : '';?>"
                                           id="inputArtist" autocomplete="on" <?= ($isDisabledForVisitors) ? 'disabled' : '' ?> required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail">Spotify link voor de preview</label>
                                    <textarea style="resize: none;" type="text" class="form-control"
                                              name="spotify"
                                              placeholder="Spotify > rechtermuisknop op nummer > delen > Embed-code kopiëren > hierin plaatsen"
                                              id="inputEmail"
                                              autocomplete="off" <?= ($isDisabledForVisitors) ? 'disabled' : '' ?> required><?php echo (isset($spotify_link)) ? $spotify_link : '';?></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-primary" <?= ($isDisabledForVisitors) ? 'disabled' : '' ?> name="addSongOfDay">Toevoegen</button>
                            <br><br>
                        </form>
                        <?php
                        } else {
                            ?>
                                <p class="alert alert-warning text-center">Je hebt niet de bevoegdheden voor deze functie.</p>
                        <?php
                        }?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
    <?php
    $stmt->close();
}

include './_layouts/_layout-footer.phtml';

    if (isset($_REQUEST['addSongOfDay']))
    {
        // Escape the values for security.
        $song_name = mysqli_real_escape_string($ConnectionLink, $_POST['song']);
        $song_artist = mysqli_real_escape_string($ConnectionLink, $_POST['band']);
        $spotify_link = mysqli_real_escape_string($ConnectionLink, $_POST['spotify']);

        // Insert the data into the database.
        $sql = "INSERT INTO songofday (SONG_NAME, SONG_ARTIST, SPOTIFY_LINK) VALUES ('$song_name', '$song_artist', '$spotify_link')";
        if (mysqli_query($ConnectionLink, $sql)) {
            echo "<script>window.location.href='songofday_page.php?SHOW_ALERT=ON_SUBMIT'</script>";
        } else {
            echo "<script>window.location.href='songofday_page.php?SHOW_ALERT=ON_ERROR'</script>";
        }

        // Close connection.
        $ConnectionLink->close();
    }

?>
