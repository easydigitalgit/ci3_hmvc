 <?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * Function Name
 *
 * Function description
 *
 * @access	public
 * @param	type	name
 * @return	type	
 * 
 * 
 * multidevice : f6fe36fb61a12e786203324c25ab55b6e02ae8ad
 */
 
if (! function_exists('sendtext'))
{
	function sendtext($number,$text,$apikey=null)
	{
       //Relawan jupe , device: 
       //$API_KEY = 'ef0564ba164774658a91cbc1d35099a6a1cbc1c6';
        $API_KEY = $apikey;
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://starsender.online/api/sendText?message='.rawurlencode($text).'&tujuan='.rawurlencode($number.'@s.whatsapp.net'),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'apikey: '.$API_KEY
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
       return $response;
    }
}

if (! function_exists('sendTextTerjadwal'))
{
  function sendTextTerjadwal($tujuan, $pesan, $jadwal, $apikey=null)
  {
      /*  $apikey="XrkpzOulTjAZt8J3dlUL:5";
        $tujuan="6281296648532" //atau $tujuan="Group Chat Name";
        $pesan="Hiii ini pesan test.";
        $jadwal="2021-01-01 10:00:00";*/

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://starsender.online/api/v2/sendText?message='.rawurlencode($pesan).'&tujuan='.rawurlencode($tujuan.'@s.whatsapp.net').'&jadwal='.rawurlencode($jadwal),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'apikey: '.$apikey
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

  }
}

if (! function_exists('sendImageUrl'))
{
  function sendImageUrl($tujuan, $pesan, $imgUrl, $apikey=null)
  {
      //$apikey="XrkpzOulTjAZt8J3dlUL:5";
      //$tujuan="6281296648532" //atau $tujuan="Group Chat Name";
      //$pesan="Hiii ini pesan test.";
      $filePath = $imgUrl; //"https://domain.com/a.png";

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://starsender.online/api/sendFiles?message='.rawurlencode($pesan).'&tujuan='.rawurlencode($tujuan.'@s.whatsapp.net'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('file'=> $filePath),
        CURLOPT_HTTPHEADER => array(
          'apikey: '.$apikey
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      return $response;

  }
}

if (! function_exists('sendImageUrlTerjadwal'))
{
  function sendImageUrlTerjadwal($tujuan, $pesan, $imgUrl, $jadwal, $apikey=null)
  {
      //$apikey="XrkpzOulTjAZt8J3dlUL:5";
      //$tujuan="6281296648532" //atau $tujuan="Group Chat Name";
      //$pesan="Hiii ini pesan test.";
      $filePath = $imgUrl; //"https://domain.com/a.png";

      $curl = curl_init();

      curl_setopt_array($curl, array(
       CURLOPT_URL => 'https://starsender.online/api/v2/sendFiles?message='.rawurlencode($pesan).'&tujuan='.rawurlencode($tujuan.'@s.whatsapp.net').'&jadwal='.rawurlencode($jadwal),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('file'=> $filePath),
        CURLOPT_HTTPHEADER => array(
          'apikey: '.$apikey
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      return $response;

  }
}



if (! function_exists('sendImageFile'))
{
  function sendImageFile($tujuan, $pesan, $filePath, $apikey=null)
  {
      //$apikey="XrkpzOulTjAZt8J3dlUL:5";
      //$tujuan="6281296648532" //atau $tujuan="Group Chat Name";
      //$pesan="Hiii ini pesan test.";
      //$filePath="a.png";

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://starsender.online/api/sendFilesUpload?message='.rawurlencode($pesan).'&tujuan='.rawurlencode($tujuan.'@s.whatsapp.net'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('file'=> curl_file_create($filePath)),
        CURLOPT_HTTPHEADER => array(
          'apikey: '.$apikey
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      return $response;

  }
}

if (! function_exists('sendImageFileTerjadwal'))
{
  function sendImageFileTerjadwal($tujuan, $pesan, $filePath, $jadwal, $apikey=null)
  {
      //$apikey="XrkpzOulTjAZt8J3dlUL:5";
      //$tujuan="6281296648532" //atau $tujuan="Group Chat Name";
      //$pesan="Hiii ini pesan test.";
      //$filePath="a.png";

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://starsender.online/api/v2/sendFilesUpload?message='.rawurlencode($pesan).'&tujuan='.rawurlencode($tujuan.'@s.whatsapp.net').'&jadwal='.rawurlencode($jadwal),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('file'=> curl_file_create($filePath)),
        CURLOPT_HTTPHEADER => array(
          'apikey: '.$apikey
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      return $response;

  }
}






if (! function_exists('msgTemplate'))
{
  function msgTemplate($nama='')
  {

    $ret = '';

    $ret .= 'Terima kasih kepada bapak/ibu '.$nama.' yang telah menggunakan layanan Ambulan Hidayatullah, Dukung kami agar terus bermanfaat untuk semua.';
    return $ret;


  }
}