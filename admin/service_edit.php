<?php

session_start();

if(!isset($_SESSION['admin_id']))
{
    header("Location: ../admin_login.php");
    exit();
}

require_once("../includes/config.php");

$id = $_GET['id'];

$stmt = $conn->prepare(
"SELECT * FROM services
 WHERE service_id = ?"
);

$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();
$service = $result->fetch_assoc();

$message = "";

if(isset($_POST['update']))
{
    $service_name = trim($_POST['service_name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);

    $stmt = $conn->prepare(
    "UPDATE services
     SET
        service_name=?,
        description=?,
        price=?
     WHERE service_id=?"
    );

    $stmt->bind_param(
        "ssdi",
        $service_name,
        $description,
        $price,
        $id
    );

    if($stmt->execute())
    {
        header("Location: services.php");
        exit();
    }

    $message = "Update failed.";
}

include("../includes/header.php");

?>

<div class="card">

    <h2>Edit Service</h2>

    <p><?php echo $message; ?></p>

    <form method="POST">

        <input
        type="text"
        name="service_name"
        value="<?php echo $service['service_name']; ?>"
        required>

        <br><br>

        <textarea
        name="description"
        required><?php echo $service['description']; ?></textarea>

        <br><br>

        <input
        type="number"
        step="0.01"
        name="price"
        value="<?php echo $service['price']; ?>"
        required>

        <br><br>

        <button
        type="submit"
        name="update"
        class="btn">

        Update Service

        </button>

    </form>

</div>

<?php

include("../includes/footer.php");

?>