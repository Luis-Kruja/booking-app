<?php
session_start();


// Prevent redirection loop on verifyEmail.php
if (!isset($_SESSION['email']) || (!isset($_SESSION['step'])) || (isset($_SESSION['step']) && $_SESSION['step'] !== 'verify_email')) {
    if (basename($_SERVER['PHP_SELF']) !== 'verifyEmail.php') {
        header('Location: verifyEmail.php');
        exit;
    }
}
?>

?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">

</head>
<body class="register">

<div class="container__register">
    <h1 class="form-title">Verify Email</h1>
    <form id="verify_email_form" method="post" action="ajax.php">
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="number" name="verification_code" id="verification_code" placeholder="Verification code">
            <label for="verification_code">Verification Code</label>
        </div>
        <button type="submit" class="btn" name="verify_email">Verify</button>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="module">

$(function () {
        const verificationForm = $('#verify_email_form');
        let verificationCode = $('#verification_code');

        verificationForm.on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'verify_email',
                    verification_code: verificationCode.val()
                },
                success: function (response) {
                    if (response.status) {
                        alert(response.message);
                        window.location.href = response.redirect;
                    } else {
                        if (response.errors) {
                            displayErrors(response.errors);
                        }
                    }
                },
                error: function (xhr, status, error) {
                    alert(`Error: ${xhr.responseText || error}`);
                }
            });
        });
    });

    function displayErrors(errors) {
        for (let key in errors) {
            $(`#${key}`).closest('.input-group').append(
                `<span class="validation-errors" style="color: red;">${errors[key]}</span>`
            );
        }
    }

</script>