<?php


require_once("../includes/auth.php");

if(!isset($_SESSION['customer_id']))
{
    header("Location: ../login.php");
    exit();
}

require_once("../includes/config.php");

/** @var mysqli $conn */


$message = "";

$services =
mysqli_query(
$conn,
"SELECT * FROM services"
);

$staff =
mysqli_query(
$conn,
"SELECT * FROM staff"
);

if(isset($_POST['book']))
{
    $customer_id =
    $_SESSION['customer_id'];

    $service_id =
    $_POST['service_id'];

    $staff_id =
    $_POST['staff_id'];

    $date =
    $_POST['appointment_date'];

    $time =
    $_POST['appointment_time'];

    $status =
    "Pending";

    $stmt =
    $conn->prepare(
    "
    INSERT INTO appointments
    (
    customer_id,
    service_id,
    staff_id,
    appointment_date,
    appointment_time,
    status
    )
    VALUES
    (?,?,?,?,?,?)
    "
    );

    $stmt->bind_param(
    "iiisss",
    $customer_id,
    $service_id,
    $staff_id,
    $date,
    $time,
    $status
    );

    if($stmt->execute())
    {
        $message =
        "Appointment Booked Successfully!";
    }
}

include("../includes/header.php");

?>

<div class="card">

<h2>
Book Appointment
</h2>

<br>

<p>
<?php echo $message; ?>
</p>

<br>

<form method="POST">

<label>
Select Service
</label>

<select
name="service_id"
required>

<option value="">
Choose Service
</option>

<?php

mysqli_data_seek(
$services,
0
);

while(
$row =
mysqli_fetch_assoc($services)
)
{

?>

<option
value="<?php echo $row['service_id']; ?>">

<?php
echo $row['service_name'];
?>

</option>

<?php } ?>

</select>

<br><br>

<label>
Select Staff Member
</label>

<select
name="staff_id"
required>

<option value="">
Choose Staff
</option>

<?php

while(
$row =
mysqli_fetch_assoc($staff)
)
{

?>

<option
value="<?php echo $row['staff_id']; ?>">

<?php
echo $row['full_name'];
?>

</option>

<?php } ?>

</select>

<br><br>

<label>
Date
</label>

<input
type="date"
name="appointment_date"
required>

<br><br>

<label>
Time
</label>

<input
type="time"
name="appointment_time"
required>

<br><br>

<button
class="btn"
type="submit"
name="book">

Book Appointment

</button>

</form>

</div>

<?php

include("../includes/footer.php");

?>
