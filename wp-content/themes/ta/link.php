<?php
/*
Template Name: Link
*/
?>
<?php get_header(); ?>
<div id="content">
<div class="lineall"></div>
<div class="main"><?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div <?php post_class(); ?> class="post-<?php the_ID(); ?> post">
<script type="text/javascript">
jQuery(document).ready(function($){
$(".weisaylink a").each(function(e){
	$(this).prepend("<img src=http://www.google.com/s2/favicons?domain="+this.href.replace(/^(http:\/\/[^\/]+).*$/, '$1').replace( 'http://', '' )+" style=float:left;padding:5px;>");
}); 
});
</script>
<div class="left">
<div class="post_date"><span><?php _e('Published on ', 'TA'); the_modified_time(__('F j, Y', 'TA')) ?></span><span class="author"><?php _e('BY ', 'TA'); the_author_posts_link(); ?></span></div>
<div class="entry-separator"></div>
<div class="article">
<h2><?php the_title(); ?></h2>
<div class="entry-separator"></div>
<div class="weisaylink"><ul>
<?php wp_list_bookmarks('orderby=id&category_orderby=id'); ?></ul>
</div>
<div class="clear"></div>
<div class="linkstandard">
<h2 style="color:#FF0000">申请友情链接前请看：</h2><ul>
<li>一、在您申请本站友情链接之前请先做好本站链接，否则不会通过，谢谢！</li>
<li>二、<span style="color:#FF0066">谢绝第一次来我博客就申请友情链接</span>，在做链接前我希望的是交流，博客与博客的交流，而不是一上来就是交换链接。</li>
<li>三、本站目前只招优秀的设计，编程类原创IT博客，其他类别的博客申请将有可能不被通过，当然如果你站确实优秀的话我会考虑添加的。</li>
<li>四、如果您的站还未被baidu或google收录，申请链接暂不予受理！</li>
<li>五、如果您的站原创内容少之又少，申请连接不予受理！</li>
<li>六、其他暂且保留，有想到的再添加。</li></ul>
</div>

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