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
    $username =
    trim($_POST['username']);

    $password =
    trim($_POST['password']);

    $hash =
    password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $stmt = $conn->prepare(
        "INSERT INTO admins
        (
            username,
            password
        )
        VALUES (?,?)"
    );

    $stmt->bind_param(
        "ss",
        $username,
        $hash
    );

    if($stmt->execute())
    {
        header("Location: admins.php");
        exit();
    }

    $message =
    "Unable to create administrator.";
}

include("../includes/header.php");

?>

<div class="card">

<h2>
Add Administrator
</h2>

<p>
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
type="submit"
name="save"
class="btn">

Create Admin

</button>

</form>

</div>

<?php

include("../includes/footer.php");

?>