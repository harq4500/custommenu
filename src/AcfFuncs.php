<?php
namespace Antonbalyan\Custommenu;

class AcfFuncs{
   
    public function load_json($paths) 
    {
        unset($paths[0]);
        
        // append path
        $paths[] = CM_PLUGIN_DIR.'/assets/acf-json';
        
        // return
        return $paths;
    }
}