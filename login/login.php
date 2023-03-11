<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../dynamic/menu.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/footer.css">
    <link rel="stylesheet" type="text/css" href="login.css">
    <link rel="icon" href="../images/icona.jpg">
</head>

<body>
    <?php
    session_start();
    include('../dynamic/menu.php');

    if (isset($_POST['submit'])) {
        require_once('../connection.php');
        $email = $_POST['email'];
        $pass = trim($_POST['pass']);
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_array();

        if (!empty($row) && password_verify($pass, $row['pass'])) {
            if ($row['role'] != "bloccato") {
                $_SESSION['user'] = $_POST['email'];
                $_SESSION['role'] = $row['role'];
                header('location: ../shop/shop.php');
                $message = "";
            } else echo "<script>alert('Il tuo account è stato bloccato!')</script>";
        } else
            $message = "Credenziali errate!";
    }
    ?>
    <form action="login.php" method="post">
        <div class="container">
            <div class="box">
                <div class="form">
                    <h1>LOGIN</h1>
                    <input type="text" placeholder="Email" id="email" name="email" class="form-control" required>

                    <input type="password" placeholder="Password" id="pass" name="pass" class="form-control" required>

                    <p class="not_reg">Non sei registrato? <a href="../registration/registration.php">Registrati</a></p>

                    <div class="message"><?php if (isset($message)) {
                                                echo $message;
                                            } ?></div>

                    <input type="submit" id="login_button" name="submit" value="Login" class="login_button">
                </div>
            </div>
        </div>
    </form>

    <?php
    include('../dynamic/footer.php');
    ?>

</body>

</html>