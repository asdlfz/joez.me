<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>
	<script type="text/javascript">
		/* <![CDATA[ */
			jQuery(document).ready(function() {
                function setsplicon(c, d) {
                    if (c.html()=='+' || d=='+') {
                        c.html('-');
                        c.removeClass('car-plus');
                        c.addClass('car-minus');
                    } else if( !d || d=='-'){
                        c.html('+');
                        c.removeClass('car-minus');
                        c.addClass('car-plus');
                    }
                }
				jQuery('.car-collapse').find('.car-yearmonth').click(function() {
					jQuery(this).next('ul').slideToggle('fast');
                    setsplicon(jQuery(this).find('.car-toggle-icon'));
				});
				jQuery('.car-collapse').find('.car-toggler').click(function() {
					if ( '展开所有月份' == jQuery(this).text() ) {
						jQuery(this).parent('.car-container').find('.car-monthlisting').show();
						jQuery(this).text('折叠所有月份');
                       setsplicon(jQuery('.car-collapse').find('.car-toggle-icon'), '+');
					}
					else {
						jQuery(this).parent('.car-container').find('.car-monthlisting').hide();
						jQuery(this).text('展开所有月份');
                        setsplicon(jQuery('.car-collapse').find('.car-toggle-icon'), '-');
					}
					return false;
				});
			});
		/* ]]> */
	</script>
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
		<p class="articles_all"><strong><?php bloginfo('name'); ?></strong>目前共有文章：  <?php echo $hacklog_archives->PostCount();?>篇	</p>
	<?php echo $hacklog_archives->PostList();?>
</div>
</div>
	<?php endwhile; else: ?>
	<?php endif; ?>
</div>
<div class="lineall"></div></div>
<?php get_footer(); ?>