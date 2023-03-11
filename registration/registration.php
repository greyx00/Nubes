<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="../dynamic/menu.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/footer.css">
    <link rel="stylesheet" type="text/css" href="registration.css">
    <link rel="icon" href="../images/icona.jpg">
</head>

<body>
    <?php
    include('../dynamic/menu.php');

    if (isset($_POST['submit'])) {
        require_once('../connection.php');
        $role = "utente";
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $pass = trim($_POST['pass']);
        $confirm = $_POST['confirm'];
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $null = '';

        if ($pass != $confirm)
            $message = "Password e conferma password devono coincidere";
        else {
            $stmt = $conn->prepare("INSERT INTO users (role,firstname,lastname,email,pass,city,addres,number) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->bind_param('ssssssss', $role, $firstname, $lastname, $email, $hash, $null, $null, $null);
            $stmt->execute();
            if ($stmt->affected_rows === 0)
                $message = "ERRORE";
            else
                header('location: ../login/login.php');
            $stmt->close();
            $conn->close();
        }
    } else $message = "";
    ?>
    <form action="registration.php" method="post">
        <div class="container">
            <div class="box">
                <div class="form">
                    <h1>REGISTRATI</h1>
                    <input type="text" placeholder="Nome" id="firstname" name="firstname" class="form-control" required>

                    <input type="text" placeholder="Cognome" id="lastname" name="lastname" class="form-control" required>

                    <input type="email" placeholder="Email" id="email" name="email" class="form-control" onkeyup="checkEmail(this.value)" required>

                    <span id="demo">
                        <p></p>
                    </span>

                    <input type="password" placeholder="Password" id="pass" name="pass" class="form-control" title=" inserire otto o più caratteri" required>

                    <input type="password" placeholder="Conferma Password" id="confirm" name="confirm" class="form-control" required>

                    <p class="not_log">Sei registrato? <a href="../login/login.php">Login</a></p>

                    <div class="message"><?php if (isset($message)) {
                                                echo $message;
                                            } ?></div>

                    <input type="submit" id="registration_button" name="submit" value="registrati" class="registration_button">
                </div>
            </div>
        </div>
    </form>

    <script>
        function checkEmail(email) {
            var xhr;
            if (email != "") {
                xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("demo").innerHTML = this.responseText;
                    }
                };

                xhr.open("POST", "../dynamic/email.php");
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("email=" + email);
            }

        }
    </script>

    <?php include('../dynamic/footer.php'); ?>
</body>

</html>