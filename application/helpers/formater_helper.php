 <?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * Function Name
 *
 * Function description
 *
 * @access	public
 * @param	type	name
 * @return	type	
 */
 
if (! function_exists('arrayformat'))
{
	function arrayformat($ar1,$ar2)
	{
		//ar1 ->key , ar2 -> val
		//ret = (value => key, text=> val)
		$ret = array();
		if(is_array($ar1) AND is_array($ar2)){
			if(count($ar1) == count($ar2)) {
				$i=0;
				foreach($ar1 as $key){

					$new_arr = array('value'=>$key, 'text'=>$ar2[$i]);
					$ret[] = $new_arr;
					$i++;
				}
			}
		}
		else{
			$x = explode(",", $ar1);
			$y = explode(",", $ar2);
			if(count($x) == count($y)) {
				$i=0;
				foreach($x as $key){

					$new_arr = array('value'=>$key, 'text'=>$y[$i]);
					$ret[] = $new_arr;
					$i++;
				}
			}

		}
	return $ret;
	}
}
	if (! function_exists('reselectkota')) {
		function reselectkota($desa){
			$CI =& get_instance();
			if ($desa) {
				$q = 	$CI->db->query("SELECT desa.id as iddesa, desa.nama as namadesa, kecamatan.id as idkec, kecamatan.nama as namakec, kabupaten.id as idkab, kabupaten.nama as namakota, propinsi.id as propid, propinsi.nama as namaprop FROM `desa` LEFT JOIN kecamatan ON desa.kecamatan_id = kecamatan.id LEFT JOIN kabupaten ON kecamatan.kabupaten_id = kabupaten.id LEFT JOIN propinsi ON kabupaten.propinsi_id = propinsi.id WHERE desa.id = $desa ")->row();
			
				if($q){
					$ret = "$('#kabupaten').append(new Option(".$q->namakota.",".$q->idkab."));";
					$ret .= "$('#kecamatan').append(new Option(".$q->namakec.",".$q->idkec."));";
					$ret .= "$('#desa').append(new Option(".$q->namadesa.",".$q->iddesa."));";
				}
				echo $ret;
			}

		}
	}
if (! function_exists('JsonValidator')) {
		function JsonValidator($data=null){
			if (!empty($data)) {

                @json_decode($data);

                return (json_last_error() === JSON_ERROR_NONE);

       		 }
        return false;
		
		}
	}



