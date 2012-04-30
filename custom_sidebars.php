<?php
/*
Plugin Name: Custom Sidebars
Plugin URI: http://simon-davies.name
Description: Select and create custom sidebars on a post by post basis.
Author: Simon Davies
Version: 1.0 

Based on an Article by Guillaume Voisin (@guillaumvoisin)
http://wp.tutsplus.com/tutorials/theme-development/how-to-use-custom-sidebars-on-posts-and-pages/

*/

class Custom_Sidebars 
{
	function __construct()
	{
		add_action('admin_init', array($this,'init'));
		add_action('widgets_init', array($this, 'register_sidebars'));
	}
	
	function init()
	{
		$page = 'custom-sidebars';
		
		add_settings_section(
			'custom_sidebar_section',
			'Create new Sidebar',
			array($this,'custom_sidebar_section_callback'),
			$page
		);
		add_settings_field(
			'csb_sidebars',
			'New Sidebar name',
			array($this,'csb_new_sidebar_callback'),
			$page,
			'custom_sidebar_section'
		);
		register_setting($page,'csb_sidebars');
	}
	
	function register_sidebars()
	{
		$sidebars = get_option('csb_sidebars');
		if($sidebars && count($sidebars) > 0)
		{
			foreach($sidebars as $sidebar)
			{
				register_sidebar( array(
					'name' => $sidebar,  
					'id' => $this->generateSlug($sidebar, 45),  
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',  
					'after_widget' => "</aside>",  
					'before_title' => '<h3 class="widget-title">',  
					'after_title' => '</h3>'
				));
			}
		}
	}
	
	function custom_sidebar_section_callback()
	{
		echo '<p>To create a new sidebar enter an name and press create. <strong>Important: Make sure you press save changes when you are finished.</strong></p>';
	}
	
	function csb_new_sidebar_callback()
	{
		echo '<input type="text" name="csb_create_sidebar" value="" id="csb_create_sidebar" class="regular-text"><input type="button" id="csb_create_btn" value="Create" class="button-primary">';
	}
	
	function generateSlug($phrase, $maxLength)  
	{  
	    $result = strtolower($phrase);  

	    $result = preg_replace("/[^a-z0-9\s-]/", "", $result);  
	    $result = trim(preg_replace("/[\s-]+/", " ", $result));  
	    $result = trim(substr($result, 0, $maxLength));  
	    $result = preg_replace("/\s/", "-", $result);  

	    return $result;  
	}
}

$custom_sidebars = new Custom_Sidebars();

// Admin page
require dirname(__FILE__) . '/admin/admin.php';
$csb_admin = new csb_admin();

// Register Metabox
require dirname(__FILE__) . '/admin/metabox.php';
$csb_metabox = new csb_metabox();