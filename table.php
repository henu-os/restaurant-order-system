<!DOCTYPE html>
<html lang="en">
<head>
<?php include ("head.php"); ?>
<style>
/* Fix JS color checks — keep actual hex bg color values consistent */
.open     { background-color: #22c55e !important; }
.occupied { background-color: #f59e0b !important; }
.dirty    { background-color: #ef4444 !important; }
</style>
</head>
<body>
<?php
error_reporting(0);
include ("./includes/settings.inc.php");
include ("./includes/connectdb.inc.php");
session_start();
if(isset($_SESSION['uName'])) {
include ("./includes/floorplan.php");
include ("./includes/category.php");
include ("./includes/item.php");
include ("./includes/orderline.php");
include ("./includes/order.php");
include ("change table.php");
include ("select category.php");
include ("add items.php");
include ("confirmation.php");

// Build table data
$tabs = new Table;
$limit = $tabs->tabCount();
$status = $tabs->tabStatus();
$tables = explode(";",$status);

// Handle AJAX updates
if(isset($_REQUEST['id']) && $_REQUEST['status']!="") {
    $tabs->updateStatus($_REQUEST['id'], $_REQUEST['status']);
}
$order = new OrderLines;
if(isset($_REQUEST['price']) && $_REQUEST['price']!="") {
    $order->addItem($_REQUEST['tabid'], $_REQUEST['desc'], $_REQUEST['quantity'], $_REQUEST['price']);
    echo $order->viewLineItem($_REQUEST['tabid']);
}
$place = new PlaceOrders;
if(isset($_REQUEST['tabidOrder']) && $_REQUEST['tabidOrder']!="") {
    $place->addOrder($_REQUEST['tabidOrder']);
}

// Build category data
$cat = new Category;
$categoryList = explode(";",$cat->categoryList());
?>

<?php include ("header.php"); ?>
<?php include ("menu.php"); ?>

<!-- ====== Main POS Layout ====== -->
<div id="page-wrapper">
  <div class="pos-layout">

    <!-- LEFT PANEL: Table tabs + category + item icons -->
    <div class="pos-left">

      <!-- Table tabs row -->
      <div style="padding:12px 14px 0; border-bottom:1px solid var(--border); background:var(--card-bg);">
        <div style="font-size:10px; font-weight:600; letter-spacing:.07em; text-transform:uppercase; color:var(--muted); margin-bottom:8px;">My Tables</div>
        <div class="pos-table-tabs" style="padding:0; margin-bottom:10px; gap:6px; display:flex; flex-wrap:wrap;">
          <?php
          for($i=0; $i<$limit; $i++) {
              $tabDet = explode("-",$tables[$i]);
              $tNum = $tabDet[0];
              $tStat = $tabDet[1];
              $cls = ($tStat=='occupied') ? 'occupied' : (($tStat=='dirty') ? 'dirty' : '');
              echo "<button class='pos-tab-btn num $cls' title='Table $tNum - $tStat'>$tNum</button>";
          }
          ?>
        </div>
      </div>

      <!-- Category filter -->
      <div class="pos-cat-bar">
        <button class="pos-cat-btn active">All</button>
        <?php
        for($i=0; $i<$cat->catLimit(); $i++) {
            $catOpt = explode("-",$categoryList[$i]);
            echo "<button class='pos-cat-btn'>".htmlspecialchars($catOpt[1])."</button>";
        }
        ?>
      </div>

      <!-- Item list -->
      <div class="pos-item-list">
        <?php
        $icons = ['🍔','🥗','🍕','🥤','🍝','🍟','🍰','🧃','🍜','🥩'];
        $iconIdx = 0;
        for($i=0; $i<$cat->catLimit(); $i++) {
            $catOpt = explode("-",$categoryList[$i]);
            $catId  = $catOpt[0];
            $catName= $catOpt[1];
            $items = new Item;
            $items->itemList($catId);
            if($items->itemLimit() > 0) {
                $itemList = explode(";",$items->getItemList());
                echo "<div style='font-size:10px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:var(--muted); padding:8px 0 4px; border-bottom:1px solid var(--border); margin-bottom:4px;'>".htmlspecialchars($catName)."</div>";
                for($j=0; $j<$items->itemLimit(); $j++) {
                    $itemOpt = explode("-",$itemList[$j]);
                    $icon = $icons[$iconIdx % count($icons)];
                    $iconIdx++;
                    echo "<div class='pos-item-row'>
                        <div class='pos-item-icon'>$icon</div>
                        <div class='pos-item-name'>".htmlspecialchars($itemOpt[0])."</div>
                        <div class='pos-item-price'>$".htmlspecialchars($itemOpt[1])."</div>
                    </div>";
                }
            }
        }
        ?>
      </div>
    </div><!-- /pos-left -->

    <!-- RIGHT PANEL: Table grid + actions -->
    <div class="pos-right">
      <div class="pos-right-header">
        <h2>Table Management</h2>
        <p>Select a table to manage orders and status.</p>
      </div>

      <div class="pos-table-grid">
        <!-- Status Legend -->
        <div class="status-legend">
          <div class="legend-item"><span class="legend-dot open"></span> Open</div>
          <div class="legend-item"><span class="legend-dot occupied"></span> Occupied</div>
          <div class="legend-item"><span class="legend-dot dirty"></span> Needs Cleaning</div>
        </div>

        <!-- Table circles -->
        <div class="tableContainer">
        <?php
        for($i=0; $i<$limit; $i++) {
            $tabDet = explode("-",$tables[$i]);
            echo "<div class='circleBase circleSize ".$tabDet[1]."'>".$tabDet[0]."</div>";
        }
        ?>
        </div>
      </div>

      <!-- Action bar -->
      <div class="pos-action-bar">
        <button class="btn btn-primary" data-toggle="modal" data-target="#selCategory" id="addItem" disabled>
            <i class="fa fa-plus"></i> Add Items
        </button>
        <button class="btn btn-default" data-toggle="modal" data-target="#status" id="changeStatus" disabled>
            <i class="fa fa-refresh"></i> Change Status
        </button>
        <div style="margin-left:auto;">
          <?php include ("footer.php"); ?>
        </div>
      </div>
    </div><!-- /pos-right -->

  </div><!-- /pos-layout -->
</div>

<script>
// Override JS color checks for new CSS colors
$(document).ready(function(){
    $(".circleBase").click(function(){
        $(".circleSize").removeClass("selected").css("border","");
        $(this).addClass("selected");
        $("#changeStatus").prop('disabled',false).removeClass('btn-disabled').addClass('btn-default');
        var bg = $(this).css("background-color");
        // occupied = rgb(245,158,11) approx → add items enabled
        // dirty = rgb(239,68,68) → add items disabled
        // open = rgb(34,197,94) → add items disabled
        var isOccupied = $(this).hasClass("occupied");
        var isDirty = $(this).hasClass("dirty");
        var isOpen = $(this).hasClass("open");
        if(isOccupied){
            $("#addItem").prop('disabled',false).removeClass('btn-disabled').addClass('btn-primary');
        } else {
            $("#addItem").prop('disabled',true).addClass('btn-disabled').removeClass('btn-primary');
        }
    });

    $("#changeStatus").click(function(){
        $("input[name=status]").prop("checked",false);
        $(".radioStatus").show();
        $("#tabSave").show();
        $("#changeDenied").hide();
        if($(".tableContainer").find(".selected").hasClass("dirty")){
            $(".radioStatus").hide(); $("#tabSave").hide(); $("#changeDenied").show();
        }
    });

    $("#tabSave").click(function(){
        var sel = $(".tableContainer").find(".selected");
        var val = $("input:radio[name=status]:checked").val();
        sel.removeClass("open occupied dirty");
        if(val=="yellow"){ sel.addClass("occupied"); $("#addItem").prop('disabled',false).removeClass('btn-disabled').addClass('btn-primary'); }
        if(val=="red")   { sel.addClass("dirty");    $("#addItem").prop('disabled',true).addClass('btn-disabled').removeClass('btn-primary'); }
        $('#status').modal('hide');
        var getid   = sel.text().trim();
        var getstat = val=="yellow" ? "occupied" : "dirty";
        $.post("table.php",{id:getid, status:getstat});
    });

    // Category pill filter
    $(".pos-cat-btn").click(function(){
        $(".pos-cat-btn").removeClass("active");
        $(this).addClass("active");
    });
    // Table num pill click → highlight matching circle
    $(".pos-tab-btn.num").click(function(){
        var num = $(this).text().trim();
        $(".circleBase").each(function(){
            if($(this).text().trim()==num){ $(this).trigger("click"); }
        });
    });
});
</script>

<?php
} else {
include ("login.php");
?>
<?php include ("header.php"); ?>
<div style="padding-top: var(--topbar-h);">
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
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
