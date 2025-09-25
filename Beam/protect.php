<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$correct_password = "srwtc";

if (!isset($_SESSION['authenticated'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['password'] === $correct_password) {
            $_SESSION['authenticated'] = true;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $error = "Incorrect password!";
        }
    }

    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Login | Gymnastics Scoring</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #f8f9fa;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                margin: 0;
            }
            .login-box {
                background: #fff;
                padding: 2rem;
                border-radius: 15px;
                box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
                max-width: 400px;
                width: 100%;
                text-align: center;
            }
            .login-box img {
                max-height: 100px;
                margin-bottom: 1.5rem;
            }
            .btn-red {
                background-color: #ff3131;
                color: white;
                border: 2px solid #ff3131;
                border-radius: 8px;
                padding: 0.75rem;
                font-weight: bold;
                width: 100%;
                transition: all 0.3s;
            }
            .btn-red:hover {
                background-color: white !important;
                color: #ff3131 !important;
                border: 2px solid #ff3131;
            }
            .form-control:focus {
                border-color: #ff3131;
                box-shadow: 0 0 0 0.25rem rgba(255, 49, 49, 0.25);
            }
        </style>
    </head>
    <body>
        <div class="login-box">
            <img src="../logo.png" alt="SRWTC Logo">
            <h4 class="mb-3">Enter Password</h4>
            <form method="post">
                <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                <button type="submit" class="btn btn-red">Login</button>
                ' . (isset($error) ? "<div class='text-danger mt-2'>$error</div>" : "") . '
            </form>
        </div>
    </body>
    </html>';
    exit;
}
?>