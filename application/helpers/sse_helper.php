<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Function Name
 *
 * Function description
 *
 * @access	public
 * @param	type	name
 * @return	type	
 */
 
if (! function_exists('sse_event'))
{
	function sse_event($data,$type,$event)
	{ 
        header("Content-Type: text/event-stream");
		header("Cache-Control: no-cache");
		header("Access-Control-Allow-Origin: *");
		
		if ($type == 'msg') {
			//$this->load->view('view_sse',$data);
			//echo "data: {$data} \n\n";
			//echo "data: All process completed2 \n";
			echo "event: message\n";
			echo "data:{$data} \n\n";
			echo "\n\n";
			echo "\n";
			echo "\n";
			ob_flush();
			flush();
		}
		else if ($type == 'eventx') {
			echo "\n";
			echo "data: All process completed \n\n";
			echo "\n";
			echo "data: connection closed \n\n";
			echo "\n";
			echo "event: ending\n";
			echo "data: 1\n";
			echo "\n";
			echo "\n";
			ob_flush();
			flush();
		}
		elseif ($type == "xerror") {
			echo "\n";
			echo "data: Terjadi kesalahan pada proses \n\n";
			echo "\n";
			echo "data: connection closed \n\n";
			echo "\n";
			echo "event: ending\n";
			echo "data: 1\n";
			echo "\n";
			echo "\n";
			ob_flush();
			flush();
		}
    }
}

/* End of file sse_helper.php */
