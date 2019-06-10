<?php $ui = 'index'; include_once '../lib/adminActions.php'; ?>
<?php if(isAdmin()){ ?>
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
            <h2>داشبورد</h2>
            <?php printMessage($errorMsg,$successMsg) ?>
            <p>تعداد دسته بندی ها : <span> <?php echo $report['countCats'] ?></span></p>
            <p>تعداد تصاویر موجود در فروشگاه : <span> <?php echo $report['countImages'] ?></span></p>
            <p>تعداد کاربران ثبت نامی در سایت : <span>  <?php echo $report['countUsers'] ?></span></p>
            <p>تعداد سفارشات ثبت شده : <span>  <?php echo $report['countOrders'] ?></span></p>
            <p>درآمد کسب شده تا کنون : <span>  <?php echo $report['income'] ?> تومان</span></p>
            <p>درآمد کسب شده امروز : <span>  <?php echo $report['todayIncome'] ?> تومان</span></p>


        </div>
        <div id="wrapper-bottom"></div>
    </div>


    <script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="../js/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="../js/jquery.fancybox.pack.js"></script>
    </body>
    </html>
<?php }else{
    log2File("ip(".$_SERVER['REMOTE_ADDR'].") access to admin area resticted !");
} ?>
