<?php
/**
 * User Page to add image to post
 *
 * @package GpcAttachImagePost
 */

/** Loads the WordPress Environment and Template */
require(dirname(__FILE__) . '/../../../../../wp-blog-header.php');
global $wpdb;

// Security: logged in users are required
GpcAttachImagePost_Users::user_must_be_authenticated();

/*
 * Actions
 */
// Action 1- Show form to Add image to a post
// Action 2- Add image

$max_images_alowed_per_user = 5;
$show_form = FALSE;

// Get post name from URL
$current_url = GpcAttachImagePost_Miscellaneous::get_current_url();
$until_post_url = str_replace('/upload-image/','',$current_url);
$last_position_slash = strrpos($until_post_url,'/');
$post_name = substr($until_post_url,$last_position_slash+1);

if ($post_name!='') {
	$post_name = GpcAttachImagePost_Validator::parse_string($post_name);

	// Get post ID by name
	$post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$post_name'");
	
	if ($post_id!=NULL) {
		$current_logued_user = GpcAttachImagePost_Users::get_user_login();
					
		//Check if in this post the user has equal or less than 5 images
		$images = GpcAttachImagePost_WpPostmeta::get_images($post_id);
		$current_user_images_count = 0;
		$current_user_can_upload = TRUE;
		if (count($images)>=$max_images_alowed_per_user) {
			// Check images for current user
			foreach ($images as $image_item) {
				$image_item_arr = split(GpcAttachImagePost_WpPostmeta::$values_separator,$image_item);
				$tmp_user = $image_item_arr[1];
				if ($tmp_user==$current_logued_user)
					$current_user_images_count++;
			}
			if ($current_user_images_count>=$max_images_alowed_per_user) {
				$current_user_can_upload = FALSE;
				$msg_error[] = sprintf(__("You can't upload more images. You can upload up to %d."), $max_images_alowed_per_user);
			}
		}
		
		// Only add if the user can add a new image
		if ($current_user_can_upload) {
			$show_form = TRUE;
			if (isset($_POST['submit'])) {
				// Process post
				
				if (!isset($_FILES['image'])
					|| ($_FILES['image']['tmp_name']=='')) {
					$msg_error[] = __('The image is required.');
				}
				else {
					// Check for extension
					
					$image_extension = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
					
					if (strtolower($image_extension)=='jpg' || strtolower($image_extension)=='png') {
	
						// Check for size
						$size=filesize($_FILES['image']['tmp_name']);
						if ($size <= (GpcAttachImagePost_Settings::get_max_size() * 1024 * 1024)) { // *1024 because filesize returns values in bytes and in setting is stored in mb
							// handle uploaded image and save it
							$file=GpcAttachImagePost_Images::handle_image_upload($_FILES['image']);
							
							// save thumbnail of image 
							// Use WordPress function to resize and image (no crop it) and save as thumbnail with a sufix
							$max_w = get_option('thumbnail_size_w');
							$max_h = get_option('thumbnail_size_h');
	                        $thumb_path = image_resize($file['file'], $max_w, $max_h, false, GpcAttachImagePost::$thumb_suffix);
	                        
	                        if (!$thumb_path) {
								$thumb_url = $file['url'];
							}
							else {
								$image_dirname = pathinfo($file['url'],PATHINFO_DIRNAME);
								$image_filename = pathinfo($file['url'],PATHINFO_FILENAME);
								$image_extension = pathinfo($file['url'],PATHINFO_EXTENSION);
								
								$thumb_url = $image_dirname . '/' . $image_filename . '-' . GpcAttachImagePost::$thumb_suffix . '.' . $image_extension;
							}
	                        
							if ($file) {
								
								$value = $file['url'] . GpcAttachImagePost_WpPostmeta::$values_separator . $current_logued_user . GpcAttachImagePost_WpPostmeta::$values_separator . $thumb_url;
								// add in database
								GpcAttachImagePost_WpPostmeta::add_image($post_id,$value);
								$msg_notify[] = __('The Image was uploaded.');
							}
						}
						else {
							$msg_error[] = sprintf(__("Max upload limit is %d mb."), GpcAttachImagePost_Settings::get_max_size());
						}					
					}
					else {
						$msg_error[] = __("Only .jpg and .png are allowed.");
					}
				}
			}
		}
	}
	else {
		$msg_error[] = __("The post or page selected doesn't exist.");
	}
}
else {
	$msg_error[] = __("You must select a post or page to add images.");
}
include(GpcAttachImagePost::$plugin_dir . '/templates/pages/public/add_image.php');
?>