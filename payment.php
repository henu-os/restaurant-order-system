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
error_reporting(0);
include ("./includes/payment.php");
?>

<?php include ("header.php"); ?>
<?php include ("menu.php"); ?>

<div id="page-wrapper">
    <div class="container-fluid">

        <h1 class="page-header">Payment</h1>
        <p class="page-subtitle">Process payments for completed orders.</p>

        <div class="well">
            <p style="color:var(--muted); font-size:13px; margin-bottom:14px;">
                Select a completed order to view the total and process payment.
            </p>
            <div id="orderContainer">
                <!-- Payment Queue List -->
                <div id="orderQueueList" class="orderList">
                    <div style="padding:12px 16px; font-size:11px; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; border-bottom:1px solid var(--border); background:var(--bg);">
                        Ready for Payment
                    </div>
                    <?php
                        $list = new Payment;
                        $orderList = explode("*",$list->OrderQueueList());
                        if($list->orderLimit() > 0) {
                            for($i = 0; $i<$list->orderLimit(); $i++) {
                                $orderDetails = explode(";",$orderList[($i*3)+2]);
                                echo "<div class='orderListSel'>".$orderList[$i*3]."
                                      <div class='orderDetails hide'>
                                      <p>Table ".$orderList[($i*3)+1]."</p>";
                                      $sum = 0;
                                      for($j = 0; $j<count($orderDetails)-1; $j++) {
                                          $orderPrettyList = explode("-",$orderDetails[$j]);
                                          echo "<span class='left'>".$orderPrettyList[0]."</span><span class='right'>$".$orderPrettyList[1]." x ".$orderPrettyList[2]."</span><br/>";
                                          $sum += $orderPrettyList[1]*$orderPrettyList[2];
                                      }
                                echo "<hr/>
                                      <div style='display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;'>
                                        <span style='font-weight:700; font-size:15px;'>Total</span>
                                        <span style='font-weight:700; font-size:18px; color:var(--primary);'>$".$sum."</span>
                                      </div>
                                      <p class='mt65'><button class='btn btn-success pay' id='payment".$orderList[($i*3)+1]."'><i class='fa fa-check'></i> Process Payment</button></p>
                                      </div>
                                      </div>";
                            }
                        } else {
                            echo "<div style='padding:40px; text-align:center; color:var(--muted);'>
                                <i class='fa fa-check-circle' style='font-size:36px; margin-bottom:10px; display:block; color:var(--success);'></i>
                                No pending payments
                            </div>";
                        }
                        if(isset($_REQUEST['tabidNoti']) && $_REQUEST['tabidNoti']!="") {
                            $list->pay($_REQUEST['tabidNoti']);
                        }
                    ?>
                </div>
                <!-- Detail Panel -->
                <div id="itemList" class="orderList">
                    <div style="padding:12px 16px; font-size:11px; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; border-bottom:1px solid var(--border); background:var(--bg);">
                        Order Details
                    </div>
                    <div style="padding:40px; text-align:center; color:var(--muted); font-size:13px;">
                        <i class="fa fa-arrow-left" style="display:block; font-size:24px; margin-bottom:10px;"></i>
                        Select an order to view details
                    </div>
                </div>
            </div>
        </div>
        <?php include ("footer.php"); ?>
    </div>
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
