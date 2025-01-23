<?php
session_start();

global $conn;
include 'config/db_connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once __DIR__ . '/PHPMailer/vendor/autoload.php';



function sendVerificationEmail($toEmail, $verificationCode) {


    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'luiskruja04@gmail.com';
        $mail->Password = 'dwvd ozdb oewj wbgn';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('luiskruja04@gmail.com', 'Your App Name');
        $mail->addAddress($toEmail);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
        $mail->Body = "Your verification code is: <strong>$verificationCode</strong>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}




function generateToken()
{
    return password_hash(uniqid(more_entropy: true), PASSWORD_DEFAULT); // Generates a random token
}

// Handle auto-login via Remember Me token
function handleAutoLogin($conn)
{
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

                    $rememberToken = password_hash(generateToken(), PASSWORD_DEFAULT);

                    $stmt = $conn->prepare("UPDATE sessions SET remember_me_token = ? WHERE user_id = ?");
                    $stmt->bind_param("ss", $rememberToken, $usersRow['user_id']);
                    $stmt->execute();

                    setcookie("remember_token", $rememberToken, time() + (30 * 24 * 60 * 60), "/", "", false, true);
                }
            }
        }
    }
}

// Handle AJAX requests for sign-up



if (isset($_POST['action']) && $_POST['action'] === 'sign_up') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $errors = [];

    // Validate input
    if (empty($firstName)) {
        $errors['first_name'] = "First name is required.";
    }

    if (empty($lastName)) {
        $errors['last_name'] = "Last name is required.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        } else {
            // Check if email already exists
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $errors['email'] = "Email already exists.";
            }
        }
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }

    if (empty($confirmPassword)) {
        $errors['confirm_password'] = "Password confirmation is required.";
    }

    if (!empty($password) && !empty($confirmPassword)) {
        if ($password !== $confirmPassword) {
            $errors['confirm_password'] = "Passwords do not match.";
        }
    }

    if (!empty($errors)) {
        echo json_encode([
            'status' => false,
            'errors' => $errors
        ]);
        exit;
    } else {
        // Hash the password and save the user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $verificationCode = rand(100000, 999999);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, email_verification_code ) VALUES (?, ?, ?, 'user', ?)");
        $name = $firstName . " " . $lastName;
        $stmt->bind_param('ssss', $name, $email, $hashedPassword, $verificationCode);

        $_SESSION['email'] = $email;

        $stmt->execute();
        if (sendVerificationEmail($email, $verificationCode)) {
            echo json_encode([
                'status' => true,
                'message' => 'Email verification code was sent to your email!',
                'redirect' => '/booking-app/verifyEmail.php'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Failed to send verification email.'
            ]);
        }
    }
}

if (isset($_POST['action']) && $_POST['action'] === 'verify_email') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['email'])) {
        echo json_encode([
            'status' => false,
            'errors' => [
                'general' => 'Session expired or email not set. Please try signing in again.'
            ]
        ]);
        exit;
    }

    $verificationCode = trim($_POST['verification_code']);
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND email_verification_code = ?");
    $stmt->bind_param("ss", $email, $verificationCode);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE users SET email_verification_code = NULL, email_verified_at = CURRENT_TIMESTAMP WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        session_destroy();

        echo json_encode([
            'status' => true,
            'message' => 'Email was verified successfully!',
            'redirect' => 'login.php'
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => false,
            'errors' => [
                'verification_code' => 'Verification code not correct.'
            ]
        ]);
        exit;
    }


}



// Handle AJAX requests for sign-in
if (isset($_POST['action']) && $_POST['action'] === 'sign_in') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $rememberMe = $_POST['remember_me'] ?? false;

    $errors = [];

    // Validate input
    if (empty($email)) {
        $errors['email'] = 'Email is required.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    } else {
        // Check user credentials
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($result->num_rows > 0) {
            if (is_null($row['email_verified_at'])) {
                $_SESSION['email'] = $email;
                $_SESSION['step'] = 'verify_email';

                $verificationCode = rand(100000, 999999);
                mail($email, 'Registration', 'Your verification code is: ' . $verificationCode);

                $stmt = $conn->prepare("UPDATE users SET email_verification_code = $verificationCode WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();

                echo json_encode([
                    'status' => false,
                    'message' => 'Your email is not verified! Email verification code was sent to your email!',
                    'redirect' => 'verifyEmail.php'
                ]);
                exit;
            }

            if (empty($password)) {
                $errors['password'] = 'Password is required.';
            } else {
                if (password_verify($password, $row['password'])) {
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["name"] = $row["name"];

                    if ($rememberMe) {
                        handleAutoLogin($conn);
                    }

                    echo json_encode([
                        'status' => true,
                        'message' => 'Login successful!'
                    ]);
                    exit;
                } else {
                    $errors['password'] = 'Incorrect password.';
                }
            }
        } else {
            $errors['email'] = 'Email not found.';
        }
    }

    echo json_encode([
        'status' => false,
        'errors' => $errors
    ]);
    exit;
}


// Handle logout
if (isset($_POST['action']) && $_POST['action'] === 'logout') {
    session_destroy();

    // Clear the token from the database
    $stmt = $conn->prepare("UPDATE users SET remember_token = NULL WHERE email = ?");
    $stmt->bind_param("s", $_SESSION["email"]);
    $stmt->execute();

    // Clear the cookie
    setcookie("remember_token", "", time() - 3600, "/", "", false, true);

    echo json_encode(['status' => 'success', 'message' => 'Logout successful!']);
    exit;
}

?>