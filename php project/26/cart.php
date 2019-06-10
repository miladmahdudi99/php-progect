<?php $ui = 'cart';  include_once 'lib/userActions.php'; ?>
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
                    <span>خوش آمدی <?php echo $_SESSION['user']; ?></span> &nbsp;
                    <a class="pf" href="<?php echo IS_HOME_URL ;?>auth.php">پروفایل</a> &nbsp;
                    <a class="logout" href="<?php echo IS_HOME_URL ;?>auth.php?logout=1">خروج</a>
                </div>
            <?php endif; ?>
            <?php if(isAdmin()): ?>
                <a class="panel" href="<?php echo IS_HOME_URL ;?>admin/index.php">پنل مدیریت</a>
            <?php endif; ?>
            <a class="cart" title="اتکمیل خرید" href="cart.php">سبد خرید <span class="cartNum"><?php echo count($cart); ?></span></a>
            <?php if(!isLogin()){ ?>
                <div class="auth">
                    <form action="auth.php" method="post">
                        <input type="text" name="email" class="ltr" placeholder="Username"><br>
                        <input type="password" name="password" class="ltr" placeholder="Password"><br>
                        <input type="submit" name="login" class="btn" value="ورود" ><br>
                        <a href="<?php echo IS_HOME_URL ;?>auth.php?register">عضویت</a> &nbsp; &nbsp;
                        <a href="<?php echo IS_HOME_URL ;?>auth.php?reset">فراموشی رمز</a>
                    </form>
                </div>
            <?php } ?>

        <?php include_once 'part-cats.php'; ?>

        </div>
        <div id="right">
            <h2>کالاهای موجود در سبد خرید شما :</h2>
            <?php printMessage($errorMsg, $successMsg) ?>
            <table>
                <tr>
                    <td style="width: 2%">#</td>
                    <td style="width: 70%">کالا</td>
                    <td style="width: 10%">حذف</td>
                    <td style="width: 18%">قیمت (تومان)</td>
                </tr>
                <?php
                $n=1;
                foreach($cartImages as $img): ?>
                    <tr>
                        <td><?php echo $n++; ?></td>
                        <td><img class="th" src="<?php echo $img['thumb_url'] ?>" width="50" height="40"/> <?php echo $img['title'] ?></td>
                        <td class="center"><a class="x" href="?delItem=<?php echo $img['id'] ?>">X</a></td>
                        <td class="center"><?php echo $img['price'] ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if(count($cart) == 0): ?>
                    <tr>
                        <td>::</td>
                        <td>سبد خرید شما خالی است .</td>
                        <td class="center"></td>
                        <td class="center"></td>
                    </tr>
                <?php endif; ?>
                <tr class="bold">
                    <td>*</td>
                    <td>مجموع هزینه</td>
                    <td class="center"></td>
                    <td class="center"><?php echo $sumPrice; ?></td>
                </tr>
            </table>
            <br><br>
            <div class="center">
                <?php if (isLogin()) { ?>
                    <?php if (count($cart) > 0) { ?>
                        <a class="btn1" href="payment.php">تکمیل خرید و پرداخت آنلاین</a>
                    <?php } ?>
                <?php } else { ?>
                    <span class="btn1">برای تکمیل خرید و پرداخت باید پس از عضویت وارد سایت شوید .</span>
                <?php } ?>

            </div>
        </div>
        <div id="wrapper-bottom"></div>
    </div>


    <script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>
    </body>
    </html>
<?php session_write_close(); ?>