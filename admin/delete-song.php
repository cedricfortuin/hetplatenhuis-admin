<?php include 'config/config.php';
$sql = "DELETE FROM songofday WHERE SONG_ID='" . $_GET["SONG_ID"] . "'";

    if (mysqli_query($ConnectionLink, $sql)) {
        echo "<script>window.location.href='songofday_page.php?SHOW_ALERT=ON_DELETE'</script>";
    } else {
        echo "<script>window.location.href='songofday_page.php?SHOW_ALERT=ON_ERROR'</script>";
    }

mysqli_close($ConnectionLink);
?>
