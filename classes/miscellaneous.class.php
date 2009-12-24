<?php
if (!class_exists('GpcAttachImagePost_Miscellaneous')) {
	class GpcAttachImagePost_Miscellaneous
	{
		/**
         * Return the current page URL with query string
         *
         * @static
         * @param 	string	$param_except	is defined, exclude this parameter form the query string
         * @return 	string
         */
		static function get_current_url($param_except='')
		{
			$to_return = 'http';
			
			if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
				$to_return .= "s";
			
			$to_return .= '://' . $_SERVER["SERVER_NAME"];
			
			if ($_SERVER["SERVER_PORT"] != "80")
				$to_return .=  ':' . $_SERVER["SERVER_PORT"];
			
			if (substr_count($_SERVER["REQUEST_URI"],'?')>0)
				$to_return .= substr($_SERVER["REQUEST_URI"], 0, strpos($_SERVER["REQUEST_URI"], '?'));
			else 
				$to_return .= $_SERVER["REQUEST_URI"];
			
			if ($param_except!='') {
				$query_parameters = array();
				$query_arr = split('&',$_SERVER['QUERY_STRING']);
				foreach ($query_arr as $query_item) {
					$query_item_arr = split('=',$query_item);
					$query_item_name = $query_item_arr[0];
					
					if ($param_except!=$query_item_name)
						$query_parameters[] = join('=',$query_item_arr);
				}
				$query_parameters_str = join('&',$query_parameters);
			}
			else 
				$query_parameters_str = $_SERVER['QUERY_STRING'];
			
			if ($query_parameters_str!='')
				$to_return .= '?' . $query_parameters_str;
			
			return $to_return;
		}
		
		/**
		 * Encode string
		 * 
		 * @param  string	$string
		 * @return string	$key
		 * @access public
		 */
		public function encode($string,$key) {
		    $key = sha1($key);
		    $strLen = strlen($string);
		    $keyLen = strlen($key);
		    $j = 0;
		    for ($i = 0; $i < $strLen; $i++) {
		        $ordStr = ord(substr($string,$i,1));
		        if ($j == $keyLen) { $j = 0; }
		        $ordKey = ord(substr($key,$j,1));
		        $j++;
		        $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
		    }
		    return $hash;
		}
	
		/**
		 * Decode string
		 * 
		 * @param  string	$string
		 * @return string	$key
		 * @access public
		 */
		public function decode($string,$key) {
		    $key = sha1($key);
		    $strLen = strlen($string);
		    $keyLen = strlen($key);
		    $j = 0;
		    for ($i = 0; $i < $strLen; $i+=2) {
		        $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
		        if ($j == $keyLen) { $j = 0; }
		        $ordKey = ord(substr($key,$j,1));
		        $j++;
		        $hash .= chr($ordStr - $ordKey);
		    }
		    return $hash;
		}
	}
}
?>