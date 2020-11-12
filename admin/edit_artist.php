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
$pageUuid = $_GET['page_uuid'];

$getPageDataArray = $ConnectionLink->query("SELECT * FROM artist_info WHERE ARTIST_UUID = '$pageUuid'")->fetch_array();

$artist_name = $about = $history = $follow = '';

if (isset($_REQUEST['updateData']) && isset($pageUuid)) {

    $artist_name = mysqli_escape_string($ConnectionLink, $_POST['artist_name']);
    $about = mysqli_escape_string($ConnectionLink, $_POST['about']);
    $history = mysqli_escape_string($ConnectionLink, $_POST['history']);
    $follow = mysqli_escape_string($ConnectionLink, $_POST['follow']);

    $name = $_FILES['file']['name'];
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    $updateSQL = "UPDATE artist_info SET ARTIST_NAME = '$artist_name', ARTIST_HEAD_TITLE = '$artist_name', ARTIST_CONTENT_ABOUT = '$about', ARTIST_CONTENT_HISTORY = '$history', ARTIST_FOLLOW_BUTTON = '$follow' WHERE ARTIST_UUID = '$pageUuid'";

    if (!empty($artist_name) && !empty($about) && !empty($history) && !empty($follow)) {
        // Select file type
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Valid file extensions
        $extensions_arr = array("jpg", "jpeg", "png", "gif");

        // Check extension
        if (in_array($imageFileType, $extensions_arr)) {

            // Convert to base64
            $image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']));
            $image = 'data:image/' . $imageFileType . ';base64,' . $image_base64;
            // Insert record
            $query = "UPDATE artist_info SET ARTIST_IMAGE = '$image' WHERE ARTIST_UUID = '$pageUuid'";
            mysqli_query($ConnectionLink, $query);

            // Upload file
            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $name);
        }

        if (mysqli_query($ConnectionLink, $updateSQL)) {
            echo "<script>window.location.href = 'edit_artist.php?page_uuid=" . $pageUuid . "'</script>";
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
                <h3 class="text-dark mb-0">Bewerk <?php echo $getPageDataArray['ARTIST_NAME']?></h3>
            </div>
            <div class="row mt-4 mx-auto">
                <div class="col-md-12">
                    <div class="card-header">
                        <img class="card-img-top" src="<?php echo $getPageDataArray['ARTIST_IMAGE']?>" alt="Image <?php echo $getPageDataArray['ARTIST_NAME']?>">
                    </div>
                    <div class="card-body form">
                        <form method="post" action="" enctype='multipart/form-data'>
                            <label for="editFirstname">Naam:</label>
                            <input id="editFirstname" class="form-control" value="<?php echo $getPageDataArray['ARTIST_NAME']?>" name="artist_name"><br/>
                            <label for="editFirstname">Over de band:</label>
                            <textarea id="editFirstname" class="form-control" name="about" style="resize: vertical; width: 100%; height: 100px;" rows="2"><?php echo $getPageDataArray['ARTIST_CONTENT_ABOUT']?></textarea><br>
                            <label for="editLastname">Geschiedenis:</label>
                            <textarea id="editLastname" class="form-control" name="history" style="resize: vertical; width: 100%; height: 100px;" rows="2"><?php echo $getPageDataArray['ARTIST_CONTENT_HISTORY']?></textarea><br>
                            <label for="editLastname">Volg knop Spotify:</label>
                            <textarea id="editLastname" class="form-control" name="follow" style="resize: none; width: 100%; height: 100px;" rows="2"><?php echo $getPageDataArray['ARTIST_FOLLOW_BUTTON']?></textarea><br>
                            <label for="editLastname">Banner:</label>
                            <input type="file" id="editLastname" class="form-control" name="file">
                            <hr/>
                            <div class="form-group text-center mt-2">
                                <input type="submit" class="btn btn-outline-primary col-md-12" name="updateData" value="Updaten">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include '_layouts/_layout-footer.phtml';?>
