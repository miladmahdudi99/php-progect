<?php $ui = 'users'; include_once '../lib/adminActions.php'; ?>
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
            <h2>کاربران</h2>
            <?php printMessage($errorMsg,$successMsg) ?>

            <form action="" method="get" class="fixForm">
                <input type="text" name="s" placeholder="نام یا ایمیل کاربر">
                <input type="submit" name="search" class="btn btn1" value="جستجو"><br>
            </form>
            <form action="" method="post" class="fixForm userForm top40">
                <input type="text" name="name" placeholder="نام">
                <select name="role">
                    <option value="user">نقش</option>
                    <option value="user">کاربر عادی</option>
                    <option value="admin">مدیر سیستم</option>
                </select>
                <input type="text" class="ltr" name="mobile" placeholder="موبایل">
                <input type="text" class="ltr" name="email" placeholder="ایمیل">
                <input type="password" class="ltr" name="password" placeholder="پسورد">
                <input type="submit" name="addUser" class="btn btn1" value="افزودن"><br>
            </form>

            <table class="mt60">
                <tr>
                    <td style="width: 3%">id</td>
                    <td style="width: 12%">نام کاربر</td>
                    <td style="width: 5%">نقش</td>
                    <td style="width: 23%">ایمیل</td>
                    <td style="width: 15%">تاریخ عضویت</td>
                    <td style="width: 10%">موبایل</td>
                    <td style="width: 7%">عملیات</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>علی محمدی</td>
                    <td class="center">user</td>
                    <td class="center">ali@gmail.com</td>
                    <td class="center">28 مهر 1393</td>
                    <td class="center">09987654323</td>
                    <td class="center">
                        <a class="x" href="?delUser=1" title="حذف کاربر">X</a> &nbsp; &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>علی محمدی</td>
                    <td class="center">user</td>
                    <td class="center">ali@gmail.com</td>
                    <td class="center">28 مهر 1393</td>
                    <td class="center">09987654323</td>
                    <td class="center">
                        <a class="x" href="?delUser=2" title="حذف کاربر">X</a> &nbsp; &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>علی محمدی</td>
                    <td class="center">admin</td>
                    <td class="center">ali@gmail.com</td>
                    <td class="center">28 مهر 1393</td>
                    <td class="center">09987654323</td>
                    <td class="center">
                        <a class="x" href="?delUser=3" title="حذف کاربر">X</a> &nbsp; &nbsp;
                    </td>
                </tr>
            </table>

            <br><br>

            <div class="navigation">
                <a href="#" class="prev">Previous</a>
                <a href="#" class="next">Next</a>
            </div>

            <p class="tamrin">تمرین : مدیریت، حذف و نمایش کاربران در پنل مدیریت به عنوان تمرین به شما محول می شود. حتما این بخش را با دقت انجام دهید .</p>

        </div>
        <div id="wrapper-bottom"></div>
    </div>


    <script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="../js/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="../js/jquery.fancybox.pack.js"></script>
    </body>
    </html>
<?php endif; ?>
