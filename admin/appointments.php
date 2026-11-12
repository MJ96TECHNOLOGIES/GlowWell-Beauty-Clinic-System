<?php


require_once("../includes/auth.php");

if(!isset($_SESSION['admin_id']))
{
    header("Location: ../admin_login.php");
    exit();
}

require_once("../includes/config.php");

/** @var mysqli $conn */

$query = "

SELECT
a.*,
c.first_name,
c.last_name,
s.service_name,
st.full_name

FROM appointments a

JOIN customers c
ON a.customer_id = c.customer_id

JOIN services s
ON a.service_id = s.service_id

JOIN staff st
ON a.staff_id = st.staff_id

ORDER BY appointment_date DESC

";

$result = mysqli_query($conn, $query);

include("../includes/header.php");

?>

<div class="card">

<h2>Appointment Management</h2>

<br>

<table>

<tr>
<th>ID</th>
<th>Customer</th>
<th>Service</th>
<th>Staff</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) : ?>

<tr>

<td>
<?php echo $row['appointment_id']; ?>
</td>

<td>
<?php echo $row['first_name'] . " " . $row['last_name']; ?>
</td>

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

<td>

<a
href="appointment_update.php?id=<?php echo $row['appointment_id']; ?>"
class="btn">

Update Status

</a>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

<?php

include("../includes/footer.php");

?>