<ul class="menu">
    <li class="bold Csky"><a href="<?php echo IS_HOME_URL ;?>">صفحه اصلی</a></li>
    <?php foreach($categories as $cat): ?>
    <li><a href="<?php echo IS_HOME_URL ;?>?cat=<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></a></li>
<?php endforeach; ?>
</ul>