<?php

/**
* 	Lists all the sidebars in a table on the admin page
*/

class Sidebar_Table extends WP_List_Table
{
	function __construct()
	{
		parent::__construct(array(
			'singular' => 'csb_list',
			'plural' => 'csb_lists',
			'ajax' => false
		));
	}
	
	function get_columns()
	{
		return $columns = array(
			'col_csb_name' => 'Name',
			'col_csb_actions' => 'Actions'
		);
	}
	public function get_sortable_columns()
	{
		return $sortable = array(
			'col_csb_name' => 'csb_name'
		);
	}
	
	function prepare_items()
	{
		$screen = get_current_screen();
		
		$this->_column_headers = array( 
			$this->get_columns(),			// columns
			array(),						// hidden
			$this->get_sortable_columns()	// sortable
		);
		
		if(get_option('csb_sidebars'))
		{
			$sidebars = get_option('csb_sidebars');
			$rows = array();
			
			foreach($sidebars as $sidebar)
			{
				$rows[] = array(
					'name' => $sidebar,
					'link' => '<a href="#" class="csb_delete">Delete</a>' 
				);
			}
			
			$columns = $this->get_columns();
			$_wp_column_headers[$screen->id] = $columns;
			
			$this->items = $rows;
		}
	}
	
	function display_rows()
	{
		foreach($this->items as $row)
		{
			echo "<tr><td class='csb_name'>" . $row['name'] . "</td><td>" . $row['link'] . "<input type='hidden' name='csb_sidebars[]' value='" . $row['name'] . "' /></td></tr>";
		}
	}
}
$sidebar_table = new Sidebar_Table();