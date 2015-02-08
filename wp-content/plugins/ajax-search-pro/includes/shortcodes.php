<?php
add_shortcode('wpdreams_ajaxsearchpro_results', 'add_ajaxsearchpro_results');
add_shortcode( 'wpdreams_ajaxsearchpro', array( aspShortcodeContainer::get_instance(), 'wpdreams_asp_shortcode' ) );

class aspShortcodeContainer {

    protected static $instance = NULL;
    private static $instanceCount = 0;

    public static function get_instance() {
        // create an object
        NULL === self::$instance and self::$instance = new self;
        return self::$instance; // return the object
    }

    function wpdreams_asp_shortcode($atts) {
        $style = null;
        self::$instanceCount++;

        extract(shortcode_atts(array(
            'id' => 'something'
        ), $atts));
        if (isset($_POST['action']) && $_POST['action'] == "ajaxsearchpro_preview") {
            require_once(ASP_PATH . "backend" . DIRECTORY_SEPARATOR . "settings" . DIRECTORY_SEPARATOR . "types.inc.php");
            parse_str($_POST['formdata'], $style);
            $file = ASP_PATH . DIRECTORY_SEPARATOR . "css" . DIRECTORY_SEPARATOR . "style-preview" . $id . ".css";
            ob_start();
            include(ASP_PATH . "/css/style.css.php");
            $out = ob_get_contents();
            ob_end_clean();
            file_put_contents($file, $out, FILE_TEXT);
            ?>
            <style>
                @import url('<?php echo plugin_dir_url(__FILE__); ?>../css/style.basic.css?r=<?php echo rand(1, 123123123); ?>');
                @import url('<?php echo plugin_dir_url(__FILE__); ?>../css/style-preview<?php echo $id; ?>.css?r=<?php echo rand(1, 123123123); ?>');
            </style>
        <?php
        } else {
            global $wpdb;
            if (isset($wpdb->base_prefix)) {
                $_prefix = $wpdb->base_prefix;
            } else {
                $_prefix = $wpdb->prefix;
            }
            $search = $wpdb->get_results("SELECT * FROM " . $_prefix . "ajaxsearchpro WHERE id=" . $id, ARRAY_A);
            if (!isset($search[0])) {
                echo "This search form does not exist!";
                $return = ob_get_clean();
                return $return;
            }
            if (isset($search[0]['id']) && isset($wpdreams_ajaxsearchpros[$search[0]['id']])) {
                echo "This search form is already on the page! You cannot use the same form twice on one page!";
                $return = ob_get_clean();
                return $return;
            }
            $wpdreams_ajaxsearchpros[$search[0]['id']] = 1;

            $search[0]['data'] = json_decode($search[0]['data'], true);
            $style = $search[0]['data'];
        }

        $def_data = get_option('asp_defaults');
        $style = array_merge($def_data, $style);


        $settingsHidden = ((
            w_isset_def($style['show_frontend_search_settings'], 1) != 1 ||
            (
              $style['showexactmatches'] != 1 &&
              $style['showsearchintitle'] != 1 &&
              $style['showsearchincontent'] != 1 &&
              $style['showsearchinexcerpt'] != 1 &&
              $style['showsearchinposts'] != 1 &&
              $style['showsearchinpages'] != 1 &&
              $style['showsearchinbpusers'] != 1 &&
              $style['showsearchinbpgroups'] != 1 &&
              $style['showsearchinbpforums'] != 1 &&
              count($style['selected-showcustomtypes']) <= 0
            )
        ) ? true : false);



        do_action('asp_layout_before_shortcode', $id);

        $out = "";
        ob_start();
        include(ASP_PATH."includes/views/asp.shortcode.php");
        $out = ob_get_clean();

        do_action('asp_layout_after_shortcode', $id);

        return $out;
    }
}

function add_ajaxsearchpro_results( $atts ) {
    extract( shortcode_atts( array(
        'id' => '0',
        'element' => 'div'
    ), $atts ) );
    if ($id == 0) return;
    return "<".$element." id='wpdreams_asp_results_".$id."'></".$element.">";
}