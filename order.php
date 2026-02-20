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
include ("./includes/orderqueue.php");
include ("./includes/notify.php");
$inform = new Notify;
if(isset($_REQUEST['tabidNoti']) && $_REQUEST['tabidNoti']!="") {
    $inform->order($_REQUEST['tabidNoti']);
}
$list = new OrderQueue;
?>

<?php include ("header.php"); ?>
<?php include ("menu.php"); ?>

<div id="page-wrapper">
  <div class="kitchen-layout">

    <!-- COLUMN 1: Pending -->
    <div class="kitchen-col">
      <div class="kitchen-col-header">
        <span class="kitchen-col-title">Pending</span>
        <span class="kitchen-col-badge badge-pending"><?php echo $list->orderLimit(); ?> orders</span>
      </div>
      <div class="kitchen-col-actions">
        <button class="btn btn-primary btn-sm">Table</button>
        <button class="btn btn-default btn-sm">4/1</button>
        <button class="btn btn-warning btn-sm" style="color:#fff;">8/5</button>
      </div>
      <div class="kitchen-orders" id="orderQueueList">
        <?php
        if($list->orderLimit() != 0) {
            $orderList = explode("*",$list->OrderQueueList());
            for($i=0; $i<$list->orderLimit(); $i++) {
                $orderDetails = explode(";",$orderList[($i*3)+2]);
                $ref   = $orderList[$i*3];
                $table = $orderList[($i*3)+1];
                echo "<div class='order-card orderListSel' id='card_$i'>
                    <div class='order-card-header'>
                        <span class='order-card-ref'><i class='fa fa-circle' style='color:var(--warning);font-size:8px;vertical-align:middle;margin-right:5px;'></i>".htmlspecialchars($ref)."</span>
                        <span class='order-card-table'>Table ".htmlspecialchars($table)."</span>
                    </div>
                    <div class='order-card-body orderDetails hide'>";
                for($j=0; $j<count($orderDetails)-1; $j++) {
                    $item = explode("-",$orderDetails[$j]);
                    echo "<div class='order-card-item'><span>".htmlspecialchars($item[0])."</span><span style='color:var(--muted)'>×".htmlspecialchars($item[1])."</span></div>";
                }
                echo "  </div>
                    <div class='order-card-action'>
                        <button class='btn btn-success btn-sm notify' id='notify$table' style='width:100%;'>
                            <i class='fa fa-check'></i> Send to Kitchen
                        </button>
                    </div>
                </div>";
            }
        } else {
            echo "<div style='padding:40px 16px;text-align:center;color:var(--muted);'>
                    <i class='fa fa-check-circle' style='font-size:32px;color:var(--success);display:block;margin-bottom:10px;'></i>
                    No pending orders
                  </div>";
        }
        ?>
      </div>
    </div><!-- /col Pending -->

    <!-- COLUMN 2: Preparing -->
    <div class="kitchen-col">
      <div class="kitchen-col-header">
        <span class="kitchen-col-title">Preparing</span>
        <div style="display:flex;align-items:center;gap:8px;">
          <span class="kitchen-col-badge badge-prep">In progress</span>
        </div>
      </div>
      <div class="kitchen-col-actions">
        <button class="btn btn-primary btn-sm">Batati</button>
        <button class="btn btn-default btn-sm">Version</button>
      </div>
      <div class="kitchen-orders">
        <!-- Placeholder prep cards -->
        <div class="order-card">
          <div class="order-card-header">
            <span class="order-card-ref"><i class="fa fa-circle" style="color:var(--primary);font-size:8px;vertical-align:middle;margin-right:5px;"></i>Order 412</span>
            <span class="order-card-table">Table 3</span>
          </div>
          <div class="order-card-body">
            <div class="order-card-item"><span>Shrimp Tacos</span><span>×1</span></div>
            <div class="order-card-item"><span>Caesar Salad</span><span>×2</span></div>
            <div class="order-card-item"><span>Coke</span><span>×2</span></div>
          </div>
          <div class="order-card-action">
            <div style="background:var(--primary-lt);border-radius:6px;padding:4px 8px;font-size:11px;font-weight:600;color:var(--primary);">
              <i class="fa fa-clock-o"></i> In preparation
            </div>
          </div>
        </div>
        <div class="order-card">
          <div class="order-card-header">
            <span class="order-card-ref"><i class="fa fa-circle" style="color:var(--primary);font-size:8px;vertical-align:middle;margin-right:5px;"></i>Order 3:19</span>
            <span class="order-card-table">Table 5</span>
          </div>
          <div class="order-card-body">
            <div class="order-card-item"><span>Shrimp Tacos</span><span>×2</span></div>
            <div class="order-card-item"><span>Caesar Salad</span><span>×1</span></div>
            <div class="order-card-item"><span>Shrimp Token</span><span>×1</span></div>
          </div>
          <div class="order-card-action">
            <div style="background:var(--primary-lt);border-radius:6px;padding:4px 8px;font-size:11px;font-weight:600;color:var(--primary);">
              <i class="fa fa-clock-o"></i> In preparation
            </div>
          </div>
        </div>
      </div>
    </div><!-- /col Preparing -->

    <!-- COLUMN 3: Ready -->
    <div class="kitchen-col">
      <div class="kitchen-col-header">
        <span class="kitchen-col-title">Ready</span>
        <div style="display:flex;align-items:center;gap:6px;">
          <button class="btn btn-default btn-sm">Ready</button>
          <button class="btn btn-default btn-sm">React</button>
        </div>
      </div>
      <div class="kitchen-col-actions" style="background:var(--card-bg); border-bottom:1px solid var(--border);padding:8px 12px;">
        <span style="font-size:11px;color:var(--muted);">Completed orders below</span>
      </div>
      <div class="kitchen-orders">
        <div class="order-card">
          <div class="order-card-header" style="background:#f0fdf4;">
            <span class="order-card-ref"><i class="fa fa-circle" style="color:var(--success);font-size:8px;vertical-align:middle;margin-right:5px;"></i>Order 416</span>
            <span class="order-card-table">Table 2</span>
          </div>
          <div class="order-card-body">
            <div class="order-card-item"><span>Shrimp Tacos</span><span>×1</span></div>
            <div class="order-card-item"><span>Caesar Salad</span><span>×1</span></div>
          </div>
          <div class="order-card-action">
            <div style="background:#dcfce7;border-radius:6px;padding:4px 8px;font-size:11px;font-weight:600;color:#166534;">
              <i class="fa fa-check"></i> Ready
            </div>
          </div>
        </div>
        <div class="order-card">
          <div class="order-card-header" style="background:#f0fdf4;">
            <span class="order-card-ref"><i class="fa fa-circle" style="color:var(--success);font-size:8px;vertical-align:middle;margin-right:5px;"></i>Order 414</span>
            <span class="order-card-table">Table 6</span>
          </div>
          <div class="order-card-body">
            <div class="order-card-item"><span>Veggie Loved</span><span>×1</span></div>
            <div class="order-card-item"><span>Caesar Salad</span><span>×2</span></div>
          </div>
          <div class="order-card-action">
            <div style="background:#dcfce7;border-radius:6px;padding:4px 8px;font-size:11px;font-weight:600;color:#166534;">
              <i class="fa fa-check"></i> Ready
            </div>
          </div>
        </div>
      </div>
    </div><!-- /col Ready -->

  </div><!-- /kitchen-layout -->
</div>

<?php
} else {
include ("login.php");
?>
<?php include ("header.php"); ?>
<div style="padding-top:var(--topbar-h);">
  <div class="login-center-wrap">
    <div class="login-center-card">
      <div class="brand-icon-lg"><i class="fa fa-eye"></i></div>
      <h2>Restaurant POS</h2>
      <p>Sign in to access the system</p>
      <button class="btn btn-primary" style="width:100%;padding:12px;" data-toggle="modal" data-target="#myModal">
        <i class="fa fa-sign-in"></i> Sign In
      </button>
    </div>
  </div>
</div>
<?php } ?>

<script src="js/jquery-1.11.0.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
