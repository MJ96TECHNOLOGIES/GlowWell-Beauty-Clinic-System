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
    "SELECT * FROM staff
     ORDER BY staff_id DESC"
);

include("../includes/header.php");

?>

<div class="card">

    <h2>Manage Staff</h2>

    <br>

    <a href="staff_add.php"
       class="btn">

       Add Staff Member

    </a>

    <br><br>

    <table>

        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Speciality</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) : ?>

        <tr>

            <td><?php echo $row['staff_id']; ?></td>

            <td><?php echo $row['full_name']; ?></td>

            <td><?php echo $row['speciality']; ?></td>

            <td><?php echo $row['phone']; ?></td>

            <td><?php echo $row['email']; ?></td>

            <td>

                <a
                href="staff_edit.php?id=<?php echo $row['staff_id']; ?>"
                class="btn">

                Edit

                </a>

                <a
                href="staff_delete.php?id=<?php echo $row['staff_id']; ?>"
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