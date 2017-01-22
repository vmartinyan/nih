<?php 

require_once 'wonderplugin-slider-functions.php';

class WonderPlugin_Slider_Model {

	private $controller;
	
	function __construct($controller) {
		
		$this->controller = $controller;
	}
	
	function get_upload_path() {
		
		$uploads = wp_upload_dir();
		return $uploads['basedir'] . '/wonderplugin-slider/';
	}
	
	function get_upload_url() {
	
		$uploads = wp_upload_dir();
		return $uploads['baseurl'] . '/wonderplugin-slider/';
	}
	
	function eacape_html_quotes($str) {
	
		$result = str_replace("\'", "&#39;", $str);
		$result = str_replace('\"', '&quot;', $result);
		$result = str_replace("'", "&#39;", $result);
		$result = str_replace('"', '&quot;', $result);
		return $result;
	}
	
	function generate_body_code($id, $has_wrapper) {
		
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_slider";
		
		if ( !$this->is_db_table_exists() )
		{
			return '<p>The specified slider does not exist.</p>';
		}
		
		$ret = "";
		$item_row = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id) );
		if ($item_row != null)
		{
			$data = json_decode(trim($item_row->data));
			
			foreach($data as &$value)
			{
				if ( is_string($value) )
					$value = wp_kses_post($value);
			}
			
			if (isset($data->customcss) && strlen($data->customcss) > 0)
			{
				$customcss = str_replace("\r", " ", $data->customcss);
				$customcss = str_replace("\n", " ", $customcss);
				$customcss = str_replace("SLIDERID", $id, $customcss);
				$ret .= '<style type="text/css">' . $customcss . '</style>';
			}
						
			$ret .= '<div class="wonderpluginslider-container" id="wonderpluginslider-container-' . $id . '" style="';
			
			if ( (isset($data->fullwidth) && strtolower($data->fullwidth) === 'true') || (isset($data->isresponsive) && strtolower($data->isresponsive) === 'true' && !isset($data->fullwidth)) )
			{
				$ret .= 'max-width:100%;';
				
				if (isset($data->isfullscreen) && strtolower($data->isfullscreen) === 'true')
				{
					if ($has_wrapper)
						$ret .= 'height:500px;';
					else
						$ret .= 'height:100%;';
				}
			}
			else
			{
				$ret .= 'max-width:' . $data->width . 'px;';
			}
			
			if ($has_wrapper)
				$ret .= 'margin:0 auto 180px;';
			else
				$ret .= 'margin:0 auto;';
			
			if ( isset($data->paddingleft) )
				$ret .= 'padding-left:' . $data->paddingleft . 'px;';
			
			if ( isset($data->paddingright) )
				$ret .= 'padding-right:' . $data->paddingright . 'px;';
			
			if ( isset($data->paddingtop) )
				$ret .= 'padding-top:' . $data->paddingtop . 'px;';
			
			if ( isset($data->paddingbottom) )
				$ret .= 'padding-bottom:' . $data->paddingbottom . 'px;';
			
			$ret .= '">';
			
			// div data tag
			$ret .= '<div class="wonderpluginslider" id="wonderpluginslider-' . $id . '" data-sliderid="' . $id . '" data-width="' . $data->width . '" data-height="' . $data->height . '" data-skin="' . $data->skin . '"';
			
			if (isset($data->dataoptions) && strlen($data->dataoptions) > 0)
			{
				$ret .= ' ' . stripslashes($data->dataoptions);
			}
			
			$boolOptions = array('autoplay', 'randomplay', 'loadimageondemand', 'transitiononfirstslide', 'autoplayvideo', 'isresponsive', 'fullwidth', 'isfullscreen', 'ratioresponsive', 'showtext', 'showtimer', 'showbottomshadow', 'navshowpreview', 'textautohide',
					'lightboxresponsive', 'lightboxshownavigation', 'lightboxshowtitle', 'lightboxshowdescription', 'texteffectresponsive', 'donotinit', 'addinitscript', 'lightboxfullscreenmode', 'lightboxcloseonoverlay', 'lightboxvideohidecontrols', 'lightboxnogroup',
					'lightboxautoslide', 'lightboxshowtimer', 'lightboxshowplaybutton', 'lightboxalwaysshownavarrows', 'lightboxshowtitleprefix');
			foreach ( $boolOptions as $key )
			{
				if (isset($data->{$key}) )
					$ret .= ' data-' . $key . '="' . ((strtolower($data->{$key}) === 'true') ? 'true': 'false') .'"';
			}
			
			$boolOptions = array('titleusealt');
			foreach ( $boolOptions as $key )
			{
				$ret .= ' data-' . $key . '="' . ((isset($data->{$key}) && strtolower($data->{$key}) === 'true') ? 'true': 'false') .'"';
			}
			
			$valOptions = array('scalemode', 'arrowstyle', 'transition', 'loop', 'border', 'slideinterval', 
					'arrowimage', 'arrowwidth', 'arrowheight', 'arrowtop', 'arrowmargin',
					'navstyle', 'navimage', 'navwidth', 'navheight', 'navspacing', 'navmarginx', 'navmarginy', 'navposition',
					'playvideoimage', 'playvideoimagewidth', 'playvideoimageheight', 'lightboxthumbwidth', 'lightboxthumbheight', 'lightboxthumbtopmargin', 'lightboxthumbbottommargin', 'lightboxbarheight', 'lightboxtitlebottomcss', 'lightboxdescriptionbottomcss',
					'textformat', 'textpositionstatic', 'textpositiondynamic', 'paddingleft', 'paddingright', 'paddingtop', 'paddingbottom', 'texteffectresponsivesize',
					'fadeduration','crossfadeduration','slideduration', 'elasticduration', 'sliceduration','blindsduration','blocksduration','shuffleduration',
					'tilesduration', 'kenburnsduration', 'flipduration', 'flipwithzoomduration',
					'threedduration','threedhorizontalduration', 'threedwithzoomduration', 'threedhorizontalwithzoomduration', 'threedflipduration', 'threedflipwithzoomduration', 'threedtilesduration',
					'threedfallback','threedhorizontalfallback', 'threedwithzoomfallback', 'threedhorizontalwithzoomfallback', 'threedflipfallback', 'threedflipwithzoomfallback', 'threedtilesfallback',
					'ratiomediumscreen', 'ratiomediumheight', 'ratiosmallscreen', 'ratiosmallheight',
					'lightboxtitlestyle', 'lightboximagepercentage', 'lightboxdefaultvideovolume', 'lightboxoverlaybgcolor', 'lightboxoverlayopacity', 'lightboxbgcolor', 'lightboxtitleprefix', 'lightboxtitleinsidecss', 'lightboxdescriptioninsidecss',
					'lightboxslideinterval', 'lightboxtimerposition', 'lightboxtimerheight:', 'lightboxtimercolor', 'lightboxtimeropacity', 'lightboxbordersize', 'lightboxborderradius'
					);
			
			foreach ( $valOptions as $key )
			{
				if (isset($data->{$key}) )
					$ret .= ' data-' . $key . '="' . $data->{$key} . '"';
			}
			
			$cssOptions = array('textcss', 'textbgcss', 'titlecss', 'descriptioncss', 'buttoncss', 'titlecssresponsive', 'descriptioncssresponsive', 'buttoncssresponsive');
			foreach ( $cssOptions as $key )
			{
				if (isset($data->{$key}) )
					$ret .= ' data-' . $key . '="' . $this->eacape_html_quotes($data->{$key}) . '"';
			}
			
			$ret .= ' data-jsfolder="' . WONDERPLUGIN_SLIDER_URL . 'engine/"'; 
			$ret .= ' style="display:none;" >';
			
			if (isset($data->slides) && count($data->slides) > 0)
			{
				
				// process posts
				$items = array();
				foreach ($data->slides as $slide)
				{
					if ($slide->type == 6)
					{
						$items = array_merge($items, $this->get_post_items($slide));
					}
					else
					{
						$items[] = $slide;
					}
				}
				
				$ret .= '<ul class="amazingslider-slides" style="display:none;">';
				
				$index = 0;
				foreach ($items as $slide)
				{		
					foreach($slide as &$value)
					{
						if ( is_string($value) )
							$value = wp_kses_post($value);
					}
					
					$boolOptions = array('lightbox', 'lightboxsize', 'altusetitle');
					foreach ( $boolOptions as $key )
					{
						$slide->{$key} = (( isset($slide->{$key}) && (strtolower($slide->{$key}) === 'true') ) ? true: false);
					}
					
					$ret .= '<li>';
					
					if ($slide->lightbox)
					{
						$ret .= '<a href="';
						if ($slide->type == 0)
						{
							$ret .= $slide->image;
						}
						else if ($slide->type == 1)
						{
							$ret .= $slide->mp4;
							if ($slide->webm)
								$ret .= '" data-webm="' . $slide->webm;
						}
						else if ($slide->type == 2 || $slide->type == 3)
						{
							$ret .= $slide->video;
						}
						
						if ($slide->lightboxsize)
							$ret .= '" data-width="' . $slide->lightboxwidth . '" data-height="' . $slide->lightboxheight;
						
						if ($slide->description && strlen($slide->description) > 0)
							$ret .= '" data-description="' . $this->eacape_html_quotes($slide->description);
						
						$ret .= '" class="html5lightbox">';
					}
					else if ($slide->weblink && strlen($slide->weblink) > 0)
					{
						$ret .= '<a href="' . $slide->weblink . '"';
						if ($slide->linktarget && strlen($slide->linktarget) > 0)
							$ret .= ' target="' . $slide->linktarget . '"';
						$ret .= '>';
					}
					
					if ($index > 0 && isset($data->loadimageondemand) && strtolower($data->loadimageondemand) === 'true')
						$ret .= '<img class="amazingsliderimg" data-src="';
					else
						$ret .= '<img class="amazingsliderimg" src="';
					$ret .= $slide->image . '"';
					
					if (isset($slide->altusetitle) && isset($slide->alt) && !$slide->altusetitle && (strlen($slide->alt) > 0))
						$ret .= ' alt="' .  $this->eacape_html_quotes($slide->alt) . '"';
					else
						$ret .= ' alt="' .  $this->eacape_html_quotes($slide->title) . '"';
					
					$ret .= ' title="' .  $this->eacape_html_quotes($slide->title) . '"';
					$ret .= ' data-description="' .  $this->eacape_html_quotes($slide->description) . '"';
					$ret .= ' />';
					
					if ($slide->lightbox || ($slide->weblink && strlen($slide->weblink) > 0))
					{
						$ret .= '</a>';
					}
					
					if (!$slide->lightbox)
					{
						if ($slide->type == 1)
						{
							$ret .= '<video preload="none" src="' . $slide->mp4 . '"';
							if ($slide->webm)
								$ret .= ' data-webm="' . $slide->webm . '"';
							$ret .= '></video>';
						}
						else if ($slide->type == 2 || $slide->type == 3)
						{
							$ret .= '<video preload="none" src="' . $slide->video . '"></video>';
						}
					}
					
					
					if (isset($slide->button) && $slide->button && strlen($slide->button) > 0)
					{
						if ($slide->buttonlink && strlen($slide->buttonlink) > 0)
						{
							$ret .= '<a href="' . $slide->buttonlink . '"';
							if ($slide->buttonlinktarget && strlen($slide->buttonlinktarget) > 0)
								$ret .= ' target="' . $slide->buttonlinktarget . '"';
							$ret .= '>';
						}
						
						$ret .= '<button class="' . $slide->buttoncss . '">' . $slide->button . '</button>';
						
						if ($slide->buttonlink && strlen($slide->buttonlink) > 0)
						{
							$ret .= '</a>';
						}
					}
					
					$ret .= '</li>';
					
					$index++;
				}
				$ret .= '</ul>';
				
				$ret .= '<ul class="amazingslider-thumbnails" style="display:none;">';
				foreach ($items as $slide)
				{
					$ret .= '<li><img class="amazingsliderthumbnailimg" src="' . $slide->thumbnail . '"';
					if (isset($slide->altusetitle) && isset($slide->alt) && !$slide->altusetitle && (strlen($slide->alt) > 0))
						$ret .= ' alt="' .  $this->eacape_html_quotes($slide->alt) . '"';
					else
						$ret .= ' alt="' .  $this->eacape_html_quotes($slide->title) . '"';
					$ret .= ' title="' .  $this->eacape_html_quotes($slide->title) . '"';
					$ret .= ' data-description="' .  $this->eacape_html_quotes($slide->description) . '"';					
					$ret .= ' /></li>';
				}
				$ret .= '</ul>';
				
			}


			$ret .= '</div>';
			
			$ret .= '</div>';
			
			if (isset($data->addinitscript) && strtolower($data->addinitscript) === 'true')
			{
				$ret .= '<script>jQuery(document).ready(function(){jQuery(".wonderplugin-engine").css({display:"none"});jQuery(".wonderpluginslider").wonderpluginslider({forceinit:true});});</script>';
			}
		}
		else
		{
			$ret = '<p>The specified slider id does not exist.</p>';
		}
		return $ret;
	}
	
	function get_post_items($options) {
	
		$posts = array();
	
		if ($options->postcategory == -1)
		{
			$posts = wp_get_recent_posts(array(
					'numberposts' 	=> $options->postnumber,
					'post_status' 	=> 'publish'
			));
		}
		else
		{
			$posts = get_posts(array(
					'numberposts' 	=> $options->postnumber,
					'post_status' 	=> 'publish',
					'category'		=> $options->postcategory
			));
		}
	
		$items = array();
	
		foreach($posts as $post)
		{
			if (is_object($post))
				$post = get_object_vars($post);
				
			$thumbnail = '';
			$image = '';
			if ( has_post_thumbnail($post['ID']) )
			{
				$featured_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post['ID']), $options->featuredimagesize);
				$thumbnail = $featured_thumb[0];
				
				$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post['ID']), 'full');
				$image = $featured_image[0];
			}
	
			$excerpt = $post['post_excerpt'];
			if (empty($excerpt))
			{
				$excerpts = explode( '<!--more-->', $post['post_content'] );
				$excerpt = $excerpts[0];
				$excerpt = strip_tags( str_replace(']]>', ']]&gt;', strip_shortcodes($excerpt)) );
			}
			$excerpt = wp_trim_words($excerpt, $options->excerptlength);
	
			$post_item = array(
					'type'			=> 0,
					'image'			=> $image,
					'thumbnail'		=> $thumbnail,
					'title'			=> $post['post_title'],
					'description'	=> $excerpt,
					'weblink'		=> get_permalink($post['ID']),
					'linktarget'	=> $options->postlinktarget,
					'button'		=> $options->button,
					'buttoncss'		=> $options->buttoncss,
					'buttonlink'	=> get_permalink($post['ID']),
					'buttonlinktarget'	=> $options->postlinktarget
			);
			
			if (isset($options->postlightbox))
			{
				$post_item['lightbox'] = $options->postlightbox;
				$post_item['lightboxsize'] = $options->postlightboxsize;
				$post_item['lightboxwidth'] = $options->postlightboxwidth;
				$post_item['lightboxheight'] = $options->postlightboxheight;
				
				if (isset($options->posttitlelink) && strtolower($options->posttitlelink) === 'true')
				{
					$post_item['title'] = '<a class="amazingslider-posttitle-link" href="' . $post_item['weblink'] . '"';
					if (isset($post_item['linktarget']) && strlen($post_item['linktarget']) > 0)
						$post_item['title'] .= ' target="' . $post_item['linktarget'] . '"';
					$post_item['title'] .= '>' . $post['post_title'] . '</a>';
				}
			}
			
			$items[] = (object) $post_item;
		}
	
		return $items;
	}
	
	function delete_item($id) {
		
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_slider";
		
		$ret = $wpdb->query( $wpdb->prepare(
				"
				DELETE FROM $table_name WHERE id=%s
				",
				$id
		) );
		
		return $ret;
	}
	
	function trash_item($id) {
	
		return $this->set_item_status($id, 0);
	}
	
	function restore_item($id) {
	
		return $this->set_item_status($id, 1);
	}
	
	function set_item_status($id, $status) {
	
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_slider";
	
		$ret = false;
		$item_row = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id) );
		if ($item_row != null)
		{
			$data = json_decode($item_row->data, true);
			$data['publish_status'] = $status;
			$data = json_encode($data);
	
			$update_ret = $wpdb->query( $wpdb->prepare( "UPDATE $table_name SET data=%s WHERE id=%d", $data, $id ) );
			if ( $update_ret )
				$ret = true;
		}
	
		return $ret;
	}
	
	function clone_item($id) {
	
		global $wpdb, $user_ID;
		$table_name = $wpdb->prefix . "wonderplugin_slider";
		
		$cloned_id = -1;
		
		$item_row = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id) );
		if ($item_row != null)
		{
			$time = current_time('mysql');
			$authorid = $user_ID;
			
			$ret = $wpdb->query( $wpdb->prepare(
					"
					INSERT INTO $table_name (name, data, time, authorid)
					VALUES (%s, %s, %s, %s)
					",
					$item_row->name . " Copy",
					$item_row->data,
					$time,
					$authorid
			) );
				
			if ($ret)
				$cloned_id = $wpdb->insert_id;
		}
	
		return $cloned_id;
	}
	
	function is_db_table_exists() {
	
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_slider";
	
		return ( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name );
	}
	
	function is_id_exist($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_slider";
	
		$slider_row = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id) );
		return ($slider_row != null);
	}
	
	function create_db_table() {
	
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_slider";
		
		$charset = '';
		if ( !empty($wpdb -> charset) )
			$charset = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( !empty($wpdb -> collate) )
			$charset .= " COLLATE $wpdb->collate";
	
		$sql = "CREATE TABLE $table_name (
		id INT(11) NOT NULL AUTO_INCREMENT,
		name tinytext DEFAULT '' NOT NULL,
		data MEDIUMTEXT DEFAULT '' NOT NULL,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		authorid tinytext NOT NULL,
		PRIMARY KEY  (id)
		) $charset;";
			
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	
	function save_item($item) {
		
		global $wpdb, $user_ID;
		
		if ( !$this->is_db_table_exists() )
		{
			$this->create_db_table();
		
			$create_error = $wpdb->last_error;
			if ( !$this->is_db_table_exists() )
			{
				return array(
						"success" => false,
						"id" => -1,
						"message" => $create_error
				);
			}
		}
		
		$table_name = $wpdb->prefix . "wonderplugin_slider";
		
		$id = $item["id"];
		$name = $item["name"];
		
		unset($item["id"]);
		$data = json_encode($item);
		
		if ( empty($data) )
		{
			$json_error = "json_encode error";
			if ( function_exists('json_last_error_msg') )
				$json_error .= ' - ' . json_last_error_msg();
			else if ( function_exists('json_last_error') )
				$json_error .= 'code - ' . json_last_error();
		
			return array(
					"success" => false,
					"id" => -1,
					"message" => $json_error
			);
		}
		
		$time = current_time('mysql');
		$authorid = $user_ID;
		
		if ( ($id > 0) && $this->is_id_exist($id) )
		{
			$ret = $wpdb->query( $wpdb->prepare(
					"
					UPDATE $table_name
					SET name=%s, data=%s, time=%s, authorid=%s
					WHERE id=%d
					",
					$name,
					$data,
					$time,
					$authorid,
					$id
			) );
			
			if (!$ret)
			{
				return array(
						"success" => false,
						"id" => $id, 
						"message" => "UPDATE - ". $wpdb->last_error
					);
			}
		}
		else
		{
			$ret = $wpdb->query( $wpdb->prepare(
					"
					INSERT INTO $table_name (name, data, time, authorid)
					VALUES (%s, %s, %s, %s)
					",
					$name,
					$data,
					$time,
					$authorid
			) );
			
			if (!$ret)
			{
				return array(
						"success" => false,
						"id" => -1,
						"message" => "INSERT - " . $wpdb->last_error
				);
			}
			
			$id = $wpdb->insert_id;
		}
		
		return array(
				"success" => true,
				"id" => intval($id),
				"message" => "Slider published!"
		);
	}
	
	function get_list_data() {
		
		if ( !$this->is_db_table_exists() )
			$this->create_db_table();
		
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_slider";
		
		$rows = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A);
		
		$ret = array();
		
		if ( $rows )
		{
			foreach ( $rows as $row )
			{
				$ret[] = array(
							"id" => $row['id'],
							'name' => $row['name'],
							'data' => $row['data'],
							'time' => $row['time'],
							'author' => $row['authorid']
						);
			}
		}
	
		return $ret;
	}
	
	function get_item_data($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_slider";
	
		$ret = "";
		$item_row = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id) );
		if ($item_row != null)
		{
			$ret = $item_row->data;
		}

		return $ret;
	}
	
	
	function get_settings() {
	
		$userrole = get_option( 'wonderplugin_slider_userrole' );
		if ( $userrole == false )
		{
			update_option( 'wonderplugin_slider_userrole', 'manage_options' );
			$userrole = 'manage_options';
		}
		
		$keepdata = get_option( 'wonderplugin_slider_keepdata', 1 );
		
		$disableupdate = get_option( 'wonderplugin_slider_disableupdate', 0 );
		
		$supportwidget = get_option( 'wonderplugin_slider_supportwidget', 1 );
		
		$addjstofooter = get_option( 'wonderplugin_slider_addjstofooter', 0 );
		
		$jsonstripcslash = get_option( 'wonderplugin_slider_jsonstripcslash', 1 );
		
		$settings = array(
				"userrole" => $userrole,
				"keepdata" => $keepdata,
				"disableupdate" => $disableupdate,
				"supportwidget" => $supportwidget,
				"addjstofooter" => $addjstofooter,
				"jsonstripcslash" => $jsonstripcslash
		);
		
		return $settings;	
	}
	
	function save_settings($options) {
	
		if (!isset($options) || !isset($options['userrole']))
			$userrole = 'manage_options';
		else if ( $options['userrole'] == "Editor")
			$userrole = 'moderate_comments';
		else if ( $options['userrole'] == "Author")
			$userrole = 'upload_files';
		else
			$userrole = 'manage_options';
		update_option( 'wonderplugin_slider_userrole', $userrole );
		
		if (!isset($options) || !isset($options['keepdata']))
			$keepdata = 0;
		else
			$keepdata = 1;
		update_option( 'wonderplugin_slider_keepdata', $keepdata );
		
		if (!isset($options) || !isset($options['disableupdate']))
			$disableupdate = 0;
		else
			$disableupdate = 1;
		update_option( 'wonderplugin_slider_disableupdate', $disableupdate );
		
		if (!isset($options) || !isset($options['supportwidget']))
			$supportwidget = 0;
		else
			$supportwidget = 1;
		update_option( 'wonderplugin_slider_supportwidget', $supportwidget );
		
		if (!isset($options) || !isset($options['addjstofooter']))
			$addjstofooter = 0;
		else
			$addjstofooter = 1;
		update_option( 'wonderplugin_slider_addjstofooter', $addjstofooter );
		
		if (!isset($options) || !isset($options['jsonstripcslash']))
			$jsonstripcslash = 0;
		else
			$jsonstripcslash = 1;
		update_option( 'wonderplugin_slider_jsonstripcslash', $jsonstripcslash );
	}
	
	function get_plugin_info() {
	
		$info = get_option('wonderplugin_slider_information');
		if ($info === false)
			return false;
	
		return unserialize($info);
	}
	
	function save_plugin_info($info) {
	
		update_option( 'wonderplugin_slider_information', serialize($info) );
	}
	
	function check_license($options) {
	
		$ret = array(
				"status" => "empty"
		);
	
		if ( !isset($options) || empty($options['wonderplugin-slider-key']) )
		{
			return $ret;
		}
	
		$key = sanitize_text_field( $options['wonderplugin-slider-key'] );
		if ( empty($key) )
			return $ret;
	
		$update_data = $this->controller->get_update_data('register', $key);
		if( $update_data === false )
		{
			$ret['status'] = 'timeout';
			return $ret;
		}
	
		if ( isset($update_data->key_status) )
			$ret['status'] = $update_data->key_status;
	
		return $ret;
	}
	
	function deregister_license($options) {
	
		$ret = array(
				"status" => "empty"
		);
	
		if ( !isset($options) || empty($options['wonderplugin-slider-key']) )
			return $ret;
	
		$key = sanitize_text_field( $options['wonderplugin-slider-key'] );
		if ( empty($key) )
			return $ret;
	
		$info = $this->get_plugin_info();
		$info->key = '';
		$info->key_status = 'empty';
		$info->key_expire = 0;
		$this->save_plugin_info($info);
	
		$update_data = $this->controller->get_update_data('deregister', $key);
		if ($update_data === false)
		{
			$ret['status'] = 'timeout';
			return $ret;
		}
	
		$ret['status'] = 'success';
	
		return $ret;
	}
}
