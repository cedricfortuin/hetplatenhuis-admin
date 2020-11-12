<?php
/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */
//include 'collect_all_datahandlers.php';
include '_layouts/_layout-nopage.phtml';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$uuid = $_GET['page_uuid'];
$album_name = $release = $present =  '';
$album_name_err = $release_err = $present_err = '';

$getPageDataArray = $ConnectionLink->query("SELECT * FROM artist_info WHERE ARTIST_UUID = '$uuid'")->fetch_array();

if (isset($_REQUEST['addData'])) {

    if (empty(trim($_POST['album_name']))) {
        $album_name_err = 'is-invalid';
    } else {
        $album_name = mysqli_escape_string($ConnectionLink, $_POST['album_name']);
    }

    if (empty(trim($_POST['release']))) {
        $release_err = 'is-invalid';
    } else {
        $release = mysqli_escape_string($ConnectionLink, $_POST['release']);
    }

    $present = mysqli_escape_string($ConnectionLink, $_POST['is_present']);
    $date = date('Y/m/d H:i:s');


    $query = "INSERT INTO discography (ARTIST_UUID, DISCO_ALBUM_TITLE, DISCO_ALBUM_RELEASE_YEAR, DISCO_ALBUM_IS_PRESENT, DISCO_ALBUM_DATE_ADDED)
                VALUES ('$uuid', '$album_name', '$release', '$present', '$date')";

    if (empty($album_name_err) && empty($release_err) && empty($present_err)) {
        if (mysqli_query($ConnectionLink, $query)) {
            echo "<script>window.location.href = 'current_artists_page.php'</script>";
        } else {
            echo "Error";
        }
    }
}
?>
<div class="container-fluid">
    <section class="content-section">
        <div class="container">
            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                <h3 class="text-dark mb-0">Album aan <?php echo $getPageDataArray['ARTIST_NAME']; ?> toevoegen</h3>
            </div>
            <div class="row mt-4 mx-auto">
                <div class="col-md-12">
                    <div class="card-body form">
                        <form method="post" action="" enctype='multipart/form-data'>
                            <label for="editFirstname">Naam van album:</label>
                            <input id="editFirstname" class="form-control <?php echo $album_name_err?>" name="album_name">
                            <p class="invalid-feedback">Dit veld is verplicht.</p><br/>

                            <label for="editFirstname">Jaar van uitkomst:</label>
                            <input id="editFirstname" class="form-control <?php echo $release_err?>" name="release">
                            <p class="invalid-feedback">Dit veld is verplicht.</p><br>

                            <div class="form-row">
                                <div class="form-group col-md-3 align-self-end">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input <?php echo $present_err?>" type="radio" id="inlineCheckbox1" value="Y" name="is_present">
                                        <label class="form-check-label" for="inlineCheckbox1">In collectie</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input <?php echo $present_err?>" type="radio" id="inlineCheckbox2" value="N" name="is_present">
                                        <label class="form-check-label" for="inlineCheckbox2">Niet in collectie</label>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group text-center mt-2">
                                <input type="submit" class="btn btn-outline-primary col-md-12" name="addData" value="Updaten">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include '_layouts/_layout-footer.phtml';?>
