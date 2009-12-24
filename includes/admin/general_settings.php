<?php
/**
 * Include to show the administrator's setting
 *
 * @package admin
 * 
 */

if (isset($_POST['max_size'])) {	
	$data['max_size'] = $_POST['max_size'];
	
	if (GpcAttachImagePost_Settings::update_options($data))
		$msg_notify[] = __('The Settings was updated.');
}

// Get the data of the Plugin Options
$data = GpcAttachImagePost_Settings::get_options();

include( GpcAttachImagePost::$plugin_dir . '/templates/includes/admin/general_settings.php'); 
?>