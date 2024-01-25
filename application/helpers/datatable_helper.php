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
 
if (! function_exists('default_datatable'))
{
	function default_datatable($thead=array(),$checkbox=TRUE, $datasource='', $datalabel='')
	{
		if($thead){
			$tbl = '<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-source="'.$datasource.'" data-label="'.$datalabel.'" >
            <thead>
                <tr>
                ';
                if($checkbox){
                    $tbl .= '<th><input type="checkbox" id="check-all"></th>';
                }
                    foreach ($thead as $t){
                        $tbl.='<th>'.$t.'</th>';
                    }
                    
                $tbl .='   
                </tr>
            </thead>
            <tbody>
            </tbody>  
         </table>';
		}
		return $btn;
	}
}