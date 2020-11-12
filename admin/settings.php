<?php
/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Including
include 'collect_all_datahandlers.php';
include '_layouts/_layout-header.phtml';
$getPageDataArray = $ConnectionLink->query("SELECT * FROM artist_info ORDER BY ARTIST_NAME");
$getConfigDataSOTDLIST = $ConnectionLink->query("SELECT * FROM configuration WHERE `KEY` = 'CONFIG_ITEMS_SONG-OF-DAY_LIST'")->fetch_array();
$getConfigDataArtistList = $ConnectionLink->query("SELECT * FROM configuration WHERE `KEY` = 'CONFIG_ITEMS_SONG-OF-DAY_LIST'")->fetch_array();

if (isset($_REQUEST['updateData'])) {
    
}

?>
<div class="container-fluid">
    <section class="content-section">
        <div class="container">
            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                <h3 class="text-dark mb-0">Huidige artiesten</h3>
            </div>
            <div class="row">
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <h5 class="card-header"></h5>
                        <div class="card-body form">
                            <label class="card-text" for="settingSOTDList">Aantal items lijst Nummer v/d Dag: </label>
                            <input id="settingSOTDList" name="settingSOTDList" class="form-control" value="<?php echo $getConfigDataSOTDLIST['VALUE']; ?>">
                            <p class="invalid-feedback">Dit veld is verplicht.</p><br/>
                            <label class="card-text" for="settingArtistList">Aantal items lijst artiesten: </label>
                            <input id="settingArtistList" name="settingArtistList" class="form-control" value="<?php echo $getConfigDataArtistList['VALUE']; ?>">
                            <p class="invalid-feedback">Dit veld is verplicht.</p><br/>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <p class="card-text"><a href=""><button class="btn btn-circle" type="submit" name="updateData"><i class="far fa-save" style="color: #4e73df;"></i></button></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '_layouts/_layout-footer.phtml';?>
