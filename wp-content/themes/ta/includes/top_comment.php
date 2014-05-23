<?php if (get_option('swt_type') == 'Display') { ?>
<h3>联系博主</h3>
<ul class="contact-info">
		<li class="contact-info-name">
			<span>Sawyer</span>
		</li>
		<li class="contact-info-email">
		<a href="mailto:706142@qq.com"><span>706142@qq.com</span></a>
		</li>
        <li class="contact-info-phone">
			<span>(+12) 345 6789</span>
		</li>
		<li class="contact-info-address">
			<span>Changsha.Hunan.China</span>
		</li>
		<li class="contact-info-speech">
			<span>Contact from 9:00AM - 8:00PM.</span>
		</li>
		</ul>
    <?php { echo ''; } ?>
			<?php } else { include(TEMPLATEPATH . '/includes/top_comment2.php'); } ?>
