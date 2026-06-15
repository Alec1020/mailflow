<?php
session_start();
// include "../config/database.php";
// include "../models/User.php";

// $userObj = new User($conn);

require_once "../config/database.php";
require_once "../models/User.php";

// require_once __DIR__ . '/../includes/header.php';
// require_once __DIR__ . '/../includes/footer.php';

$db = (new Database())->connect();

$userObj = new User($db);

if($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // $user = $userObj->verify($email, $password);
    $user = $userObj->login($email, $password);

    if($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        header("Location: ../dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>

<?php include "../templates/header.php"; ?>

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="card p-4 bg-secondary text-light">
        <h3>Login</h3>
        <?php if(isset($error)) echo "<div class='text-danger'>$error</div>"; ?>
        <form method="POST">
            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
            <button class="btn btn-primary w-100" type="submit">Login</button>
        </form>
        <p class="mt-2"><a href="register.php">Don't have an account? Register</a></p>
    </div>
</div>

<?php include "../templates/footer.php"; ?>