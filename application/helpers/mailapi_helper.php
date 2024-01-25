<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * Function Name
 *
 * Function description
 *
 * @access      public
 * @param       type    name
 * @return      type    
 */
 
if (! function_exists('mailApi'))
{

function mailApi($subject,$body,$toAddress){
        $api_token='b3a1d9549bb826054e3f871ae6ee0523'; //silahkan copy dari api token mailketing
        $from_name='MONEV DPD PKS KOTA MEDAN'; //nama pengirim
        $from_email='monev@easydigital.id'; //email pengirim
        //$subject='test email'; //judul email
        //$content='Ini Hanya Test Email'; //isi email format text / html
        //$recipient='jeffnst6075@gmail.com'; //penerima email
        $params = [
        'from_name' => $from_name,
        'from_email' => $from_email,
        'recipient' => $toAddress,
        'subject' => $subject,
        'content' => $body,
        'api_token' => $api_token
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://app.mailketing.co.id/api/v1/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec ($ch); //print_r($output);
        curl_close ($ch);
        return $output;
    }
}