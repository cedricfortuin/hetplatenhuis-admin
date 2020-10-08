<?php include 'config/config.php';
$sql = "DELETE FROM updates WHERE UPDATE_ID='" . $_GET["UPDATE_ID"] . "'";

    if (mysqli_query($ConnectionLink, $sql)) {
        echo "<script>window.location.href='update_page.php?SHOW_ALERT=ON_DELETE'</script>";
    } else {
        echo "<script>window.location.href='update_page.php?SHOW_ALERT=ON_ERROR'</script>";
    }

$ConnectionLink->close();
?>