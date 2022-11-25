<?php

$backLink = '';
$getFilePath = '';
$destination = '';
$msg = '';
$pathParts = '';
$fileExtension = '';
$source = '';
//Create, delete, cut, copy, paste
if (isset($_GET['do'])) {
//If multiple checkboxes checked
    if ($_GET['do'] == 'get-folder-size') {
        echo $filesize = suGetFolderSize($_GET['path']);
        exit;
    }


//If multiple checkboxes checked
    if ($_GET['do'] == 'multi-copy') {
        $_SESSION['copy_source'] = '';
        $_SESSION['multiple_files'] = $_GET['files'];
        exit;
    }
//Delete multiple files
    if ($_GET['do'] == 'multi-delete') {
        for ($i = 0; $i <= sizeof($_SESSION['multiple_files']) - 1; $i++) {
            if (is_dir($_SESSION['multiple_files'][$i])) {
                suDeleteFolder($_SESSION['multiple_files'][$i]);
            } else {
                suDeleteFile($_SESSION['multiple_files'][$i]);
            }
        }
        $_SESSION['copy_source'] = '';
        $_SESSION['multiple_files'] = '';
    }
//Paste multiple files
    if ($_GET['do'] == 'multi-paste') {

        $copySource = '';
        for ($i = 0; $i <= sizeof($_SESSION['multiple_files']) - 1; $i++) {
            $copySource = $_SESSION['multiple_files'][$i];
            $fileName = explode('/', $copySource);
            $fileName = end($fileName);
            $copyDestination = $_GET['filePath'] . '/' . $fileName;
            if (!file_exists($copyDestination) && ($copySource != $_GET['filePath'])) {
                if (is_dir($copySource)) {
                    suCopy($copySource, $copyDestination);
                } else {
                    copy($copySource, $copyDestination);
                }
            }
        }
        $_SESSION['copy_source'] = '';
        $_SESSION['multiple_files'] = '';
    }

//Save file
    if ($_GET['do'] == 'save_file') {
        $fileToWrite = $_POST['file_name'];
        $fileContent = $_POST['file_content'];
        if (!file_exists($fileToWrite)) {
            $msg = FILE_DOES_NOT_EXIST;
        } else {
            suWriteFile($fileToWrite, $fileContent);
            $_GET['filePath'] = $_POST['filePath'];
        }
    }
//Change permissions
    if ($_GET['do'] == 'permissions') {
        if ($_GET['permission_type'] == 'single') {
            suChomd($_GET['permission_file'], $_GET['permission_attributes']);
        } else {
            for ($i = 0; $i <= sizeof($_SESSION['multiple_files']) - 1; $i++) {
                suChomd($_SESSION['multiple_files'][$i], $_GET['permission_attributes']);
            }
        }
    }
//Rename
    if ($_GET['do'] == 'rename') {
        if ($_GET['rename_source'] != $_GET['rename_destination']) {
            if (file_exists($_GET['rename_destination'])) {
                if (is_dir($_GET['rename_source'])) {
                    $msg = FOLDER_ALREADY_EXISTS;
                } else {
                    $msg = FILE_ALREADY_EXISTS;
                }
            } else {
                rename($_GET['rename_source'], $_GET['rename_destination']);
            }
        }
    }
//Upload
    if ($_GET['do'] == 'upload') {
        $uploadSrc = $_FILES['file']['tmp_name'];
        $uploadDest = $_POST['filePath'] . '/' . $_FILES['file']['name'];
        //Check overwrite
        if ($_POST['overwrite'] == 'yes') {
            @unlink($uploadDest);
            copy($uploadSrc, $uploadDest);
        } else {
            if (file_exists($uploadDest)) {
                $msg = FILE_ALREADY_EXISTS;
            } else {
                copy($uploadSrc, $uploadDest);
            }
        }

        $_GET['filePath'] = $_POST['filePath'];
    }
//Log out
    if ($_GET['do'] == 'logout') {
        $_SESSION['login'] = '';
        session_unset();
        suRedirect('?filePath=' . ROOT_PATH);
        exit;
    }

    if (!isset($_GET['filePath']) || $_GET['filePath'] == '') {
        $_GET['filePath'] = ROOT_PATH;
    }

//Create file
    if ($_GET['do'] == 'create') {
        if (isset($_GET['create_file'])) {
            if ($_GET['create'] == '') {
                $msg = FILE_NAME_REQUIRED;
            } else {
                $destination = $_GET['destination'] . '/' . $_GET['create'];
                if (file_exists($destination)) {
                    $msg = FILE_ALREADY_EXISTS;
                } else {
                    fopen($destination, "w");
                    chmod($destination, 0644);
                }
            }
        }
//Create folder
        if (isset($_GET['create_folder'])) {
            if ($_GET['create'] == '') {
                $msg = FOLDER_NAME_REQUIRED;
            } else {
                $destination = $_GET['destination'] . '/' . $_GET['create'];
                if (file_exists($destination)) {
                    $msg = FOLDER_ALREADY_EXISTS;
                } else {
                    mkdir($destination, 0755);
                    chmod($destination, 0755);
                }
            }
        }
    }
//Stream
    if ($_GET['do'] == 'stream') {
        stream($_GET['file']);
    }
//Delete file or folder
    if ($_GET['do'] == 'delete') {
        if ($_GET['type'] == 'file') {
            $destination = $_GET['destination'];
            suDeleteFile($destination);
        }
        if ($_GET['type'] == 'folder') {
            $destination = $_GET['destination'];
            suDeleteFolder($destination);
        }
    }
//Unzip
    if ($_GET['do'] == 'unzip') {
        $source = $_GET['source'];
        suUnzip($source, $_GET['filePath']);
    }
//Zip
    if ($_GET['do'] == 'zip') {
        $source = $_GET['source'];
        suZip($source, $_GET['filePath']);
    }
//Copy
    if ($_GET['do'] == 'copy') {
        $_SESSION['multiple_files'] = '';
        $_SESSION['copy_source'] = $_GET['source'];
        $_SESSION['copy_file'] = $_GET['name'];
        exit;
    }
//Paste
    if ($_GET['do'] == 'paste') {
        if ($_SESSION['copy_source'] == '') {
            if ($_SESSION['multiple_files'] != '') {
                $url = '?do=multi-paste&filePath=' . urlencode($_GET['destination']);
                suRedirect($url);
                exit;
            } else {
                $msg = NO_SOURCE_FILE;
            }
            //$msg = NO_SOURCE_FILE;
        } else {
            $copySource = $_SESSION['copy_source'];
            $copyDestination = $_GET['destination'] . '/' . $_SESSION['copy_file'];
            if (file_exists($copyDestination)) {
                $msg = PASTE_ERROR;
            } else {
                if (is_dir($copySource)) {
                    suCopy($copySource, $copyDestination);
                } else {
                    copy($copySource, $copyDestination);
                }
                $_SESSION['copy_source'] = '';
                $_SESSION['copy_file'] = '';
            }
        }
    }
//Redirect to safe URL
    if ($msg == '') {
        $delay = 0;
    } else {
        $delay = 3;
    }
    if ($_GET['do'] != 'edit') {
        echo '
    <!DOCTYPE html>
    <html>
    <head>';
        include('includes/head.php');
        suRedirect('?filePath=' . urlencode($_GET['filePath']), $delay);
        echo '
    </head>
    <body>';
        if ($getFilePath != '') {
            echo '<p>You are here: ' . $rootPath . '</p>';
        }
        include('includes/message.php');
        echo '<div class="label label-warning" id="clip-board"></div>';
        echo '
    </body>
    </html>';
        exit;
    }
}


//==
if (isset($_GET['filePath'])) {
    $getFilePath = $_GET['filePath'];
    $rootPath = $_GET['filePath'];
    $back = explode('/', $rootPath);
    for ($i = 0; $i <= sizeof($back) - 2; $i++) {
        $backLink .= $back[$i] . '/';
    }
    $backLink = substr($backLink, 0, -1);
} else {
    $rootPath = ROOT_PATH;
}
if ($getFilePath == ROOT_PATH) {
    $getFilePath = '';
}
if ($getFilePath == '') {
    $destination = ROOT_PATH;
} else {
    $destination = $_GET['filePath'];
}

$files = array();
$type = '';
$filesize = '';
$rootPath;
$dir = scandir($rootPath);

foreach ($dir as $file) {
    if (!in_array($file, $exclude)) {
        $filePath = $rootPath . '/' . $file;
        if ($filePath != ROOT_PATH) {
            if (@is_dir($filePath)) {
                $type = 'folder';
            } else {
                $type = 'file';
            }
            $fileExtension = explode('.', $filePath);
            if (isset($fileExtension)) {
                $fileExtension = end($fileExtension);
            } else {
                $fileExtension = '';
            }
            array_push($files, array('name' => $filePath, 'size' => @filesize($filePath), 'type' => $type, 'ext' => $fileExtension));
        }
    }
}

sort($files);
