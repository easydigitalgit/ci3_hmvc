<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * Function Name
 *
 * Function description
 *
 * @access	public
 * @param	int/string	$id
 * @return	string 	$act
 */
 
if (! function_exists('currentClass'))
{
	function currentClass()
	{
		 //$this->router->fetch_module();
		$CI =& get_instance();

		return $CI->router->fetch_module().'/'.$CI->router->fetch_class();
		//return $CI->uri->segment(1) === $CI->router->fetch_class() ? $CI->router->fetch_class() : $CI->uri->segment(1).'/'.$CI->router->fetch_class();
		
	}
}

if (! function_exists('currentMethod'))
{
	function currentMethod()
	{
		$CI =& get_instance();
		return  $CI->router->fetch_method();
		
	}
}