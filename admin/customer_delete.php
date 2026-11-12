<?php

session_start();

if(!isset($_SESSION['admin_id']))
{
    header("Location: ../admin_login.php");
    exit();
}

require_once("../includes/config.php");

$id = $_GET['id'];

$stmt = $conn->prepare(
"DELETE FROM customers
 WHERE customer_id = ?"
);

$stmt->bind_param(
"i",
$id
);

$stmt->execute();

header("Location: customers.php");
exit();

?>