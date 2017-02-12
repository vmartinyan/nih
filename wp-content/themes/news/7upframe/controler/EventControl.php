<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!class_exists('SV_EventController'))
{
    class SV_EventController{
        public $taxonomy;
        public function _init()
        {
            if(function_exists('stp_reg_post_type'))
            {
                add_action('init',array($this,'_add_post_type'));
                $this->_add_taxonomy();
                $this->_set_taxonomy();
            }
        }

        public function _add_post_type()
        {
            $labels = array(
                'name'               => esc_html__('Event','news'),
                'singular_name'      => esc_html__('Event','news'),
                'menu_name'          => esc_html__('Event','news'),
                'name_admin_bar'     => esc_html__('Event','news'),
                'add_new'            => esc_html__('Add New','news'),
                'add_new_item'       => esc_html__( 'Add New Event','news' ),
                'new_item'           => esc_html__( 'New Event', 'news' ),
                'edit_item'          => esc_html__( 'Edit Event', 'news' ),
                'view_item'          => esc_html__( 'View Event', 'news' ),
                'all_items'          => esc_html__( 'All Events', 'news' ),
                'search_items'       => esc_html__( 'Search Event', 'news' ),
                'parent_item_colon'  => esc_html__( 'Parent Event:', 'news' ),
                'not_found'          => esc_html__( 'No Event found.', 'news' ),
                'not_found_in_trash' => esc_html__( 'No Event found in Trash.', 'news' )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'event' ),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' )
            );

            stp_reg_post_type('event',$args);
        }

        public function _add_taxonomy (){
            stp_reg_taxonomy(
                'event_category',
                'event',
                array(
                    'label' => esc_html__( 'Event Category', 'news' ),
                    'rewrite' => array( 'slug' => 'event_category' ),
                    'hierarchical' => true,
                    'query_var'  => true,
                    'show_ui'           => true,
                    'show_admin_column' => true,
                )
            );
        }

        public function _set_taxonomy(){
            $taxonomy = get_terms('event_category',array('orderby'=>'description'));
            global $event_taxonomy;
            $event_taxonomy = $taxonomy;
        }
        
    }
    $event = new SV_EventController();
    $event->_init();    
}