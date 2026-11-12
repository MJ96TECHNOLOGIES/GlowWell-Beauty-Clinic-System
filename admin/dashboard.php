<?php


require_once("../includes/auth.php");

if(!isset($_SESSION['admin_id']))
{
    header("Location: ../admin_login.php");
    exit();
}

require_once("../includes/config.php");

/** @var mysqli $conn */


$customer_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM customers"
);

$customer_row = mysqli_fetch_assoc($customer_result);
$total_customers = $customer_row['total'];

$staff_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM staff"
);

$staff_row = mysqli_fetch_assoc($staff_result);
$total_staff = $staff_row['total'];

$appointment_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM appointments"
);

$appointment_row = mysqli_fetch_assoc($appointment_result);
$total_appointments = $appointment_row['total'];

$today_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM appointments
     WHERE appointment_date = CURDATE()"
);

$today_row = mysqli_fetch_assoc($today_result);
$today_bookings = $today_row['total'];

include("../includes/header.php");

?>

<div class="card">

    <h1>
        Welcome,
        <?php echo $_SESSION['admin_name']; ?>
    </h1>

    <br>

    <p>
        GlowWell Beauty Clinic Administration Dashboard
    </p>

</div>

<div class="service-grid">

    <div class="service-card">

        <h2>
            <?php echo $total_customers; ?>
        </h2>

        <p>
            Customers
        </p>

    </div>

    <div class="service-card">

        <h2>
            <?php echo $total_staff; ?>
        </h2>

        <p>
            Staff Members
        </p>

    </div>

    <div class="service-card">

        <h2>
            <?php echo $total_appointments; ?>
        </h2>

        <p>
            Appointments
        </p>

    </div>

    <div class="service-card">

        <h2>
            <?php echo $today_bookings; ?>
        </h2>

        <p>
            Today's Bookings
        </p>

    </div>

</div>

<br>


<?php

include("../includes/footer.php");

?>