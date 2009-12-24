<?php
if (!class_exists('GpcAttachImagePost_Users'))
{
	class GpcAttachImagePost_Users
	{

		/**
		 * Check if user is authenticated, if not, redirect to User Login page 
		 *
		 * @static 
		 * @return void
		 * @access public
		 * 
		 */
		static function user_must_be_authenticated() 
		{
			/*
			 * Use WP function to:
			 * Checks whether the cookie is present on the client browser. If it is not, the user is 
			 * sent to the wp-login.php login screen. After logging in, the user is sent back to the 
			 * page he or she attempted to access. 
			 */
			auth_redirect();
		}
		
		/**
		 * Checks if the current visitor is a logged in user.
		 *
		 * @static 
		 * @return bool True if user is logged in, false if not logged in.
		 * @access public
		 * 
		 */
		static function is_user_authenticate() 
		{
			if (is_user_logged_in())
				return TRUE;
			else
				return FALSE;
		}
		
		/**
		 * Return current user ID
		 *
		 * @static 
		 * @return int
		 * @access public
		 * 
		 */
		static function get_current_user_id() 
		{
			// Call to WP function to get the current information 
			$user_data = wp_get_current_user();
			return $user_data->ID;
		}
		
		/**
		 * Get user login
		 *
		 * @static 
		 * @param int $user_id when isn't received the informations is about the authenticated user
		 * @return string
		 * @access public
		 */
		static function get_user_login($user_id = '') 
		{
			if ($user_id=='')
				$user_id = self::get_current_user_id();
			
			// Call to WP function to get user data
			$user_data = get_userdata($user_id);
			if ($user_data!=NULL)
				return $user_data->user_login;
			else
				return '';
		}	
		
		/**
		 * Get user id
		 *
		 * @static 
		 * @param string $login
		 * @return string
		 * @access public
		 */
		static function get_user_id($login) 
		{
			// Call to WP function to get user data
			$user_data = get_userdatabylogin($login);
			if ($user_data!=NULL)
				return $user_data->ID;
			else
				return '';
		}	
	}
}
?>