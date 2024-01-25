<?php defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('read_image'))
{
	/**
	 * Read image
	 *
	 * Opens the file specified in the path and returns it as a string.
	 *
	 * @todo	Remove in version 3.1+.
	 * @deprecated	3.0.0	It is now just an alias for PHP's native file_get_contents().
	 * @param	string	$file	Path to file
	 * @return	string	image File contents
	 */
	function read_image($file)
	{
		if (file_exists($file))
		{
		    $size = getimagesize($file);
		    $fp = fopen($file, 'rb');
		    if ($size and $fp)
		    {
		        // Optional never cache
		    //  header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
		    //  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		    //  header('Pragma: no-cache');

		        // Optional cache if not changed
		    //  header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($file)).' GMT');

		        // Optional send not modified
		    //  if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) and 
		    //      filemtime($file) == strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']))
		    //  {
		    //      header('HTTP/1.1 304 Not Modified');
		    //  }

		        header('Content-Type: '.$size['mime']);
		        header('Content-Length: '.filesize($file));
		        fpassthru($fp);

		        exit;
		    }
		}
	}
}

if ( ! function_exists('image_exist'))
{
	/**
	 * Read image
	 *
	 * Opens the file specified in the path and returns it as a string.
	 *
	 * @todo	Remove in version 3.1+.
	 * @deprecated	3.0.0	It is now just an alias for PHP's native file_get_contents().
	 * @param	string	$file	Path to file
	 * @return	string	image File contents
	 */
	function image_exist($file)
	{
		if (is_file($file))
		{
		    $size = getimagesize($file);
		    $fp = fopen($file, 'rb');
		    if ($size and $fp)
		    {
		        // Optional never cache
		    //  header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
		    //  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		    //  header('Pragma: no-cache');

		        // Optional cache if not changed
		    //  header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($file)).' GMT');

		        // Optional send not modified
		    //  if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) and 
		    //      filemtime($file) == strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']))
		    //  {
		    //      header('HTTP/1.1 304 Not Modified');
		    //  }

		       return true;
		    }
		}
		else{
			return false;
		}
	}
}

