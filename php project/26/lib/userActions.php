<?php
include_once 'funcs.php';

$errorMsg = false; // error message
$successMsg = false; // success message


if ($ui == 'index') {
    $imageCount = 0;
    $cat = (isset($_GET['cat'])) ? $_GET['cat'] : 0;
    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
    $images = getImages($cat, $page, $imageCount);
    // add to cart
    if (isset($_GET['add2cart']) and is_numeric($_GET['add2cart'])) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array($_GET['add2cart']);
            $_SESSION['cartStatus'] = 'open';
        } else {
            if (isset($_SESSION['cartStatus']) and $_SESSION['cartStatus'] == 'open') {
                $_SESSION['cart'][] = $_GET['add2cart'];
                $_SESSION['cart'] = array_unique($_SESSION['cart']);
            } else {
                $errorMsg = 'سبد خرید قفل است و شما باید عملیات پرداخت را تکمیل نمایید.';
            }
        }
    }
}

if (in_array($ui, array('index', 'cart', 'auth'))) {
    $catCount = 0;
    $categories = getCategories($catCounts);

    if (isset($_SESSION['cart'])) {
        $cart = array_unique($_SESSION['cart']);
    } else {
        $cart = array();
    }
}


if ($ui == 'cart') {
    if (isset($_GET['delItem'])) {
        if (($key = array_search($_GET['delItem'], $_SESSION['cart'])) !== false) {
            unset($_SESSION['cart'][$key]);
            $cart = array_unique($_SESSION['cart']);
        }
    }
    $cartImages = getCartImages($cart);
    $sumPrice = 0;
    foreach ($cartImages as $img) {
        $sumPrice += $img['price'];
    }

}

if ($ui == 'payment') {
    $cart = array_unique($_SESSION['cart']);
    $_SESSION['cartStatus'] = 'block';
    $cartImages = getCartImages($cart);
    $sumPrice = 0;
    foreach ($cartImages as $img) {
        $sumPrice += $img['price'];
    }
}

if ($ui == 'payback') {
    // check if payment is Valid ! (payment and ...)
    if (isset($_POST['status']) and $_POST['status'] == 100) { // successfull payment

        $cart = array_unique($_SESSION['cart']);
        // add order
        foreach ($cart as $imageID) {
            addOrder(currentUserID(), $imageID);
        }
        $successMsg = "تصاویر خریداری شده با موفقیت برای شما ثبت شد . برای دانلود می توانید از صفحه پروفایل خود لیست سفارشاتتان را ببینید .";

        // free cart !
        unset($_SESSION['cart'], $_SESSION['cartStatus']);
    } else { // problem in payment
        $errorMsg = "پرداخت شما نامعتبر است و یا با موفقیت انجام نشده است .";
    }
}


if ($ui == 'auth') {
    // login,logout,register,reset
    if (isset($_POST['register'])) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) and $_POST['password1'] == $_POST['password2'] and strlen($_POST['password1']) > 5) {
            addUser($_POST['email'], $_POST['password1'], $_POST['name'], $_POST['mobile']);
            $successMsg = "شما با موفقیت عضو شدید و هم اکنون می توانید از طرق فرم ورود، لاگین شوید .";
        } else {
            $errorMsg = "اطلاعات نادرست و یا غیر معتبر است .";
        }
    }

    if (isset($_POST['login'])) {
        if (doLogin($_POST['email'], $_POST['password'])) {
            $successMsg = "شما با موفقیت وارد سایت شدید .";
        } else {
            $errorMsg = 'ایمیل یا رمز ورود اشتباه است .';
        }
    }

    if (isset($_GET['logout'])) {
        doLogout();
        $successMsg = "شما با موفقیت خارج  شدید .";
    }

    if (isset($_POST['changePass'])) {
        if ($_POST['pw1'] == $_POST['pw2'] and strlen($_POST['pw1']) > 5) { // min length on password is 6 charachters
            // do change
            $userID = getField('uid', $db->passResetTable, 'hash', $_POST['hash']);
            if ($userID) {
                changeUserPassword($userID, $_POST['pw1']);
                $successMsg = "پسورد شما با موفقیت تغیر یافت .";
                log2File("User $userID : change password !");
            } else {
                $errorMsg = "درخواست شما نا معتبر است .";
            }
        } else {
            $errorMsg = "پسوردهای وارد شده معتبر و یا یکسان نیستند .";
        }
    }

    if (isset($_POST['resetpassReq'])) {
        $user = getUser($_POST['email']);
        if ($user) {
            $hash = addPasswordResetRequest($user['id'], $errorMsg);
            if ($hash) {
                // send an email to user containing pass reset url :
                $passResetUrl = IS_HOME_URL . "auth.php?hash=$hash";
                $msg = "Change your password here : \r\n $passResetUrl";
                @mail($user['email'], 'Pass Reset', $msg);
                $successMsg = "ایمیلی حاوی لینک تغیر پسورد برای شما ارسال شد.";
            }
        } else {
            $errorMsg = "کاربری با این ایمیل در سایت وجود ندارد .";
        }
    }

    if (isLogin()) {
        $orderCount = 0;
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $orders = getOrders(currentUserID(), $page, $orderCount);
    }
}






