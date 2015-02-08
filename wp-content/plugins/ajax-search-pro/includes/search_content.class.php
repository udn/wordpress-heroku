<?php
if (!class_exists('wpdreams_searchContent')) {
    class wpdreams_searchContent extends wpdreams_search {

        protected function do_search() {
            global $wpdb;
            global $q_config;

            $options = $this->options;
            $searchData = $this->searchData;

            $parts = array();
            $relevance_parts = array();
            $types = array();
            $post_types = "";
            $term_query = "";
            $post_statuses = "";

            $s = $this->s; // full keyword
            $_s = $this->_s;    // array of keywords

            $_si = implode('|', $_s); // imploded phrase for regexp
            $_si = $_si!=''?$_si:$s;

            $q_config['language'] = $options['qtranslate_lang'];

            /*------------------------- Statuses ----------------------------*/
            $statuses = array('publish');
            if ($searchData['searchinpending'])
                $statuses[] = 'pending';
            if ($searchData['searchindrafts'])
                $statuses[] = 'draft';
            $words = implode('|', $statuses);
            $post_statuses = "(lower($wpdb->posts.post_status) REGEXP '$words')";
            /*---------------------------------------------------------------*/

            /*----------------------- Gather Types --------------------------*/
            if ($options['set_inposts'] == 1)
                $types[] = "post";
            if ($options['set_inpages'])
                $types[] = "page";
            if (isset($options['customset']) && count($options['customset']) > 0)
                $types = array_merge($types, $options['customset']);
            if (count($types) < 1) {
                return '';
            } else {
                $words = implode('[[:>:]]|[[:<:]]', $types);
                $post_types = "($wpdb->posts.post_type REGEXP '[[:<:]]".$words."[[:>:]]')";
            }
            /*---------------------------------------------------------------*/

            /*----------------------- Title query ---------------------------*/
            if ($options['set_intitle']) {
                $words = $options['set_exactonly']==1?$s:$_si;
                $parts[] = "(lower($wpdb->posts.post_title) REGEXP '$words')";
                $relevance_parts[] = "(case when
                (lower($wpdb->posts.post_title) REGEXP '$words')
                 then $searchData[titleweight] else 0 end)";
                $relevance_parts[] = "(case when
                (lower($wpdb->posts.post_title) REGEXP '$s')
                 then $searchData[etitleweight] else 0 end)"; 
                
                // The first word relevance is higher 
                if (count($_s)>0)
                  $relevance_parts[] = "(case when
                  (lower($wpdb->posts.post_title) REGEXP '".$_s[0]."')
                   then $searchData[etitleweight] else 0 end)";
            }
            /*---------------------------------------------------------------*/

            /*---------------------- Content query --------------------------*/
            if ($options['set_incontent']) {
                $words = $options['set_exactonly']==1?$s:$_si;
                $parts[] = "(lower($wpdb->posts.post_content) REGEXP '$words')";
                $relevance_parts[] = "(case when
                (lower($wpdb->posts.post_content) REGEXP '$words')
                 then $searchData[contentweight] else 0 end)";
                $relevance_parts[] = "(case when
                (lower($wpdb->posts.post_content) REGEXP '$s')
                 then $searchData[econtentweight] else 0 end)";
            }
            /*---------------------------------------------------------------*/

            /*---------------------- Excerpt query --------------------------*/
            if ($options['set_inexcerpt']) {
                $words = $options['set_exactonly']==1?$s:$_si;
                $parts[] = "(lower($wpdb->posts.post_excerpt) REGEXP '$words')";
                $relevance_parts[] = "(case when
                (lower($wpdb->posts.post_excerpt) REGEXP '$words')
                 then $searchData[excerptweight] else 0 end)";
                $relevance_parts[] = "(case when
                (lower($wpdb->posts.post_excerpt) REGEXP '$s')
                 then $searchData[eexcerptweight] else 0 end)";
            }
            /*---------------------------------------------------------------*/

            /*------------------------ Term query ---------------------------*/
            if ($options['searchinterms']) {
                $words = $options['set_exactonly']==1?$s:$_si;
                $parts[] = "(lower($wpdb->terms.name) REGEXP '$words')";
                $relevance_parts[] = "(case when
                (lower($wpdb->terms.name) REGEXP '$words')
                 then $searchData[termsweight] else 0 end)";
                $relevance_parts[] = "(case when
                (lower($wpdb->terms.name) REGEXP '$s')
                 then $searchData[etermsweight] else 0 end)";
            }
            /*---------------------------------------------------------------*/

            /*---------------------- Custom Fields --------------------------*/
            if (isset($searchData['selected-customfields'])) {
                $selected_customfields = $searchData['selected-customfields'];
                if (is_array($selected_customfields) && count($selected_customfields) > 0) {
                    $words = $options['set_exactonly']==1?$s:$_si;
                    foreach ($selected_customfields as $cfield) {
                        $parts[] = "($wpdb->postmeta.meta_key='$cfield' AND
                                   lower($wpdb->postmeta.meta_value) REGEXP '$words')";
                    }
                }
            }
            /*---------------------------------------------------------------*/

            // ------------------------ Categories/taxonomies ----------------------
            if (!isset($options['categoryset']) || $options['categoryset'] == "")
                $options['categoryset'] = array();
            if (!isset($options['termset']) || $options['termset'] == "")
                $options['termset'] = array();

            $exclude_categories = array();
            $searchData['selected-exsearchincategories'] = w_isset_def($searchData['selected-exsearchincategories'], array());
            $searchData['selected-excludecategories'] = w_isset_def($searchData['selected-excludecategories'], array());
            $_all_cat = get_terms('category', array('fields'=>'ids'));
            $_needed_cat = array_diff($_all_cat, $searchData['selected-exsearchincategories']);
            $_needed_cat = !is_array($_needed_cat)?array():$_needed_cat;
            $exclude_categories = array_diff(array_merge($_needed_cat, $searchData['selected-excludecategories']), $options['categoryset']);

            $exclude_terms = array();
            $exclude_showterms = array();
            $searchData['selected-showterms'] = w_isset_def($searchData['selected-showterms'], array());
            $searchData['selected-excludeterms'] = w_isset_def($searchData['selected-excludeterms'], array());
            foreach ($searchData['selected-excludeterms'] as $tax=>$terms) {
                $exclude_terms = array_merge($exclude_terms, $terms);
            }
            foreach ($searchData['selected-showterms'] as $tax=>$terms) {
                $exclude_showterms = array_merge($exclude_showterms, $terms);
            }

            $exclude_terms = array_diff(array_merge($exclude_terms, $exclude_showterms), $options['termset']);

            $all_terms = array();
            $all_terms = array_merge($exclude_categories, $exclude_terms);
            if (count($all_terms) > 0) {
                $words = '--'.implode('--|--', $all_terms).'--';
                $term_query = "HAVING (ttid NOT REGEXP '$words')";
            }
            // ---------------------------------------------------------------------


            /*------------------------ Exclude id's -------------------------*/
            if (isset($searchData['excludeposts']) && $searchData['excludeposts'] != "") {
                $exclude_posts = "($wpdb->posts.ID NOT IN (" . $searchData['excludeposts'] . "))";
            } else {
                $exclude_posts = "($wpdb->posts.ID NOT IN (-55))";
            }
            /*---------------------------------------------------------------*/

            /*------------------------- Build like --------------------------*/
            $like_query = implode(' OR ', $parts);
            if ($like_query == "")
                $like_query = "(1)";
            else {
                $like_query = "($like_query)";
            }
            /*---------------------------------------------------------------*/

            /*---------------------- Build relevance ------------------------*/
            $relevance = implode(' + ', $relevance_parts);
            if ($searchData['userelevance'] != 1 || $relevance == "")
                $relevance = "(1)";
            else {
                $relevance = "($relevance)";
            }
            /*---------------------------------------------------------------*/

            /*------------------------- WPML filter -------------------------*/
            $wpml_join = "";
            if (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE != '' && w_isset_def($searchData['wpml_compatibility'], 1) == 1)
                $wpml_join = "RIGHT JOIN ".$wpdb->base_prefix."icl_translations ON ($wpdb->posts.ID = ".$wpdb->base_prefix."icl_translations.element_id AND ".$wpdb->base_prefix."icl_translations.language_code = '".ICL_LANGUAGE_CODE."')";
            /*---------------------------------------------------------------*/


            $orderby = ((isset($searchData['selected-orderby']) && $searchData['selected-orderby'] != '') ? $searchData['selected-orderby'] : "post_date DESC");
            $querystr = "
    		SELECT 
          $wpdb->posts.post_title as title,
          $wpdb->posts.ID as id,
          $wpdb->posts.post_date as date,               
          $wpdb->posts.post_content as content,
          $wpdb->posts.post_excerpt as excerpt,
          $wpdb->users.user_nicename as author,
          CONCAT('--', GROUP_CONCAT(DISTINCT $wpdb->terms.term_id SEPARATOR '----'), '--') as ttid,
          $wpdb->posts.post_type as post_type,
          $relevance as relevance
    		FROM $wpdb->posts
        LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID
        LEFT JOIN $wpdb->users ON $wpdb->users.ID = $wpdb->posts.post_author
        LEFT JOIN $wpdb->term_relationships ON $wpdb->posts.ID = $wpdb->term_relationships.object_id
        LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id
        LEFT JOIN $wpdb->terms ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id
        $wpml_join
    	WHERE
                $post_types
            AND $post_statuses
            AND $like_query
            AND $exclude_posts
        GROUP BY
          $wpdb->posts.ID
        $term_query
         ";
            $querystr .= " ORDER BY relevance DESC, " . $wpdb->posts . "." . $orderby . "
        LIMIT " . $searchData['maxresults'];

            $pageposts = $wpdb->get_results($querystr, OBJECT);
            //var_dump($querystr);die("!!");
            //var_dump($pageposts);die("!!");

            $this->results = $pageposts;


            return $pageposts;

        }

        protected function post_process() {

            $pageposts = is_array($this->results)?$this->results:array();
            $options = $this->options;
            $searchData = $this->searchData;
            $s = $this->s;
            $_s = $this->_s;


            if (is_multisite()) {
                $home_url = network_home_url();
            } else {
                $home_url = home_url();
            }

            foreach ($pageposts as $k => $v) {
                $r = & $pageposts[$k];
                $r->title = w_isset_def($r->title, null);
                $r->content = w_isset_def($r->content, null);
                $r->image = w_isset_def($r->image, null);
                $r->author = w_isset_def($r->author , null);
                $r->date = w_isset_def($r->date, null);
            }

            /* Images, title, desc */
            foreach ($pageposts as $k => $v) {

                // Let's simplify things
                $r = & $pageposts[$k];

                $r->title = apply_filters('asp_result_title_before_prostproc', $r->title, $r->id);
                $r->content = apply_filters('asp_result_content_before_prostproc', $r->content, $r->id);
                $r->image = apply_filters('asp_result_image_before_prostproc', $r->image, $r->id);
                $r->author = apply_filters('asp_result_author_before_prostproc', $r->author, $r->id);
                $r->date = apply_filters('asp_result_date_before_prostproc', $r->date, $r->id);

                $r->link = get_permalink($v->id);

                $caching_options = w_false_def(get_option('asp_caching'), get_option('asp_caching_def'));

                $use_timthumb = w_isset_def($caching_options['usetimthumb'], 1);

                $image_settings = $searchData['image_options'];

                if ($image_settings['show_images'] != 0) {
                    if ($use_timthumb == 0) {
                        $im = $this->getCachedImage($r);
                        if ($im != '')
                            $r->image = $im;
                    } else {
                        $im = $this->getTimThumbImage($r);
                        if ($im != '' && strpos($im, "mshots/v1") === false)
                            $r->image = $home_url . '/wp-content/plugins/ajax-search-pro/includes/timthumb.php' . '?ct=' . $image_settings['image_transparency'] . '&cc=' . str_replace('#', '', wpdreams_rgb2hex($image_settings['image_bg_color'])) . '&q=95&w=' . $image_settings['image_width'] . '&h=' . $image_settings['image_height']. '&a=' . $image_settings['image_crop_location'] . '&src=' . rawurlencode($im);
                        else
                            $r->image = $im;
                    }
                }


                if (!isset($searchData['titlefield']) || $searchData['titlefield'] == "0" || is_array($searchData['titlefield'])) {
                    $r->title = get_the_title($r->id);
                } else {
                    if ($searchData['titlefield'] == "1") {
                        if (strlen($r->excerpt) >= 200)
                            $r->title = wd_substr_at_word($r->excerpt, 200);
                        else
                            $r->title = $r->excerpt;
                    } else {
                        $mykey_values = get_post_custom_values($searchData['titlefield'], $r->id);
                        if (isset($mykey_values[0])) {
                            $r->title = $mykey_values[0];
                        } else {
                            $r->title = get_the_title($r->id);
                        }
                    }
                }

                if (!isset($searchData['striptagsexclude'])) $searchData['striptagsexclude'] = "<a><span>";

                if (!isset($searchData['descriptionfield']) || $searchData['descriptionfield'] == "0" || is_array($searchData['descriptionfield'])) {
                    if (function_exists('qtrans_getLanguage'))
                        $r->content = apply_filters('the_content', $r->content);
                    $_content = strip_tags($r->content, $searchData['striptagsexclude']);
                } else {
                    if ($searchData['descriptionfield'] == "1") {
                        $_content = strip_tags($r->excerpt, $searchData['striptagsexclude']);
                    } else if ($searchData['descriptionfield'] == "2") {
                        $_content = strip_tags(get_the_title($r->id), $searchData['striptagsexclude']);
                    } else {
                        $mykey_values = get_post_custom_values($searchData['descriptionfield'], $r->id);
                        if (isset($mykey_values[0])) {
                            $_content = strip_tags($mykey_values[0], $searchData['striptagsexclude']);
                        } else {
                            $_content = strip_tags(get_content_w($r->content), $searchData['striptagsexclude']);
                        }
                    }
                }
                if ($_content == "") $_content = $r->content;
                if (isset($searchData['runshortcode']) && $searchData['runshortcode'] == 1) {
                    if ($_content != "") $_content = apply_filters('the_content', $_content);
                    if ($_content != "") $_content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $_content);
                }
                if (isset($searchData['stripshortcode']) && $searchData['stripshortcode'] == 1) {
                    if ($_content != "") $_content = strip_shortcodes($_content);
                }
                $_content = strip_tags($_content, $searchData['striptagsexclude']);

                if ($_content != '' && (strlen($_content) > $searchData['descriptionlength']))
                    $r->content = wd_substr_at_word($_content, $searchData['descriptionlength']) . "...";
                else
                    $r->content = $_content . "...";

                $r->title = apply_filters('asp_result_title_after_prostproc', $r->title, $r->id);
                $r->content = apply_filters('asp_result_content_after_prostproc', $r->content, $r->id);
                $r->image = apply_filters('asp_result_image_after_prostproc', $r->image, $r->id);
                $r->author = apply_filters('asp_result_author_after_prostproc', $r->author, $r->id);
                $r->date = apply_filters('asp_result_date_after_prostproc', $r->date, $r->id);
            }
            
            
            /* !Images, title, desc */
            //var_dump($pageposts); die();
            $this->results = $pageposts;
            return $pageposts;

        }

        protected function group() {

            $pageposts = $this->results;
            $options = $this->options;
            $searchData = $this->searchData;
            $allpageposts = array();
            $s = $this->s;
            $_s = $this->_s;

            if ($options['do_group'] == false) return;

            // Need a suffix to separate blogs
            if (isset($blog)) {
                $_key_suff = "_" . $blog;
            } else {
                $_key_suff = "";
            }
            /* Regrouping */
            // By category
            if ($searchData['groupby'] == 1 && count($pageposts) > 0) {
                $_pageposts = array();
                foreach ($pageposts as $k => $v) {
                    if ($v->term_id == "" || ($v->post_type != 'post' && $searchData['pageswithcategories'] != 1)) {
                        $_pageposts['99999']['data'][] = $v;
                        continue;
                    }
                    $_term_ids = explode(',', $v->term_id);
                    if (count($_term_ids) <= 0) $_term_ids = array($v->term_id);
                    foreach ($_term_ids as $_term_id) {
                        $cat = get_category($_term_id);
                        if (!is_object($cat) || trim($cat->name) == "") {
                            $_pageposts['99999']['data'][] = $v;
                        } else {
                            $_pageposts[$_term_id]['data'][] = $v;
                        }
                    }
                }

                foreach ($_pageposts as $k => $v) {
                    if ($searchData['showpostnumber'] == 1) {
                        $num = " (" . count($_pageposts[$k]['data']) . ")";
                    } else {
                        $num = "";
                    }
                    if ($k != 99999) {
                        $cat = get_category($k);
                        $_pageposts[$k]['name'] = str_replace('%GROUP%', $cat->name, $searchData['groupbytext']) . $num;
                    } else {
                        $_pageposts[$k]['name'] = $searchData['uncategorizedtext'] . $num;
                    }
                }

                $pageposts = null;
                $pageposts['grouped'] = 1;
                $pageposts['items'] = $_pageposts;
                ksort($pageposts['items']);
                if ($_key_suff != "") {
                    foreach ($pageposts['items'] as $k => $v) {
                        $pageposts['items'][$k . $_key_suff] = $v;
                        unset($pageposts['items'][$k]);
                    }
                }
                // By post type
            } else if ($searchData['groupby'] == 2 && count($pageposts) > 0) {
                foreach ($pageposts as $k => $v) {
                    $_pageposts[$v->post_type]['data'][] = $v;
                }
                foreach ($_pageposts as $k => $v) {
                    if ($searchData['showpostnumber'] == 1) {
                        $num = " (" . count($_pageposts[$k]['data']) . ")";
                    } else {
                        $num = "";
                    }
                    $obj = get_post_type_object($k);
                    $_pageposts[$k]['name'] = str_replace('%GROUP%', $obj->labels->singular_name, $searchData['groupbytext']) . $num;
                }
                $pageposts = null;
                $pageposts['grouped'] = 1;
                $pageposts['items'] = $_pageposts;
                ksort($pageposts['items']);
            }

            if (($searchData['groupby'] == 1 || $searchData['groupby'] == 2) && count($pageposts) > 0 && count($allpageposts) > 0)
                $allpageposts['items'] = array_merge($allpageposts['items'], $pageposts['items']);
            else
                $allpageposts = array_merge($allpageposts, $pageposts);

            $this->results = $allpageposts;
            return $this->results;

        }

        /**
         * Fetches an image with the imageCache class
         */
        function getCachedImage($post) {
            if ($post->image == null) {
                $i = 1;
                $im = "";
                for ($i == 1; $i < 6; $i++) {
                    switch ($this->imageSettings['image_source' . $i]) {
                        case "featured":
                            $__im = wp_get_attachment_url(get_post_thumbnail_id($post->id));
                            if ($__im != "") {
                                $img = new wpdreamsImageCache(
                                    $__im, "post" . $post->id,
                                    ASP_PATH . DIRECTORY_SEPARATOR . "cache" . DIRECTORY_SEPARATOR,
                                    $this->imageSettings['image_width'], $this->imageSettings['image_height'],
                                    -1, $this->imageSettings['image_bg_color']
                                );
                                $_im = $img->get_image();
                                if ($_im != '') {
                                    $im = plugins_url('/ajax-search-pro/cache/' . $_im);
                                }
                            }
                            break;
                        case "content":
                            $img = new wpdreamsImageCache(
                                $post->content, "post" . $post->id,
                                ASP_PATH . DIRECTORY_SEPARATOR . "cache" . DIRECTORY_SEPARATOR,
                                $this->imageSettings['image_width'], $this->imageSettings['image_height'],
                                1, $this->imageSettings['image_bg_color']
                            );
                            $_im = $img->get_image();
                            if ($_im != '') {
                                $im = plugins_url('/ajax-search-pro/cache/' . $_im);
                            }
                            break;
                        case "excerpt":
                            $img = new wpdreamsImageCache(
                                $post->excerpt, "post" . $post->id,
                                ASP_PATH . DIRECTORY_SEPARATOR . "cache" . DIRECTORY_SEPARATOR,
                                $this->imageSettings['image_width'], $this->imageSettings['image_height'],
                                1, $this->imageSettings['image_bg_color']
                            );
                            $_im = $img->get_image();
                            if ($_im != '') {
                                $im = plugins_url('/ajax-search-pro/cache/' . $_im);
                            }
                            break;
                        case "screenshot":
                            $im = 'http://s.wordpress.com/mshots/v1/' . urlencode(get_permalink($post->id)) .
                                '?w=' . $this->imageSettings['image_width'] . '&h=' . $this->imageSettings['image_height'];
                            break;
                        case "custom":
                            if ($this->imageSettings['image_custom_field'] != "") {
                                $val = get_post_meta($post->id, $this->imageSettings['image_custom_field'], true);
                                if ($val != null && $val != "")
                                    $im = $val;
                            }
                            break;
                        case "default":
                            if ($this->imageSettings['image_default'] != "")
                                $im = $this->imageSettings['image_default'];
                            break;
                        default:
                            $im = "";
                            break;
                    }
                    if ($im != null && $im != '') break;
                }
                return $im;
            } else {
                return $post->image;
            }
        }

        /**
         * Fetches an image for thimthumb class
         */
        function getTimThumbImage($post) {
            if (!isset($post->image) || $post->image == null) {
                $home_url = network_home_url();
                $home_url = home_url();

                if (!isset($post->id)) return "";
                $i = 1;
                $im = "";
                for ($i == 1; $i < 6; $i++) {
                    switch ($this->imageSettings['image_source' . $i]) {
                        case "featured":
                            $im = wp_get_attachment_url(get_post_thumbnail_id($post->id));
                            if (is_multisite())
                                $im = str_replace(home_url(), network_home_url(), $im);
                            break;
                        case "content":
                            $im = wpdreams_get_image_from_content($post->content, 1);
                            if (is_multisite())
                                $im = str_replace(home_url(), network_home_url(), $im);
                            break;
                        case "excerpt":
                            $im = wpdreams_get_image_from_content($post->excerpt, 1);
                            if (is_multisite())
                                $im = str_replace(home_url(), network_home_url(), $im);
                            break;
                        case "screenshot":
                            $im = 'http://s.wordpress.com/mshots/v1/' . urlencode(get_permalink($post->id)) .
                                '?w=' . $this->imageSettings['image_width'] . '&h=' . $this->imageSettings['image_height'];
                            break;
                        case "custom":
                            if ($this->imageSettings['image_custom_field'] != "") {
                                $val = get_post_meta($post->id, $this->imageSettings['image_custom_field'], true);
                                if ($val != null && $val != "")
                                    $im = $val;
                            }
                            break;
                        case "default":
                            if ($this->imageSettings['image_default'] != "")
                                $im = $this->imageSettings['image_default'];
                            break;
                        default:
                            $im = "";
                            break;
                    }
                    if ($im != null && $im != '') break;
                }
                return $im;
            } else {
                return $post->image;
            }
        }

    }
}
?>