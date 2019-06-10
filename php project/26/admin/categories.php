<?php $ui = 'categories';  include_once '../lib/adminActions.php'; ?>
<?php if(isAdmin()): ?>
    <!doctype html>
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo IS_TITLE ;?></title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="../css/all.css" media="screen"/>
        <link rel="stylesheet" href="../css/jquery.fancybox.css" type="text/css" media="screen"/>
        <script>var baseUrl = "<?php echo IS_HOME_URL ;?>";</script>
    </head>
    <body>
    <div id="wrapper">
        <div id="wrapper-top"></div>
        <div id="left">
            <a class="panel" href="<?php echo IS_HOME_URL ;?>">خوش آمدی مدیر</a>

            <ul class="menu">
                <li><a href="<?php echo IS_HOME_URL ;?>admin/index.php">داشبورد</a></li>
                <li><a href="<?php echo IS_HOME_URL ;?>admin/upload.php">ارسال تصویر</a></li>
                <li><a href="<?php echo IS_HOME_URL ;?>admin/categories.php">دسته بندی ها</a></li>
                <li><a href="<?php echo IS_HOME_URL ;?>admin/orders.php">سفارشات</a></li>
                <li><a href="<?php echo IS_HOME_URL ;?>admin/users.php">کاربران</a></li>
            </ul>
        </div>
        <div id="right">

            <form action="" method="post" class="fixForm">
                <input type="text" name="catName" class="center" placeholder="نام دسته بندی">
                <input type="text" name="catOrder" class="center w50" placeholder="ترتیب">
                <input type="submit" name="addCat" class="btn btn1" value="افزودن"><br>
            </form>
            <form action="" method="post" class="fixForm top30">
                <input type="text" name="catID" class="center w50" placeholder="آیدی">
                <input type="text" name="catName" class="center" placeholder="نام دسته بندی">
                <input type="text" name="catOrder" class="center w50" placeholder="ترتیب">
                <input type="submit" name="editCat" class="btn btn1" value="ویرایش"><br>
            </form>

            <h2>دسته بندی ها <?php echo " : $catCount مورد"; ?></h2>
            <?php printMessage($errorMsg,$successMsg); ?>
            <table>
                <tr>
                    <td style="width: 3%">id</td>
                    <td style="width: 75%">نام</td>
                    <td style="width: 5%">تصاویر</td>
                    <td style="width: 7%">ترتیب</td>
                    <td style="width: 10%">عملیات</td>
                </tr>
                <?php foreach($categories as $cat): ?>
                    <tr>
                        <td><?php echo $cat['id'] ?></td>
                        <td><?php echo $cat['name'] ?></td>
                        <td><?php echo getField('count(*)',$db->imagesTable,'cat_id',$cat['id']); ?></td>
                        <td class="center"><span class="ltr"><?php echo $cat['ord'] ?></span></td>
                        <td class="center">
                            <a class="x" href="?delCat=<?php echo $cat['id'] ?>" onclick="return confirm('آیا مطمئن هستید می خواهید دسته (<?php echo $cat['name'] ?>) را حذف کنید ؟')" title="حذف دسته">X</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>


        </div>
        <div id="wrapper-bottom"></div>
    </div>


    <script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="../js/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="../js/jquery.fancybox.pack.js"></script>
    </body>
    </html>
<?php endif; ?>
