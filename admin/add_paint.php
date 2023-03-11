<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add paint</title>
    <link rel="stylesheet" type="text/css" href="../dynamic/menu.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/footer.css">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="icon" href="../images/icona.jpg">
</head>

<body>
    <?php
    session_start();
    include('../dynamic/menu.php');
    if (isset($_POST['upload'])) {
        $upload_path = "../images/";
        $filename = basename($_FILES['img']['name']);
        $target_file = $upload_path . $filename;
        $check = true;
        $message = "";

        $img_check = getimagesize($_FILES['img']['tmp_name']);
        if (!$img_check) {
            $check = false;
            $message = "Questo file non è un'immagine valida";
        }

        if (file_exists($target_file)) {
            $check = false;
            $message = "il file esiste già";
        }

        $ext = strtoupper(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($ext != "JPG" && $ext != "PNG") {
            $check = false;
            $message = "Estensione non valida! (Solo JPG e PNG)";
        }

        if ($check) {
            if (!move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
                $message = "Upload Fallito...";
            } else {
                require_once('../connection.php');

                $name = $_POST['name'];
                $price = $_POST['price'];
                $size = $_POST['size'];
                $technique = $_POST['technique'];
                $description = $_POST['description'];
                $sold_out = 0;

                $stmt = $conn->prepare("INSERT INTO paintings (name, price, image, size, technique, description, sold_out) VALUES (?,?,?,?,?,?,?)");
                $stmt->bind_param('ssssssi', $name, $price, $filename, $size, $technique, $description, $sold_out);
                $stmt->execute();
                if ($stmt->affected_rows === 0) $message = "Upload Fallito...";
                else $message = "File caricato con successo!";
                $stmt->close();
                $conn->close();
            }
        }
    }
    ?>
    <form action="add_paint.php" method="post" enctype="multipart/form-data">
        <div class="container">
            <div class="box">
                <div class="form">
                    <h1>Aggiungi dipinto</h1>
                    <input type="text" placeholder="Nome" name="name" class="form-control" required>

                    <input type="text" placeholder="Prezzo" name="price" class="form-control" required>

                    <input type="text" placeholder="Dimensione" name="size" class="form-control" required>

                    <input type="text" placeholder="Tecnica" name="technique" class="form-control" required>

                    <input type="text" placeholder="Descrizione" name="description" class="form-control">

                    <input type="file" name="img" class="form-control" required>

                    <div class="message"><?php if (isset($message)) echo $message; ?></div>

                    <input type="submit" id="upload" name="upload" value="Upload" class="upload">
                </div>
            </div>
        </div>
    </form>

    <?php include('../dynamic/footer.php'); ?>
</body>

</html>