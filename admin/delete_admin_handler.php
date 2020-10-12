<?php include 'config/config.php';
$sql = "DELETE FROM users WHERE USER_ID='" . $_GET["USER_ID"] . "'";
$deleteSql = "DELETE FROM reset_password WHERE USER_TOKEN_MAIL = '" . $_GET["USER_EMAIL"]. "'";

    if (mysqli_query($ConnectionLink, $sql) && mysqli_query($ConnectionLink, $deleteSql)) {
        echo "<script>window.location.href='current_admins_page.php?SHOW_ALERT=ON_DELETE'</script>";
    } else {
        echo "<script>window.location.href='current_admins_page.php?SHOW_ALERT=ON_ERROR'</script>";
    }

$ConnectionLink->close();

?>