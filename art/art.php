<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Art</title>
    <link rel="stylesheet" type="text/css" href="../dynamic/menu.css">
    <link rel="stylesheet" type="text/css" href="art.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/footer.css">
    <link rel="icon" href="../images/icona.jpg">
</head>

<body>
    <?php
    session_start();
    require_once('../connection.php');
    include('../dynamic/menu.php');
    ?>
    <div class="container">
        <div class="text-center">
            <?php

            $stmt = $conn->prepare("SELECT * FROM paintings");
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $paintings = "
                            <div class=\"container\">
                                <div class=\"box\">
                                        <a href='painting.php?name=" . $row['name'] . "' target=\"_self\"><img src=\"../images/" . $row['image'] . "\" alt=\"Immagine\" class=\"\" width=300px></a>
                                </div>
                            </div>";
                echo $paintings;
            }

            ?>
        </div>
    </div>

    <?php include('../dynamic/footer.php'); ?>
</body>

</html>