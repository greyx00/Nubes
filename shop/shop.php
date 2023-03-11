<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop</title>
    <link rel="stylesheet" type="text/css" href="../dynamic/menu.css">
    <link rel="stylesheet" type="text/css" href="shop.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/footer.css">
    <link rel="icon" href="../images/icona.jpg">
</head>

<body>
    <?php
    session_start();
    require_once('../connection.php');
    require_once('./function.php');
    if (isset($_POST['buy'])) {
        if (isset($_SESSION['cart'])) {
            $item_array_name = array_column($_SESSION['cart'], "name");
            if (in_array($_POST['name'], $item_array_name)) {
                echo "<script>alert('Prodotto giá nel carrello!')</script>";
                echo "<script>window.location = 'shop.php'</script>";
            } else {
                $count = count($_SESSION['cart']);
                $item_array = array('name' => $_POST['name']);
                $_SESSION['cart'][$count] = $item_array;
            }
        } else {
            $item_array = array('name' => $_POST['name']);
            $_SESSION['cart'][0] = $item_array;
        }
    }
    include('../dynamic/menu.php');
    ?>

    <div class="container">
        <div class="text-center">
            <form action="shop.php" method="post">
                <div class="box">
                    <span><input class="boxsearch" name="boxsearch" id="textsearch" type="text" placeholder="Cerca"></span>
                    <span><button class="search" name="search" id="search" type="submit">Cerca</button></span>
                </div>
            </form>
            <?php
            if (isset($_POST['search'])) {
                $search = $_POST['boxsearch'];
                if ($search != '') {
                    $s = '%' . $search . '%';
                    $stmt = $conn->prepare("SELECT * FROM paintings WHERE name LIKE ?");
                    $stmt->bind_param('s', $s);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $numrows = $res->num_rows;

                    if ($numrows === 0) {
                        echo "NESSUN QUADRO TROVATO";
                    } else {
                        while ($row = $res->fetch_array()) {
                            if (!$row['sold_out']) paintings($row['name'], $row['price'], $row['image'], $row['size'], $row['technique']);
                        }
                    }
                } else header('location: shop.php');
            } else {
                $stmt = $conn->prepare("SELECT * FROM paintings");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    if (!$row['sold_out']) paintings($row['name'], $row['price'], $row['image'], $row['size'], $row['technique']);
                }
            }
            ?>
        </div>
    </div>

    <?php include('../dynamic/footer.php'); ?>
</body>

</html>