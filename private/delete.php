<?php

require_once './Usuario.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = new Usuario();
    $isDelected = $user->deleteUser($id);

    if ($isDelected) {
        $usrImagesDir = "../images/$id";

        rrmdir($usrImagesDir);

        if ($_SESSION['id'] == $id) {
            session_destroy();
        }
        header('Location: ../index.php');
    }
}

// apagar aos ficheiros recursivamente
function rrmdir($src)
{
    $dir = opendir($src);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            $full = $src.'/'.$file;
            if (is_dir($full)) {
                rrmdir($full);
            } else {
                unlink($full);
            }
        }
    }
    closedir($dir);
    rmdir($src);
}
