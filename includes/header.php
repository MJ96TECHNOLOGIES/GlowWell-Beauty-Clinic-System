<?php

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
GlowWell Beauty Clinic
</title>

<link rel="stylesheet"
href="/GlowWell/css/style.css">

<script src="/GlowWell/js/script.js"></script>

</head>

<body>

<div class="navbar">

<?php if(isset($_SESSION['admin_id'])) : ?>

    <a href="/GlowWell/admin/dashboard.php">
        Dashboard
    </a>

    <a href="/GlowWell/admin/customers.php">
        Manage Customers
    </a>

    <a href="/GlowWell/admin/staff.php">
        Manage Staff
    </a>

    <a href="/GlowWell/admin/services.php">
        Manage Services
    </a>

    <a href="/GlowWell/admin/appointments.php">
        Manage Appointments
    </a>

    <a href="/GlowWell/admin/admins.php">
        Manage Admins
    </a>

    <a href="/GlowWell/admin/reports.php">
        Reports
    </a>

    <a href="/GlowWell/logout.php">
        Logout
    </a>

<?php elseif(isset($_SESSION['customer_id'])) : ?>

    <a href="/GlowWell/customer/dashboard.php">
        Dashboard
    </a>

    <a href="/GlowWell/customer/book_appointment.php">
        Book Appointment
    </a>

    <a href="/GlowWell/customer/appointments.php">
        My Appointments
    </a>

    <a href="/GlowWell/customer/profile.php">
        My Profile
    </a>

    <a href="/GlowWell/logout.php">
        Logout
    </a>

<?php else : ?>

    <a href="/GlowWell/index.php">
        Home
    </a>

    <a href="/GlowWell/register.php">
        Register
    </a>

    <a href="/GlowWell/login.php">
        Customer Login
    </a>

    <a href="/GlowWell/admin_login.php">
        Admin Login
    </a>

<?php endif; ?>

</div>