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
$getPageAlbumList = $ConnectionLink->query("SELECT * FROM discography WHERE ARTIST_UUID = '$uuid'");

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
            echo "<script>window.location.href = 'album_list.php?page_uuid={$uuid}'</script>";
        } else {
            echo "Error";
        }
    }
}

if (isset($_GET['action']) == 'delete') {
    $id = $_GET['id'];
//    $sql = "UPDATE discography SET DISCO_IS_DELETED = 1 WHERE DISCO_ALBUM_ID = '$id'";
    $sql = "DELETE FROM discography WHERE DISCO_ALBUM_ID = '$id'";

    if (mysqli_query($ConnectionLink, $sql)) {
        echo "<script>window.location.href = 'album_list.php?page_uuid={$uuid}'</script>";
    } else {
        echo "<script>window.location.href = 'album_list.php?page_uuid={$uuid}'</script>";
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
                    <div class="card-body table-responsive" >
                        <table class="table text-center">
                            <!--                    This section is for the discography-->
                            <thead style="color: black">
                            <tr>
                                <th scope="col">Titel</th>
                                <th scope="col">Jaar van uitkomst</th>
                                <th scope="col">In collectie</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody style="color: black">
                            <?php
                            $i = 0;
                            while ($showList = $getPageAlbumList->fetch_array()) {
                                ?>
                                <tr>
                                    <td><?php echo $showList['DISCO_ALBUM_TITLE'];?></td>
                                    <td><?php echo $showList['DISCO_ALBUM_RELEASE_YEAR'] ?></td>
                                    <?php
                                    switch ($showList['DISCO_ALBUM_IS_PRESENT']) {
                                        case ('Y'):
                                            ?>
                                            <td><i class="fa fa-check fa-fw"></i></td>
                                            <?php
                                            break;
                                        case ('N'):
                                            ?>
                                            <td><i class="fa fa-times fa-fw"></i></td>
                                            <?php
                                            break;
                                    }
                                    ?>
                                    <td><a href="album_list.php?page_uuid=<?php echo $uuid?>&&action=delete&&id=<?php echo $showList['DISCO_ALBUM_ID']?>"><i class="fa fa-trash fa-fw"></i></a></td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <div class="form">
                            <form method="post" action="" enctype='multipart/form-data'>

                                <div class="form-row">
                                    <div class="col-md-4">
                                        <input id="editFirstname" class="form-control <?php echo $album_name_err?>" name="album_name" placeholder="Naam van album:">
                                        <p class="invalid-feedback">Dit veld is verplicht.</p><br/>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="editFirstname" class="form-control <?php echo $release_err?>" name="release" placeholder="Jaar van uitkomst:">
                                        <p class="invalid-feedback">Dit veld is verplicht.</p><br>
                                    </div>
                                    <div class="col-md-2 align-self-start">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input <?php echo $present_err?>" type="radio" id="inlineCheckbox1" value="Y" name="is_present">
                                            <label class="form-check-label" for="inlineCheckbox1">In collectie</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input <?php echo $present_err?>" type="radio" id="inlineCheckbox2" value="N" name="is_present">
                                            <label class="form-check-label" for="inlineCheckbox2">Niet in collectie</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 align-self-center">
                                        <input type="submit" class="btn btn-outline-primary col-md-12" name="addData" value="Updaten">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</div>
<?php include '_layouts/_layout-footer.phtml';?>
