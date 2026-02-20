<?php
    if (!isset($_SESSION)) { session_start(); }
    $uName = '';
    $uInitial = '';
    $uRole = '';
    if (isset($_SESSION['uName'])) {
        $uName    = ucfirst($_SESSION['uName']);
        $uInitial = strtoupper(substr($uName, 0, 1));
        if (!class_exists('Employee')) {
            include_once ("./includes/employee.php");
        }
        $emp   = new Employee;
        $uRole = $emp->getRole($_SESSION['uName']);
    }
    $pageName = basename($_SERVER['PHP_SELF']);
?>
<!-- ===== Modern POS Top Bar ===== -->
<header class="pos-topbar">

    <!-- Brand (Henu Logo + text) -->
    <a href="index.php" class="pos-brand">
        <div class="brand-icon">
            <img src="HENU LOGO.svg" alt="Henu OS" style="width:22px;height:22px;object-fit:contain;filter:brightness(0) invert(1);">
        </div>
        Restaurant POS
    </a>

    <!-- Search (visible when logged in) -->
    <?php if ($uName): ?>
    <div class="pos-topbar-search">
        <input type="text" id="topbarSearch" placeholder="Search orders, tables…" autocomplete="off">
    </div>
    <?php endif; ?>

    <!-- Right side actions -->
    <div class="pos-topbar-right">
        <?php if ($uName): ?>

            <!-- Notifications bell -->
            <a href="#" class="pos-topbar-icon" title="Notifications" id="topbarBell">
                <i class="fa fa-bell-o"></i>
                <span class="badge-dot"></span>
            </a>

            <!-- Settings (go to index) -->
            <a href="index.php" class="pos-topbar-icon" title="Dashboard / Home">
                <i class="fa fa-home"></i>
            </a>

            <!-- Print -->
            <a href="javascript:window.print();" class="pos-topbar-icon" title="Print page">
                <i class="fa fa-print"></i>
            </a>

            <?php if ($uRole == 'waiter'): ?>
            <!-- Payment shortcut -->
            <a href="payment.php" class="pos-topbar-icon <?php echo ($pageName=='payment.php'?'active-icon':''); ?>" title="Go to Payments">
                <i class="fa fa-credit-card"></i>
            </a>
            <?php endif; ?>

            <!-- User chip dropdown -->
            <div class="dropdown">
                <a href="#" class="pos-user-chip dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <div class="avatar"><?php echo htmlspecialchars($uInitial); ?></div>
                    <span><?php echo htmlspecialchars($uName); ?></span>
                    <i class="fa fa-caret-down" style="margin-left:5px;font-size:12px;color:#94a3b8;"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" style="border-radius:10px;border:1px solid #E2E8F0;box-shadow:0 8px 24px rgba(0,0,0,.12);min-width:180px;margin-top:8px;padding:6px 0;">
                    <li>
                        <a href="#" style="display:flex;align-items:center;gap:10px;padding:10px 16px;color:var(--text);font-size:14px;font-weight:500;">
                            <i class="fa fa-user-circle-o" style="color:var(--muted);"></i> My Account
                        </a>
                    </li>
                    <li role="separator" style="border-top:1px solid var(--border);margin:4px 0;"></li>
                    <li>
                        <a href="logout.php" style="display:flex;align-items:center;gap:10px;padding:10px 16px;color:#EF4444;font-size:14px;font-weight:500;">
                            <i class="fa fa-power-off"></i> Log Out
                        </a>
                    </li>
                </ul>
            </div>

        <?php else: ?>
            <a class="btn btn-primary login-btn" data-toggle="modal" data-target="#myModal" style="font-size:15px;padding:9px 22px;">
                <i class="fa fa-sign-in"></i> Login
            </a>
        <?php endif; ?>
    </div><!--/pos-topbar-right-->
</header>

<script src="js/jquery-1.11.0.js"></script>
<script src="js/simulation.js"></script>
<script>
// Topbar search: live filter tables / items on page
$(document).ready(function(){
    $('#topbarSearch').on('keyup', function(){
        var q = $(this).val().toLowerCase();
        // Filter table cards
        $('.circleBase, .circleBaseBoy').each(function(){
            var txt = $(this).text().toLowerCase();
            $(this).closest('.circleBase, .circleBaseBoy').toggle(!q || txt.indexOf(q) !== -1);
        });
        // Filter item rows in left panel
        $('.pos-item-row').each(function(){
            var txt = $(this).text().toLowerCase();
            $(this).toggle(!q || txt.indexOf(q) !== -1);
        });
        // Filter order cards
        $('.order-card').each(function(){
            var txt = $(this).text().toLowerCase();
            $(this).toggle(!q || txt.indexOf(q) !== -1);
        });
    });

    // Bell icon: scroll to first notification / order card
    $('#topbarBell').on('click', function(e){
        e.preventDefault();
        var $card = $('.order-card, .orderListSel').first();
        if($card.length) $('html,body').animate({scrollTop: $card.offset().top - 80}, 300);
    });
});
</script>