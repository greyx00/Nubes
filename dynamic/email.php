<?php
session_start();
require_once('../connection.php');
$email = $_POST['email'];
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    if ($email != $_SESSION['user'] || $_SESSION['role'] == "admin") {
        $email_error = "" . $email . " già esistente";
        echo " " . $email_error;
    }
}

$stmt->close();
$conn->close();
