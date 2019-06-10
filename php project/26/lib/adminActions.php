<?php
include_once 'funcs.php';
if (isAdmin()) {
    $errorMsg = false; // error message
    $successMsg = false; // success message

    if ($ui == 'index') {
        global $db;
        $report = array();
        $report['countCats'] = getField('count(*)', $db->categoriesTable);
        $report['countImages'] = getField('count(*)', $db->imagesTable);
        $report['countUsers'] = getField('count(*)', $db->usersTable);
        $report['countOrders'] = getField('count(*)', $db->ordersTable);
        $report['income'] = getField('sum(price)', $db->ordersTable);
        $report['todayIncome'] = getField('sum(price)', $db->ordersTable, 'DATE(`create_date`)', 'CURDATE()');
    }


    if ($ui == 'categories') {
        if (isset($_POST['addCat'])) {
            if (is_numeric($_POST['catOrder']) and strlen($_POST['catName']) > 5) {
                if (addCategory($_POST['catName'], $_POST['catOrder'], $errorMsg)) {
                    $successMsg = "دسته بندی با موفقیت افزوده شد .";
                }
            } else {
                $errorMsg = "نام و ترتیب دسته بندی باید به درستی وارد شوند .";
            }
        } elseif (isset($_POST['editCat'])) {
            // Tamrin : function zir ro benvisid :
            // updateCategory(catID,catName,catOrder);
            $errorMsg = "تابع آپدیت و ویرایش دسته بندی برای تمرین به شما محول شده است . حتما آنرا بنویسید .";
        } elseif (isset($_GET['delCat']) and is_numeric($_GET['delCat'])) {
            removeCategory($_GET['delCat']);
            $successMsg = "دسته بندی با موفقیت حذف شد .";
        }
        // prepare categories for ui
        $catCount = 0;
        $categories = getCategories($catCount);
    }

    if ($ui == 'upload') {
        if (isset($_POST['upload'])) {
            if (isset($_POST['cat'], $_POST['title'], $_POST['price']) and $_FILES['image']['error'] == 0 and is_numeric($_POST['price'])) {
                if (uploadAndSaveImage($_POST['cat'], $_POST['title'], $_POST['price'], $_FILES['image'], $errorMsg)) {
                    $successMsg = 'تصویر با موفقیت ثبت و در پایگاه داده ذخیره شد .';
                }
            } else {
                $errorMsg = "همه فیلدها باید به درستی وارد شوند .";
            }
        }
        // prepare categories for ui
        $catCounts = 0;
        $categories = getCategories($catCounts);

        //tamrin : daryaft List Axha va namayesh dar yek jadval + ghabeliate hazf (az database va az hafeze)
    }

    if ($ui == 'orders') {
        $orderCount = 0;
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $orders = getOrders('all', $page, $orderCount);
    }

    if ($ui == 'users') {
        // prepare data for users ui
    }

}
