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
    $service_name = trim($_POST['service_name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);

    if(
        empty($service_name) ||
        empty($description) ||
        empty($price)
    )
    {
        $message = "All fields are required.";
    }
    elseif(!is_numeric($price))
    {
        $message = "Price must be numeric.";
    }
    else
    {
        $stmt = $conn->prepare(
        "INSERT INTO services
        (
            service_name,
            description,
            price
        )
        VALUES (?,?,?)"
        );

        $stmt->bind_param(
            "ssd",
            $service_name,
            $description,
            $price
        );

        if($stmt->execute())
        {
            header("Location: services.php");
            exit();
        }

        $message = "Failed to save service.";
    }
}

include("../includes/header.php");

?>

<div class="card">

    <h2>Add Service</h2>

    <p><?php echo $message; ?></p>

    <form method="POST">

        <input
        type="text"
        name="service_name"
        placeholder="Service Name"
        required>

        <br><br>

        <textarea
        name="description"
        placeholder="Service Description"
        required></textarea>

        <br><br>

        <input
        type="number"
        step="0.01"
        name="price"
        placeholder="Price"
        required>

        <br><br>

        <button
        type="submit"
        name="save"
        class="btn">

        Save Service

        </button>

    </form>

</div>

<?php

include("../includes/footer.php");

?>