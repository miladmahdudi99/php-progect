<?php
// Force download of image file specified in URL query string

include_once 'lib/funcs.php';

$filename = 'images/wm.png';

if (empty($_GET['img'])) {
    header("HTTP/1.0 404 Not Found");
    return;
}

if (isLogin() and userBuyImage(currentUserID(), $_GET['img'])) {
    global $db;
    $filename = getField('path', $db->imagesTable, 'id', $_GET['img']);
    $basename = pathinfo($filename, PATHINFO_BASENAME);

    // get file mime type
    $info = getimagesize($filename);
    $mime = $info['mime'];

    // get file size
    $filesize = filesize($filename);
    $fp = fopen($filename, "rb");   // opening file in Binary format
    if (!($mime && $filesize && $fp)) {
        // Error.
        return;
    }
    header("Content-type: " . $mime);
    header("Content-Length: " . $filesize);
    header("Content-Disposition: attachment; filename=" . $basename);
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    fpassthru($fp);
}
