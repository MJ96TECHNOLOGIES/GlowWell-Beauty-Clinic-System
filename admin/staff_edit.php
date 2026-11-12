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
"SELECT * FROM staff
 WHERE staff_id = ?"
);

$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();
$staff = $result->fetch_assoc();

$message = "";

if(isset($_POST['update']))
{
    $full_name = trim($_POST['full_name']);
    $speciality = trim($_POST['speciality']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    $stmt = $conn->prepare(
    "UPDATE staff
     SET
        full_name=?,
        speciality=?,
        phone=?,
        email=?
     WHERE staff_id=?"
    );

    $stmt->bind_param(
        "ssssi",
        $full_name,
        $speciality,
        $phone,
        $email,
        $id
    );

    if($stmt->execute())
    {
        header("Location: staff.php");
        exit();
    }

    $message = "Update failed.";
}

include("../includes/header.php");

?>

<div class="card">

<h2>Edit Staff Member</h2>

<p><?php echo $message; ?></p>

<form method="POST">

<input
type="text"
name="full_name"
value="<?php echo $staff['full_name']; ?>"
required>

<br><br>

<input
type="text"
name="speciality"
value="<?php echo $staff['speciality']; ?>"
required>

<br><br>

<input
type="text"
name="phone"
value="<?php echo $staff['phone']; ?>"
required>

<br><br>

<input
type="email"
name="email"
value="<?php echo $staff['email']; ?>"
required>

<br><br>

<button
name="update"
class="btn">

Update Staff Member

</button>

</form>

</div>

<?php

include("../includes/footer.php");

?>