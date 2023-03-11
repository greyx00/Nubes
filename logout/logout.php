<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" type="text/css" href="logout.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/menu.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/footer.css">
    <link rel="icon" href="../images/icona.jpg">
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['user'])) header('location: ../login/login.php');
    if (isset($_POST['yes'])) {
        if (isset($_SESSION['user'])) {
            session_destroy();
            header('location:../home/home.php');
        }
    } elseif (isset($_POST['no'])) {
        header('location:../home/home.php');
    }

    include('../dynamic/menu.php');
    ?>

    <div class="container">
        <div class="box">
            <form action="logout.php" method="post">
                <h1>Sei sicuro di voler uscire?</h1>
                <button type="submit" id="yes" name="yes">SI</button>
                <button type="submit" id="no" name="no">NO</button>
            </form>
        </div>
    </div>

    <?php
    include('../dynamic/footer.php');
    ?>
</body>

</html>