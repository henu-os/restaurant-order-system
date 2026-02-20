<?php
error_reporting(0);
// POST HANDLER

if(isset($_POST['submit'])){
    include ("./includes/employee.php");
    $user = new Employee;
    $user->setCredentials($_POST['uid'], $_POST['passwd']);

    if(md5($_POST['passwd']) == $user->getPwd()) {
        session_start();
        $_SESSION['uName'] = $_POST['uid'];
        if($user->getRole($_SESSION['uName']) == "waiter")  header('Location: table.php');
        if($user->getRole($_SESSION['uName']) == "cook")    header('Location: order.php');
        if($user->getRole($_SESSION['uName']) == "busboy" || $user->getRole($_SESSION['uName']) == "host") header('Location: tablelow.php');
    } else {
?>
<div style="margin: 10px 0;">
    <div class="alert alert-danger" style="display:flex; align-items:center; gap:8px; border-radius:8px; padding:12px 16px;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="fa fa-exclamation-circle"></i>
        <strong>Invalid username or password. Please try again.</strong>
    </div>
</div>
<?php
    }
}
?>
<!-- ===== Modern Login Modal ===== -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="max-width:400px;">
        <div class="modal-content">
            <div class="modal-header" style="background:var(--primary); padding:20px 24px; border-radius:12px 12px 0 0;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:.8;">&times;</button>
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="width:40px; height:40px; background:rgba(255,255,255,.2); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:20px; color:#fff;">
                        <i class="fa fa-eye"></i>
                    </div>
                    <div>
                        <h4 class="modal-title" style="color:#fff; margin:0; font-weight:700;">Sign In</h4>
                        <div style="color:rgba(255,255,255,.7); font-size:12px; margin-top:2px;">Restaurant POS System</div>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="padding:24px;">
                <form method="post" action="index.php" name="login_form">
                    <div style="margin-bottom:16px;">
                        <label style="font-size:13px; font-weight:500; display:block; margin-bottom:6px; color:var(--text);">
                            Username
                        </label>
                        <div style="position:relative;">
                            <i class="fa fa-user" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--muted); font-size:14px;"></i>
                            <input type="text" name="uid" id="uname" placeholder="Enter your username"
                                style="width:100%; padding:10px 14px 10px 36px; border:1px solid var(--border); border-radius:8px; font-size:14px; font-family:inherit; outline:none; transition:border-color .18s;"
                                onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        </div>
                    </div>
                    <div style="margin-bottom:20px;">
                        <label style="font-size:13px; font-weight:500; display:block; margin-bottom:6px; color:var(--text);">
                            Password
                        </label>
                        <div style="position:relative;">
                            <i class="fa fa-lock" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--muted); font-size:14px;"></i>
                            <input type="password" name="passwd" placeholder="Enter your password"
                                style="width:100%; padding:10px 14px 10px 36px; border:1px solid var(--border); border-radius:8px; font-size:14px; font-family:inherit; outline:none; transition:border-color .18s;"
                                onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        </div>
                    </div>
                    <input type="submit" value="Sign In" name="submit"
                        style="width:100%; padding:12px; background:var(--primary); color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; font-family:inherit; transition:background .18s;"
                        onmouseover="this.style.background='var(--primary-dk)'" onmouseout="this.style.background='var(--primary)'"/>
                </form>
            </div>
        </div>
    </div>
</div>