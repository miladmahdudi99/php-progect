<?php $ui = 'auth';  include_once 'lib/userActions.php'; ?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?php echo IS_TITLE ;?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/all.css" media="screen"/>
    <link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css" media="screen"/>
    <script>var baseUrl = "<?php echo IS_HOME_URL ;?>";</script>
</head>
<body>
<div id="wrapper">
    <div id="wrapper-top"></div>
    <div id="left">
        <?php if(isLogin()): ?>
            <div class="center welcome">
                <span>خوش آمدی <?php echo $_SESSION['user']; ?></span> &nbsp; &nbsp;
                <a class="logout" href="<?php echo IS_HOME_URL ;?>auth.php?logout=1">خروج</a>
            </div>
        <?php endif; ?>
        <?php if(isAdmin()): ?>
            <a class="panel" href="<?php echo IS_HOME_URL ;?>admin/index.php">پنل مدیریت</a>
        <?php endif; ?>

        <a class="cart" title="اتکمیل خرید" href="cart.php">سبد خرید <span class="cartNum"><?php echo count($cart); ?></span></a>

        <?php include_once 'part-cats.php'; ?>

    </div>
    <div id="right">
        <?php printMessage($errorMsg, $successMsg) ?>
        <?php if(isset($_GET['hash'])){ ?>
            <h2>تغیر رمز شما</h2>
            <div class="auth">
                <form action="<?php echo IS_HOME_URL ?>auth.php" method="post">
                    <input type="hidden" name="hash" class="ltr" value="<?php echo $_GET['hash']; ?>"><br>
                    <input type="password" name="pw1" class="ltr" placeholder="New Password"><br>
                    <input type="password" name="pw2" class="ltr" placeholder="New Password Again"><br>
                    <input type="submit" name="changePass" class="btn" value="تغیر رمز"><br>
                </form>
            </div>
        <?php }else{ ?>
            <?php if(!isLogin()){ ?>
                <h2>ورود به سایت</h2>
                <div class="auth">
                    <form action="<?php echo IS_HOME_URL ?>auth.php" method="post">
                        <input type="text" name="email" class="ltr" placeholder="Your Email"><br>
                        <input type="password" name="password" class="ltr" placeholder="Password"><br>
                        <input type="submit" name="login" class="btn" value="ورود"><br>
                    </form>
                </div>

                <h2>فراموشی رمز عبور</h2>
                <div class="auth">
                    <form action="<?php echo IS_HOME_URL ?>auth.php" method="post">
                        <input type="text" name="email" class="ltr" placeholder="Enter Your Email"><br>
                        <input type="submit" name="resetpassReq" class="btn" value="ارسال"><br>
                    </form>
                </div>

                <h2>عضویت در سایت</h2>
                <div class="auth">
                    <form action="<?php echo IS_HOME_URL ?>auth.php" method="post">
                        <span>اطلاعات شما :</span><br>
                        <input type="text" name="name" placeholder="نام کامل شما"><br>
                        <input type="text" class="ltr" name="mobile" placeholder="شماره موبایل"><br>
                        <span>اطلاعات ورود به سایت :</span><br>
                        <input type="text" name="email" class="ltr" placeholder="Enter Your Email"><br>
                        <input type="password" name="password1" class="ltr" placeholder="Password"><br>
                        <input type="password" name="password2" class="ltr" placeholder="Password again"><br>
                        <input type="submit" name="register" class="btn" value="عضویت"><br>
                    </form>
                </div>
            <?php }else{ ?>
                <h2><?php echo $_SESSION['user'] ?> عزیز ، شما وارد سایت شدید .</h2>
                <h2>خریدها و سفارشات شما<?php echo " : $orderCount مورد"; ?></h2>
                <table>
                    <tr>
                        <td style="width: 50%">کالا</td>
                        <td style="width: 15%">قیمت (تومان)</td>
                        <td style="width: 25%">تاریخ</td>
                    </tr>
                    <?php foreach ($orders as $ord): ?>
                        <tr>
                            <td><img class="th" src="<?php echo $ord['thumb_url'] ?>" width="50" height="40"/> <?php echo $ord['title'] ?>
                                <span class="dllink"><a href="<?php echo IS_HOME_URL ?>download.php?img=<?php echo $ord['image_id'] ?>">دانلود</a></span>
                            </td>
                            <td class="center"><?php echo $ord['price']; ?></td>
                            <td class="center"><?php echo jdate(IS_DATE_FORMAT, strtotime($ord['create_date'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <p class="tamrin">تمرین : صفحه بندی سفارشات کاربر را در اینجا انجام دهید .</p>
                <p class="tamrin">تمرین : قابلیت تغیر اطلاعات کاربر توسط او را در اینجا پیاده سازی نمایید .</p>
            <?php } ?>
        <?php } ?>


    </div>
    <div id="wrapper-bottom"></div>
</div>


<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>
<script type="text/javascript">
    $('.success').delay(10000).fadeOut(1000);
</script>
</body>
</html>
