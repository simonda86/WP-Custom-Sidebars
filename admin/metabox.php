<?php

/**
* 	Add's a metabox to the editor page to select Custom Sidebars
*/
class csb_metabox
{
	function __construct()
	{
		add_action('add_meta_boxes', array($this,'add_metabox'));
		add_action('admin_head', array($this,'admin_head'));
		add_action('save_post', array($this,'save_post_meta'));
		
		// AJAX Handler
		add_action('wp_ajax_csb_create', array($this,'create_sidebar'));
	}
	
	function add_metabox()
	{
		add_meta_box(
			'custom_sidebar',
			__('Custom Sidebar'),
			array($this, 'metabox_callback'),
			'page',
			'side'
		);
	}
	
	function metabox_callback()
	{
		global $wp_registered_sidebars;
		global $post;
		
		// Load current sidebar
		$val = get_post_meta($post->ID, 'csb_sidebar', TRUE);
		if($val == '') $val = 'default'; // If meta has not yet been set, set it to default

		wp_nonce_field(plugin_basename(__FILE__), 'csb_nonce');
		?>
		<ul class="wp-tab-bar clearfix">
			<li class="wp-tab-active"><a href="#" id="csb-existing">Existing sidebars</a></li>
			<li><a href="#" id="csb-create">Create a sidebar</a></li>
		</ul>
		<div id="csb-existing-panel" class="tabs-panel">
			<p><strong><label for="custom_sidebar">Select a sidebar</label></strong></p>
			<p>
				<select name="custom_sidebar" id="custom_sidebar">
					<?php foreach ($wp_registered_sidebars as $sidebar_id => $sidebar) : ?>
						<option<?php if($sidebar_id == $val) echo ' selected="selected" '; ?> value="<?php echo $sidebar_id; ?>"><?php echo $sidebar['name']?></option>
					<?php endforeach; ?>
				</select>
			</p>
		</div>
		<div id="csb-create-panel" class="tabs-panel" style="display: none;">
			<p><strong><label for="create_new_sidebar">Create new sidebar</label></strong></p>
			<p>
				<input type="text" name="csb-create-label" value="">
			</p>
			<p>
				<button type="button" name="csb-create-sidebar" class="button-primary">Create</button>
			</p>
		</div>
		<?
	}
	
	function admin_head()
	{
		echo '<style type="text/css">
				#custom_sidebar .tabs-panel { padding: 0 10px; border-width: 1px; border-style: solid; }
			</style>';

		wp_register_script( 'csb-js', plugins_url('js/metabox.js', __FILE__));
		wp_enqueue_script( 'csb-js' );
	}
	
	function save_post_meta()
	{
		global $post;
		if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
		if(!isset($_POST['custom_sidebar'])) return;
		if(!wp_verify_nonce($_POST['csb_nonce'], plugin_basename(__FILE__))) return;
		
		update_post_meta($post->ID, 'csb_sidebar', $_POST['custom_sidebar']);
	}
	
	// Ajax Handler
	function create_sidebar()
	{
		$sidebar_label = $_POST['sidebar_name'];
		$csb_sidebars = get_option('csb_sidebars');
		
		if(in_array($sidebar_label, $csb_sidebars))
		{
			echo 'Sidebar with the same name already exists';
			die();
		}
		else
		{
			$csb_sidebars[] = $sidebar_label;
			update_option('csb_sidebars', $csb_sidebars);
			echo 'Sidebar Added';
		}
		
		die();
	}
}