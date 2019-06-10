<?php
include_once 'lib/funcs.php';
$path = 'images/wm.jpg';
if(isset($_GET['image'])){
    $path = getField('path',$db->imagesTable,'id',$_GET['image']);
}
$ext = pathinfo($path, PATHINFO_EXTENSION);
// Create image instances
$src = imagecreatefromjpeg('images/wm.jpg');
if($ext == 'png'){
    $dest = imagecreatefrompng($path);
}else{
    $dest = imagecreatefromjpeg($path);
}
$transparency = 7;
// Copy and merge
imagecopymerge($dest, $src, 0, 0, 300, 50, 3000, 3000, $transparency);
// Output and free from memory
header('Content-Type: image/gif');
imagegif($dest);

imagedestroy($dest);
imagedestroy($src);