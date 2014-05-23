<?php get_header(); ?>
<div id="content">
<div class="lineall"></div>
<div class="main">
<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
<div <?php post_class(); ?> class="post-<?php the_ID(); ?> post">
<div class="post_date"><span><?php _e('Published on ', 'TA'); the_modified_time(__('F j, Y', 'TA')) ?></span><span class="author"><?php _e('BY ', 'TA'); the_author_posts_link(); ?></span></div>
<div class="entry-separator"></div>
<div class="article">
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="详细阅读 <?php the_title_attribute(); ?>"><?php the_title(); ?></a><span class="new"><?php include('includes/new.php'); ?></span></h2>
<div class="entry-separator"></div>
<?php if (get_option('swt_thumbnail') == 'Display') { ?>
        <?php if (get_option('swt_articlepic') == 'Display') { ?>
<?php include('includes/articlepic.php'); ?>
    <?php { echo ''; } ?>
			<?php } else { include(TEMPLATEPATH . '/includes/thumbnail.php'); } ?>
<?php { echo ''; } ?><?php } else { } ?>
<div class="entry_post"><span><?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 365,"..."); ?></span><span class="more"><a href="<?php the_permalink() ?>" title="详细阅读 <?php the_title(); ?>" rel="bookmark">阅读全文</a></span></div>
<div class="clear"></div>
<div class="info">
<span class="category"><?php the_category(', ') ?></span>
<span class="tags"><?php the_tags('', ', ', ''); ?></span>
<span class="comm"><?php comments_popup_link ('No comments yet','1 comment','% comments'); ?></span>
<span class="views"><?php if(function_exists(the_views)) { the_views(' views', true);}?></span>
</div></div><div class="clear"></div></div><div class="lineall"></div>
		<?php endwhile; else: ?>
<div class="left">
<div class="article">
<h3 class="center">非常抱歉，无法搜索到与之相匹配的信息。</h3>
</div></div>
		<?php endif; ?> 
<div class="navigation"><?php pagination($query_string); ?></div>
</div>
<?php get_footer(); ?>