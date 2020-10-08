<?php include 'config/config.php';
$deleteRecord = "DELETE FROM collection WHERE RECORD_ID='" . $_GET["RECORD_ID"] . "'";

    if (mysqli_query($ConnectionLink, $deleteRecord)) {
        echo "<script>window.location.href='collection.php?SHOW_ALERT=ON_DELETE'</script>";
    } else {
        echo "<script>window.location.href='collection.php?SHOW_ALERT=ON_ERROR'</script>";
    }

$ConnectionLink->close();
?>
