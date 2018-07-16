<?php
require('insta_function.php');
$instaFunction = new InstaFunction();
$timelineFeeds = $instaFunction->getInstaContents();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Instagram</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <h2>Instagram Feeds</h2>
        <div class="row">
            <?php foreach ($timelineFeeds as $feed) { ?>
                <?php
                if (!is_null($feed->node) && ($feed->node->__typename == 'GraphVideo')) {
                    ?>
                    <div class="column">
                        <a target="_blank" href="https://www.instagram.com/<?php echo $feed->node->owner->username; ?>" title="<?php echo $feed->node->owner->full_name; ?>"><img class="insta-user" src="<?php echo $feed->node->owner->profile_pic_url; ?>" alt="Avatar"><span><?php echo $feed->node->owner->username; ?></span></a>
                        <img src="<?php echo $feed->node->display_url; ?>" alt="Snow" style="width:100%">
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </body>
</html>





