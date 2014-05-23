</div>
<div id="footer">
<div id="sidebar">
<div class="widget"><?php include('includes/r_comment.php'); ?></div>

<div class="widget"><div id="tab-title"><?php include('includes/r_tab.php'); ?></div></div>

<div class="widget">
<div class="search">		
	<form id="searchform" method="get" action="<?php bloginfo('home'); ?>">
		<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" size="30" />
	</form>
</div></div>

<div class="widget"><div class="contact">
	<?php if (get_option('swt_wallreaders') == 'Hide') { ?>
	<?php { echo ''; } ?>
	<?php } else { include(TEMPLATEPATH . '/includes/top_comment.php'); } ?></div>
</div>

<div class="clear"></div>

<div class="foottext">
Copyright <?php echo comicpress_copyright(); ?> <?php bloginfo('name'); ?>. Powered by <a href="http://www.wordpress.org/" rel="external">WordPress</a>.
 Theme by <a href="http://www.imsawyer.com/" rel="external">Sawyer</a>.
 <?php if (get_option('swt_beian') == 'Display') { ?><a href="http://www.miitbeian.gov.cn/" rel="external"><?php echo stripslashes(get_option('swt_beianhao')); ?></a><?php { echo '.'; } ?><?php } else { } ?> <?php if (get_option('swt_tj') == 'Display') { ?><?php echo stripslashes(get_option('swt_tjcode')); ?><?php { echo '.'; } ?>	<?php } else { } ?></div>
 </div>
<?php wp_footer(); ?>
</div>
<!-- 返回顶部 -->
<div style="display: none;" id="gotop"></div>
<script type='text/javascript'>
	backTop=function (btnId){
		var btn=document.getElementById(btnId);
		var d=document.documentElement;
		var b=document.body;
		window.onscroll=set;
		btn.onclick=function (){
			btn.style.display="none";
			window.onscroll=null;
			this.timer=setInterval(function(){
				d.scrollTop-=Math.ceil((d.scrollTop+b.scrollTop)*0.1);
				b.scrollTop-=Math.ceil((d.scrollTop+b.scrollTop)*0.1);
				if((d.scrollTop+b.scrollTop)==0) clearInterval(btn.timer,window.onscroll=set);
			},10);
		};
		function set(){btn.style.display=(d.scrollTop+b.scrollTop>100)?'block':"none"}
	};
	backTop('gotop');
</script>
<!-- 返回顶部END -->

</body>
</html>