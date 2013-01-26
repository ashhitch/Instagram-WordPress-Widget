<?php
/*
Plugin Name: Instagram Widget
Plugin URI: http://www.ashleyhitchcock.co.uk
Description: Display Instagram Feed in your blog.
Version: 0.1
Author: Ashley Hitchcock
Author URI: http://www.ashleyhitchcock.co.uk
Author Email: hello@ashleyhitchcock.co.uk
Text Domain: instagram-widget-locale
Domain Path: /lang/
Network: false
License: MIT
License URI: http://opensource.org/licenses/MIT

Copyright 2013 Ashley Hitchcock (hello@ashleyhitchcock.co.uk)

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  

*/


class Instagram_Widget extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/
	
	/**
	 * Specifies the classname and description, instantiates the widget, 
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {
	
		// load plugin text domain
		add_action( 'init', array( $this, 'widget_textdomain' ) );
		
		// Hooks fired when the Widget is activated and deactivated
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		

		parent::__construct(
			'instagram-widget',
			__( 'Instagram Widget', 'instagram-widget-locale' ),
			array(
				'classname'		=>	'instagram-widget-class',
				'description'	=>	__( 'Display Instagram Feed in your blog.', 'instagram-widget-locale' )
			)
		);
		
	
		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );
		
	} // end constructor

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/
	
	/**
	 * Outputs the content of the widget.
	 *
	 * @param	array	args		The array of form elements
	 * @param	array	instance	The current instance of the widget
	 */
	public function widget( $args, $instance ) {
	
		extract( $args, EXTR_SKIP );
		
		
		echo $before_widget;
    
    
		include( plugin_dir_path( __FILE__ ) . '/views/widget.php' );
		
		echo $after_widget;
		
	} // end widget
	
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param	array	new_instance	The previous instance of values before the update.
	 * @param	array	old_instance	The new instance of values to be generated via the update.
	 */
	public function update( $new_instance, $old_instance ) {
	
		$instance = $old_instance;
		
		$instance['userID'] = $new_instance['userID'];
		$instance['clientID'] = $new_instance['clientID'];
		$instance['accessToken'] = $new_instance['accessToken'];
		$instance['limit'] = $new_instance['limit'];
    
		return $instance;
		
	} // end widget
	
	/**
	 * Generates the administration form for the widget.
	 *
	 * @param	array	instance	The array of keys and values for the widget.
	 */
	public function form( $instance ) {
	
   
		
		$instance = wp_parse_args( (array) $instance, array( 'userID' => '','clientID' => '','accessToken' => '','limit' => 10) );
		$userID = $instance['userID'];
		$clientID =$instance['clientID'];
		$accessToken =$instance['accessToken'];
		$limit =$instance['limit'];

		
		// Display the admin form
		include( plugin_dir_path(__FILE__) . '/views/admin.php' );	
		
	} // end form

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/
	
	/**
	 * Loads the Widget's text domain for localization and translation.
	 */
	public function widget_textdomain() {

		load_plugin_textdomain( 'instagram-widget-locale', false, plugin_dir_path( __FILE__ ) . '/lang/' );
		
	} // end widget_textdomain
	
	/**
	 * Fired when the plugin is activated.
	 *
	 * @param		boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public function activate( $network_wide ) {
		
		
	} // end activate
	
	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function deactivate( $network_wide ) {
	
	} // end deactivate
	

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {
	
		wp_enqueue_style( 'instagram-widget-widget-styles', plugins_url( 'instagram-widget/css/widget.css' ) );
		
	} // end register_widget_styles
	
	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {
	
		wp_enqueue_script( 'instagram-widget-script', plugins_url( 'instagram-widget/js/widget.js' ) );
		
	} // end register_widget_scripts
	
} // end class

add_action( 'widgets_init', create_function( '', 'register_widget("Instagram_Widget");' ) ); 