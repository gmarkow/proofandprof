<?php
 

    $private_dir = getcwd();
    $private_dir = substr($private_dir, 0, -6);
    // 
    $file_path = $private_dir . $_GET['file_path'];


    $filename = basename($file_path);
    $file_extension = strtolower(substr(strrchr($filename,"."),1));

    switch( $file_extension ) {
        case "gif": $ctype="image/gif"; break;
        case "png": $ctype="image/png"; break;
        case "jpeg":
        case "jpg": $ctype="image/jpeg"; break;
        default:
    }

    header('Content-type: ' . $ctype);
    header('content-disposition: inline; filename="'.$filename.'";');
    readfile($file_path);
