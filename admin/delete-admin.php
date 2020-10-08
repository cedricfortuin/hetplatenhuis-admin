<?php include 'config/config.php';
$sql = "DELETE FROM users WHERE USER_ID='" . $_GET["USER_ID"] . "'";

    if (mysqli_query($ConnectionLink, $sql)) {
        echo "<script>window.location.href='current_admins_page.php?SHOW_ALERT=ON_DELETE'</script>";
    } else {
        echo "<script>window.location.href='current_admins_page.php?SHOW_ALERT=ON_ERROR'</script>";
    }

$ConnectionLink->close();

?>