<p><i class="fa fa-map-marker"></i> You are here: <?php echo suMakeBreadcrumbs($rootPath); ?></p>
<table>
    <tr>
        <td>
            <!-- Rename form -->
            <form action="" name="permissions_form" id="permissions_form" method="get">
                <input type="hidden" name="permission_type" id="permission_type">
                <input type="hidden" name="permission_file" id="permission_file">
                <input type="hidden" name="permission_attributes" id="permission_attributes">
                <input type="hidden" name="filePath" id="filePath" value="<?php echo $getFilePath; ?>">
                <input type="hidden" name="do" value="permissions">
            </form>
            <!-- Rename form -->
            <form action="" name="rename_form" id="rename_form" method="get">
                <input type="hidden" name="rename_source" id="rename_source">
                <input type="hidden" name="rename_destination" id="rename_destination">
                <input type="hidden" name="filePath" id="filePath" value="<?php echo $getFilePath; ?>">
                <input type="hidden" name="do" value="rename">
            </form>
            <!-- Create form -->
            <form action="" name="create_form" id="create_form" method="get" onkeypress="return event.keyCode != 13;">
                <input type="hidden" name="do" value="create">
                <input type="text" name="create" required="required" placeholder="Type name.." autocomplete="off">
                <input type="submit" name="create_file" id="create_file" value="Create File" class="btn btn-primary">
                <input type="submit" name="create_folder" id="create_folder" value="Create Folder" class="btn btn-primary">
                <input type="hidden" name="filePath" value="<?php echo $getFilePath; ?>">
                <input type="hidden" name="destination" value="<?php echo $destination; ?>">
                <?php if (isset($_SESSION['copy_source']) && ($_SESSION['copy_source'] != '')) { ?>
                    <a data-toggle="tooltip" id="paste-single" title="Paste" href="?do=paste&filePath=<?php echo $rootPath; ?>&destination=<?php echo $rootPath; ?>"><i class="fa fa-paste"></i> Paste '<?php echo $_SESSION['copy_file']; ?>' here.</a>
                <?php } ?>
                <?php if (isset($_SESSION['multiple_files']) && ($_SESSION['multiple_files'] != '')) { ?>
                    <a data-toggle="tooltip" id="paste-multiple" title="Paste" href="?do=multi-paste&filePath=<?php echo $rootPath; ?>"><i class="fa fa-paste"></i> Paste here.</a>
                <?php } ?>


            </form>

        </td>
        <td>&nbsp;</td>
        <td>

            <!-- Upload form -->
            <form action="?do=upload" name="upload_form" id="upload_form" method="post" enctype="multipart/form-data" onsubmit="uploader()">
                <input type="file" name="file" id="file" required="required" class="hide" onchange="openFileDialog(this);">
                <input type="hidden" name="filePath" value="<?php echo $rootPath; ?>">

                <table>
                    <tr>
                        <td>
                            <h1>&nbsp;<a data-toggle="tooltip" href="javascript:;" id="paperclip" title="Select file to upload"><i class="fa fa-paperclip"></i></a>&nbsp;</h1>
                            <script type="text/javascript">
                                $("#paperclip").click(function(e) {
                                    e.preventDefault();
                                    $("#file").trigger('click');
                                });
                            </script>
                        </td>
                        <td>
                            <span id="file-name" class="label label-info"></span>
                            <span id="overwrite"><label><input type="checkbox" value="yes" name="overwrite"/> Overwrite</label></span>
                            <input type="submit" name="upload" id="upload" value="Upload" class="btn btn-small btn-primary">
                            <span id="uploader" style="display:none;"><img src="assets/loading.gif" alt="Loading"></span>
                            <span id="max-size">Max file size: <?php echo ini_get('upload_max_filesize'); ?></span>


                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
<div class="label label-warning" id="clip-board"></div>
<!-- Action for multiple selected files -->
<div id="multi-action" style="display:none;padding:10px;">
    <table>
        <tr>
            <td>Multi-select operations: &nbsp;</td>
            <td>
                <a data-toggle="tooltip" title="Delete" href="?do=multi-delete&filePath=<?php echo $getFilePath; ?>" onclick="return confirm('<?php echo SURE; ?>');"><i class="fa fa-trash"></i> </a>&nbsp;
            </td>


            </td>

            <td>
                <a data-toggle="tooltip" title="Change permissions" onclick="return changePermissions('', 'multiple','')" href="javascript:;"><i class="fa fa-lock"></i> </a>&nbsp;
            </td>


        </tr>
    </table>

</div>
