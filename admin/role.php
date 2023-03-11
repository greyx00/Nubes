<?php
echo "ciao";
require_once('../connection.php');
$role = $_POST['role'];
$email = $_POST['email'];
$stmt = $conn->prepare("UPDATE users SET role = ? WHERE email = ?");
$stmt->bind_param('ss', $role, $email);
$stmt->execute();
$res = $stmt->get_result();
$message = "a";
if ($stmt->execute()) {
    $message = "Modifica effetuata";
    echo " " . $message;
} else {
    $message = "Modifica non effetuata";
    echo " " . $message;
}

$stmt->close();
$conn->close();
