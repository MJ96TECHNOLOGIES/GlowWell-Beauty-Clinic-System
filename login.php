<?php

session_start();

require_once 'includes/config.php';

$message = "";

if(isset($_POST['login']))
{
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare(
        "SELECT * FROM customers
         WHERE email = ?"
    );

    $stmt->bind_param(
        "s",
        $email
    );

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows == 1)
    {
        $user = $result->fetch_assoc();

        if(
            password_verify(
                $password,
                $user['password']
            )
        )
        {
            $_SESSION['customer_id']
            = $user['customer_id'];

            $_SESSION['customer_name']
            = $user['first_name'];

            header(
                "Location: customer/dashboard.php"
            );

            exit();
        }
    }

    $message = "Invalid login details.";
}

include 'includes/header.php';

?>

<div class="card">

<h2>Customer Login</h2>

<br>

<p><?php echo $message; ?></p>

<br>

<form method="POST">

<input
type="email"
name="email"
placeholder="Email"
required>

<br><br>

<input
type="password"
name="password"
placeholder="Password"
required>

<br><br>

<button
type="submit"
name="login"
class="btn">

Login

</button>

</form>

</div>

<?php

include 'includes/footer.php';

?>