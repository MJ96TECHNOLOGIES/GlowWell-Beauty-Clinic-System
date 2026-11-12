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

$message = "";

/* Load Current Customer Details */

$stmt = $conn->prepare(
"SELECT *
 FROM customers
 WHERE customer_id = ?"
);

$stmt->bind_param(
"i",
$customer_id
);

$stmt->execute();

$result = $stmt->get_result();

$customer = $result->fetch_assoc();

/* Update Profile */

if(isset($_POST['update']))
{
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if(
        empty($first_name) ||
        empty($last_name) ||
        empty($email) ||
        empty($phone)
    )
    {
        $message =
        "Please complete all fields.";
    }
    elseif(!preg_match("/^[a-zA-Z ]+$/",$first_name))
    {
        $message =
        "First name must contain letters only.";
    }
    elseif(!preg_match("/^[a-zA-Z ]+$/",$last_name))
    {
        $message =
        "Last name must contain letters only.";
    }
    elseif(!preg_match("/^0[0-9]{9}$/",$phone))
    {
        $message =
        "Phone number must start with 0 and contain 10 digits.";
    }
    else
    {
        $stmt = $conn->prepare(
        "UPDATE customers
         SET
            first_name = ?,
            last_name = ?,
            email = ?,
            phone = ?
         WHERE customer_id = ?"
        );

        $stmt->bind_param(
            "ssssi",
            $first_name,
            $last_name,
            $email,
            $phone,
            $customer_id
        );

        if($stmt->execute())
        {
            $_SESSION['customer_name']
            = $first_name;

            $message =
            "Profile updated successfully.";

            /* Reload fresh data */

            $stmt = $conn->prepare(
            "SELECT *
             FROM customers
             WHERE customer_id = ?"
            );

            $stmt->bind_param(
            "i",
            $customer_id
            );

            $stmt->execute();

            $result = $stmt->get_result();

            $customer =
            $result->fetch_assoc();
        }
        else
        {
            $message =
            "Error updating profile.";
        }
    }
}

include("../includes/header.php");

?>

<div class="card">

    <h2>My Profile</h2>

    <br>

    <p style="color:green;">
        <?php echo $message; ?>
    </p>

    <form method="POST">

        <label>
            First Name
        </label>

        <br><br>

        <input
        type="text"
        name="first_name"
        value="<?php echo $customer['first_name']; ?>"
        required>

        <br><br>

        <label>
            Last Name
        </label>

        <br><br>

        <input
        type="text"
        name="last_name"
        value="<?php echo $customer['last_name']; ?>"
        required>

        <br><br>

        <label>
            Email
        </label>

        <br><br>

        <input
        type="email"
        name="email"
        value="<?php echo $customer['email']; ?>"
        required>

        <br><br>

        <label>
            Phone Number
        </label>

        <br><br>

        <input
        type="tel"
        name="phone"
        value="<?php echo $customer['phone']; ?>"
        required>

        <br><br>

        <button
        type="submit"
        name="update"
        class="btn">

        Update Profile

        </button>

    </form>

</div>

<?php

include("../includes/footer.php");

?>