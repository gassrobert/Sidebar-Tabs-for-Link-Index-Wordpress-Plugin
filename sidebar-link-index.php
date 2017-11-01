<?php

/**
 * Plugin Name: Sidebar Tabs for Link Index
 * Plugin URI: http://robert-paul-gass-portfolio.co.nf/
 * Description: Organizes Links into Tabs to Create Indexes
 * Author: Robert Paul Gass
 * Author URI: http://robert-paul-gass-portfolio.co.nf/
 * Version: 1.0.0
 * License: GPLv2
 */

// Exit if accessed directly 
if ( ! defined('ABSPATH') ) {
	exit;
}

// Access the necessary scripts for the admin widget area
function rpg_sidebarlinkindex_enqueue_scripts() {

	// Obtain the WP variable for current page
	global $pagenow;

	// Access the necessary scripts if current page is widgets.php
	if ($pagenow == 'widgets.php') {
		wp_enqueue_script( 'rpgAdminLinkIndex', plugins_url( 'js/rpg-admin-link-index.js', __FILE__ ), array( 'jquery' ), '20170924' );
		wp_enqueue_style( 'rpg-admin-sidebar-link-index', plugins_url( 'css/admin-style.css', __FILE__ ));
	}

}
add_action( 'admin_enqueue_scripts', 'rpg_sidebarlinkindex_enqueue_scripts' );



// Access the necessary scripts for the widget displayed in the sidebar
function load_rpg_front_tab_styles_and_scripts() {

	wp_enqueue_script( 'rpgMainLinkIndex', plugins_url( 'js/rpg-main-link-index.js', __FILE__ ), array( 'jquery' ), '20170924', true );
	wp_enqueue_style( 'rpg-sidebar-link-index', plugins_url( 'css/style.css', __FILE__ ));
}
add_action( 'wp_enqueue_scripts', 'load_rpg_front_tab_styles_and_scripts' );


// The Widget Class
class RPG_Sidebar_Tabs_Link_Index extends WP_Widget {

	// Run the constructor  and set the values for the Available Widgets area
	function __construct()
	{
		$params = array(
			'description' => 'Organizes Links into Tabs to Create Indexes',
			'name' => 'Sidebar Tabs for Link Index',
		);

		parent::__construct('SidebarTabsforLinkIndex', '', $params);
	}

	// Initialize the form display in the admin widget area
	public function form($instance)
	{
		// Extract the instance for the form
		extract($instance);

		?>
		<p>
		<b>Instructions:</b> To enter subheadings among the links type the subheading text into the Link Name field and type a # into the Link URL field.
		</p>
		<p>
		<!-- Display the number of tabs for the sidebar -->
			<label class="inputlabel" for="<?php echo $this->get_field_id('tabnumber'); ?>"><b>Number of Tabs: </b></label>
		<input type="number" class="inputnum" id="<?php echo $this->get_field_id('tabnumber'); ?>" name="<?php echo $this->get_field_name('tabnumber'); ?>" min="1" max="10" value="<?php echo !empty($tabnumber) ? $tabnumber : 1; ?>" /> Maximum: 10
		</p>

		<hr>


		<?php  
		// If there are tab values saved, display the tabs 
		// Otherwise display a default empty tab
		if (empty($tabnumber)) {
			$currenttabnumber = 1;
		} else {
			$currenttabnumber = $tabnumber;
		}

		// loop through the tabs
		for ($rpg_num = 0; $rpg_num < $currenttabnumber; $rpg_num++) {

		// The Name of the Tab displayed in the accordion heading
			?>
		<div class="rpgAccordionHeading"><?php if( !empty(${'title' . $rpg_num}) ) { echo esc_attr(${'title' . $rpg_num}); } else { echo 'Untitled Tab'; }  ?></div>

		<div class="rpgAccordion" style="<?php if ($rpg_num == 0 && empty(${'title' . $rpg_num})) { ?>display: block;<?php } else { ?>display: none;<?php } ?>">	
				<p>
				<?php
				// Set the number of links for this tab as ids for the Tab Heading Name textbox and the Number of Links for the Tab textbox
					$title_field_id = 'title' . $rpg_num;
					$link_title_num_id = 'linknum' . $rpg_num;
				?>
				<!-- Display the title textbox of the tab name -->
					<label for="<?php echo $this->get_field_id($title_field_id); ?>"><b>Tab Heading <?php echo ($rpg_num + 1); ?>: </b></label>
					<input class="widefat" id="<?php echo $this->get_field_id($title_field_id); ?>" name="<?php echo $this->get_field_name($title_field_id); ?>" placeholder="Untitled Tab" value="<?php if( !empty(${'title' . $rpg_num}) ) { echo esc_attr(${'title' . $rpg_num}); } else { echo 'Untitled Tab'; } ?>" />
				</p>

				<p>
				<!-- Display the textbox for the number of links under the tab -->
					<label for="<?php echo $this->get_field_id($link_title_num_id); ?>"><b>Number of Links for Tab <?php echo ($rpg_num + 1); ?>: </b></label>
					<input type="number" class="inputnum" id="<?php echo $this->get_field_id($link_title_num_id); ?>" name="<?php echo $this->get_field_name($link_title_num_id); ?>" min="1" max="999" value="<?php echo !empty(${'linknum' . $rpg_num}) ? ${'linknum' . $rpg_num} : 0; ?>" />
				</p>
				<?php
				// If there are link values saved display them
				if (isset(${'linknum' . $rpg_num})) {
				?>
				<div class="rpg_tab_links">
				<?php
					// loop through each link
					for ($rpg_link_num = 0; $rpg_link_num < ${'linknum' . $rpg_num}; $rpg_link_num++) {

						// Display horizontal bar between links for better UX
						if ($rpg_link_num != 0) { echo '<hr>'; }
				?>
					<?php
						// Set the ids for the name textbox and the url textbox
						$link_name_field_id = 'linkname' . $rpg_num . '_' . $rpg_link_num;
						$link_url_field_id = 'linkurl' . $rpg_num . '_' . $rpg_link_num;
					?>

					<!-- display the name textbox -->
					<p>
						<label for="<?php echo $this->get_field_id($link_name_field_id); ?>"><b>Link Name <?php echo ($rpg_link_num + 1); ?>: </b></label>
						<input class="widefat" id="<?php echo $this->get_field_id($link_name_field_id); ?>" name="<?php echo $this->get_field_name($link_name_field_id); ?>" value="<?php if( isset(${'linkname' . $rpg_num . '_' . $rpg_link_num}) ) echo esc_attr(${'linkname' . $rpg_num . '_' . $rpg_link_num}); ?>" />
					</p>		

					<!-- display the URL textbox -->
					<p>
						<label for="<?php echo $this->get_field_id($link_url_field_id); ?>"><b>Link URL <?php echo ($rpg_link_num + 1); ?>: </b></label>
						<input class="widefat" id="<?php echo $this->get_field_id($link_url_field_id); ?>" name="<?php echo $this->get_field_name($link_url_field_id); ?>" value="<?php if( isset(${'linkurl' . $rpg_num . '_' . $rpg_link_num}) ) echo esc_attr(${'linkurl' . $rpg_num . '_' . $rpg_link_num}); ?>" />
					</p>				
				<?php
					} // End of for ($rpg_link_num = 0; 
				?>
				</div>
	  <?php } // End of if (isset(${'linknum' . $rpg_num})) { ?>
	</div>
		<?php
		} // End of for ($rpg_num = 0;
		?>

		<br>
		<br>
		<?php
	}


// This is the Widget Form displayed in the sidebar to the user
public function widget($args, $instance)
{
		// extract the arguments and the instance
		extract($args);
		extract($instance);

		// assign the number of tabs
		$tabnumber = apply_filters('widget-number', $tabnumber);

		// Assign a default title value if necessary
		if( empty($title) ) $title = 'Default Title';

		// display the markup beore the widget
		echo $before_widget;

?>
<!-- Display the row of tabs at the top of the widget -->
<div id="rpg_menu_tabs">
   <ul>
<?php
		// loop through the tabs
		for ($numOfTabs = 0; $numOfTabs < $tabnumber; $numOfTabs++) {

			// Display the title of the tab
			if (isset(${'title' . $numOfTabs})) {
					$title = apply_filters('widget-title', ${'title' . $numOfTabs});
?>
				<li <?php echo ( $numOfTabs == 0 ) ? 'class="rpgTabTitle rpg_tab_active"' : 'class="rpgTabTitle rpg_tab_' . $numOfTabs . '"'; ?> ><a href="#"><?php echo $title; ?></a></li>
<?php
			} // End of if (isset(${'title' . $numOfTabs})) {
		} // End of for ($numOfTabs
?>
   </ul>
</div> <!-- end of id="menu_tabs" -->

<!-- Display the list of links for the selected tab and hide the others -->
<div id="rpg_main_tabs">
<?php

			// loop through the links for each tab
			for ($numOfTabs = 0; $numOfTabs < $tabnumber; $numOfTabs++) {
				if (isset(${'title' . $numOfTabs})) {
					if (isset(${'linknum' . $numOfTabs})) {		
						for ($rpg_link_num = 0; $rpg_link_num < ${'linknum' . $numOfTabs}; $rpg_link_num++) {

							// Assign the saved link name and link URL values
							$link_name = apply_filters('widget-title', ${'linkname' . $numOfTabs . '_' . $rpg_link_num});
							$link_url = apply_filters('widget-title', ${'linkurl' . $numOfTabs . '_' . $rpg_link_num});

							if (!empty($link_name) && !empty($link_url)) {
	?>
								<!-- Display the link name in an anchor pointing to the saved link URL -->
								<?php if ($link_url != "#" && $rpg_link_num == 0) { echo '<p style="margin-top: 10px;">'; } else if ($link_url != "#") { echo "<p>"; } else { echo "<h3>"; } ?><a href="<?php echo $link_url; ?>" <?php echo ( $numOfTabs == 0 ) ? 'class="rpg_link_active" style="display: block;"' : 'class="rpg_link_' . $numOfTabs . '" style="display: none;"'; ?>><?php echo $link_name; ?></a><?php echo ($link_url != "#") ? "</p>" : "</h3>"; ?>
	<?php
							} // End of if (!empty($link_name) && !empty($link_url)) {
						} // End of for ($rpg_link_num
					} // End of if (isset(${'linknum' . $rpg_num})) {
				} // End of if (isset(${'title' . $numOfTabs})) {
			} // End of for ($numOfTabs
?>
</div>
<?php
		// Display markup after the widget form			
		echo $after_widget;
	}

}
add_action('widgets_init', 'rpg_register_sidebar_link_index');

// Register the Widget class declared above
function rpg_register_sidebar_link_index() {
	register_widget('RPG_Sidebar_Tabs_Link_Index');
}