 <?php if (!defined('BASEPATH')) exit('No direct script access allowed');
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

  if (!function_exists('sendtext')) {
    function sendtext($toNumber, $text, $senderNumber)
    {
      $data = [
        'api_key' => '',
        'sender'  => $senderNumber,
        'number'  => $toNumber,
        'message' => $text
      ];

      $curl = curl_init();
      curl_setopt_array(
        $curl,
        array(
          CURLOPT_URL => "https://sender.easydigital.id/app/api/send-message",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($data)
        )
      );

      $response = curl_exec($curl);

      curl_close($curl);
      return $response;
    }
  }



  if (!function_exists('sendmedia')) {
    function sendmedia($toNumber, $caption, $linkFile, $senderNumber)
    {
      $data = [
        'api_key' => '',
        'sender'  => $senderNumber,
        'number'  => $toNumber,
        'message' => $caption,

        'url' => $linkFile //link Image or link PDF
      ];

      $curl = curl_init();
      curl_setopt_array(
        $curl,
        array(
          CURLOPT_URL => "https://sender.easydigital.id/app/api/send-media",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($data)
        )
      );

      $response = curl_exec($curl);

      curl_close($curl);

      return $response;
    }
  }

  if (!function_exists('sendbutton')) {
    function sendbutton($toNumber, $text, $footer, $button1, $button2, $senderNumber)
    {
      $data = [
        'api_key' => '',
        'sender'  => $senderNumber,
        'number'  => $toNumber,
        'message' => $text,
        'footer' => $footer,
        'button1' => $button1,
        'button2' => $button2,
      ];

      $curl = curl_init();
      curl_setopt_array(
        $curl,
        array(
          CURLOPT_URL => "https://sender.easydigital.id/app/api/send-button",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($data)
        )
      );

      $response = curl_exec($curl);

      curl_close($curl);

      return $response;
    }
  }


  if (!function_exists('msgTemplate')) {
    function msgTemplate($nama = '')
    {

      $ret = '';

      $ret .= 'Terima kasih kepada bapak/ibu ' . $nama . ' yang telah menggunakan layanan Ambulan Hidayatullah, Dukung kami agar terus bermanfaat untuk semua.';
      return $ret;
    }
  }
