<?php 

/**
* Create a container HTMLElement with compoenent (meta)data
*/
if ( !function_exists( 'rwp_render_component' ) ) :
    function rwp_render_component($element = 'div', $component, $content, $title){
        if ($element == null || $component == null)
            exit();

        $data_component_attr = 'data-component="'. $component .'"';
        $data_content_attr = 'data-content="'. $content .'"';
        $data_title_attr = $title ? 'data-title="'. $title .'"' : null;

        echo '<'.$element.' '. $data_component_attr .' '. $data_content_attr  .' '. $data_title_attr .'></'. $element .'>';
    }
endif;

/**
* Renders parsed content
*/
if ( !function_exists( 'rwp_get_the_content' ) ) :
    // http://www.web-templates.nu/2008/08/31/get_the_content-with-formatting/index.html    

    function rwp_get_the_content ($with_formatting=true, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
        $content = get_the_content($more_link_text, $stripteaser, $more_file);
        if ($with_formatting!=false){        
            $content = apply_filters('the_content', $content);
            // $content = str_replace(']]>', ']]&gt;', $content);

            // $content = htmlspecialchars($content);
            $content = escape_html_markup($content);
        }
        return $content;
    }
endif;

/**
* Renders WordPress theme navigation
*/
if ( !function_exists( 'rwp_get_nav' ) ) :
    function rwp_get_nav ($menu_name) {
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
            $locations = get_nav_menu_locations();
            $menu_id = $locations[ $menu_name ];
            return wp_get_nav_menu_items($menu_id);                        
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


?>