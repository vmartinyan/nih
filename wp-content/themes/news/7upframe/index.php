<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */

if(!defined('ABSPATH')) return;
if(!function_exists('sv_list_taxonomy_event'))
{
    function sv_list_taxonomy_event()
    {
        global $event_taxonomy;
        $list = array();
        if(is_array($event_taxonomy) && !empty($event_taxonomy)){
            foreach ($event_taxonomy as $tax) {
                $list[$tax->name] = $tax->slug;
            }
        }
        return $list;
    }
}
if(function_exists('s7upf_load_lib')){
    if(class_exists('Vc_Manager') && class_exists('PluginCore')){
        s7upf_load_lib('element');
    } 
    s7upf_load_lib('widget');
}