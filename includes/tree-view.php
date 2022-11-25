<?php

$rootPath = ROOT_PATH;
$filePath='';
$dir = scandir($rootPath);
//$sidebarExclude comes from config.php
foreach ($dir as $file) {
    if (is_dir($file)) {
    echo "<a href='index.php?filePath=" . $file . "'>$file</><br>";
    }
}