<?php $ui = 'index'; include_once 'lib/userActions.php'; ?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?php echo IS_TITLE ;?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/all.css" media="screen" />
    <link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css" media="screen" />
    <script>var baseUrl = "<?php echo IS_HOME_URL ;?>";</script>
</head>
<body>
<div id="wrapper">
    <div id="wrapper-top"> </div>
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
        <ul class="thumbnails">
            <?php printMessage($errorMsg, $successMsg) ?>
            <?php if($imageCount==0){
                echo '<h2>تصویری وجود ندارد .</h2>';
            } ?>
            <?php foreach($images as $img): ?>
                <?php $buyClass = (userBuyImage(currentUserID(),$img['id']))? 'bought':'';; ?>
                <li><a class="fancybox <?php echo $buyClass; ?>" rel="group" href="wm.php?image=<?php echo $img['id'] ?>&f=.jpg" title="<?php echo $img['id']."|".$img['title'] ?>|<?php echo $buyClass; ?>"><img src="<?php echo $img['thumb_url'] ?>" alt="<?php echo $img['title'] ?>" width="150" height="121" /></a></li>
            <?php endforeach; ?>
        </ul>


        <?php $numPages = ceil($imageCount / IS_IMAGE_PER_PAGE); ?>
        <div class="navigation">
            <?php
            if ($page > 1) {
                echo '<a href="' . getPageUrl($page - 1) . '" class="prev">Previous</a>';
            }
            if ($page < $numPages) {
                echo '<a href="' . getPageUrl($page + 1) . '" class="next">Next</a>';
            }
            ?>
        </div>
        <br>
        <?php if($imageCount != 0){?>
            <div class="center"><?php echo "صفحه $page از $numPages"; ?></div>
        <?php } ?>
    </div>
    <div id="wrapper-bottom"> </div>
</div>
<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".fancybox").fancybox({
            afterLoad: function() {
                var tArr = this.title.split('|');
                if(this.title.search('bought') == -1){
                    this.title = '<a class="addBtn btn1" href="'+baseUrl+'?add2cart=' + tArr[0] + '">افزودن به سبد خرید</a> ' +
                        '<span class="btn1" >' + tArr[1] + '</span> ';
                }else{
                    this.title = '<span class="addBtn btn1">قبلا خریداری شده است</span> ' +
                        '<span class="btn1" >' + tArr[1] + '</span> ';

                }
            },
            helpers : {
                title: {
                    type: 'inside'
                }
            }
        });
    });
</script>
</body>
</html>
