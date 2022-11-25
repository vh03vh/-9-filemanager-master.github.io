<h1>
    <a href="./"><?php echo SITE_NAME; ?></a>
    <small><?php echo TAGLINE; ?></small>
</h1>
<?php if (isset($_SESSION['login'])) { ?>
    <div align="right">
        <div><a href="?do=logout"><i class="fa fa-power-off"></i> Log Out</a></div>
        <div><?php echo suGetNotification();?></div>
    </div>
<?php } ?>
