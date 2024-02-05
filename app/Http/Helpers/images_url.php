<?php

//namespace App\Helpers;



if (! function_exists('baffasoft_url')) {
    function baffasoft_url($url)
    {
//        if($rest = substr($url, 0) != '/'){
//            $url = '/'.$url;
//        }
         $host = request()->getHost();
        $root = request()->root();
        if($host == 'localhost'){
//            return $hostname = gethostname();
//            if (strpos($hostname, 'sanaulla') !== FALSE) {
//                return 'http://localhost/baffasoft/public'.$url;
//            }else{
//                return 'http://localhost/baffasoft/public'.$url;
//            }
            return  'http://localhost/baffasoft/'.$url;
        }else{
            if(strpos($root,'baffasoft') !== false){
                return 'https://gatepass.baffa-bd.org/'.$url;
            }else{
                return asset($url);
            }
        }
//        return str_replace("gatepass.baffa-bd.org/baffasoft","gatepass.baffa-bd.org",asset($url));
    }
}
