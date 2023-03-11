<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carrello</title>
    <link rel="stylesheet" type="text/css" href="../dynamic/menu.css">
    <link rel="stylesheet" type="text/css" href="cart.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/footer.css">
    <link rel="icon" href="../images/icona.jpg">
</head>

<?php
session_start();
if (!isset($_SESSION['user']))
    header('location: ../login/login.php');
require_once("./function.php");
require_once('../connection.php');

if (isset($_POST['remove'])) {
    if ($_GET['action'] == 'remove') {
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value["name"] == $_GET['name']) {
                unset($_SESSION['cart'][$key]);
                header('location:cart.php');
            }
        }
    }
}

include('../dynamic/menu.php');
?>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row px-5">
            <div class="col-md-7">
                <div class="shopping-cart">
                    <h2>Carrello</h2>

                    <?php
                    if (isset($_POST["pay"])) {
                        if (isset($_SESSION['cart'])) {
                            $painting_name = array_column($_SESSION['cart'], 'name');
                            $count = count($_SESSION['cart']);
                            if (is_countable($_SESSION['cart']) &&  $count != 0) {
                                $sold_out = 1;
                                for ($i = 0; $i <= $count; $i++) {
                                    foreach ($painting_name as $name) {
                                        $stmt = $conn->prepare("UPDATE paintings SET sold_out= ? WHERE name= ?");
                                        $stmt->bind_param('is', $sold_out, $name);
                                        $stmt->execute();
                                    }
                                    unset($_SESSION['cart'][$i]);
                                }
                                $messageshop = "Grazie per l'acquisto!";
                                $stmt->close();
                            }
                        }
                    }


                    $total = 0;
                    if (isset($_SESSION['cart'])) {
                        $painting_name = array_column($_SESSION['cart'], 'name');

                        $stmt = $conn->prepare("SELECT * FROM paintings");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            foreach ($painting_name as $name) {
                                if ($row['name'] == $name) {
                                    cartPaints($row['image'], $row['name'], $row['price']);
                                    $total = $total + (int)$row['price'];
                                }
                            }
                        }
                    }

                    ?>

                </div>
            </div>
            <div class="pt">
                <h6 class="resume">Riassunto Spesa</h6>
                <div class="row price-details">
                    <div class="col-md-6">
                        <?php
                        if (isset($_SESSION['cart'])) {
                            $count  = count($_SESSION['cart']);
                            echo "<h6>Subtotale ($count oggetti):</h6>";
                        }

                        ?>
                        <h6>€<?php echo $total; ?></h6>
                        <h6>Spedizione: GRATIS</h6>
                        <h6>Da pagare: €<?php echo $total; ?></h6>


                        <form method="post">
                            <div>
                                <input type="submit" class="pay" name="pay" id="pay" value="Acquista">
                            </div>
                        </form>
                        <div class="messageshop"><?php if (isset($messageshop)) {
                                                        echo $messageshop;
                                                    } ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('../dynamic/footer.php');
    ?>
</body>

</html>