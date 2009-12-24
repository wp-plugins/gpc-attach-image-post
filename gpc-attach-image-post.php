<?php
/*
Plugin Name: Attach Images to posts or pages 
Description: Install the scripts to to allow registered users attach an image to a post.
Version: 0.1
Author: leticia_larr,poolie
*/

/**
 * Version of WordPress
 * @global	string	$wp_version
 */

global $wp_version;

$exit_msg = __('This plugin require WordPress 2.8.5 or newer').'. <a href="http://codex.wordpress.org/Upgrading_WordPress">'.__('Please update').'</a>';
if (version_compare($wp_version, "2.8.5", "<")) {
	exit($exit_msg);
}

// Avoid name collisions.
if (!class_exists('GpcAttachImagePost'))
{
	class GpcAttachImagePost
    {
       /**
	    * The url to the plugin
	    *
	    * @static 
	    * @var string
	    */
        static $plugin_url;
         
       /**
	    * The path to the plugin
	    *
	    * @static 
	    * @var string
	    */
        static $plugin_dir;
         
       /**
	    * The descriptive name for plugin
	    *
	    * @var string
	    */
        static $plugin_desc_name;
        
       /**
	    * The prefix for tables in the DB
	    *
	    * @var string
	    */
        static $db_prefix = 'gpc_att_img_';
        
       /**
	    * The suffix for images thumbnails
	    *
	    * @var string
	    */
        static $thumb_suffix = 'gpc_thumb';
        
       /**
         * Executes all initialization code for the plugin.
         * 
         * @return void
         * @access public
		 */
        function GpcAttachImagePost() {
        	// Define static values
        	self::$plugin_url = trailingslashit( WP_PLUGIN_URL.'/'. dirname( plugin_basename(__FILE__) ));
        	self::$plugin_dir = pathinfo(__FILE__,PATHINFO_DIRNAME);
        	self::$plugin_desc_name = __('Attach Images to posts or pages');
        	
        	// Add options Page
           	add_action('admin_menu', array(&$this, 'admin_menu'));
			
           	// Creating rewrite rules and query variables
			add_filter('query_vars', array(&$this, 'handle_query_vars'));
			add_filter('rewrite_rules_array', array(&$this, 'handle_rewrite_rules_array'));
			// Flush the rewrite rules
			add_action('init', array(&$this, 'handle_flush_rewrite'));
			// Add filter to show template to upload images or list images when required 
			add_filter('home_template', array(&$this, 'handle_home_template'));
			
			// Include all classes
        	include( self::$plugin_dir . '/includes/all_classes.php');
        }
        
    	/** 
		 * Hooks the add the main menu
		 * 
		 * @return void
		 * @access public
		 */
        function admin_menu() {
        	add_menu_page(__('Attach Image'), __('Attach Image'), 8, basename(__FILE__), array(&$this, 'handle_admin'));
			
            add_submenu_page(basename(__FILE__), __('General Settings'), __('General Settings'), 8, basename(__FILE__), array(&$this, 'handle_admin'));
        }
        
        /**
		 * Handles the main menu options page for General Settings
		 * 
		 * @return void
		 * @access public
		 */
        function handle_admin() {
           	include('includes/admin/general_settings.php');
        }
        
        /**
         * Handler for HTML tag to show the first thumbnail of post if has any
         * 
         * This function print the HTML code to show the thumbnail
         * 
         * @static
         * @global 	object	$post	wordpress object that represent the post
         * @param 	int		$post_id
         * @param 	boolean	$output
         * @return 	void
         * @access 	public
         */
        static function new_image_tag_for_post($post_id='',$output=TRUE) {
        	
        	if ($post_id=='') {
	        	global $post;
	        	
	        	// Get post ID
	        	$post_id = $post->ID;
        	}
        	
        	// Get all images of this post
		    $images = GpcAttachImagePost_WpPostmeta::get_images($post_id);
			
		    // Get the first thumbnail
		    $html = '';
		    if (count($images)>0) {
		    	$image_item_arr = split(GpcAttachImagePost_WpPostmeta::$values_separator,$images[0]);
				$image_thumb_url = $image_item_arr[2];
				
				$html = '<img alt="' . __('Post Thumbnail') . '" src="'. $image_thumb_url .'" />';
		    }
        	
		    if ($output) 
		    	echo $html;
		    else 
		    	return $html;			
        }
        
		/**
         * Function to Rewrite Rules Array
         * 
         * This function is used to add two pages urls associated to post: to show upload form and list of images
         * 
         * @return void
         * @access public
         */
        function handle_rewrite_rules_array($rules) { 

			// <anything> / <post or page name> / upload-image
			$newrules['.*/upload-image$'] = 'index.php?showupload-image=1';
			$newrules['.*/images$'] = 'images.php?showimages=1';
			
			$newrules = array_merge($newrules,$rules);
			return $newrules;
		}

		/**
         * Function to add vars for Rewrite Rules Array
         * 
         * @return void
         * @access public
         */
		function handle_query_vars ( $vars ) {
			$vars[] = "showupload-image";
			$vars[] = "showimages";
			return $vars;
		}

		/**
         * Function to change the home template to upload images or list images when required
         * 
         * @param 	string	$template_dir	current home template
         * @return 	void
         * @access 	public
         */
		function handle_home_template($template_dir) {
			if (get_query_var("showupload-image")) {
				return GpcAttachImagePost::$plugin_dir . '/pages/public/add_image.php';
			}
			elseif (get_query_var("showimages")) {
				return GpcAttachImagePost::$plugin_dir . '/pages/public/list_images.php';
			}
			else
				return $template_dir;
		}
		
		/**
         * Function to flush the rewrite rules
         * 
         * @param 	string	$template_dir	current home template
         * @return 	void
         * @access 	public
         */
	    function handle_flush_rewrite() {
			global $wp_rewrite;
			$wp_rewrite->flush_rules();
		}
	}
}

// create new instance of the class
$GpcAttachImagePost = new GpcAttachImagePost();

?>