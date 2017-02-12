<?php
/**
 * Plugin Name: Rearrange Comment Fields
 * Plugin URI:  http://wordpress.stackexchange.com/a/207449/26350
 * Author:      Birgir Erlendsson (birgire)
 * Description: Support for rearranging the comment fields: 'comment', 'auhtor', 'url', 'email' and 'submit' through the 'wpse_comment_fields' filter.
 * Version:     0.0.1
 */

add_action( 'comment_form_before', 'sv_comment_form_before');
if(!function_exists('sv_comment_form_before')){
    function sv_comment_form_before(){
        $fields = apply_filters( 
            'wpse_comment_fields', 
            array( 'comment', 'author', 'url', 'email', 'submit' )
        );
        $o = new SV_Rearrange_Comment_Fields;
        $o->set_fields( $fields )->init();
    }
}
class SV_Rearrange_Comment_Fields
{
    private $html       = array();
    private $defaults   = array();
    private $fields     = array();

    public function set_fields( array $fields )
    {
        $this->fields = $fields;
        return $this;
    }

    public function init()
    {
        // Default
        $this->defaults = array( 'comment', 'author', 'url', 'email', 'submit' );

        // Check for defaults
        if( empty( $this->fields ) )
            $this->fields = $this->defaults;

        // Hooks
        add_action( 'comment_form',                 array($this, 'display'),                     PHP_INT_MAX );
        add_filter( 'comment_form_field_comment',   array($this, 'comment_form_field_comment'),  PHP_INT_MAX );
        add_filter( 'comment_form_submit_field',    array($this, 'comment_form_submit_field'),   PHP_INT_MAX );
        foreach( array( 'author', 'url', 'email' ) as $field )
            add_filter( "comment_form_field_{$field}",  array($this, 'comment_form_field'), PHP_INT_MAX );       
    }

    public function display()
    {
        // Display fields in the custom order                   
        $html = '';
        foreach( (array) $this->fields as $field )
        {
            if( in_array( $field, $this->defaults ) && isset($this->html[$field]) ) 
                $html .= $this->html[$field]; 
        }
        echo balanceTags($html);
    }

    public function comment_form_submit_field( $submit_field )
    {
        $this->html['submit'] = $submit_field;
        return '';
    }

    public function comment_form_field_comment( $comment_field )
    {
        $this->html['comment'] = $comment_field;
        return '';
    }

    public function comment_form_field( $field )
    {
        $key = str_replace( 'comment_form_field_', '', current_filter() );
        $this->html[$key] = $field;
        return '';
    }

} // end class
add_filter( 'wpse_comment_fields', 'sv_comment_fields');
if(!function_exists('sv_comment_fields')){
    function sv_comment_fields($fields){
        $fields = array(  'author', 'email', 'url', 'comment', 'submit' );
        return $fields;
    }
}