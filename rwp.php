<?php 

/**
* Create a container HTMLElement with compoenent (meta)data
*/
if ( !function_exists( 'rwp_render_component' ) ) :
    function rwp_render_component($element = 'div', $component, $content=null, $title=null){
        if ($element == null || $component == null)
            exit();

        $data_component_attr = 'data-component="'. $component .'"';
        $data_content_attr = 'data-content="'. $content .'"';
        $data_title_attr = $title ? 'data-title="'. $title .'"' : null;

        echo '<'.$element.' '. $data_component_attr .' '. $data_content_attr  .' '. $data_title_attr .'></'. $element .'>';
    }
endif;

/**
* Returns parsed content
*/
if ( !function_exists( 'rwp_get_the_content' ) ) :
    // http://www.web-templates.nu/2008/08/31/get_the_content-with-formatting/index.html    

    function rwp_get_the_content ($with_formatting=true, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
        $content = get_the_content($more_link_text, $stripteaser, $more_file);
        if ($with_formatting!=false){        
            $the_content = apply_filters('the_content', $content);
            // $content = str_replace(']]>', ']]&gt;', $content);

            // $content = htmlspecialchars($content);
            // $content = escape_html_markup($content);
        }
        return $the_content;
    }
endif;

/**
 * Returns the page title
 */
if ( !function_exists( 'rwp_get_the_title' ) ) :
    function rwp_get_the_title () {
        $the_title = get_the_title();        
        return $the_title;
    }
endif;

/**
 * Renders WordPress theme navigation
 * https://developer.wordpress.org/reference/functions/wp_nav_menu/
*/
if ( !function_exists( 'rwp_get_nav' ) ) :
    function rwp_get_nav($menu_name, $return_html=false) {
       /*  $content = get_the_content($more_link_text, $stripteaser, $more_file);
        if ($with_formatting!=false){        
            $content = apply_filters('the_content', $content);
            // $content = str_replace(']]>', ']]&gt;', $content);
            $content = htmlspecialchars($content);
        }
        return $content; */

        /* wp_nav_menu( array( 
            'theme_location' => 'secondary_menu',      								
            'items_wrap' => '<ul class="list list-inline">%3$s</ul>')
        );  */

        if ($menu_name != null){
            if ($return_html===true){                
                return parse_and_escape( wp_nav_menu( array( 
                    'echo' =>false,
                    'theme_location' => $menu_name,      								
                    // 'items_wrap' => '<ul>%3$s</ul>'
                    )
                )); 
            }
            else{
                $locations = get_nav_menu_locations();
                $menu_id = $locations[ $menu_name ];                
                $nav_menu = wp_get_nav_menu_items($menu_id);
                $rwp_posts = array();

                foreach ( $nav_menu as $nav_menu_item ){

                    $menu_item = array(
                        // 'id' => $nav_menu_item->ID,
                        'id' => $nav_menu_item->object_id,
                        'title' => $nav_menu_item->title,
                        'url'=> $nav_menu_item->url,
                        'parentID'=> $nav_menu_item->menu_item_parent,
                        'children'=>array(),
                        // '_meta'=> get_post_meta($nav_menu_item->ID/* '_menu_item_object_id', true */ ),
                        '_nav'=> $nav_menu_item,                            
                    );

                    if ($nav_menu_item->menu_item_parent>0):
                        array_push( 
                            // $rwp_posts[(count($rwp_posts)-1)], 
                            $rwp_posts[(count($rwp_posts)-1)][children], 
                            $menu_item
                        );
                    
                    else:
                        array_push( 
                            $rwp_posts, $menu_item
                        ); 
                    endif;
                    
                }
                
                return $rwp_posts;      
            }
        }
    }
endif;


/* HELPER FUNCTIONS */

/**
 * Parse (Encode) JSON string
 */
if ( !function_exists( 'json_parse' ) ) :
    function json_parse($json_string){
        return json_encode($json_string);
    }
endif;

/**
 * Escape html markup special chars
 */
if ( !function_exists( 'escape_html_markup' ) ) :
    function escape_html_markup($json_object){
        return htmlspecialchars ( $json_object, ENT_QUOTES, 'UTF-8' );
    }
endif;

/**
 * Parse array, and escape HTML
 */
if ( !function_exists( 'parse_and_escape' ) ) :
    function parse_and_escape($array){
        $parsed_json = json_parse($array);
        return escape_html_markup( $parsed_json );
    }
endif;    

/**
 * Truncate Text
 * https://stackoverflow.com/questions/9219795/truncating-text-in-php#answer-9219884
  */
if ( !function_exists( 'rwp_truncate_text' ) ) :
    function rwp_truncate_text($text, $chars = 90) {
        if (strlen($text) <= $chars) {
            return $text;
        }
        $text = $text." ";
        $text = substr($text,0,$chars);
        $text = substr($text,0,strrpos($text,' '));
        $text = $text."...";
        return $text;
    }
endif;    

?>