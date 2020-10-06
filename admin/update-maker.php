<?php
// Initialize the session

/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
include 'config/config.php';
$new_sql = mysqli_query($link, "SELECT * FROM users WHERE USER_ID ='" . $_SESSION['id'] . "'");
$username = mysqli_fetch_array($new_sql);

if($username['USER_ROLE'] == 3)
{
    header('location: no-permission.php');
    exit;
}

include '_layouts/_layout-header.phtml';
?>
            <section class="content-section" style="color: black;">
                <div class="container">
                    <div class="col-md-12 mx-auto">
                        <div class="d-sm-flex justify-content-between align-items-center mb-4">
                            <h3 class="text-dark mb-0">Updates</h3>
                        </div>
                        <div>
                            <p>Zie hier de huidige updates op de site</p>
                        </div>
                        <div class="form">
                            <form action="inject-blogpost.php" method="post">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputName">Titel</label>
                                        <input type="text" class="form-control" name="title" id="inputName"
                                               autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputCompany">Auteur</label>
                                        <input type="text" class="form-control" name="author" id="inputCompany"
                                               autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail">Tekst om weer te geven</label>
                                        <textarea style="resize: none;height: 200px;" type="text" class="form-control" name="text"
                                                  id="inputEmail" autocomplete="off"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-outline-primary">Uploaden</button>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <br><br>
            <section class="content-section">
                <?php
                $result = mysqli_query($link, "SELECT * FROM posts ORDER BY POST_ID DESC")
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <table class="table" style="color:black;">
                                <tr>
                                    <th scope="col">Titel</th>
                                    <th scope="col">Tekst</th>
                                    <th scope="col">Datum</th>
                                    <th scope="col">Auteur</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                                <?php
                                $i = 0;
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <tbody style="color: black">
                                <tr>
                                    <td><?php echo $row["POST_TITLE"]; ?></td>
                                    <td><?php echo $row["POST_AUTHOR"]; ?></td>
                                    <td><?php echo $row["UPLOAD_DATE"]; ?></td>
                                    <td><?php echo $row["POST_TEXT"]; ?></td>
                                    <td><a
                                                href="edit-posts.php?POST_ID=<?php echo $row["POST_ID"]; ?>">Bewerken</a>
                                    </td>
                                    <td><a
                                           href="delete-posts.php?POST_ID=<?php echo $row["POST_ID"]; ?>">Verwijderen</a>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
<?php include '_layouts/_layout-footer.phtml' ?>