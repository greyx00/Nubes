<?php
require_once('../connection.php');
$email = $_GET['email'];
$null = "";
$hash = password_hash($null, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE users SET pass= ? WHERE email= ?");
$stmt->bind_param('ss', $hash, $email);
$stmt->execute();
if ($stmt->affected_rows === 0) {
    echo "<script>alert('si è verificato un errore!'); window.location = '../admin/allusers.php';</script>";
} else {
    echo "<script>alert('password resettata'); window.location = '../admin/allusers.php';</script>";
}
$stmt->close();
