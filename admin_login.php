<?php

session_start();

require_once("includes/config.php");

$message = "";

if(isset($_POST['login']))
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare(
        "SELECT * FROM admins
         WHERE username = ?"
    );

    $stmt->bind_param(
        "s",
        $username
    );

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows == 1)
    {
        $admin = $result->fetch_assoc();

        if(
            password_verify(
                $password,
                $admin['password']
            )
        )
        {
            $_SESSION['admin_id'] =
            $admin['admin_id'];

            $_SESSION['admin_name'] =
            $admin['username'];

            header(
            "Location: admin/dashboard.php"
            );

            exit();
        }
    }

    $message =
    "Invalid Username or Password";
}

include("includes/header.php");

?>

<div class="card">

<h2>Administrator Login</h2>

<br>

<p style="color:red;">
<?php echo $message; ?>
</p>

<form method="POST">

<input
type="text"
name="username"
placeholder="Username"
required>

<br><br>

<input
type="password"
name="password"
placeholder="Password"
required>

<br><br>

<button
class="btn"
type="submit"
name="login">

Login

</button>

</form>

</div>

<?php

include("includes/footer.php");

?>