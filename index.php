<?php
include('includes/definitions.php');
include('includes/config.php');
include('includes/functions.php');
include('includes/operations.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('includes/head.php'); ?>
    </head>
    <body>
        <div class="container-fluid">
            <header>
                <?php include('includes/header.php'); ?>
            </header>
            <div>

                <?php
                if (!isset($_SESSION['login'])) {
                    include('includes/login-form.php');
                } else {
                    if (isset($_GET['do']) && $_GET['do'] == 'edit') {
                        include('includes/edit.php');
                    } else {
                        include('includes/files.php');
                    }
                }
                ?>
            </div>

        </div>
        <footer>
            <?php include('includes/footer.php'); ?>
        </footer>
    </body>
</html>
