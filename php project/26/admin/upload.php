<?php $ui = 'upload'; include_once '../lib/adminActions.php'; ?>
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
            <h2>ارسال و آپلود تصویر جدید</h2>
            <?php printMessage($errorMsg,$successMsg) ?>

            <p>
            <form action="" method="post" class="upImage" enctype="multipart/form-data">
                <select name="cat">
                    <option value="0">انتخاب دسته بندی</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?php echo $cat['id'] ?>"><?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="title" placeholder="نام و عنوان تصویر"><br>
                <input type="text" name="price" placeholder="قیمت فروش تصویر (تومان)"><br>
                <input type="file" class="ltr" name="image"><br>
                <input type="submit" name="upload" class="btn btn1" value="آپلود و ثبت تصویر"><br>
            </form>
            </p>

            <p class="tamrin">تمرین : در این مکان لیست تصاویر را نشان دهید .</p>
        </div>
        <div id="wrapper-bottom"></div>
    </div>


    <script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="../js/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="../js/jquery.fancybox.pack.js"></script>
    </body>
    </html>
<?php endif; ?>
