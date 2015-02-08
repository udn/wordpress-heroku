<?php
/*
Plugin Name: Ajax Search Pro 
Plugin URI: http://wp-dreams.com
Description: The most powerful ajax powered search engine for WordPress.
Version: 3.1
Author: Ernest Marcinko
Author URI: http://wp-dreams.com
*/
?>
<?php

define('ASP_PATH', plugin_dir_path(__FILE__));
define('ASP_CSS_PATH', plugin_dir_path(__FILE__)."/css/");
define('ASP_CACHE_PATH', plugin_dir_path(__FILE__)."/cache/");
define('ASP_TT_CACHE_PATH', plugin_dir_path(__FILE__)."/includes/cache/");
define('ASP_DIR', 'ajax-search-pro');
define('ASP_URL',  plugin_dir_url(__FILE__));
define('ASP_CURR_VER', 310);
define('ASP_DEBUG', 0);

global $asp_admin_pages;

$asp_admin_pages = array(
    "ajax-search-pro/backend/settings.php",
    "ajax-search-pro/backend/statistics.php",
    "ajax-search-pro/backend/analytics.php",
    "ajax-search-pro/backend/comp_check.php",
    "ajax-search-pro/backend/fulltext.php",
    "ajax-search-pro/backend/cache_settings.php",
    "ajax-search-pro/backend/compatibility_settings.php"
);

require_once(ASP_PATH . "/includes/asp_init.class.php");
require_once(ASP_PATH . "/functions.php");
require_once(ASP_PATH . "/backend/settings/functions.php");
require_once(ASP_PATH . "/includes/wpdreams-fulltext.class.php");


/* Includes only on ASP ajax requests  */
if (isset($_POST) && isset($_POST['action']) &&
    (
        $_POST['action'] == 'ajaxsearchpro_search' ||
        $_POST['action'] == 'ajaxsearchpro_autocomplete' ||
        $_POST['action'] == 'ajaxsearchpro_preview' ||
        $_POST['action'] == 'ajaxsearchpro_precache' ||
        $_POST['action'] == 'ajaxsearchpro_deletecache' ||
        $_POST['action'] == 'ajaxsearchpro_deletekeyword'
    )
) {
    require_once(ASP_PATH . "/search.php");
    return;
}


$funcs = new aspInit();

/* Includes only on ASP admin pages */
if (wpdreams_on_backend_page($asp_admin_pages) == true) {
    require_once(ASP_PATH . "/backend/settings/types.inc.php");
    require_once(ASP_PATH . "/includes/compatibility.class.php");
    require_once(ASP_PATH . "/compatibility.php");
    add_action('admin_enqueue_scripts', array($funcs, 'scripts'));
}

/* Includes only on full backend, frontend, non-ajax requests */
if (is_admin() || (!is_admin() && !isset($_POST['action_']))) {
    require_once(ASP_PATH . "/backend/settings/default_options.php");
    require_once(ASP_PATH . "/backend/settings/admin-ajax.php");
    require_once(ASP_PATH . "/includes/shortcodes.php");
    require_once(ASP_PATH . "/includes/hooks.php");


    add_action('admin_menu', array($funcs, 'navigation_menu'));
    register_activation_hook(__FILE__, array($funcs, 'ajaxsearchpro_activate'));
    add_action('wp_print_styles', array($funcs, 'styles'));
    add_action('wp_enqueue_scripts', array($funcs, 'scripts'));
    add_action('wp_footer', array($funcs, 'footer'));
}

/* Includes on Post/Page/Custom post type edit pages */
if (wpdreams_on_backend_post_editor()) {
    require_once(ASP_PATH . "/backend/settings/types.inc.php");
    require_once(ASP_PATH . "/backend/tinymce/buttons.php");
}

require_once(ASP_PATH . "/includes/widgets.php");
