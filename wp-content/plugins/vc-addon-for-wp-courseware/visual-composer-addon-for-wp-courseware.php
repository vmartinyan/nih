<?php
/**
 * Plugin Name: Visual Composer Addon for WP Courseware
 * Plugin URI:  flyplugins.com
 * Description: Plugin adds course unit conent element to Visual Composer
 * Version:     1.6
 * Author:      Fly Plugins
 * Author URI:  flyplugins.com
 */

class WPCW_VC_Integration
{
    /**
    * @var WPCW_VC_Integration
    */
    protected static $instance;


    /**
    * Registering actions and filters
    */
    protected function __construct()
    {
        add_action("wp_head", array($this, 'WPCWremoveContentFilter'));

        add_action( 'vc_before_init', array($this, 'WPCW_VC_Map'));

        add_filter('the_content', array($this, 'WPCWrenderUnitContent'));        

    }


    /**
    * Add WP Courseware unit content to the Visual Composer content element list
    * @return void
    */
    public function WPCW_VC_Map()
    {
        $params = array(
          "name" => __( "WP Courseware Unit Content", "wpcw_vc_int" ),
          "base" => "wpcourse_unit",
          "description" => "WP Courseare unit content",
          "class" => "",
          "category" => __( "Content", "wpcw_vc_int"),
          'icon' => plugin_dir_url( __FILE__ ) .'/assets/wpcw-icon.png'
          );

        vc_map( $params );
    }


    /**
    * Removes WP Courseware the_content filter that renders unit content
    * @return void
    */
    public function WPCWremoveContentFilter()
    {
        global $post;
        
        // #### Ensure we're only showing a course unit, a single item
        if (!is_single() || 'course_unit' !=  get_post_type()) {
            return;
        }

        if( has_shortcode( $post->post_content, 'wpcourse_unit' ) )
        {
            remove_filter('the_content', 'WPCW_units_processUnitContent');
        }
    }


    /**
    * Renders unit content via shortcode
    * @return void
    */
    public static function WPCWrenderUnitProgressBox(){
        global $post;
        $fe = new WPCW_UnitFrontend($post);
        return $fe->render_detailsForUnit("");
    }

    /**
    * Display content with with WPCW Shortcode
    * @return string
    */
    public static function WPCWrenderUnitContent($content)
    {
        global $post;
        
        // #### Ensure we're only showing a course unit, a single item
        if (!is_single() || 'course_unit' !=  get_post_type()) {
            return $content;
        }

        $fe = new WPCW_UnitFrontend($post);

        // #### Get associated data for this unit. No course/module data, then it's not a unit
        if (!$fe->check_unit_doesUnitHaveParentData() && the_author_meta( 'ID',true ) != get_current_user_id()) {
            return $content . $fe->message_createMessage_error(__('This unit has not been assigned!', 'wpcw_vc_int'));
        }

        // Check for drip content
        $lockDetails = $fe->render_completionBox_contentLockedDueToDripfeed();
        if ($lockDetails['content_locked']) {
            // Do not return any content
            $content = false;

            // Get parent data
            $parentData = WPCW_units_getAssociatedParentData($post->ID);
            // Prepare drip access message
            $lockedMsg = $fe->message_createMessage_error($parentData->course_message_unit_not_yet_dripfeed);
            // Replace variable with the actual time delay before the unit is unlocked.
            $completionBox = str_ireplace('{UNIT_UNLOCKED_TIME}', WPCW_date_getHumanTimeDiff($lockDetails['unlock_date']), $lockedMsg);
            // Show the message and navigation box.
            return $completionBox . $fe->render_navigation_getNavigationBox();
        }

        // #### Ensure we're logged in
        if (!$fe->check_user_isUserLoggedIn() && !$fe->check_unit_doesUnitHaveParentData()) {
            return $fe->message_createMessage_error(__('You cannot view this unit as you\'re not logged in yet..', 'wpcw_vc_int'));
        }else if (!$fe->check_user_isUserLoggedIn()){
            return $fe->message_user_notLoggedIn();
        }

        // #### User not allowed access to content, so certainly can't say they've done this unit.
        if (!$fe->check_user_canUserAccessCourse()) {
            return $fe->message_user_cannotAccessCourse();
        }

        // #### Is user allowed to access this unit yet?
        if (!$fe->check_user_canUserAccessUnit())
        {
            // DJH 2015-08-18 - Added capability for a previous button if we've stumbled
            // on a unit that we're not able to complete just yet.
            $navigationBox = $fe->render_navigation_getNavigationBox();

            // Show the navigation box AFTErR the cannot progress message.
            return $fe->message_user_cannotAccessUnit() . $navigationBox;
        }

        // #### Has user completed course prerequisites
        if (!$fe->check_user_hasCompletedCoursePrerequisites())
        {
            // on a unit that we're not able to complete just yet.
            $navigationBox = $fe->render_navigation_getNavigationBox();

            // Show navigation box after the cannot process message.
            return $fe->message_user_hasNotCompletedCoursePrerequisites() . $navigationBox;
        }

        add_shortcode('wpcourse_unit', array($this, 'WPCWrenderUnitProgressBox'));
        return $content;

    }


    /**
    * Singleton
    * @return WPCW_VC_Integration
    */
    public static function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

}

if (class_exists('Vc_Manager'))
{
    WPCW_VC_Integration::getInstance();
}

?>