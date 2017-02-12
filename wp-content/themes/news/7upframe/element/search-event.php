<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 29/01/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_search_event'))
{
    function sv_vc_search_event($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'search_text'      => 'Search',
        ),$attr));
        $search_val = get_search_query();
        $location = '';
        $event_date = $event_location = '';
        if(isset($_GET['event_location'])) $location = $event_location = $_GET['event_location'];
        if(isset($_GET['event_date'])) $event_date = $_GET['event_date'];
        if(empty($search_val)){
            $search_val = '';
        }
        ob_start();?>
        <div class="event-search-form">
            <form class="clearfix" method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
                <input name="s" class="event-search-category" type="text" value="<?php echo esc_attr($search_val)?>" placeholder="<?php echo esc_html__('Event Name','news')?>">
                <input name="event_location" class="event-search-location" type="text" value="<?php echo esc_attr($location)?>" placeholder="<?php echo esc_html__('Enter city or location','news')?>">
                <select class="select-event-time">
                    <option value=""><?php esc_html_e("All Dates","news")?></option>
                    <option <?php if($event_date == 'today') echo'selected="selected"';?> value="today"><?php esc_html_e("Today","news")?></option>
                    <option <?php if($event_date == 'tomorrow') echo'selected="selected"';?> value="tomorrow"><?php esc_html_e("Tomorrow","news")?></option>
                    <option <?php if($event_date == 'this-week') echo'selected="selected"';?> value="this-week"><?php esc_html_e("This Week","news")?></option>
                    <option <?php if($event_date == 'this-weekend') echo'selected="selected"';?> value="this-weekend"><?php esc_html_e("This Weekend","news")?></option>
                    <option <?php if($event_date == 'next-week') echo'selected="selected"';?> value="next-week"><?php esc_html_e("Next Week","news")?></option>
                    <option <?php if($event_date == 'this-month') echo'selected="selected"';?> value="this-month"><?php esc_html_e("This Month","news")?></option>
                    <option <?php if($event_date == 'next-month') echo'selected="selected"';?> value="next-month"><?php esc_html_e("Next Month","news")?></option>
                </select>
                <input type="hidden" name="post_type" value="event" />
                <input type="hidden" class="event-date-value" name="event_date" value="" />
                <input class="submit-event-search-form" type="submit" value="<?php echo esc_attr($search_text)?>">
            </form>
        </div>
        <?php
        $html .= ob_get_clean();
        return $html;
    }
}

stp_reg_shortcode('sv_search_event','sv_vc_search_event');

vc_map( array(
    "name"      => esc_html__("SV Search Event", 'news'),
    "base"      => "sv_search_event",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Search Text",'news'),
            "param_name" => "search_text",
        )
    )
));