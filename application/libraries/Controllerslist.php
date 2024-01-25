<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/***
 * File: (Codeigniterapp)/libraries/Controllerlist.php
 * 
 * A simple library to list all your controllers with their methods.
 * This library will return an array with controllers and methods
 * 
 * The library will scan the "controller" directory and (in case of) one (1) subdirectory level deep
 * for controllers
 * 
 * Usage in one of your controllers:
 * 
 * $this->load->library('controllerlist');
 * print_r($this->controllerlist->getControllers());
 * 
 * @author Peter Prins 
 */
class Controllerslist {


    private $CI;


    private $aControllers;


    function __construct() {

        $this->CI = get_instance();

        $this->setControllers();
    }


    public function getControllers() {
        return $this->aControllers;
    }


    public function setControllerMethods($p_sControllerName, $p_aControllerMethods) {
        $this->aControllers[$p_sControllerName] = $p_aControllerMethods;
    }

    public function get_controller(){
        $listctrl = array();
        $foldermodules = get_dir_file_info(APPPATH.'modules', TRUE);

            // Loop through file names removing .php extension
            foreach (array_keys($foldermodules) as $file)
            {
                $listctrl[] = $file ;//str_replace(EXT, '', $file);
            }

        foreach( $listctrl as $controller) {
                
               $dirname = basename($controller);
               foreach(glob(APPPATH . 'modules/'.$dirname.'/controllers/*') as $subdircontroller) {
                    $ctrl = array();
                    $subdircontrollername = basename($subdircontroller, EXT);


                    /*if(!class_exists($subdircontrollername)) {
                        $this->CI->load->file($subdircontroller);
                    }*/
                   $ctrl['module'] = $dirname; 
                   $ctrl['name'] = $subdircontrollername;
                   $ctrl['path'] = APPPATH. 'modules/'.$dirname.'/controllers/';
                   $ret[] = $ctrl;
                   // $this->setControllerMethods($subdircontrollername, $declared_methods);                                      
                }           
        } 
        return $ret; 
    }

    public function get_method(){

    }

    private function setControllers() {
        $controllers = array();
        $foldermodules = get_dir_file_info(APPPATH.'modules', TRUE);

            // Loop through file names removing .php extension
            foreach (array_keys($foldermodules) as $file)
            {
                $controllers[] = $file ;//str_replace(EXT, '', $file);
            }

        foreach( $controllers as $controller) {


           

                $dirname = basename($controller);


                foreach(glob(APPPATH . 'modules/'.$dirname.'/controllers/*') as $subdircontroller) {

                    $subdircontrollername = basename($subdircontroller, EXT);


                    if(!class_exists($subdircontrollername)) {
                        $this->CI->load->file($subdircontroller);
                    }

                    $aMethods = get_class_methods($subdircontrollername);
                    $pMethods = get_class_methods(get_parent_class($subdircontrollername));
                    $aUserMethods = array();
                    foreach($aMethods as $method) {
                        if($method != '__get' && $method != '__construct' && $method != 'get_instance' && $method != $subdircontrollername) {



                            $aUserMethods[] = $method;
                        }
                    }
                    $declared_methods = array_diff($aUserMethods, $pMethods);
                    $this->setControllerMethods($subdircontrollername, $declared_methods);                                      
                }
            
           
        }   
    }
}
// EOF


/* If you only need the methods declared by the class, and not the parent classes ones, you can do something like:

$declared_methods = array_diff(get_class_methods($class), get_class_methods(get_parent_class($class)));
*/