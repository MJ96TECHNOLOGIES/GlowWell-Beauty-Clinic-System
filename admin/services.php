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
    "SELECT * FROM services
     ORDER BY service_id DESC"
);

include("../includes/header.php");

?>

<div class="card">

    <h2>Manage Services</h2>

    <br>

    <a href="service_add.php"
       class="btn">

       Add Service

    </a>

    <br><br>

    <table>

        <tr>
            <th>ID</th>
            <th>Service</th>
            <th>Description</th>
            <th>Price (R)</th>
            <th>Actions</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) : ?>

        <tr>

            <td><?php echo $row['service_id']; ?></td>

            <td><?php echo $row['service_name']; ?></td>

            <td><?php echo $row['description']; ?></td>

            <td><?php echo number_format($row['price'],2); ?></td>

            <td>

                <a
                href="service_edit.php?id=<?php echo $row['service_id']; ?>"
                class="btn">

                Edit

                </a>

                <a
                href="service_delete.php?id=<?php echo $row['service_id']; ?>"
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