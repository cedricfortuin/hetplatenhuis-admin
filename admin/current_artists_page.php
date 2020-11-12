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
$getConfigDataArtistList = $ConnectionLink->query("SELECT * FROM configuration WHERE `KEY` = 'CONFIG_ITEMS_ROW_ARTISTS'")->fetch_array();
$getConfigDataUUIDList = $ConnectionLink->query("SELECT * FROM configuration WHERE `KEY` = 'CONFIG_ENABLE_UUID_LIST'")->fetch_array();
?>
<div class="container-fluid">
    <section class="content-section">
        <div class="container">
            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                <h3 class="text-dark mb-0">Huidige artiesten</h3>
            </div>
            <div class="row">
                <?php
                $i = 0;
                while ($showResult = $getPageDataArray->fetch_array()) {
                    $timestamp = strtotime($showResult['ARTIST_ADDED_AT']);
                    $uuid = $showResult['ARTIST_UUID'];
                    $countItems = $ConnectionLink->query("SELECT * FROM discography WHERE ARTIST_UUID = '$uuid'")->num_rows;
                    ?>
                    <div class="col-md-<?php echo $getConfigDataArtistList['VALUE']?> mt-4">
                        <div class="card">
                            <img class="card-img-top" src="<?php echo $showResult['ARTIST_IMAGE']?>" alt="Image <?php echo $showResult['ARTIST_NAME']?>">
                            <h5 class="card-header"><?php echo $showResult['ARTIST_NAME']?></h5>
                            <div class="card-body">
                                <p class="card-text">Toegevoegd op: <?php echo date('d/m/Y', $timestamp)?></p>
                                <?php if ($getConfigDataUUIDList['VALUE'] == 'On') {
                                    ?>
                                        <p class="card-text">UUID: <?php echo $showResult['ARTIST_UUID']?></p>
                                    <?php
                                } else {
                                    ?>
                                        <p class="card-text d-none"></p>
                                    <?php
                                }?>
                                <p class="card-text">Aantal albums in database: <?php echo $countItems?></p>
                                <div class="row">
                                    <div class="col-md-6 text-left">
                                        <p class="card-text"><a href="edit_artist.php?page_uuid=<?php echo $showResult['ARTIST_UUID']?>"><i class="fas fa-edit"></i></a></p>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <p class="card-text"><a href="album_list.php?page_uuid=<?php echo $showResult['ARTIST_UUID']?>"><i class="fas fa-list"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $i++;
                }

                ?>
            </div>
        </div>
    </section>
</div>
</div>
<?php include '_layouts/_layout-footer.phtml';?>
