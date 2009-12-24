<?php
if (!class_exists('GpcAttachImagePost_WpPostmeta')) {
	class GpcAttachImagePost_WpPostmeta
	{
		
	   /**
	    * The string for separate image url and username values
	    *
	    * @var string
	    */
        static $values_separator = '#-#-#';
		
	   /**
	    * The name of the hidden postmeta for images
	    *
	    * @var string
	    */
        static $key_images = '_gpc_attach_images';
		
		/**
		 * Get images of post to DB
		 * 
		 * @static
		 * @param 	int		$post_id
		 * @return 	array 
		 * @access 	public
		 */
		static public function get_images($post_id) {
			// Use WordPress function
			$all = get_post_meta($post_id, self::$key_images);
			if ($all==NULL)
				return array();
			else
				return $all;
		}
		
		/**
		 * Add image of post to DB
		 * 
		 * @static
		 * @param 	int		$post_id
		 * @param 	string	$value
		 * @return 	void
		 * @access 	public
		 */
		static public function add_image($post_id,$value) {
			// Use WordPress function
			add_post_meta($post_id, self::$key_images, $value);
		}
	}
}
?>