<?php
if (!class_exists('GpcAttachImagePost_Images')) {
	class GpcAttachImagePost_Images
	{
		
		/**
		 * Handle the uploading of an image
		 * 
		 * @param array $upload with all data of the field in $_FILES
		 * @return mixed returns an array with the uploaded file, or FALSE if an error occurs
		 * @access public
		 */
        function handle_image_upload($upload) {
		    // check if image
			// Check permissions in WP upload dir
			$uploads_dir = wp_upload_dir();
			
			if (is_writable($uploads_dir['path']))  
			{
				// Include two WordPress files that have the functions to upload images, there are only available in admin interface
				if (!function_exists('file_is_displayable_image'))
					include ( GpcAttachImagePost::$plugin_dir . '/../../../wp-admin/includes/image.php');
				if (!function_exists('wp_handle_upload'))
					include ( GpcAttachImagePost::$plugin_dir . '/../../../wp-admin/includes/file.php');
			    if (file_is_displayable_image( $upload['tmp_name'] ))
			    {
			        // handle the uploaded file
			        $overrides = array('test_form' => false);
			        $file=wp_handle_upload($upload, $overrides);
			        
			        return $file;
			    }
			    else {
			    	global $msg_error;
			    	$msg_error[] = __("The selected file isn't a valid image.");
			    	return FALSE;
			    }
			}
			else 
			{
				global $msg_error;
			    $msg_error[] = __("The Upload directory isn't writable.");
			    return FALSE;
			}    
		}
	}
}
?>