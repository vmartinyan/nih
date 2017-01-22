<?php

VP_Security::instance()->whitelist_function('vp_simple_shortcode');

function vp_simple_shortcode($style = "", $category = "")
{
	$rdresult = '[vbs_'.$style.' category="'.$category. '" ]';
	return $rdresult;
}

?>