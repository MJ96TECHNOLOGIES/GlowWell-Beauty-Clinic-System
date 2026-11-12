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
"SELECT * FROM appointments
 WHERE appointment_id = ?"
);

$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();

$appointment = $result->fetch_assoc();

if(isset($_POST['update']))
{
    $status = $_POST['status'];

    $stmt = $conn->prepare(
    "UPDATE appointments
     SET status = ?
     WHERE appointment_id = ?"
    );

    $stmt->bind_param(
    "si",
    $status,
    $id
    );

    if($stmt->execute())
    {
        header("Location: appointments.php");
        exit();
    }
}

include("../includes/header.php");

?>

<div class="card">

<h2>Update Appointment Status</h2>

<form method="POST">

<label>
Status
</label>

<br><br>

<select
name="status">

<option value="Pending">
Pending
</option>

<option value="Approved">
Approved
</option>

<option value="Completed">
Completed
</option>

<option value="Cancelled">
Cancelled
</option>

</select>

<br><br>

<button
type="submit"
name="update"
class="btn">

Update

</button>

</form>

</div>

<?php

include("../includes/footer.php");

?>