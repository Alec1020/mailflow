<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

include "config/database.php";

require_once __DIR__ . '/templates/header.php';

?>

<div class="container-fluid">
    <div class="row" style="height:100vh;">
        <!-- Sidebar -->
        <div class="col-md-3 bg-secondary p-3 d-flex flex-column">
            <?php include "templates/sidebar.php"; ?>
        </div>

        <!-- Mail content -->
        <div class="col-md-9 bg-dark text-light p-3">
            <div class="d-flex justify-content-between mb-2">
                <span>User: <?php echo $_SESSION['user_name']; ?></span>
                <a href="auth/logout.php" class="btn btn-danger btn-sm">Sign Out</a>
            </div>
            <div id="mailContent"
                class="border border-secondary p-4 h-100">

                <div class="text-center mt-5">

                    <h3>
                        📧 Email Viewer
                    </h3>

                    <p>
                        Select a message from the inbox.
                    </p>

                </div>

            </div>
        </div>
    </div>
</div>

<?php include "templates/compose_modal.php"; ?>
<?php require_once __DIR__ . '/templates/footer.php'; ?>