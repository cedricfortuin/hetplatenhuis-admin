<?php
include '../config/config.php';
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Het Platenhuis</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../assets/img/functional/song.png" type="image/x-icon"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
</head>
<body class="bg-gradient-primary">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-12 col-xl-10">
            <div class="card shadow-lg o-hidden border-0 my-5">
                <div class="card-body p-0">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="login-form">
                                    <?php
                                    $showTooShortError = false;
                                    $showNotTheSameError = false;
                                    $userUuid = $_GET['uuid'];
                                    $userToken = $_GET['token'];
                                    $sql = $ConnectionLink->query("SELECT * FROM admins WHERE ADMIN_UUID = '$userUuid'")->fetch_array();
                                    if (!empty($_GET['token']) && !empty($_GET['uuid'])) {
                                        if ($sql['ADMIN_UUID'] === $userUuid && $sql['ADMIN_RESET_TOKEN'] === $userToken) {
                                            ?>
                                            <form action="" method="post">
                                                <h4 class="modal-title text-center">Stel hier je (nieuwe) wachtwoord in!</h4><br/>
                                                <div class="form-group">
                                                    <label for="password-label">Wachtwoord</label>
                                                    <input id="password-label" type="password" name="password"
                                                           class="form-control"
                                                           placeholder="" autocomplete="off">
                                                </div>
                                                <div class="form-group">
                                                    <label for="password-label">Herhaal wachtwoord</label>
                                                    <input id="password-label" type="password" name="confirm-password"
                                                           class="form-control"
                                                           placeholder="" autocomplete="off">
                                                </div>
                                                <input type="submit" class="btn btn-primary btn-block btn-lg" value="Opslaan" name="setNewPassword">
                                            </form>
                                            <?php
                                            if (isset($_POST['setNewPassword'])) {
                                                $setPassword = mysqli_real_escape_string($ConnectionLink, $_POST['password']);
                                                $setConfirmPassword = mysqli_real_escape_string($ConnectionLink, $_POST['confirm-password']);

                                                if ($setPassword === $setConfirmPassword) {
                                                    if (strlen(trim($setPassword)) >= 8 && !empty($setPassword)) {
                                                        $hashedPassword = password_hash($setPassword, PASSWORD_BCRYPT);
                                                        $updateAdminData = $ConnectionLink->query("UPDATE admins SET ADMIN_PASSWORD = '$hashedPassword', ADMIN_RESET_TOKEN = null WHERE ADMIN_UUID = '$userUuid'");
                                                        if (mysqli_query($ConnectionLink, $updateAdminData)) {
                                                            session_start();
                                                            $_SESSION["loggedin"] = true;
                                                            $_SESSION["uuid"] = $userUuid;
                                                            header("location: ../index.php");
                                                        } else {
                                                            echo "<script>window.location.href='../login.php'</script>";
                                                        }

                                                    } else {
                                                        $showTooShortError = true;
                                                        echo 'Het wachtwoord is niet lang genoeg';
                                                    }
                                                } else {
                                                    $showNotTheSameError = true;
                                                    echo 'De wachtwoorden zijn niet hetzelfde';
                                                }
                                            }
                                        } else {
                                            echo '<p class="alert alert-danger">Er is een fout opgetreden. Probeer het opnieuw.</p>';
                                        }
                                    }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="../assets/js/theme.js"></script>
</body>
</html>