<?php


require_once("../includes/auth.php");

if(!isset($_SESSION['customer_id']))
{
    header("Location: ../login.php");
    exit();
}

include '../includes/header.php';


?>

<div class="card">

<h1>
Welcome,
<?php echo $_SESSION['customer_name']; ?>
</h1>

    <br>

    <p>
        GlowWell Beauty Clinic Customer Dashboard
    </p>

<?php

include '../includes/footer.php';

?>