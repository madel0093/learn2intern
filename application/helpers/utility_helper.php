<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

     if ( ! function_exists('asset_url()'))
     {
       function asset_url()
       {
          return base_url().'assets/';
       }
     }
     function getSideBarActivebyController($instance,$ControlerName)
     {
       if(strtolower($instance->router->fetch_method())==strtolower($ControlerName))
       {
       	echo 'active';
       }
     }
     function getUrl($controller,$function)
     {
       return base_url()."/index.php/$controller/$function";
     }
?>