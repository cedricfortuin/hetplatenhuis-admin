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
                                    include '../config/config.php';
                                    $showTooShortError = false;
                                    $showNotTheSameError = false;

                                    if (!empty($_GET['token']) && !empty($_GET['email'])) {

                                        $userEmail = $_GET['email'];
                                        $userToken = $_GET['token'];
                                        $sql = mysqli_query($ConnectionLink,"SELECT * FROM reset_password WHERE USER_TOKEN_MAIL = '$userEmail'");
                                        $getResult = mysqli_fetch_array($sql);
                                        $mail_from_database = $getResult['USER_TOKEN_MAIL'];
                                        $token_from_database = $getResult['USER_TOKEN'];
                                        if ($mail_from_database === $userEmail && $token_from_database  === $userToken) {
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
                                                        $insertSql = $ConnectionLink->query("UPDATE users SET USER_PASSWORD = '$hashedPassword' WHERE USER_EMAIL = '$userEmail'");
                                                        $deleteSql = $ConnectionLink->query("DELETE FROM reset_password WHERE USER_TOKEN_MAIL = '$userEmail'");

                                                        if (mysqli_query($ConnectionLink, $insertSql, $deleteSql)) {
                                                            echo "<script>window.location.href='../login.php'</script>";
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
                                            echo 'Error';
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