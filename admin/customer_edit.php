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
"SELECT * FROM customers
 WHERE customer_id = ?"
);

$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();
$customer = $result->fetch_assoc();

$message = "";

if(isset($_POST['update']))
{
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $stmt = $conn->prepare(
    "UPDATE customers
     SET
        first_name=?,
        last_name=?,
        email=?,
        phone=?
     WHERE customer_id=?"
    );

    $stmt->bind_param(
        "ssssi",
        $first_name,
        $last_name,
        $email,
        $phone,
        $id
    );

    if($stmt->execute())
    {
        header("Location: customers.php");
        exit();
    }

    $message =
    "Update failed.";
}

include("../includes/header.php");

?>

<div class="card">

<h2>Edit Customer</h2>

<p><?php echo $message; ?></p>

<form method="POST">

<input
type="text"
name="first_name"
value="<?php echo $customer['first_name']; ?>"
required>

<br><br>

<input
type="text"
name="last_name"
value="<?php echo $customer['last_name']; ?>"
required>

<br><br>

<input
type="email"
name="email"
value="<?php echo $customer['email']; ?>"
required>

<br><br>

<input
type="text"
name="phone"
value="<?php echo $customer['phone']; ?>"
required>

<br><br>

<button
name="update"
class="btn">

Update Customer

</button>

</form>

</div>

<?php

include("../includes/footer.php");

?>