<!DOCTYPE html>
<html lang="it">

<head>
    <title>Change Password</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../dynamic/menu.css">
    <link rel="stylesheet" type="text/css" href="profile.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/footer.css">
    <link rel="icon" href="../images/icona.jpg">
</head>

<body>

    <?php
    session_start();
    if (!isset($_SESSION['user']))
        header('location: ../login/login.php');
    require_once('../connection.php');

    if (isset($_POST['submit'])) {
        if (count($_POST) > 0) {
            $currentpass = trim($_POST['currentPassword']);
            $newpass = trim($_POST['newPassword']);
            $confirm = trim($_POST['confirmPassword']);
            $session = $_SESSION['user'];

            $stmt = $conn->prepare("SELECT * FROM users WHERE email= ?");
            $stmt->bind_param('s', $session);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_array();

            if (!empty($row)) {
                if (password_verify($currentpass, $row['pass'])) {
                    if ($newpass == $confirm && $currentpass != $newpass) {
                        $newhash = password_hash($newpass, PASSWORD_DEFAULT);
                        $new = $conn->prepare("UPDATE users SET pass= ? WHERE email= ?");
                        $new->bind_param('ss', $newhash, $session);
                        $new->execute();
                        $result = $new->get_result();
                        if ($new->affected_rows === 0)
                            $message = "si è verificato un errore";
                        else
                            $message = "password cambiata correttamente";
                        $new->close();
                    } elseif ($newpass != $confirm)
                        $message = "nuova password e conferma non coincidono";
                    elseif ($currentpass == $newpass)
                        $message = "la nuova password deve essere diversa da quella corrente";
                } else
                    $message = "password errata";
            }
        }
    } else $message = "";

    include('../dynamic/menu.php');
    ?>


    <div class="container">
        <div class="box">
            <form name="frmChange" method="post" action="" onSubmit="return validatePassword()">
                <div class="form">
                    <h1>PASSWORD</h1>
                    <input type="password" name="currentPassword" class="form-control" placeholder="Password Corrente" /><span id="currentPassword" class="required"></span>

                    <input type="password" name="newPassword" class="form-control" pattern=".{8,}" title="inserire otto o più caratteri" placeholder="Nuova Password" /><span id="newPassword" class="required"></span>

                    <input type="password" name="confirmPassword" class="form-control" placeholder="Conferma Password" /><span id="confirmPassword" class="required"></span>

                    <div class="message"><?php if (isset($message)) {
                                                echo $message;
                                            } ?></div>
                    <input type="submit" id="changepass" name="submit" value="Modifica" class="modify">
                </div>

            </form>
        </div>
    </div>


    <script>
        function validatePassword() {
            var currentPassword, newPassword, confirmPassword, output = true;
            currentPassword = document.frmChange.currentPassword;
            newPassword = document.frmChange.newPassword;
            confirmPassword = document.frmChange.confirmPassword;

            if (!currentPassword.value) {
                currentPassword.focus();
                document.getElementById("currentPassword").innerHTML = "inserire la password corrente";
                output = false;
            } else if (!newPassword.value) {
                newPassword.focus();
                document.getElementById("newPassword").innerHTML = "inserire la nuova password";
                output = false;
            } else if (!confirmPassword.value) {
                confirmPassword.focus();
                document.getElementById("confirmPassword").innerHTML = "confermare la password";
                output = false;
            }
            if (newPassword.value != confirmPassword.value) {
                newPassword.value = "";
                confirmPassword.value = "";
                newPassword.focus();
                document.getElementById("confirmPassword").innerHTML = "password e conferma devono coincidere";
                output = false;
            }
            return output;
        }
    </script>

    <?php
    include('../dynamic/footer.php');
    ?>
</body>

</html>