<?php
include 'config/config.php';
$sql = "DELETE FROM collection WHERE RECORD_ID='" . $_GET["RECORD_ID"] . "'";

if (mysqli_query($ConnectionLink, $sql)) {
echo "<script>window.location.href='collection.php?DELETE_SUCCESS=true'</script>";
} else {
echo "Oops, something went wrong: " . mysqli_error($ConnectionLink);
}

mysqli_close($ConnectionLink);
?>
