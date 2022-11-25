<?php include('includes/form.php'); ?>
<div class="table-responsive">
    <form name="files_form" id="file_form">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th><input type="checkbox" onclick="toggleCheckboxes()" id="checkbox-main"> File</th>
                    <th>Size</th>
                    <th>Permission</th>
                    <th>Last Modified</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($getFilePath != '') { ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td> &nbsp;&nbsp;&nbsp;<a data-toggle="tooltip" title="Home" href="?filePath=<?php echo ROOT_PATH; ?>"><i class="fa fa-home"></i></a>
                            <br>
                            &nbsp;&nbsp;&nbsp;<a data-toggle="tooltip" title="Back" href="?filePath=<?php echo urlencode($backLink); ?>"><i class="fa fa-long-arrow-left"></i></a></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        
                    </tr>
                <?php } ?>
                <?php
                $cnt=0;
                for ($i = 0; $i <= sizeof($files) - 1; $i++) {
                    $fileLink = $files[$i]['name'];
                    if (!is_dir($fileLink)) {
                        $finfo = finfo_open(FILEINFO_MIME);
                        $asciiStatus = substr(finfo_file($finfo, $fileLink), 0, 4) == 'text';
                        if ($asciiStatus == TRUE) {
                            $ascii == TRUE;
                        } else {
                            $ascii == FALSE;
                        }
                    } else {
                        $ascii == FALSE;
                    }
                    $filePath1 = explode('/', $fileLink);
                    $fileName = end($filePath1);

                    if (end($filePath1) != '.' && end($filePath1) != '..') {
                        $fileName = str_replace($rootPath, '', $files);

                        $fileName = end($filePath1);
                        $type = $files[$i]['type'];
                        if ($type == 'file') {
                            $icon = suFileIcon($files[$i]['ext']);
                        } elseif ($type == 'folder') {
                            $icon = '<i class="fa fa-folder text-primary"></i>';
                        } else {
                            $icon = '';
                        }
                        $size = $files[$i]['size'];
                        $filesize = suFileSize($size);

                        if ($type == 'folder') {
                            $filesize = '';
                            $filesize = suDisplayFolderSize($fileLink);
                        }
                        $cnt = $cnt+1;
                        ?>
                        <tr>
                            <td width="20">
                               <?php echo $cnt;?>. 
                            </td>
                            <td><input type="checkbox" name="chk_<?php echo $i; ?>" id="chk_<?php echo $i; ?>" value="<?php echo $fileLink; ?>" onclick="uncheckMain();"> 
                                <?php if ($type == 'folder') { ?>
                                    <a href="?filePath=<?php echo urlencode($fileLink); ?>"><?php echo $icon; ?> <?php echo $fileName; ?></a>
                                <?php } else { ?>
                                    <?php echo $icon; ?> <?php echo $fileName; ?>
                                <?php } ?>
                            </td>
                            <td><?php echo $filesize; ?></td>
                            <td><?php echo suGetFilePermission($fileLink); ?></td>
                            <td><?php echo date("F d, Y H:i:s", filemtime(($fileLink))); ?></td>

                            <td>
                                <table width="100%">
                                    <tr>
                                        <td width="12%">
                                            <a data-toggle="tooltip" title="Delete" href="?do=delete&type=<?php echo $type; ?>&filePath=<?php echo $getFilePath; ?>&destination=<?php echo $fileLink; ?>" onclick="return confirm('<?php echo SURE; ?>');"><i class="fa fa-trash"></i> </a>
                                        </td>
                                        <td width="12%">
                                            <?php if ($files[$i]['ext'] == 'zip') { ?>
                                                <a data-toggle="tooltip" title="Upzip" href="?do=unzip&type=<?php echo $type; ?>&filePath=<?php echo $getFilePath; ?>&source=<?php echo $fileLink; ?>" onclick="return confirm('<?php echo OVERWRITE; ?>');"><i class="fa fa-file-zip-o"></i> </a>
                                            <?php } else { ?>
                                                <a data-toggle="tooltip" title="Zip" href="?do=zip&filePath=<?php echo $getFilePath; ?>&source=<?php echo $fileLink; ?>" onclick="return confirm('<?php echo OVERWRITE; ?>');"><i class="fa fa-archive"></i> </a>
                                            <?php } ?>
                                        </td>
                                        <td width="12%">
                                            <a data-toggle="tooltip" title="Copy" onclick="copySource('<?php echo $fileLink; ?>', '<?php echo $fileName; ?>')" href="javascript:;"><i class="fa fa-copy"></i> </a>
                                        </td>
                                        <td width="12%">
                                            <?php if ($type == 'folder') { ?>
                                                <a data-toggle="tooltip" title="Paste" href="?do=paste&filePath=<?php echo $getFilePath; ?>&destination=<?php echo $fileLink; ?>"><i class="fa fa-paste"></i> </a>
                                            <?php } else { ?> 
                                                &nbsp;
                                            <?php } ?> 
                                        </td>
                                        <td width="12%">
                                            <a data-toggle="tooltip" title="Rename" onclick="return rename('<?php echo $fileLink; ?>', '<?php echo $fileName; ?>')" href="javascript:;"><i class="fa fa-strikethrough"></i> </a>
                                        </td>
                                        <td width="12%">
                                            <a data-toggle="tooltip" title="Change permissions" onclick="return changePermissions('<?php echo $fileLink; ?>', 'single', '<?php echo suGetFilePermission($fileLink); ?>')" href="javascript:;"><i class="fa fa-lock"></i> </a>
                                        </td>
                                        <td width="12%">
                                            <?php if ($type == 'file') { ?>
                                                <a data-toggle="tooltip" title="Download" href="?do=stream&file=<?php echo $fileLink; ?>&filePath=<?php echo $getFilePath; ?>"><i class="fa fa-download"></i> </a>
                                            <?php } else { ?> 
                                                &nbsp;
                                            <?php } ?> 
                                        </td>
                                        <td width="12%">
                                            <?php if (($type == 'file' && $asciiStatus == TRUE)||($size==0)) { ?>
                                            
                                                <a data-toggle="tooltip" title="Edit" href="?do=edit&file=<?php echo $fileLink; ?>&filePath=<?php echo $rootPath; ?>"><i class="fa fa-edit"></i> </a>
                                            <?php } else { ?> 
                                                &nbsp;
                                            <?php } ?> 
                                        </td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </form>
</div>