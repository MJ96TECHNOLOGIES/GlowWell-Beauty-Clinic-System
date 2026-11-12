<?php


require_once("../includes/auth.php");

if(!isset($_SESSION['admin_id']))
{
    header("Location: ../admin_login.php");
    exit();
}

require_once("../includes/config.php");

/** @var mysqli $conn */

$result =
mysqli_query(
$conn,
"SELECT COUNT(*) AS total
 FROM appointments"
);

$row =
mysqli_fetch_assoc($result);

$totalAppointments =
$row['total'];


$result =
mysqli_query(
$conn,
"SELECT COUNT(*) AS total
 FROM customers"
);

$row =
mysqli_fetch_assoc($result);

$totalCustomers =
$row['total'];


$result =
mysqli_query(
$conn,
"SELECT COUNT(*) AS total
 FROM staff"
);

$row =
mysqli_fetch_assoc($result);

$totalStaff =
$row['total'];

include("../includes/header.php");

?>

<div class="card">

<h2>
Reports Dashboard
</h2>

<br>

<table>

<tr>
<th>Report</th>
<th>Total</th>
</tr>

<tr>
<td>Total Customers</td>
<td><?php echo $totalCustomers; ?></td>
</tr>

<tr>
<td>Total Staff</td>
<td><?php echo $totalStaff; ?></td>
</tr>

<tr>
<td>Total Appointments</td>
<td><?php echo $totalAppointments; ?></td>
</tr>

</table>

</div>

<?php

include("../includes/footer.php");

?>