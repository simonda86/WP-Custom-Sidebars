<?php

/**
* 
*/
class csb_admin
{
	function __construct()
	{
		// Admin pages
		add_action('admin_menu', array($this, 'csb_create_menu_page'));
		add_action('admin_print_scripts-settings_page_custom-sidebars', array($this,'csb_admin_scripts'));
	}
	
	function csb_create_menu_page()
	{
		add_submenu_page( 'options-general.php', 'Custom Sidebars', 'Custom Sidebars', 'manage_options', 'custom-sidebars', array($this, 'csb_admin_page'));
	}
	
	function csb_admin_page()
	{
		echo '<div class="wrap">';
			echo '<h2>Custom Sidebars</h2>';
			settings_errors();
			echo '<form action="options.php" method="post">';
				$sidebars = get_option('csb_sidebars');
				
				// Load WP table list to display all custom sidebars
				require dirname( __FILE__ ) . '/sidebar-table.php';
				$sidebar_table->prepare_items();
				$sidebar_table->display();
				
				do_settings_sections('custom-sidebars');
				
				settings_fields('custom-sidebars');	
				submit_button();
		echo '</form></div>';
	}
	
	function csb_admin_scripts()
	{
		wp_enqueue_script('csb_scripts', plugins_url('js/admin.js', __FILE__), 'jquery');
	}
}
