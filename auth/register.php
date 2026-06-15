<?php

session_start();

require_once "../config/database.php";
require_once "../models/User.php";

$db = (new Database())->connect();

$userModel = new User($db);

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    $email = trim($_POST['email']);

    $password = $_POST['password'];

    if (
        empty($name) ||
        empty($email) ||
        empty($password)
    ) {
        $error = "All fields are required.";
    } elseif (
        $userModel->findByEmail(
            $email
        )
    ) {
        $error = "Email already exists.";
    } else {
        // if (
        //     $userModel->create(
        //         $name,
        //         $email,
        //         $password
        //     )
        // )
        // {
        //     $success =
        //         "Account created successfully.";
        // }
        if (
            $userModel->create(
                $name,
                $email,
                $password
            )
        ) {
            header("Location: login.php?registered=1");
            exit;
        } else {
            $error =
                "Unable to create account.";
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Register</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-dark">

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-5">

                <div class="card">

                    <div class="card-body">

                        <h3>Create User</h3>

                        <?php if ($error): ?>
                            <div class="alert alert-danger">
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                            <div class="alert alert-success">
                                <?= htmlspecialchars($success) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">

                            <input
                                type="text"
                                name="name"
                                class="form-control mb-3"
                                placeholder="Full Name"
                                required>

                            <input
                                type="email"
                                name="email"
                                class="form-control mb-3"
                                placeholder="Email"
                                required>

                            <input
                                type="password"
                                name="password"
                                class="form-control mb-3"
                                placeholder="Password"
                                required>

                            <button
                                class="btn btn-primary w-100">

                                Create User

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>