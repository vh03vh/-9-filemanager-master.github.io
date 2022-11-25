<!-- Edit form -->
<p><a href="?filePath=<?php echo ROOT_PATH; ?>"><i class="fa fa-home"></i></a></p>
<p><a href="?filePath=<?php echo $_GET['filePath']; ?>"><i class="fa fa-long-arrow-left"></i></a></p>
<p><strong>Editing: <?php echo end(explode('/',$_GET['file']));?></strong></p>

<?php $fileContent = file_get_contents($_GET['file']); ?>
<form action="?do=save_file" name="edit_form" id="edit_form" method="post">
    <textarea class="edit-box" name="file_content"><?php echo $fileContent; ?></textarea>
    <input type="hidden" name="filePath" id="filePath" value="<?php echo $_GET['filePath']; ?>">
    <input type="hidden" name="file_name" id="file_name" value="<?php echo $_GET['file']; ?>">
    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary">
</form>