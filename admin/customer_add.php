<?php

session_start();

if(!isset($_SESSION['admin_id']))
{
    header("Location: ../admin_login.php");
    exit();
}

require_once("../includes/config.php");

$message = "";

if(isset($_POST['save']))
{
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    if(
        empty($first_name) ||
        empty($last_name) ||
        empty($email) ||
        empty($phone) ||
        empty($password)
    )
    {
        $message = "All fields are required.";
    }
    else
    {
        $hash =
        password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $stmt = $conn->prepare(
        "INSERT INTO customers
        (
            first_name,
            last_name,
            email,
            phone,
            password
        )
        VALUES (?,?,?,?,?)"
        );

        $stmt->bind_param(
            "sssss",
            $first_name,
            $last_name,
            $email,
            $phone,
            $hash
        );

        if($stmt->execute())
        {
            header("Location: customers.php");
            exit();
        }

        $message = "Failed to save customer.";
    }
}

include("../includes/header.php");

?>

<div class="card">

<h2>Add Customer</h2>

<p><?php echo $message; ?></p>

<form method="POST">

<input type="text"
name="first_name"
placeholder="First Name"
required>

<br><br>

<input type="text"
name="last_name"
placeholder="Last Name"
required>

<br><br>

<input type="email"
name="email"
placeholder="Email"
required>

<br><br>

<input type="text"
name="phone"
placeholder="Phone"
required>

<br><br>

<input type="password"
name="password"
placeholder="Password"
required>

<br><br>

<button
class="btn"
name="save">

Save Customer

</button>

</form>

</div>

<?php

include("../includes/footer.php");

?>
