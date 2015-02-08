<?php

// Override the default search hook, posts_results 

function asp_search_filter_posts($posts, $wp_query) {

    if (!$wp_query->is_search())
        return $posts;

    if (empty($wp_query->query_vars['s']) || !isset($_GET['asp_data'])) return $posts;

    parse_str(base64_decode($_GET['asp_data']), $s_data);

    $_POST['options'] = $s_data;
    $_POST['asid'] = $s_data['asid'];
    $_POST['aspp'] = $_GET['s'];
    $_POST['asp_get_as_array'] = 1;

    $post_ids = array();

    require_once(ASP_PATH . '/search.php');

    $res = ajaxsearchpro_search();
    foreach ($res as $k => $v) {
        if (isset($v->post_type))
            $post_ids[] = $v->id;
    }

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $posts_per_page = (int)get_option('posts_per_page');

    $mod_post_ids = array_slice($post_ids, (($paged - 1) * $posts_per_page), $posts_per_page);

    $n_posts = get_posts(array(
        'posts_per_page' => $posts_per_page,
        'post__in' => $mod_post_ids,
        'orderby' => 'post__in',
        'ignore_sticky_posts' => true,
        'post_type' => 'any'
    ));

    $wp_query->found_posts = count($post_ids);
    $wp_query->max_num_pages = floor($wp_query->found_posts / $posts_per_page) + 1;

    return $n_posts;
}

add_filter('posts_results', 'asp_search_filter_posts', 1, 2);


function asp_order_posts($posts, $order) {
    $result = array();
    foreach ($order as $id) {
        $i = 0;
        foreach ($posts as $post) {
            if ($post->ID == $id) {
                array_push($result, $post);
                unset($posts[$i]);
                $posts = array_values($posts);
            }
            $i++;
        }
    }
    return $result;
}

function wpdreams_asp_echo_out() {
    global $asp_head_out;
    ?>
    <style type="text/css" xmlns="http://www.w3.org/1999/html">
        <?php echo $asp_head_out; ?>
    </style>
<?php
}

function search_stylesheets() {
    global $wpdb;
    global $asp_head_out;

    $comp_settings = get_option('asp_compatibility');
    $force_inline = w_isset_def($comp_settings['forceinlinestyles'], false);

    wp_enqueue_style('wpdreams_animations', plugins_url('css/animations.css', dirname(__FILE__)), false);
    wp_register_style('wpdreams-asp-basic', ASP_URL . 'css/style.basic.css', true);
    wp_enqueue_style('wpdreams-asp-basic');

    if (isset($wpdb->base_prefix)) {
        $_prefix = $wpdb->base_prefix;
    } else {
        $_prefix = $wpdb->prefix;
    }
    $search = $wpdb->get_results("SELECT * FROM " . $_prefix . "ajaxsearchpro", ARRAY_A);
    if (is_array($search)) {
        foreach ($search as $s) {

            if ($force_inline == 1) {
                $s['data'] = json_decode($s['data'], true);
                $style = $s['data'];
                $id = $s['id'];
                ob_start();
                include(ASP_PATH . "/css/style.css.php");
                $out = ob_get_contents();
                $asp_head_out .= $out;
                ob_end_clean();

            } else {
                wp_enqueue_style('wpdreams-ajaxsearchpro' . $s['id'], plugins_url('css/style' . $s['id'] . '.css', dirname(__FILE__)), false);
            }

        }

        if ($force_inline == 1)
            add_action('wp_head', 'wpdreams_asp_echo_out', 10, 0);
    }
}

add_action('wp_print_styles', 'search_stylesheets');