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
 
if (! function_exists('usia_tahun'))
{
	function usia_tahun($birth)
	{

		$l= date('Y-m-d', strtotime($birth));
		
		$bday = new DateTime($l);
		$today = new DateTime('today');
		$diff = $today->diff($bday);
		return $diff->y.' Tahun';

	}
}

if (! function_exists('usia_bulan'))
{
	function usia_bulan($birth)
	{

		$l= date('Y-m-d', strtotime($birth));
		
		$bday = new DateTime($l);
		$today = new DateTime('today');
		$diff = $today->diff($bday);
		return $diff->m.' Bulan';

	}
}