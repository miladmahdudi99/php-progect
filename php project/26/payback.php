<?php $ui = 'payback';  include_once 'lib/userActions.php'; ?>
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
        <ul class="menu">
            <li class="bold Csky"><a href="<?php echo IS_HOME_URL ;?>">صفحه اصلی</a></li>
        </ul>
    </div>
    <div id="right">
        <h2>بازگشت از درگاه بانک : </h2>
        <?php printMessage($errorMsg, $successMsg) ?>

    </div>
    <div id="wrapper-bottom"></div>
</div>


<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>
</body>
</html>
<?php session_write_close(); ?>