<?php get_header(); ?>
<div id="content">
<div class="lineall"></div>
<div class="main"><?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div <?php post_class(); ?> class="post-<?php the_ID(); ?> post">
<div class="left">
<div class="post_date"><span><?php _e('Published on ', 'TA'); the_modified_time(__('F j, Y', 'TA')) ?></span><span class="author"><?php _e('BY ', 'TA'); the_author_posts_link(); ?></span></div>
<div class="entry-separator"></div>
<div class="article">
<h2><?php the_title(); ?></h2>
<div class="entry-separator"></div>
        <div class="context"><?php the_content('Read more...'); ?></div>
</div>
</div>

<div class="articles">
<?php comments_template(); ?>
</div>

	<?php endwhile; else: ?>
	<?php endif; ?>
</div>
<div class="lineall"></div></div>
<?php get_footer(); ?>