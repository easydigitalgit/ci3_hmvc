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
 
if (! function_exists('nikParser'))
{
	function nikParser($nik)
	{

		  $data = array();
		  if (strlen($nik) == 16){
			  	
	            $data['status'] 		= true;
	            $data['propinsi'] 		= substr($nik, 0,  2);
	            $data['kota'] 			= substr($nik, 2,  2);
	            $data['kota_1']			= substr($nik, 0,  2).'.'.substr($nik, 2,  2);
	            $data['kecamatan'] 		= substr($nik, 4,  2);
	            $data['kecamatan_1']	= substr($nik, 0,  2).'.'.substr($nik, 2,  2).'.'.substr($nik, 4,  2);
	            $data['tanggal_lahir'] 	= substr($nik, 6,  2);
	            $data['bulan_lahir'] 	= substr($nik, 8,  2);
	            $data['tahun_lahir'] 	= substr($nik, 10, 2);
	            $data['unik'] 			= substr($nik, 12, 4);

	            if(intval($data['tahun_lahir']) > 30 ){
	            	$data['tahun_lahir_1'] = '19'.$data['tahun_lahir'];
	            }
	            else{
	            	$data['tahun_lahir_1'] = '20'.$data['tahun_lahir'];
	            }



	            if (intval($data['tanggal_lahir']) > 40) {
	                $data['tanggal_lahir_2'] = intval($data['tanggal_lahir']) - 40;
	                $data['gender_1'] = 'W';
	                $data['gender_2'] = '2';
	                $gender = 'Wanita';
	            } else {
	                $data['tanggal_lahir_2'] = intval($data['tanggal_lahir']);
	                $gender = 'Pria';
	                $data['gender_1'] = 'P';
	                $data['gender_2'] = '1';
	            }

	             $data['tanggal_lahir_3'] = date('Y-m-d', strtotime( $data['tahun_lahir_1'].'-'.$data['bulan_lahir'].'-'.$data['tanggal_lahir_2'] ));
		  }
		  else{
		  	$data['status'] = false;
		  	$data['msg']	='NIK harus 16 digit';

		  }
		   	
		  return $data;
	}
		
}