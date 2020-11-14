<?php
/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

include '_layouts/_layout-header.phtml';

if (isset($_REQUEST['updateAdmin'])) {
    $settingSOTDList = mysqli_real_escape_string($ConnectionLink, $_POST['settingSOTDList']);
    $settingArtistList = mysqli_real_escape_string($ConnectionLink, $_POST['settingArtistList']);

    $sqlSOTD = "UPDATE configuration SET CONFIG_VALUE = '$settingSOTDList' WHERE CONFIG_KEY = 'CONFIG_ITEMS_SONG_OF_DAY_LIST'";
    $sqlArtist = "UPDATE configuration SET CONFIG_VALUE = '$settingArtistList' WHERE CONFIG_KEY = 'CONFIG_ITEMS_ROW_ARTISTS'";


    if (mysqli_query($ConnectionLink, $sqlSOTD) && mysqli_query($ConnectionLink, $sqlArtist)) {
        echo '<script>window.location.href("settings.php")</script>';
    } else {
        echo '<script>window.location.href("settings.php")</script>';
    }
}

if (isset($_REQUEST['updateIndex'])) {
    if (!empty($_POST['alertSwitch'])) {
        // Checked switch
        $sqlAlert = "UPDATE configuration SET CONFIG_VALUE = 1 WHERE CONFIG_KEY = 'CONFIG_ENABLE_WEBSITE_NEW_FEATURE_ALERT'";
        if (mysqli_query($ConnectionLink, $sqlAlert)) {
            echo '<script>window.location.href("settings.php")</script>';
        } else {
            echo '<script>window.location.href("settings.php")</script>';
        }
    } else {
        $sqlAlert = "UPDATE configuration SET CONFIG_VALUE = 0 WHERE CONFIG_KEY = 'CONFIG_ENABLE_WEBSITE_NEW_FEATURE_ALERT'";
        if (mysqli_query($ConnectionLink, $sqlAlert)) {
            echo '<script>window.location.href("settings.php")</script>';
        } else {
            echo '<script>window.location.href("settings.php")</script>';
        }
    }

    $settingUsersAlert_err = '';
    if (isset($_POST['settingUsersAlert']) && !empty($_POST['settingUsersAlert'])) {
        $settingUsersAlert = mysqli_real_escape_string($ConnectionLink, $_POST['settingUsersAlert']);
        $sqlAlertText = "UPDATE configuration SET CONFIG_VALUE = '" . $settingUsersAlert . "' WHERE CONFIG_KEY = 'CONFIG_NEW_WEBSITE_FEATURE_ALERT_TEXT'";
        if (mysqli_query($ConnectionLink, $sqlAlertText)) {
            echo '<script>window.location.href("settings.php")</script>';
        } else {
            echo '<script>window.location.href("settings.php")</script>';
        }
    } else {
        $settingUsersAlert_err = 'is-invalid';
    }
}

if (isset($_POST['updateEnv'])) {
    if (!empty($_POST['sotdSwitch'])) {
        $sqlSotdEnable = "UPDATE configuration SET CONFIG_VALUE = 1 WHERE CONFIG_KEY = 'CONFIG_ENABLE_SONG_OF_DAY'";
        if (mysqli_query($ConnectionLink, $sqlSotdEnable)) {
            echo '<script>window.location.href("settings.php")</script>';
        } else {
            echo '<script>window.location.href("settings.php")</script>';
        }
    } else {
        $sqlSotdEnable = "UPDATE configuration SET CONFIG_VALUE = 0 WHERE CONFIG_KEY = 'CONFIG_ENABLE_SONG_OF_DAY'";
        if (mysqli_query($ConnectionLink, $sqlSotdEnable)) {
            echo '<script>window.location.href("settings.php")</script>';
        } else {
            echo '<script>window.location.href("settings.php")</script>';
        }
    }

    if (!empty($_POST['newsletterSwitch'])) {
        $sqlNewsletterEnable = "UPDATE configuration SET CONFIG_VALUE = 1 WHERE CONFIG_KEY = 'CONFIG_ENABLE_NEWSLETTER'";
        if (mysqli_query($ConnectionLink, $sqlNewsletterEnable)) {
            echo '<script>window.location.href("settings.php")</script>';
        } else {
            echo '<script>window.location.href("settings.php")</script>';
        }
    } else {
        $sqlNewsletterEnable = "UPDATE configuration SET CONFIG_VALUE = 0 WHERE CONFIG_KEY = 'CONFIG_ENABLE_NEWSLETTER'";
        if (mysqli_query($ConnectionLink, $sqlNewsletterEnable)) {
            echo '<script>window.location.href("settings.php")</script>';
        } else {
            echo '<script>window.location.href("settings.php")</script>';
        }
    }

    if (!empty($_POST['myphSwitch'])) {
        $sqlMyPHEnable = "UPDATE configuration SET CONFIG_VALUE = 1 WHERE CONFIG_KEY = 'CONFIG_ENABLE_MY_PH'";
        if (mysqli_query($ConnectionLink, $sqlMyPHEnable)) {
            echo '<script>window.location.href("settings.php")</script>';
        } else {
            echo '<script>window.location.href("settings.php")</script>';
        }
    } else {
        $sqlMyPHEnable = "UPDATE configuration SET CONFIG_VALUE = 0 WHERE CONFIG_KEY = 'CONFIG_ENABLE_MY_PH'";
        if (mysqli_query($ConnectionLink, $sqlMyPHEnable)) {
            echo '<script>window.location.href("settings.php")</script>';
        } else {
            echo '<script>window.location.href("settings.php")</script>';
        }
    }
}
?>
<div class="container-fluid">
    <section class="content-section">
        <div class="container">
            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                <h3 class="text-dark mb-0">Website instellingen</h3>
            </div>
            <div class="row">
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <h5 class="card-header">Adminomgeving</h5>
                        <div class="card-body">
                            <div class="form">
                                <form method="post" action="" enctype='multipart/form-data'>
                                    <label class="card-text" for="settingSOTDList">Aantal items lijst Nummer v/d
                                        Dag:</label>
                                    <input type="number" min="1" max="15" id="settingSOTDList" name="settingSOTDList"
                                           class="form-control"
                                           value="<?php echo $getConfigDataSOTDList['CONFIG_VALUE']; ?>">
                                    <p class="invalid-feedback">Dit veld is verplicht.</p><br/>
                                    <label class="card-text" for="settingArtistList">Aantal items lijst
                                        artiesten:</label>
                                    <input type="number" min="2" max="6" id="settingArtistList" name="settingArtistList"
                                           class="form-control"
                                           value="<?php echo $getConfigDataArtistList['CONFIG_VALUE']; ?>">
                                    <p class="invalid-feedback">Dit veld is verplicht.</p><br/>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <input class="btn btn-sm btn-outline-primary" type="submit"
                                                   name="updateAdmin" value="Bijwerken">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <h5 class="card-header">Voorpagina</h5>
                        <div class="card-body form">
                            <div class="form">
                                <form method="post" action="" enctype='multipart/form-data'>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="alertSwitch" name="alertSwitch" <?php echo ($getConfigDataAlertEnable['CONFIG_VALUE'] == 1) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="alertSwitch">Schakel alert bij users in.</label>
                                    </div>
                                    <br/>
                                    <label class="card-text" for="settingArtistList">Tekst van alert bij users: </label>
                                    <textarea id="settingArtistList" name="settingUsersAlert" class="form-control <?php echo $settingUsersAlert_err;?>" style="resize: vertical; min-height: 100px;"><?php echo $getConfigDataAlertText['CONFIG_VALUE']; ?></textarea>
                                    <p class="invalid-feedback">Dit veld is verplicht.</p><br/>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <input class="btn btn-sm btn-outline-primary" type="submit"
                                                   name="updateIndex" value="Bijwerken">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <h5 class="card-header">Useromgeving</h5>
                        <div class="card-body">
                            <div class="form">
                                <form method="post" action="">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="sotdSwitch" name="sotdSwitch" <?php echo ($getConfigDataSotdEnable['CONFIG_VALUE'] == 1) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="sotdSwitch">Schakel nummer van de dag
                                            in.</label>
                                    </div>
                                    <br/>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="newsletterSwitch" name="newsletterSwitch" <?php echo ($getConfigDataNewsletterEnable['CONFIG_VALUE'] == 1) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="newsletterSwitch">Schakel nieuwsbrief
                                            in.</label>
                                    </div>
                                    <br/>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="myphSwitch" name="myphSwitch" <?php echo ($getConfigDataMyPHEnable['CONFIG_VALUE'] == 1) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="myphSwitch">Schakel Mijn Platenhuis in.</label>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <input class="btn btn-sm btn-outline-primary" type="submit"
                                                   name="updateEnv" value="Bijwerken">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</div>

<?php include '_layouts/_layout-footer.phtml';?>
