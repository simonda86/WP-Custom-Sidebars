# WP-Custom-Sidebars
WordPress plugin that allows you to create custom sidebars from an admin page and select these sidebars in a metbox on the page editor page.

#Installation
To install this plugin download a zipped folder and then upload to WordPress.
Then add the following code to your template files
	<?php 
	$sidebar = get_post_meta($post->ID, 'csb_sidebar', true);
	if($sidebar == '') $sidebar = 'default';
	?>
	<ul>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar()) dynamic_sidebar($sidebar); ?>
	</ul>