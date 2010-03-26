<?php
/**
 * User Page to list of images of a post
 *
 * @package GpcAttachImagePost
 */

/** Loads the WordPress Environment and Template */
require(dirname(__FILE__) . '/../../../../../wp-blog-header.php');

// Security: logged in users are required
GpcAttachImagePost_Users::user_must_be_authenticated();

/*
 * Actions
 */
// Action 1- Show all images of post of any user

// Get post name from URL
$current_url = GpcAttachImagePost_Miscellaneous::get_current_url();
$until_post_url = str_replace('/images/','',$current_url);
$last_position_slash = strrpos($until_post_url,'/');
$post_name = substr($until_post_url,$last_position_slash+1);
$images_urls = array();

if ($post_name) {
	$post_name = GpcAttachImagePost_Validator::parse_string($post_name);
	
	// Get post
	$post = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE post_name = '$post_name'");
	
	// Get ID
	$post_id = $post->ID;
	
	// Get post URL
	$post_url = get_permalink($post_id);
	
	// Get post name
	$post_name = $post->post_title;
	
	if ($post_id!=NULL) {
		$current_logued_user = GpcAttachImagePost_Users::get_user_login();
		
		$images = GpcAttachImagePost_WpPostmeta::get_images($post_id);
		foreach ($images as $image_item) {
			$image_item_arr = split(GpcAttachImagePost_WpPostmeta::$values_separator,$image_item);
			
			// Get user data
			$user_data = get_userdatabylogin($image_item_arr[1]);
			
			$images_urls[] = array('full'=>$image_item_arr[0],
									'thumb'=>$image_item_arr[2],
									'user_login'=>$image_item_arr[1],
									// uncomment to use frontend profile //'profile_link'=>$user_data->user_url
									'profile_link'=>GpcAttachImagePost::$plugin_url . '/../../../../wp-admin/profile.php?user_id=' . GpcAttachImagePost_Users::get_user_id($image_item_arr[1])
								);
		}
	}
	else {
		$msg_error[] = __("The post or page selected doesn't exist.");
	}
}
else {
	$msg_error[] = __("You must select a post or page to add images.");
}

include(GpcAttachImagePost::$plugin_dir . '/templates/pages/public/list_images.php');
?>