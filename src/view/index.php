<?php

/**
 * Flickr Photo Viewer index view
 *
 * @package    Flicker
 * @author     Aravind.B.Dev <aravind@abdev.in>
 * @link       http://www.abdev.com.au
 *
 */


?>
<html>
    <head>
        <title>Flicker Image Viewer</title>
        <link rel="stylesheet" type="text/css" href="application/css/style.css">
    </head>
    <body>
        <h1 id="heading">Flicker Images Search</h1>
        <div id="searchBox">
            <form method="GET">
                <input type="text" id="searchImgText" name="search" value="<?php echo $search;?>" />
                <input type="submit" value="Search" id="searchImg" />
            </form>
        </div>
        <?php if(isset($images['total']) && $images['total'] == 0) :?>
        <div id="error_msg">No Images matches your search, try another keyword</div>
        <?php elseif(isset($images['total']) && $images['total'] && !empty($images['photo'])) :?>
        <div id="imgList">
            <?php foreach($images['photo'] as $photo){?>
            <a href="<?php echo $photo['img_main'];?>" target="_blank"><img class="resultImg" src="<?php echo $photo['img_thumb'];?>" /></a>
            <?php }?>
        </div>
        <?php endif ?>
            <div id="navigate">
            <?php if(isset($images['previous_page']) && $images['previous_page']) :?>
            <a class="navigate_link" href="index.php?search=<?php echo urlencode($search);?>&page=<?php echo $images['previous_page'];?>">&lt;&nbsp;Previous</a>
            <?php endif ?>
            <?php if(isset($images['next_page']) && $images['next_page']) :?>
            <a class="navigate_link" href="index.php?search=<?php echo urlencode($search);?>&page=<?php echo $images['next_page'];?>">Next&nbsp;&gt;</a>
            <?php endif ?>
        </div>
    </body>
</html>