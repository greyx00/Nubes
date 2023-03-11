<!DOCTYPE html>
<html lang="it">

<head>
    <title>Lista utenti</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../dynamic/menu.css">
    <link rel="stylesheet" type="text/css" href="../dynamic/footer.css">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="icon" href="../images/icona.jpg">
</head>

<body>
    <?php
    session_start();
    require_once('../connection.php');
    include('../dynamic/menu.php');
    ?>
    <form action="allusers.php" method="post">
        <div class="search">
            <span><input class="boxSearch" name="search" id="textsearch" type="text" placeholder="Cerca utente"></span>
            <span><button class="submit" name="submit" id="search" type="submit">Cerca</button></span>
        </div>
    </form>
    <table>
        <tr>
            <td>Firstname</td>
            <td>Lastname</td>
            <td>Email</td>
            <td>City</td>
            <td>Addres</td>
            <td>Number</td>
            <td>Role</td>
        </tr>
        <?php
        require_once('../connection.php');
        if (isset($_POST['submit'])) {
            $search = $_POST['search'];
            if ($search != '') {
                $s = '%' . $search . '%';
                $stmt = $conn->prepare("SELECT * FROM users WHERE firstname LIKE ? OR lastname LIKE ?");
                $stmt->bind_param('ss', $s, $s);
                $stmt->execute();
                $res = $stmt->get_result();
                $numrows = $res->num_rows;

                if ($numrows === 0) {
                    echo "NESSUN UTENTE TROVATO";
                } else {
                    while ($row = $res->fetch_array()) {
                        echo "
                        <tr>
                            <form action=\"show_profile.php\" method=\"post\">
                                <td>" . $row['firstname'] . "</td>
                                <td>" . $row['lastname'] . "</td>
                                <td>" . $row['email'] . "</td>
                                <td>" . $row['city'] . "</td>
                                <td>" . $row['addres'] . "</td>
                                <td>" . $row['number'] . "</td>
                                <td><select name=\"role\" onchange=\"changeRole(this.value, " . $row['email'] . ")\">
                                    <option value=" . $row['role'] . " selected disabled hidden>" . $row['role'] . "</option>
                                    <option value=\"utente\">utente</option>
                                    <option value=\"admin\">admin</option>
                                    <option value=\"bloccato\">bloccato</option>
                                </select></td>
                                <td><input type=\"submit\" name=\"modifica\" value=\"Modifica\"></td>
                                <input type=\"hidden\" name=\"email\" value=" . $row['email'] . ">
                            </form>
                        </tr>";
                    }
                }
            } else header('location: allusers.php');
        } else {
            $stmt = $conn->prepare("SELECT * FROM users ORDER BY role ASC ");
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                        <form action=\"show_profile.php\" method=\"post\">
                            <td>" . $row['firstname'] . "</td>
                            <td>" . $row['lastname'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $row['city'] . "</td>
                            <td>" . $row['addres'] . "</td>
                            <td>" . $row['number'] . "</td>
                            <td><select name=\"role\" onchange=\"changeRole(this.value, " . $row['email'] . ")\">
                                <option value=" . $row['role'] . " selected disabled hidden>" . $row['role'] . "</option>
                                <option value=\"utente\">utente</option>
                                <option value=\"admin\">admin</option>
                                <option value=\"bloccato\">bloccato</option>
                            </select></td>
                            <td><input type=\"submit\" name=\"modifica\" value=\"Modifica\"></td>
                            <input type=\"hidden\" name=\"email\" value=" . $row['email'] . ">
                        </form>
                    </tr>";
            }
        }
        ?>
    </table>
    <span>
        <p id="demo"></p>
    </span>
    <script>
        function changeRole(role, email) {
            var xhr;
            xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("demo").innerHTML = this.responseText;
                }
            }
            xhr.open("POST", "role.php");
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("role=" + role, "email" + email);
        }
    </script>

    <?php include '../dynamic/footer.php'; ?>
</body>

</html>