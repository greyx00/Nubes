<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/menu.css">
    <link rel="stylesheet" type="text/css" href="showprofile.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/footer.css">
    <link rel="icon" href="../images/icona.jpg">
    <title>Profilo utente</title>
</head>

<body>

    <?php
    session_start();
    require_once('../connection.php');
    $email = $_POST['email'];

    if (isset($_POST['submit'])) {
        $newname = $_POST['firstname'];
        $newlastname = $_POST['lastname'];
        $newemail = $_POST['email'];
        $newcity = $_POST['city'];
        $newaddress = $_POST['address'];
        $newnumber = $_POST['number'];
        $stmt = $conn->prepare("UPDATE users SET firstname= ?, lastname= ?, email= ?, city= ?, addres= ?, number= ? WHERE email= ?");
        $stmt->bind_param('sssssss', $newname, $newlastname, $newemail, $newcity, $newaddress, $newnumber, $email);
        $stmt->execute();
        $res = $stmt->get_result();
        header('location:../admin/allusers.php');
    }


    $stmt = $conn->prepare("SELECT * FROM users WHERE email= ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_array();
    $name = htmlspecialchars($row['firstname']);
    $lastname = htmlspecialchars($row['lastname']);
    $email = htmlspecialchars($row['email']);
    $pass = $row['pass'];
    $city = htmlspecialchars($row['city']);
    $address = htmlspecialchars($row['addres']);
    $number = htmlspecialchars($row['number']);


    $stmt->close();
    $conn->close();
    include('../dynamic/menu.php');
    ?>


    <form action="show_profile.php" method="post">
        <div class="container">
            <div class="box">
                <div class="form">
                    <h1>PROFILO</h1>
                    <input type="text" placeholder="Nome" id="firstname" name="firstname" class="form-control" value="<?php echo $name; ?>" required>

                    <input type="text" placeholder="Cognome" id="lastname" name="lastname" class="form-control" value="<?php echo $lastname; ?>" required>

                    <input type="email" placeholder="E-mail" id="email" name="email" class="form-control" value="<?php echo $email; ?>" onkeyup="checkEmail(this.value)" required>

                    <span id="demo">
                        <p></p>
                    </span>



                    <input type="text" placeholder="Cittá" id="city" name="city" class="form-control" value="<?php echo $city; ?>">

                    <input type="text" placeholder="Indirizzo" id="address" name="address" class="form-control" value="<?php echo $address; ?>">

                    <input type="tel" placeholder="Telefono" id="number" name="number" class="form-control" pattern="[0-9]{7,10}" title=" Inserire numero di telefono valido!" value="<?php echo $number; ?>">

                    <div class="password_modify">
                        <p><a href="reset_pass.php?email=<?php echo $row['email'] ?>">Resetta Password</a></p>
                    </div>
                    <input type="submit" id="modify" name="submit" value="Modifica" class="modify">
                </div>

                <div class="message"><?php if (isset($message)) {
                                            echo $message;
                                        } ?></div>
            </div>
        </div>

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
                    xhr.send("email=" + document.getElementById("email").value);
                }

            }
        </script>


        <?php
        include('../dynamic/footer.php');
        ?>
</body>

</html>