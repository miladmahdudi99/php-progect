<?php $ui = 'orders'; include_once '../lib/adminActions.php';?>
<?php if(isAdmin()): ?>
    <!doctype html>
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo IS_TITLE; ?></title>
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
                <li><a href="<?php echo IS_HOME_URL; ?>admin/index.php">داشبورد</a></li>
                <li><a href="<?php echo IS_HOME_URL; ?>admin/upload.php">ارسال تصویر</a></li>
                <li><a href="<?php echo IS_HOME_URL; ?>admin/categories.php">دسته بندی ها</a></li>
                <li><a href="<?php echo IS_HOME_URL; ?>admin/orders.php">سفارشات</a></li>
                <li><a href="<?php echo IS_HOME_URL; ?>admin/users.php">کاربران</a></li>
            </ul>
        </div>
        <div id="right">
            <h2>مدیریت سفارشات<?php echo " : $orderCount مورد"; ?></h2>
            <?php printMessage($errorMsg, $successMsg) ?>
            <table>
                <tr>
                    <td style="width: 2%">id</td>
                    <td style="width: 50%">کالا</td>
                    <td style="width: 8%">کاربر</td>
                    <td style="width: 15%">قیمت (تومان)</td>
                    <td style="width: 25%">تاریخ</td>
                </tr>
                <?php foreach ($orders as $ord): ?>
                    <tr>
                        <td><?php echo $ord['id']; ?></td>
                        <td><img class="th" src="<?php echo $ord['thumb_url'] ?>" width="50" height="40"/> <?php echo $ord['image_id'] . ' : ' . $ord['title'] ?>
                        <td class="center"><?php echo $ord['user_id']; ?></td>
                        <td class="center"><?php echo $ord['price']; ?></td>
                        <td class="center"><?php echo jdate(IS_DATE_FORMAT, strtotime($ord['create_date'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <br><br>
            <?php $numPages = ceil($orderCount / IS_ORDERS_PER_PAGE); ?>
            <div class="navigation">
                <?php
                if ($page > 1) {
                    echo '<a href="?page=' . ($page - 1) . '" class="prev">Previous</a>';
                }
                if ($page < $numPages) {
                    echo '<a href="?page=' . ($page + 1) . '" class="next">Next</a>';
                }
                ?>
            </div>
            <br>
            <div class="center"><?php echo "صفحه $page از $numPages"; ?></div>


        </div>
        <div id="wrapper-bottom"></div>
    </div>


    <script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="../js/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="../js/jquery.fancybox.pack.js"></script>
    </body>
    </html>
<?php endif; ?>
