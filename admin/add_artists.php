<?php
/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */
include '_layouts/_layout-header.phtml';

$artist_name = $title = $uuid = $about = $history = $follow = $date = '';
$artist_name_err = $about_err = $history_err = $follow_err = $img_err = '';

if (isset($_REQUEST['addData'])) {

    if (empty(trim($_POST['artist_name']))) {
        $artist_name_err = 'is-invalid';
    } else {
        $artist_name = mysqli_escape_string($ConnectionLink, $_POST['artist_name']);
    }

    $title = mysqli_escape_string($ConnectionLink, $_POST['artist_name']);

    $uuid = uniqid();

    if (empty(trim($_POST['about']))) {
        $about_err = 'is-invalid';
    } else {
        $about = mysqli_escape_string($ConnectionLink, $_POST['about']);
    }

    if (empty(trim($_POST['history']))) {
        $history_err = 'is-invalid';
    } else {
        $history = mysqli_escape_string($ConnectionLink, $_POST['history']);
    }

    if (empty(trim($_POST['follow']))) {
        $follow_err = 'is-invalid';
    } else {
        $follow = mysqli_escape_string($ConnectionLink, $_POST['follow']);
    }

    $date = date('Y/m/d H:i:s');

    if (empty($_FILES['file'])) {
        $img_err = 'is-invalid';
    } else {
        $name = $_FILES['file']['name'];
    }


    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    if (empty($artist_name_err) && empty($about_err) && empty($history_err) && empty($follow_err) && empty($img_err)) {
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
            $query = "INSERT INTO artist_info (ARTIST_UUID, ARTIST_NAME, ARTIST_HEAD_TITLE, ARTIST_CONTENT_ABOUT, ARTIST_CONTENT_HISTORY, ARTIST_IMAGE, ARTIST_FOLLOW_BUTTON, ARTIST_ADDED_AT)
                VALUES ('$uuid', '$artist_name', '$title', '$about', '$history', '$image', '$follow', '$date')";
            if (mysqli_query($ConnectionLink, $query)) {
                // Upload file
                move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $name);
                echo "<script>window.location.href = 'current_artists_page.php'</script>";
            } else {
                echo "Error";
            }
        }
    }
}
?>
<div class="container-fluid">
    <section class="content-section">
        <div class="container">
            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                <h3 class="text-dark mb-0">Artiest toevoegen</h3>
            </div>
            <div class="row mt-4 mx-auto">
                <div class="col-md-12">
                    <div class="card-body form">
                        <form method="post" action="" enctype='multipart/form-data'>
                            <label for="editFirstname">Naam:</label>
                            <input id="editFirstname" class="form-control <?php echo (!empty($artist_name_err)) ? 'is-invalid' : '';?>" name="artist_name">
                            <p class="invalid-feedback">Dit veld is verplicht.</p><br/>

                            <label for="editFirstname">Over de band (I):</label>
                            <textarea id="editFirstname" class="form-control <?php echo (!empty($about_err)) ? 'is-invalid' : '';?>" name="about" style="resize: vertical; width: 100%; height: 100px;" rows="2"></textarea>
                            <p class="invalid-feedback">Dit veld is verplicht.</p><br>

                            <label for="editLastname">Over de band (II):</label>
                            <textarea id="editLastname" class="form-control <?php echo (!empty($history_err)) ? 'is-invalid' : '';?>" name="history" style="resize: vertical; width: 100%; height: 100px;" rows="2"></textarea>
                            <p class="invalid-feedback">Dit veld is verplicht.</p><br>

                            <label for="editLastname">Volg knop Spotify:</label>
                            <textarea id="editLastname" class="form-control <?php echo (!empty($follow_err)) ? 'is-invalid' : '';?>" name="follow" style="resize: none; width: 100%; height: 100px;" rows="2"></textarea>
                            <p class="invalid-feedback">Dit veld is verplicht.</p><br>

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFileInput" aria-describedby="customFileInput" name="file">
                                <label class="custom-file-label" for="customFileInput">Banner uploaden</label>
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
</div>
<script>
    document.querySelector('.custom-file-input').addEventListener('change', function (e) {
        var name = document.getElementById("customFileInput").files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = name
    })
</script>
<?php include '_layouts/_layout-footer.phtml';?>
