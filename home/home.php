<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="./home.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/menu.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/footer.css">
    <link rel="icon" href="../images/icona.jpg">
</head>

<body>
    <?php
    session_start();
    include('../dynamic/menu.php');
    ?>

    <div class="center">
        <div class="logohome">
            <img src="../images/logo_home.jpg" alt="Logo" height="65">
        </div>
        <div class="presentation">
            <p><strong>Chi siamo? </strong>Nubes è sito riservato all'altista Nicoletta Crapuzzi.</p>
            <br>
            <p>Non si tratta solo di uno shop, iscriviti o interagisci con alcune delle opere più significative dell'artista</p>
        </div>
    </div>

    <?php
    include('../dynamic/footer.php');
    ?>

</body>

</html>