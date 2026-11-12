<?php


require_once("../includes/auth.php");

if(!isset($_SESSION['customer_id']))
{
    header("Location: ../login.php");
    exit();
}

require_once("../includes/config.php");

/** @var mysqli $conn */


$customer_id = $_SESSION['customer_id'];

$stmt = $conn->prepare(
"
SELECT
a.*,
s.service_name,
st.full_name

FROM appointments a

JOIN services s
ON a.service_id = s.service_id

JOIN staff st
ON a.staff_id = st.staff_id

WHERE a.customer_id = ?
ORDER BY appointment_date
"
);

$stmt->bind_param(
"s",
$customer_id
);

$stmt->execute();

$result = $stmt->get_result();

include("../includes/header.php");

?>

<div class="card">

<h2>My Appointments</h2>

<br>

<table>

<tr>
<th>Service</th>
<th>Staff</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
</tr>

<?php while($row = $result->fetch_assoc()) : ?>

<tr>

<td>
<?php echo $row['service_name']; ?>
</td>

<td>
<?php echo $row['full_name']; ?>
</td>

<td>
<?php echo $row['appointment_date']; ?>
</td>

<td>
<?php echo $row['appointment_time']; ?>
</td>

<td>
<?php echo $row['status']; ?>
</td>

</tr>

<?php endwhile; ?>

</table>

</div>

<?php

include("../includes/footer.php");

?>