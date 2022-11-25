<?php
if (isset($_POST['do']) && ($_POST['do'] == 'login')) {
    if ($_POST['login'] != LOGIN && $_POST['password'] != PASSWORD) {
        $msg = INVALID_LOGIN;
    } else {
        $_SESSION['login'] = $_POST['login'];
        suRedirect('?filePath=' . ROOT_PATH);
        exit;
    }
}
?>
<?php include('includes/message.php'); ?>
<!-- Login form -->
<form action="" name="login_form" id="login_form" method="post">
    <input type="text" name="login" id="login" required="required" placeholder="Login ID" autocomplete="off">
    <input type="password" name="password" id="password" required="required" placeholder="Password">
    <input type="hidden" name="do" value="login">
    <input type="submit" name="submit" id="submit" value="Login" class="btn btn-primary">
</form>