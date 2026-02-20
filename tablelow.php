<!DOCTYPE html>
<html lang="en">
<head>
<?php include ("head.php"); ?>
</head>

<body>
<?php
//error_reporting(0);
include ("./includes/settings.inc.php");
include ("./includes/connectdb.inc.php");
session_start();
if(isset($_SESSION['uName'])) {
include ("./includes/floorplan.php");
include ("change table low.php");
?>

<?php include ("header.php"); ?>
<?php include ("menu.php"); ?>

<div id="page-wrapper">
    <div class="container-fluid">

        <h1 class="page-header">Floor Plan</h1>
        <p class="page-subtitle">View and manage table statuses across the restaurant floor.</p>

        <div class="well">
            <!-- Legend -->
            <div class="status-legend">
                <div class="legend-item"><span class="legend-dot open"></span> Open</div>
                <div class="legend-item"><span class="legend-dot occupied"></span> Occupied</div>
                <div class="legend-item"><span class="legend-dot dirty"></span> Needs Cleaning</div>
            </div>

            <div class="tableContainer">
            <?php
                $tabs = new Table;
                $limit = $tabs->totCount();
                $status = $tabs->totStatus();
                $tables = explode(";",$status);
                for($i = 0; $i<$limit; $i++) {
                    $tabDet = explode("-",$tables[$i]);
                    echo "<div class='circleBaseBoy circleSize ".$tabDet[1]."'>".$tabDet[0]."</div>";
                }
                if(isset($_REQUEST['id']) && $_REQUEST['status']!="") {
                    $tabs->updateStatus($_REQUEST['id'], $_REQUEST['status']);
                }
            ?>
            </div>

            <div class="controls">
                <button class="btn btn-default" data-toggle="modal" data-target="#status" id="changeStatusBoy" disabled>
                    <i class="fa fa-refresh"></i> Change Status
                </button>
            </div>
        </div>
    </div>
    <?php include ("footer.php"); ?>
</div>

<?php
} else {
include ("login.php");
?>

<?php include ("header.php"); ?>

<div style="margin-top: var(--topbar-h);">
    <div class="login-center-wrap">
        <div class="login-center-card">
            <div class="brand-icon-lg"><i class="fa fa-eye"></i></div>
            <h2>Restaurant POS</h2>
            <p>Please log in to access the system.</p>
            <button class="btn btn-primary" style="width:100%; padding:12px;" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-sign-in"></i> Log In
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
