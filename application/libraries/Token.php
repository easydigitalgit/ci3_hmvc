<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

class Token {

    private $_CI;

    private function key($string) {

        $output         = false;
        $secret_key     = "1272030909920003";
        $secret_iv      = "1272015712940004";
        $encrypt_method = "aes-256-cbc";
        $key            = hash("sha256", $secret_key);
        $iv             = substr(hash("sha256", $secret_iv), 0, 16);
        $result         = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output         = base64_encode($result);
        
        return $output;

    }


    public function encrypt($string) {

        $output         = false;
        $secret_key     = substr($this->key(date("hisymd")),0,10);
        $secret_iv      = substr($this->key(date("ymdhis")),-10);
        $encrypt_method = "aes-256-cbc";
        $key            = hash("sha256", $secret_key);
        $iv             = substr(hash("sha256", $secret_iv), 0, 16);
        $result         = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output         = base64_encode($result).$secret_key.$secret_iv ;
       
        return $output;

    }

    
    public function decrypt($string) {

        $output         = false;
        $secret_key     = substr(substr($string,-20),0,10);
        $secret_iv      = substr($string,-10);
        $encrypt_method = "aes-256-cbc";
        $string         = substr($string,0,-20);
        $key            = hash("sha256", $secret_key);
        $iv             = substr(hash("sha256", $secret_iv), 0, 16);
        $output         = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

        return $output;

    }



    public function GetToken($string){

        // $CI =& get_instance();

        // $CI->load->library('session');

        // if ( $CI->session->userdata("dataLogin")){

        //     $data       = $CI->session->userdata("dataLogin");

        //     $data       = json_decode($this->decrypt($data));

        //     $data       = $data->token_login;

        // } else {

            $data= "12720157129400041272015712940004";

        // }

        $output         = false;
        $secret_key     = substr($data,0,10);
        $secret_iv      = substr($data,-10);
        $encrypt_method = "aes-256-cbc";
        $key            = hash("sha256", $secret_key);
        $iv             = substr(hash("sha256", $secret_iv), 0, 16);
        $result         = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output         = base64_encode($result) ;

        return $output;

    }

    

    public function GetValueToken($string){

        // $CI =& get_instance();

        // $CI->load->library('session');

        // if ( $CI->session->userdata("dataLogin")){

        //     $data       = $CI->session->userdata("dataLogin");

        //     $data       = json_decode($this->decrypt($data));

        //     $data       = $data->token_login;

        // } else {

            $data= "12720157129400041272015712940004";

        // }

        $output         = false;
        $secret_key     = substr($data,0,10);
        $secret_iv      = substr($data,-10);
        $encrypt_method = "aes-256-cbc";
        $key            = hash("sha256", $secret_key);
        $iv             = substr(hash("sha256", $secret_iv), 0, 16);

        $output         = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

        return $output;

    }
  

     public function GetSecretKey($string){

 
        $output         = false;
        $secret_key    = "1272030909920003";
        $secret_iv      = "1272015712940004";
        $encrypt_method = "aes-256-cbc";
        $key            = hash("sha256", $secret_key);
        $iv             = substr(hash("sha256", $secret_iv), 0, 16);
        $result         = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output         = base64_encode($result) ;

        return $output;

    }

    

    public function GetValueSecretKey($string){

        $output         = false;
        $secret_key     = "1272030909920003";
        $secret_iv      = "1272015712940004";
        $encrypt_method = "aes-256-cbc";
        $key            = hash("sha256", $secret_key);
        $iv             = substr(hash("sha256", $secret_iv), 0, 16);
        $output         = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

        return $output;

    }

public function randomString($n=0){


     return $n ? bin2hex(random_bytes($n)) : bin2hex(random_bytes(10)) ;
}


}