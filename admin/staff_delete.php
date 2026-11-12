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
"DELETE FROM staff
 WHERE staff_id = ?"
);

$stmt->bind_param(
"i",
$id
);

$stmt->execute();

header("Location: staff.php");
exit();

?>