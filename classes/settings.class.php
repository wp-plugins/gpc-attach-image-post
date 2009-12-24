<?php
if (!class_exists('GpcAttachImagePost_Settings'))
{
	class GpcAttachImagePost_Settings 
	{
	   /**
	    * The name for plugin options in the DB
	    *
	    * @var string
	    */
        static $db_option = 'GpcAttachImagePost_Options';
        
		/**
		 * Get value of max_size
		 * 
		 * @static
		 * @return string
		 * @access public
		 */
		static public function get_max_size() {
		   	$options = self::get_options();
		   	return $options['max_size'];
		}
		/**
		 * Updates the General Settings of Plugin
		 * 
		 * @return void
		 * @access public
		 */
        static function update_options($options) {
	    	update_option(self::$db_option, $options);	
	    }
        
	    
    	/**
		 * Return the General Settings of Plugin, and set them to default values if they are empty
		 * 
		 * @return array general options of plugin
		 * @access public
		 */
        static function get_options() {
        	// default values
		    $options = array 
		    (
		        'max_size' => '1024'
		    );
		    
	        // get saved options
			$saved = get_option(self::$db_option);
		    
			// assign them
		    if (!empty($saved))  
		    {
		        foreach ($saved as $key => $option)
		        {
		        	$options[$key] = GpcAttachImagePost_Validator::parse_output($option);
		        }
		    }
		    
		    // update the options if necessary
	        if ($saved != $options)
	          update_option(self::$db_option, $options);
	        //return the options
	        return $options;
        }
        
	}
}
?>