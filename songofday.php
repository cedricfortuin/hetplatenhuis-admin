<?php
// Initialize the session

/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

session_start();
include 'config/config.php';
$new_sql = mysqli_query($link,  "SELECT * FROM users WHERE USER_ID ='". $_SESSION['id'] ."'");
$username = mysqli_fetch_array($new_sql);

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
if($username['USER_ROLE'] == 3)
{
    $disabled = 'disabled';
} else {
    $disabled = '';
}

// Get the total number of records from our table "students".
$total_pages = $link->query('SELECT * FROM songofday')->num_rows;
$num_results_on_page = 4;
// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
include '_layouts/_layout-header.phtml';
if ($stmt = $link->prepare('SELECT * FROM songofday ORDER BY SONG_ID DESC LIMIT ?,?')) {
    // Calculate the page to get the results we need from our table.
    $calc_page = ($page - 1) * $num_results_on_page;
    $stmt->bind_param('ii', $calc_page, $num_results_on_page);
    $stmt->execute();
    // Get the results...
    $result = $stmt->get_result();?>

    <div class="container-fluid">
        <section class="content-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-row col-6 text-center">
                            <div class="form-group justify-content-end">
                                <?php echo 'Aantal nummers van de dag: ' .  $link->query('SELECT * FROM songofday')->num_rows . " nummers."?>
                            </div>
                        </div>
                        <table class="table" style="color: black;">
                            <tr>
                                <th>Nummer</th>
                                <th>Band/artiest</th>
                                <th>Upload datum</th>
                                <th></th>
                            </tr>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['SONG_NAME']; ?></td>
                                    <td><?php echo $row['SONG_ARTIST']; ?></td>
                                    <td><?php echo $row['UPLOAD_DATE']; ?></td>
                                    <td><a
                                                href="delete-song.php?SONG_ID=<?php echo $row["SONG_ID"] ?>">Verwijderen</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </table>
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
                                           href="songofday.php?page=<?php echo $page - 1 ?>">Vorige</a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                    <li class="next">
                                        <a class="btn btn-outline-primary harry"
                                           href="songofday.php?page=<?php echo $page + 1 ?>">Volgende</a>
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
                        <form action="inject-songofday.php" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputName">Naam</label>
                                    <input type="text" class="form-control" name="song" id="inputName"
                                           autocomplete="off" <?php echo $disabled ?>>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputArtist">Band of Artiest</label>
                                    <input type="text" class="form-control" name="band"
                                           id="inputArtist" autocomplete="on" <?php echo $disabled ?>>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputCompany">Reden van upload</label>
                                    <textarea type="text" class="form-control" name="reason"
                                              id="inputCompany" autocomplete="off"
                                              style="resize: vertical; min-height: 100px; max-height: 250px;" <?php echo $disabled ?>></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail">Spotify Link voor het voorbeeld</label>
                                    <textarea style="resize: none;" type="text" class="form-control"
                                              name="spotify"
                                              placeholder="Spotify > rechtermuisknop op nummer > delen > Embed-code kopiëren > hierin plaatsen"
                                              id="inputEmail"
                                              autocomplete="off" <?php echo $disabled ?>></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-primary" <?php echo $disabled ?>>Updaten</button>
                            <br><br>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <?php
    $stmt->close();
}

include './_layouts/_layout-footer.phtml' ?>
