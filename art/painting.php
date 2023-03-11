<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painting</title>
    <link rel="stylesheet" type="text/css" href="./painting.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/menu.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/footer.css">
    <link rel="icon" href="../images/icona.jpg">
</head>

<body>
    <?php
    session_start();
    $sessionid = $_SESSION['user'];
    if (!isset($sessionid))
        header('location: ../login/login.php');

    include('../dynamic/menu.php');

    require_once('../connection.php');
    $pg = $_GET['name'];
    $_SESSION['name'] = $pg;
    ?>


    <div class="ProductContainer">

        <?php

        $stmt = $conn->prepare("SELECT * FROM paintings WHERE name = ?");
        $stmt->bind_param('s', $pg);
        $stmt->execute();
        $res = $stmt->get_result();
        $pag = $res->fetch_assoc();

        $painting = "
                    <div class=\"product\">
                        <div class=\"box\">
                            <img id=\"myimage\" src=\"../images/" . $pag['image'] . "\" style={{ height=\"800px\"}}/ alt=\"paintg\">
                        </div>
                        <span><h1 class=\"title\">" . $pag['name'] . "</h1></span>
                         <div class=\"about\">
                            <p1>" . $pag['description'] . "</p1>
                        </div>
                    </div>
                ";

        echo $painting;
        ?>


    </div>

    <?php
    include('../dynamic/footer.php');
    ?>
</body>

</html>