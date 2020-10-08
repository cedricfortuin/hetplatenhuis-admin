<?php
// Initialize the session

/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

session_start();
include 'config/config.php';
$new_sql = mysqli_query($ConnectionLink,  "SELECT * FROM users WHERE USER_ID ='". $_SESSION['id'] ."'");
$username = mysqli_fetch_array($new_sql);

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$UPDATE_SUCCESS = false;
if (isset($_GET['UPDATE_SUCCESS']))
{
    $UPDATE_SUCCESS = true;
} elseif (!isset($_GET['UPDATE_SUCCESS']))
{
    $UPDATE_SUCCESS = false;
} else {
    $UPDATE_SUCCESS = false;
}

$DELETE_SUCCESS = false;
if (isset($_GET['DELETE_SUCCESS']))
{
    $DELETE_SUCCESS = true;
} elseif (!isset($_GET['DELETE_SUCCESS']))
{
    $DELETE_SUCCESS = false;
} else {
    $DELETE_SUCCESS = false;
}



if($username['USER_ROLE'] === 'visitor')
{
    $disabled = 'disabled';
} else {
    $disabled = '';
}

// Get the total number of records from our table "students".
$total_pages = $ConnectionLink->query('SELECT * FROM collection')->num_rows;
$num_results_on_page = 4;
// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

include '_layouts/_layout-header.phtml';

if ($stmt = $ConnectionLink->prepare('SELECT * FROM collection ORDER BY RECORD_ID DESC LIMIT ?,?')) {
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
                if ($UPDATE_SUCCESS) { ?>
                    <p class="alert alert-success alert-dismissible fade show">De plaat is succesvol toegevoegd!
                        <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                    </p>
                <?php }
                if ($DELETE_SUCCESS) { ?>
                    <p class="alert alert-success alert-dismissible fade show">De plaat is succesvol verwijderd!
                        <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                    </p>
                <?php }
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-row col-6 text-center">
                            <div class="form-group justify-content-end">
                                <?php echo 'Aantal platen in collectie: ' .  $ConnectionLink->query('SELECT * FROM collection')->num_rows . " platen."?>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="color: black;">
                                <tr>
                                    <th>Album</th>
                                    <th>Band/artiest</th>
                                    <th>Eigenaar</th>
                                    <th></th>
                                </tr>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['RECORD_NAME']; ?></td>
                                        <td><?php echo $row['RECORD_ARTIST']; ?></td>
                                        <td><?php echo $row['RECORD_OWNER']; ?></td>
                                        <?php
                                        if ($username['USER_ROLE'] !== 'visitor')
                                        { ?>
                                            <td><a
                                                    href="delete_record.php?RECORD_ID=<?php echo $row["RECORD_ID"] ?>">Verwijderen</a>
                                            </td>
                                        <?php }
                                        ?>
                                    </tr>
                                <?php endwhile; ?>
                            </table>
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
                                           href="collection.php?page=<?php echo $page - 1 ?>">Vorige</a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                    <li class="next">
                                        <a class="btn btn-outline-primary harry"
                                           href="collection.php?page=<?php echo $page + 1 ?>">Volgende</a>
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
                        <h3 class="text-dark mb-0">In onze collectie</h3>
                    </div>
                    <div>
                        <p>Voeg hier een nieuwe plaat toe aan de collectie.</p>
                    </div>
                    <div class="form">
                        <form action="add_to_collection.php" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputName">Naam van de plaat</label>
                                    <input type="text" class="form-control" name="record_name" id="inputName"
                                           autocomplete="off" <?php echo $disabled ?>>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputArtist">Band of Artiest</label>
                                    <input type="text" class="form-control" name="record_artist"
                                           id="inputArtist" autocomplete="on" <?php echo $disabled ?>>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputOwner">Eigenaar</label>
                                    <input type="text" class="form-control" name="record_owner"
                                              id="inputOwner" autocomplete="off" <?php echo $disabled ?>>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-primary" <?php echo $disabled ?>>Toevoegen</button>
                            <br><br>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>
    </div>
    <?php
    $stmt->close();
}

include './_layouts/_layout-footer.phtml' ?>
