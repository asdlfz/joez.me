<?php get_header(); ?>
<div id="content">
<div class="lineall"></div>
<div class="main"><?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div <?php post_class(); ?> class="post-<?php the_ID(); ?> post">
<div class="left">
	<div class="postpath">
		You are here: <a title="<?php _e('Go to homepage', 'ta'); ?>" href="<?php echo get_settings('home'); ?>/"><?php _e('Home', 'ta'); ?></a>
		 &gt; <?php the_category(', '); ?>
		 &gt; <?php the_title(); ?>
	</div>
<div class="entry-separator"></div>
<div class="article">
<h2><?php the_title(); ?></h2>
<div class="entry-separator"></div>
        <div class="context">
           <?php the_content('Read more...'); ?>
	   </div>
		   <!-- Baidu Button BEGIN -->
               <div id="bdshare" class="bdshare_b" style="line-height: 12px;"><img src="http://news.share.baidu.com/static/images/type-button-1.jpg" />
	            	<a class="shareCount"></a>
               	</div>
               <script type="text/javascript" id="bdshare_js" data="type=button" ></script>
               <script type="text/javascript" id="bdshell_js"></script>
               <script type="text/javascript">
                	document.getElementById("bdshell_js").src = "http://news.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
               </script>
           <!-- Baidu Button END -->
		<?php if (get_option('swt_adc') == 'Display') { ?><p style="text-align:center;"><?php echo stripslashes(get_option('swt_adccode')); ?></p><?php { echo ''; } ?><?php } else { } ?>
</div>
</div>
<div class="articles">

<span style="float:left;width:45%;overflow:hidden;"><?php previous_post_link('【上一篇】%link') ?></span><span style="float:right;width:45%;overflow:hidden;text-align: right;"><?php next_post_link('【下一篇】%link') ?></span>
</div>

<div class="articles">
<?php include('includes/related.php'); ?>
<div class="clear"></div>
</div>

<div class="articles">
<?php comments_template(); ?>
</div>

	<?php endwhile; else: ?>
	<?php endif; ?>
</div>
<div class="lineall"></div></div>
<?php get_footer(); ?>