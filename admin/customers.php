<?php


require_once("../includes/auth.php");

if(!isset($_SESSION['admin_id']))
{
    header("Location: ../admin_login.php");
    exit();
}

require_once("../includes/config.php");

/** @var mysqli $conn */

$result = mysqli_query(
    $conn,
    "SELECT * FROM customers
     ORDER BY customer_id DESC"
);

include("../includes/header.php");

?>

<div class="card">

    <h2>Manage Customers</h2>

    <br>

    <a href="customer_add.php"
       class="btn">

       Add New Customer

    </a>

    <br><br>

    <table>

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) : ?>

        <tr>

            <td>
                <?php echo $row['customer_id']; ?>
            </td>

            <td>
                <?php
                echo $row['first_name']
                . " " .
                $row['last_name'];
                ?>
            </td>

            <td>
                <?php echo $row['email']; ?>
            </td>

            <td>
                <?php echo $row['phone']; ?>
            </td>

            <td>

                <a
                href="customer_edit.php?id=<?php echo $row['customer_id']; ?>"
                class="btn">

                Edit

                </a>

                <a
                href="customer_delete.php?id=<?php echo $row['customer_id']; ?>"
                class="btn"
                onclick="return confirmDelete();">

                Delete

                </a>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

<?php

include("../includes/footer.php");

?>