<?php

//Stream file
function stream($file) {
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
}

//Redirect
function suRedirect($url, $delay = 0) {
    echo '<meta http-equiv="refresh" content="' . $delay . '; url=' . $url . '">';
}

//Delete folder with content
function suDeleteFolder($destination) {
    $dir = opendir($destination);
    while (false !== ( $file = readdir($dir))) {
        if (( $file != '.' ) && ( $file != '..' )) {
            $full = $destination . '/' . $file;
            if (is_dir($full)) {
                suDeleteFolder($full);
            } else {
                @unlink($full);
            }
        }
    }
    closedir($dir);
    rmdir($destination);
}

//Delete file
function suDeleteFile($destination) {
    @unlink($destination);
}

//Copy
function suCopy($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ( $file = readdir($dir))) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if (is_dir($src . '/' . $file)) {
                suCopy($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

//Slugify
function suSlugify($fileName) {
    $fileName = preg_replace('/[^A-Za-z0-9-]+/', '-', $fileName);
    return strtolower($fileName);
}

//Unzip
function suUnzip($zipFile, $destination) {
    if (function_exists('shell_exec')) {
        if (is_dir($zipFile)) {
            shell_exec("unzip -q -o '" . $zipFile . "' -d " . $destination);
        } else {
            shell_exec("unzip -q -o '" . $zipFile . "' -d " . $destination);
        }
    } else {
        suExit(UNSUPPORTED_FUNCTION);
    }
}

//Zip
function suZip($source, $destination) {
    if (function_exists('shell_exec')) {
        if (is_dir($source)) {
            $folderToZip = explode('/', $source);
            $folderToZip = end($folderToZip);
            $destinationFile = $folderToZip . '.zip';
            shell_exec("pushd '" . $destination . "'; zip -r -q '" . $destinationFile . "' '" . $folderToZip . "';popd");
        } else {
            $fileToZip = explode('/', $source);
            $fileToZip = end($fileToZip);
            $destinationFile = $fileToZip . '.zip';
            shell_exec("pushd '" . $destination . "'; zip -q '" . $destinationFile . "' '" . $fileToZip . "';popd");
        }
    } else {
        suExit(UNSUPPORTED_FUNCTION);
    }
}

//Show file size
function suFileSize($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' kB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

//Get folder size
function suGetFolderSize($path) {
    $path = realpath($path);
    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
    $totalSize = 0;
    foreach ($objects as $name => $object) {
        $totalSize = $totalSize + filesize($name);
    }
    return $totalSize = '~' . suFileSize($totalSize);
}

//Display folder size
function suDisplayFolderSize($fileLink) {
    $uid = uniqid();
    $getSizeLink = "<span id='showSize_{$uid}'></span><a href=\"javascript:;\" onclick=\"$('#showSize_{$uid}').load('./index.php?do=get-folder-size&path=" . urlencode($fileLink) . "');$(this).remove();\" id=\"loadSize_{$uid}\">Get size..</a>";
    return $getSizeLink;
}

//Show file icon
function suFileIcon($extension) {
    $extension = strtolower($extension);
    if ($extension == 'zip') {
        $icon = '<i class="fa fa-file-archive-o text-primary"></i>';
    } elseif ($extension == 'xls') {
        $icon = '<i class="fa fa-file-excel-o text-primary"></i>';
    } elseif ($extension == 'xlsx') {
        $icon = '<i class="fa fa-file-excel-o text-primary"></i>';
    } elseif ($extension == 'doc') {
        $icon = '<i class="fa fa-file-word-o text-primary"></i>';
    } elseif ($extension == 'docx') {
        $icon = '<i class="fa fa-file-word-o text-primary"></i>';
    } elseif ($extension == 'pdf') {
        $icon = '<i class="fa fa-file-pdf-o text-primary"></i>';
    } elseif ($extension == 'gif') {
        $icon = '<i class="fa fa-file-image-o text-primary"></i>';
    } elseif ($extension == 'jpg') {
        $icon = '<i class="fa fa-file-image-o text-primary"></i>';
    } elseif ($extension == 'jpeg') {
        $icon = '<i class="fa fa-file-image-o text-primary"></i>';
    } elseif ($extension == 'png') {
        $icon = '<i class="fa fa-file-image-o text-primary"></i>';
    } elseif ($extension == 'txt') {
        $icon = '<i class="fa fa-file-text-o text-primary"></i>';
    } elseif ($extension == 'wav') {
        $icon = '<i class="fa fa-file-audio-o text-primary"></i>';
    } elseif ($extension == 'mp3') {
        $icon = '<i class="fa fa-file-audio-o text-primary"></i>';
    } elseif ($extension == 'mp4') {
        $icon = '<i class="fa fa-file-video-o text-primary"></i>';
    } elseif ($extension == 'wav') {
        $icon = '<i class="fa fa-file-3gp-o text-primary"></i>';
    } elseif ($extension == 'iso') {
        $icon = '<i class="fa fa-circle-o text-primary"></i>';
    } else {
        $icon = '<i class="fa fa-file-o text-primary"></i>';
    }
    return $icon;
}

//Bar chart
function suBarChart($val) {
    echo " <div class=\"bar-chart\">
                <div class=\"progress\" style=\"width:{$val}%;\"></div>
            </div>";
}

// Get file permission
function suGetFilePermission($file) {
    $length = strlen(decoct(fileperms($file))) - 3;
    return substr(decoct(fileperms($file)), $length);
}

//Print array
function print_array($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

//Write file
function suWriteFile($file, $content, $arg = 'w') {
    $file = fopen($file, $arg);
    fwrite($file, $content);
    fclose($file);
}

//Get URL content
function suGetNotification($url = NOTIFICATION_URL) {
    if ($url != '') {
        if (function_exists('file_get_contents')) {
            echo file_get_contents($url);
        }
    }
}

//Connect to FTP
function suFtpConnect($user, $password) {
    $ftp_server = $_SERVER['SERVER_ADDR'];
    $ftp_user = $user;
    $ftp_pass = $password;

// set up a connection or die
    $conn_id = ftp_connect($ftp_server) or die(FTP_CONNECTION_ERROR);

// try to login
    if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {
        return TRUE;
    } else {
        return FALSE;
    }

// close the connection
    @ftp_close($conn_id);
}

//Change permissions
function suChomd($file, $permissions) {
    chmod($file, intval($permissions, 8));
}

//Make breadcrumb
function suMakeBreadcrumbs($path) {
    //$linkPlus = 'index.php?filePath=' . ROOT_PATH;
    $homeLink = '..';
    $linkPlus = '..';
    $path = substr($path, 2);
    $path = explode('/', $path);
    for ($i = 0; $i <= sizeof($path) - 1; $i++) {
        $linkPlus .= urlencode($path[$i]) . '/';
        $link = substr($linkPlus, 0, -1);
        if ($link == ROOT_PATH) {
            echo "<a href='index.php?filePath=" . $link . "'><i class='fa fa-home'></i></a>/";
        } else {
            echo "<a href='index.php?filePath=" . $link . "'>" . $path[$i] . "</a>/";
        }
    }
}
