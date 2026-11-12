function validatePhone()
{
    let phone =
    document.getElementById("phone").value;

    let regex =
    /^0[0-9]{9}$/;

    if(!regex.test(phone))
    {
        alert(
        "Phone number must start with 0 and contain 10 digits."
        );

        return false;
    }

    return true;
}

function confirmDelete()
{
    return confirm(
    "Are you sure you want to delete this record?"
    );
}

function bookingSuccess()
{
    alert(
    "Appointment Booked Successfully!"
    );
}