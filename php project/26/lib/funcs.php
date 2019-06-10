<?php
session_start();
include_once 'config.php';
include_once 'jdf.php';

function log2File($msg)
{
    $logfile = __DIR__ . '/log-' . date('Y') . '-' . date('m') . '.txt';
    file_put_contents($logfile, date("Y-m-d H:i:s") . " > " . $msg . PHP_EOL, FILE_APPEND);
}

/***** Database Functions *****/
function getField($field, $table, $column = '1', $value = '1', $op = '=')
{
    global $db;
    if($value != 'CURDATE()'){
        $value = "'$value'";
    }
    $sql = "SELECT $field as f FROM $table where $column{$op}$value";
    $result = $db->query($sql);
    if ($result->num_rows)
        return $result->fetch_object()->f;
    return false;
}

function addCategory($catName, $catOrder, &$errorMsg = '')
{
    global $db;
    // sanitize all inputs in one line !!!
    list($catName, $catOrder) = array(sanitize($catName), sanitize($catOrder));
    $sql = "INSERT INTO $db->categoriesTable (name, ord) VALUES ('$catName','$catOrder');";

    $alreadyExisted = getField('count(*)', $db->categoriesTable, 'name', $catName);
    if (!$alreadyExisted) {
        $result = $db->query($sql);
        if ($result) {
            return true;
        }
        $errorMsg = 'مشکلی در هنگام ثبت اطلاعات در پایگاه داده  رخ داده است .';
        return false;
    } else {
        $errorMsg = 'این دسته بندی قبلا وجود داشته است .';
        return false;
    }
}

function getCategories(&$catCount = 0)
{
    global $db;
    $sql = "SELECT * FROM $db->categoriesTable order by ord";
    $result = $db->query($sql);
    if ($result) {
        $catCount = getField('count(*)', $db->categoriesTable);
        $cats = $result->fetch_all(MYSQLI_ASSOC);
        return $cats;
    }
    return false;
}

function removeCategory($cid)
{
    global $db;
    $sql = "Delete from $db->categoriesTable WHERE id=$cid;";
    $result = $db->query($sql);
    if ($result) {
        return true;
    }
    return false;
}


function getOrders($uID = 'all', $page = 1, &$count = 0)
{
    global $db;
    $whereStr = "1=1";
    if ($uID != 'all' and is_numeric($uID)) {
        $whereStr = "user_id=$uID";
    }
    $start = ($page - 1) * IS_ORDERS_PER_PAGE;
    $len = IS_ORDERS_PER_PAGE;
    // Get Orders Query
    $sql = "SELECT o.id,o.price,o.create_date,o.image_id,o.user_id,i.title,thumb_url FROM $db->ordersTable o,$db->imagesTable i where $whereStr and i.id=o.image_id order by o.create_date desc limit $start,$len";
    $result = $db->query($sql);
    if ($result) {
        if ($uID != 'all' and is_numeric($uID)) {
            $count = getField('count(*)', $db->ordersTable, 'user_id', $uID);
        } else {
            $count = getField('count(*)', $db->ordersTable);
        }
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        return $orders;
    }
    return false;
}

function getImages($cat = 0, $page = 1, &$count = 0)
{
    global $db;
    $whereStr = '1=1';
    if ($cat > 0) {
        $whereStr = "cat_id='$cat'";
    }
    $start = ($page - 1) * IS_IMAGE_PER_PAGE;
    $len = IS_IMAGE_PER_PAGE;

    $sql = "SELECT * FROM $db->imagesTable where $whereStr order by create_date desc limit $start,$len";
    $countSql = "SELECT count(*) as c FROM $db->imagesTable where $whereStr";
    $result = $db->query($sql);
    if ($result) {
        $count = $db->query($countSql)->fetch_object()->c;
        $images = $result->fetch_all(MYSQLI_ASSOC);
        return $images;
    }
    return false;
}

function getCartImages($idArray)
{
    global $db;
    if (count($idArray) == 0) // chek if cart empty
        return array();
    $whereStr = 'id IN (' . implode(',', $idArray) . ')';
    $sql = "SELECT * FROM $db->imagesTable where $whereStr";
    $result = $db->query($sql);
    if ($result) {
        $images = $result->fetch_all(MYSQLI_ASSOC);
        return $images;
    }
    return array();

}

function createAndGetThumbURL($inputFilePath, $thumbName, $mime)
{
    list($width, $height) = getimagesize($inputFilePath);
    $thumb = imagecreatetruecolor(IS_THUMB_WIDTH, IS_THUMB_HEIGHT);
    if ($mime == 'image/png') {
        $source = imagecreatefrompng($inputFilePath);
    } else {
        $source = imagecreatefromjpeg($inputFilePath);
    }
    imagecopyresized($thumb, $source, 0, 0, 0, 0, IS_THUMB_WIDTH, IS_THUMB_HEIGHT, $width, $height);
    $newFilename = IS_THUMB_UPLOAD_PATH . $thumbName;
    if ($mime == 'image/png') {
        imagepng($thumb, $newFilename);
    } else {
        imagejpeg($thumb, $newFilename);
    }
    imagedestroy($thumb);
    imagedestroy($source);
    return IS_THUMB_BASE_URL . $thumbName;
}

function uploadAndSaveImage($cat, $title, $price, $image, &$errorMsg)
{
    $uploadDir = IS_IMAGE_UPLOAD_PATH;
    $fileName = rand(1000, 9999) . '-' . $image['name'];
    $thumbFileName = 'th-' . rand(100, 999) . '-' . $image['name'];
    $filePath = $uploadDir . $fileName;
    $allowedTypes = array('image/png', 'image/jpg', 'image/jpeg');
    if (in_array($image['type'], $allowedTypes)) {
        if (move_uploaded_file($image['tmp_name'], $filePath)) {
            $thumbUrl = createAndGetThumbURL($filePath, $thumbFileName, $image['type']); // create thumbnail
            global $db;
            list($cat, $title, $price) = array(sanitize($cat), sanitize($title), sanitize($price));
            $filePath = str_replace("\\", "/", $filePath); // replace \ with / in file path
            $sql = "INSERT INTO $db->imagesTable (cat_id, title, path, thumb_url, price) VALUES ('$cat', '$title', '$filePath', '$thumbUrl', '$price');";
            $result = $db->query($sql);
            if ($result)
                return true;

            $errorMsg = 'مشکلی در هنگام ثبت اطلاعات در پایگاه داده  رخ داده است .';
            return false;
        } else {
            $errorMsg = "فایل آپلود نشد .";
            return false;
        }
    } else {
        $errorMsg = "فرمت فایل غیر مجاز است . فقط فرمت های jpg و png قابل قبول است .";
        return false;
    }
}
function addOrder($uID, $imageID)
{
    global $db;
    $price = getField('price',$db->imagesTable,'id',$imageID);
    $sql = "INSERT INTO $db->ordersTable (user_id,image_id,price) VALUES ('$uID','$imageID','$price');";
    $result = $db->query($sql);
    if ($result) {
        return true;
    }
    return false;
}

// check if User Bought an image
function userBuyImage($uID, $imageID)
{
    global $db;
    $val = $db->query("SELECT count(*) as c FROM $db->ordersTable where user_id='$uID' and image_id='$imageID'")->fetch_object()->c;
    if ($val)
        return $val;
    return 0;
}

/***** Authentication(login/logout/check) Functions *****/
function getHash($str)
{
    $saltStr = '7Learn.cOm';
    $hash = sha1($saltStr . md5($str . $saltStr));
    return $hash;
}

function addUser($email, $password, $name, $mobile, $role = 'user')
{
    global $db;
    // sanitize all inputs in one line !!!
    list($email, $password, $name, $mobile) = array(sanitize($email), sanitize($password), sanitize($name), sanitize($mobile));
    $password = getHash($password); // hash password
    $sql = "INSERT INTO $db->usersTable (role,name,email,password,mobile) VALUES ('$role','$name','$email','$password','$mobile');";
    $result = $db->query($sql);
    if ($result) {
        return true;
    }
    return false;
}

function changeUserPassword($uID, $newPassword, &$errMsg = '')
{
    global $db;
    $newPassword = getHash($newPassword);
    $sql = "UPDATE $db->usersTable set password='$newPassword' where id='$uID';";
    $result = $db->query($sql);
    if ($result) {
        return true;
    }
    $errMsg = 'مشکلی در هنگام ثبت درخواست شما رخ داده است .';
    return false;
}

function addPasswordResetRequest($uID, &$errMsg = '')
{
    global $db;
    $hash = hash('sha1', rand(1000, PHP_INT_MAX) . '7Learn' . rand(1000, PHP_INT_MAX));
    $countRequests = getField('count(*)', $db->passResetTable, 'uid', $uID);
    if ($countRequests <= 0) {
        $sql = "INSERT INTO $db->passResetTable (uid,hash) VALUES ('$uID','$hash');";
    } else { // if a request already exists !
        $sql = "UPDATE $db->passResetTable set hash='$hash', req_date=now() where uid='$uID' ;";
    }
    $result = $db->query($sql);
    if ($result) {
        return $hash;
    }
    $errMsg = 'مشکلی در هنگام ثبت درخواست شما رخ داده است .';
    return false;
}

function getUser($email)
{
    global $db;
    $sql = "SELECT * FROM $db->usersTable where email='$email' limit 0,1;";
    $result = $db->query($sql);
    if ($result) {
        $user = $result->fetch_assoc();
        return $user;
    }
    return false;
}

function doLogin($email, $password)
{
    $user = getUser($email);
    if ($user and $email == $user['email'] and getHash($password) == $user['password']) {
        $_SESSION['login'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user'] = $user['name'];
        $_SESSION['userID'] = $user['id'];
        return true;
    }
    return false;
}

function doLogout()
{
    unset($_SESSION['login'], $_SESSION['user'], $_SESSION['userID'], $_SESSION['role']);
    return true;
}

function isLogin()
{
    if (isset($_SESSION['login'], $_SESSION['user'], $_SESSION['userID'], $_SESSION['role']))
        return true;
    return false;
}

function currentUserID()
{
    if (isLogin()) {
        return $_SESSION['userID'];
    }
    return -1;
}

function isAdmin()
{
    if (isLogin() and $_SESSION['role'] == 'admin')
        return true;
    return false;
}


/***** Data Cleaning and Sanitizing Functions *****/
function cleanInput(&$input)
{

    $search = array(
        '@<script[^>]*?>.*?</script>@si', // Strip out javascript
        '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
        '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
        '@<![\s\S]*?--[ \t\n\r]*>@' // Strip multi-line comments
    );

    $output = preg_replace($search, '', $input);
    $input = $output;
    return $output;
}

function sanitize(&$input)
{
    if (is_array($input)) {
        foreach ($input as $var => $val) {
            $output[$var] = sanitize($val);
        }
    } else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input = cleanInput($input);
        $output = mysql_real_escape_string($input);
    }
    $input = $output;
    return $output;
}

/***** Pagination Functions *****/
function getNumPages($numQuestions)
{
    $numPages = ceil($numQuestions / QA_QUSETION_PER_PAGE);
    return $numPages;
}

/***** Helper Functions *****/
function getPageUrl($pageNumber)
{
    $getParameters = array();
    if (isset($_GET['cat']))
        $getParameters['cat'] = $_GET['cat'];
    $getParameters['page'] = $pageNumber;
    $str = '?';
    foreach ($getParameters as $key => $value) {
        $str .= "$key=$value&";
    }
    return IS_HOME_URL . trim($str, '&');
}

function myPrint($var)
{
    echo '<pre class="ltr">';
    if (is_array($var) or is_object($var))
        print_r($var);
    else
        echo $var;
    echo '</pre>';
}

function printMessage($errMsg, $succMsg)
{
    if ($errMsg) {
        echo "<div class='error'><b>خطا : </b>" . nl2br($errMsg) . "</div>";
    }
    if ($succMsg) {
        echo "<div class='success'>" . nl2br($succMsg) . "</div>";
    }
}
