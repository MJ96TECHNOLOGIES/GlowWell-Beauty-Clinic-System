<?php

session_start();

if(!isset($_SESSION['admin_id']))
{
    header("Location: ../admin_login.php");
    exit();
}

require_once("../includes/config.php");

/** @var mysqli $conn */

$message = "";

if(isset($_POST['save']))
{
    $full_name = trim($_POST['full_name']);
    $speciality = trim($_POST['speciality']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if(
        empty($full_name) ||
        empty($speciality) ||
        empty($phone) ||
        empty($email)
    )
    {
        $message = "All fields are required.";
    }
    elseif(!preg_match("/^0[0-9]{9}$/", $phone))
    {
        $message = "Phone number must contain 10 digits.";
    }
    else
    {
        $stmt = $conn->prepare(
        "INSERT INTO staff
        (
            full_name,
            speciality,
            phone,
            email
        )
        VALUES (?,?,?,?)"
        );

        $stmt->bind_param(
            "ssss",
            $full_name,
            $speciality,
            $phone,
            $email
        );

        if($stmt->execute())
        {
            header("Location: staff.php");
            exit();
        }

        $message = "Error saving staff member.";
    }
}

include("../includes/header.php");

?>

<div class="card">

<h2>Add Staff Member</h2>

<p><?php echo $message; ?></p>

<form method="POST">

<input
type="text"
name="full_name"
placeholder="Full Name"
required>

<br><br>

<input
type="text"
name="speciality"
placeholder="Speciality"
required>

<br><br>

<input
type="tel"
name="phone"
placeholder="0721234567"
required>

<br><br>

<input
type="email"
name="email"
placeholder="Email Address"
required>

<br><br>

<button
type="submit"
name="save"
class="btn">

Save Staff Member

</button>

</form>

</div>

<?php

include("../includes/footer.php");

?>