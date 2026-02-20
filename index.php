<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include ("head.php"); ?>
</head>

<body>
<?php
include ("./includes/settings.inc.php");
include ("./includes/connectdb.inc.php");
session_start();
if(isset($_SESSION['uName'])) {
?>

<?php include ("header.php"); ?>
<?php include ("menu.php"); ?>

<div id="page-wrapper">
    <div class="container-fluid">

        <h1 class="page-header">Dashboard</h1>
        <p class="page-subtitle">Welcome back. Use the sidebar to navigate.</p>

        <div class="well" style="max-width:480px;">
            <div style="display:flex; align-items:center; gap:14px; margin-bottom:16px;">
                <div style="width:48px; height:48px; background:var(--primary-lt); border-radius:12px; display:flex; align-items:center; justify-content:center; color:var(--primary); font-size:22px;">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div>
                    <div style="font-weight:700; font-size:16px;">You're logged in</div>
                    <div style="color:var(--muted); font-size:13px;">Select an option from the sidebar to get started.</div>
                </div>
            </div>
            <a href="<?php
                include ("./includes/employee.php");
                $u = new Employee; $r = $u->getRole($_SESSION['uName']);
                echo ($r=='waiter' ? 'table.php' : ($r=='cook' ? 'order.php' : 'tablelow.php'));
            ?>" class="btn btn-primary">
                <i class="fa fa-arrow-right"></i> Go to My View
            </a>
        <?php include ("footer.php"); ?>
        </div>

    </div>
</div>

<?php
} else {
    // Handle POST login here (include login.php for the modal + handler)
    include ("login.php");
?>

<?php include ("header.php"); ?>

<div style="padding-top: var(--topbar-h);">
    <div class="login-center-wrap">
        <div class="login-center-card">
            <div class="brand-icon-lg"><i class="fa fa-eye"></i></div>
            <h2>Restaurant POS</h2>
            <p>Sign in to access the system</p>
            <button class="btn btn-primary" style="width:100%; padding:13px 24px; font-size:15px;" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-sign-in"></i>&nbsp; Sign In
            </button>
        </div>
    </div>
</div>

<?php
}
?>

    <!-- jQuery -->
    <script src="js/jquery-1.11.0.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="js/custom.js"></script>

</body>
</html>
