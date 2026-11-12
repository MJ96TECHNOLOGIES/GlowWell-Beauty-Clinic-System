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
    "SELECT *
     FROM admins
     ORDER BY admin_id DESC"
);

include("../includes/header.php");

?>

<div class="card">

<h2>
Manage Administrators
</h2>

<br>

<a
href="admin_add.php"
class="btn">

Add Administrator

</a>

<br><br>

<table>

<tr>
<th>ID</th>
<th>Username</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) : ?>

<tr>

<td>
<?php echo $row['admin_id']; ?>
</td>

<td>
<?php echo $row['username']; ?>
</td>

</tr>

<?php endwhile; ?>

</table>

</div>

<?php

include("../includes/footer.php");

?>