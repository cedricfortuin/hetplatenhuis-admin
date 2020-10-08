<?php include 'config/config.php';
$deleteSong = "DELETE FROM songofday WHERE SONG_ID='" . $_GET["SONG_ID"] . "'";

    if (mysqli_query($ConnectionLink, $deleteSong)) {
        echo "<script>window.location.href='songofday_page.php?SHOW_ALERT=ON_DELETE'</script>";
    } else {
        echo "<script>window.location.href='songofday_page.php?SHOW_ALERT=ON_ERROR'</script>";
    }

$ConnectionLink->close();
?>
