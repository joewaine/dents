<?php $protocols = array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet', 'skype'); ?>

<ul class="social-list list-inline list--hover stack-footer-social">
	<?php 
		for( $i = 1; $i < 11; $i++ ){
			if( $url = get_option("footer_social_url_$i") ) {
				$parts = parse_url($url);
				$title = ( isset($parts['path']) ) ? $parts['path'] : false;
				echo '<li>
					      <a href="' . esc_url($url, $protocols) . '" title="'. $title .' '. esc_attr__(' social icon', 'stack') .'" target="_blank">
						      <i class="socicon icon--xs ' . esc_attr(get_option("footer_social_icon_$i")) . '"></i>
					      </a>
					  </li>';
			}
		} 
	?>
</ul>