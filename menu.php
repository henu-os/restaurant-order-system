<?php
    $pageName = basename($_SERVER['PHP_SELF']);
    if (!class_exists('Employee')) { include_once ("./includes/employee.php"); }
    $currentUser = new Employee;
    $role = $currentUser->getRole($_SESSION['uName']);
?>
<!-- ===== Sidebar ===== -->
<aside class="pos-sidebar">
    <div class="sidebar-section-label">Navigation</div>

    <?php if ($role == "waiter"): ?>
        <a href="table.php"   class="sidebar-link <?php echo ($pageName=='table.php'  ? 'active':''); ?>">
            <i class="fa fa-th-large"></i> Table Status
        </a>
        <a href="payment.php" class="sidebar-link <?php echo ($pageName=='payment.php'? 'active':''); ?>">
            <i class="fa fa-credit-card"></i> Payment
        </a>
    <?php elseif ($role == "cook"): ?>
        <a href="order.php"   class="sidebar-link <?php echo ($pageName=='order.php'  ? 'active':''); ?>">
            <i class="fa fa-list-alt"></i> Order Queue
        </a>
    <?php elseif ($role == "busboy" || $role == "host"): ?>
        <a href="tablelow.php" class="sidebar-link <?php echo ($pageName=='tablelow.php'? 'active':''); ?>">
            <i class="fa fa-th-large"></i> Table Status
        </a>
    <?php endif; ?>

    <div class="sidebar-logout">
        <a href="logout.php" class="sidebar-link" style="color:#EF4444;">
            <i class="fa fa-power-off"></i> Log Out
        </a>
    </div>
</aside>