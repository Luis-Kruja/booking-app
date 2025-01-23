<?php
session_start();
if (isset($_SESSION['email']) && !isset($_SESSION['step'])) {
    header('Location: index.php');
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
    <h1 class="form-title">Register</h1>
    <form id="sign_up_form" method="post" action="ajax.php">
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="first_name" id="first_name" placeholder="First Name">
            <label for="first_name">First Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="last_name" id="last_name" placeholder="Last Name">
            <label for="last_name">Last Name</label>
        </div>
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
            <i class="fas fa-lock"></i>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="confirmPassword" >
            <label for="confirm_password">Confirm Password</label>
        </div>
        <button type="submit" class="btn" name="sign_up">Sign Up</button>
    </form>

    <div class="links">
        <p>Already Have Account ?</p>
        <a href="login.php" style="text-decoration: none; color: #7AACAD;">Sign In</a>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="module">
    $(function () {
        const signUpForm = $('#sign_up_form');
        // Handle sign-up form submission
        signUpForm.on('submit', function (e) {
            e.preventDefault();

            $('.validation-errors').remove();
            const email = $('#email').val();
            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();
            const firstName = $('#first_name').val();
            const lastName = $('#last_name').val();

            const errors = [];

            // Validate inputs
            if (!firstName) {
                errors['first_name'] = 'First name is required.';
            }

            if (!lastName) {
                errors['last_name'] = 'Last name is required.';
            }

            if (!email) {
                errors['email'] = 'Email is required.';
            } else {
                if (!isValidEmail(email)) {
                    errors['email'] = 'Invalid email format.';
                }
            }

            if (!password) {
                errors['password'] = 'Password is required.';
            }

            if (!confirmPassword) {
                errors['confirm_password'] = 'Password confirmation is required.';
            }

            if (password && confirmPassword) {
                if (password !== confirmPassword) {
                    errors['confirm_password'] = 'Passwords do not match.';
                }
            }

            if (Object.keys(errors).length) {
                displayErrors(errors);
            } else {
                // Proceed with AJAX request
                const formData = new FormData(this);
                formData.append('action', 'sign_up');

                $.ajax({
                    url: 'ajax.php',
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        if (response.status) {
                            // console.log(response);
                            // console.log(window.location.href);
                            // console.log(window.location.href = response.redirect);
                            alert(response.message);
                            window.location.href = response.redirect;
                        } else {
                            if (response.errors) {
                                displayErrors(response.errors);
                            } else {
                                if (response.message) {
                                    alert(response.message)
                                }
                            }
                        }
                    },
                    error: function (response) {
                        alert(response);
                    }
                });
            }
        });
    });

    // Helper function to validate email
    function isValidEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    function displayErrors(errors) {
        for (let error in errors) {
            $('#' + error).closest('.input-group').append($('<span class="validation-errors" style="color: red;">' + errors[error] + '</span>'));
        }
    }
</script>
</body>
</html>