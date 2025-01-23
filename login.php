<?php
session_start();

global $conn;
include 'config/db_connection.php';

if (isset($_SESSION['email']) && !isset($_SESSION['step'])) {
    header('Location: index.php');
} else {
    if (isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];
        $stmt = $conn->prepare("SELECT user_id FROM sessions WHERE remember_me_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? AND email_verified_at IS NOT NULL");
                $stmt->bind_param("s", $row['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($usersRow = $result->fetch_assoc()) {
                    $_SESSION["email"] = $usersRow["email"];

                    $rememberToken = password_hash(uniqid(more_entropy: true), PASSWORD_DEFAULT);

                    $stmt = $conn->prepare("UPDATE sessions SET remember_me_token = ? WHERE user_id = ?");
                    $stmt->bind_param("ss", $rememberToken, $usersRow['user_id']);
                    $stmt->execute();

                    setcookie("remember_token", $usersRow, time() + (30 * 24 * 60 * 60), "/", "", false, true);

                    header('Location: index.php');
                }
            }
        }
    }
}
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
    <h1 class="form-title">Sign In</h1>
    <form id="sign_in_form" method="post" action="ajax.php">
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="text" name="email" id="email" placeholder="Email">
            <label for="email">Email</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password">
            <label for="password">Password</label>
        </div>
        <div class="input-group">
            <input type="checkbox" name="remember_me" id="remember_me">
            <label for="remember_me">Remember Me</label>
        </div>
        <p class="recover">
            <a href="#">Recover Password</a>
        </p>
        <button type="submit" class="btn" name="sign_in" id="sign_in_button">Sign In</button>
    </form>

    <div class="links">
        <p>Don't have account yet?</p>
        <a href="register.php" id="sign_up_button" style="text-decoration: none; color: #7AACAD;">Sign Up</a>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="module">
    $(function () {
        const signInForm = $('#sign_in_form');

        // Handle sign-in form submission
        signInForm.on('submit', function (e) {
            e.preventDefault();

            $('.validation-errors').remove();
            const email = $('#email').val();
            const password = $('#password').val();
            const rememberMe = $('#remember_me').is(':checked');

            const errors = [];

            // Validate inputs
            if (!email) {
                errors['email'] = 'Email is required.';
            } else {
                if (email && !isValidEmail(email)) {
                    errors['email'] = 'Invalid email format.';
                }
            }

            if (!password) {
                errors['password'] = 'Password is required.';
            }

            if (Object.keys(errors).length) {
                displayErrors(errors);
            } else {
                // Proceed with AJAX request
                let formData = new FormData(signInForm[0]);
                formData.append('action', 'sign_in');
                formData.append('remember_me', rememberMe);

                $.ajax({
                    url: 'ajax.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status) {
                            window.location.href = 'index.php';
                        } else {
                            if (response.errors) {
                                displayErrors(response.errors)
                            } else {
                                if (response.message) {
                                    alert(response.message);
                                }

                                if (response.redirect) {
                                    window.location.href = response.redirect;
                                }
                            }
                        }
                    },
                    error: function (response) {
                        alert('Error' + response);
                    }
                })
            }
        });
    })

    function isValidEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    function displayErrors(errors) {
        console.log(errors);
        for (let error in errors) {
            $('#' + error).closest('.input-group').append($('<span class="validation-errors" style="color: red;">' + errors[error] + '</span>'));
        }
    }
</script>
</body>
