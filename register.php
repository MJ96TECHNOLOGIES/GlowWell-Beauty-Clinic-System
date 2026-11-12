<?php

require_once 'includes/config.php';

$message = "";

if(isset($_POST['register']))
{
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    if(
        empty($first_name) ||
        empty($last_name) ||
        empty($email) ||
        empty($phone) ||
        empty($password)
    )
    {
        $message = "Please complete all fields.";
    }

    elseif(!preg_match("/^[a-zA-Z ]+$/", $first_name))
    {
        $message = "First name may only contain letters.";
    }

    elseif(!preg_match("/^[a-zA-Z ]+$/", $last_name))
    {
        $message = "Last name may only contain letters.";
    }

    elseif(!preg_match("/^0[0-9]{9}$/", $phone))
    {
        $message = "Phone number must start with 0 and contain 10 digits.";
    }

    else
    {
        $check = $conn->prepare(
            "SELECT customer_id
             FROM customers
             WHERE email = ?
             OR phone = ?"
        );

        $check->bind_param("ss",$email,$phone);
        $check->execute();

        $result = $check->get_result();

        if($result->num_rows > 0)
        {
            $message =  "An account with that email address or phone 
            number already exists. Please use different details or login 
            if you already have an account.";
        }
        else
        {
            $hashedPassword =
            password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
            "INSERT INTO customers
            (
                first_name,
                last_name,
                email,
                phone,
                password
            )
            VALUES
            (?,?,?,?,?)"
            );

            $stmt->bind_param(
                "sssss",
                $first_name,
                $last_name,
                $email,
                $phone,
                $hashedPassword
            );

            if($stmt->execute())
            {
                $message =
                "Registration Successful!";
            }
            else
            {
                $message =
                "Error creating account.";
            }
        }
    }
}

include 'includes/header.php';

?>

<div class="card">

<h2>Customer Registration</h2>

<br>

<p><?php echo $message; ?></p>

<br>

<form method="POST">

<input
type="text"
name="first_name"
placeholder="First Name"
required>

<br><br>

<input
type="text"
name="last_name"
placeholder="Last Name"
required>

<br><br>

<input
type="email"
name="email"
placeholder="Email Address"
required>

<br><br>

<input
type="tel"
id="phone"
name="phone"
placeholder="0721234567"
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
name="register"
class="btn">

Register

</button>

</form>

</div>

<?php

include 'includes/footer.php';

?>