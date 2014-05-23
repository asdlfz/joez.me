<div class="relatedposts">
    <ul>
        <?php
            foreach(get_the_category() as $category){
            $cat = $category->cat_ID;
            }
            query_posts('cat=' . $cat . '&orderby=rand&showposts=4');  //控制相关文章排序为随机，显示4篇相关文章
            while (have_posts()) : the_post();
            $imgContent = $post->post_content;
            $imgser = '~<img [^\>]*\ />~'; // 搜索所有符合的图片
            preg_match_all( $imgser, $imgContent, $aimgs );
            $imgnum = count($aimgs[0]); // 检查一下至少有一张图片
        ?>
        <li>
		<?php if ( $imgnum > 0 ) {  ?>
		<a class="same_cat_posts_img" href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php echo $aimgs[0][0];//如果没有启用jQuery图片延时加载就改为[0][0] ?></a>
		<?php } else {  ?>
		<a class="same_cat_posts_img" href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><img alt="<?php the_title(); ?>" src="<?php bloginfo('template_url'); ?>/includes/mod-post-timthumb.php?src=<?php bloginfo('template_url'); ?>/images/default.jpg&amp;w=140&amp;h=98&amp;zc=1" /></a>
		<?php } ?>
        </li>
		<?php endwhile; wp_reset_query(); ?>
    </ul>
</div>