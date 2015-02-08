<?php
if (!class_exists('wpdreams_searchBuddyPress')) {
    class wpdreams_searchBuddyPress extends wpdreams_search {

        protected function do_search() {
            global $wpdb;

            if (isset($wpdb->base_prefix)) {
                $_prefix = $wpdb->base_prefix;
            } else {
                $_prefix = $wpdb->prefix;
            }

            $options = $this->options;
            $searchData = $this->searchData;
            $s = $this->s; // full keyword
            $_s = $this->_s;    // array of keywords

            $_si = implode('|', $_s); // imploded phrase for regexp
            $_si = $_si!=''?$_si:$s;

            $repliesresults = array();
            $userresults = array();
            $groupresults = array();
            $activityresults = array();

            if (function_exists('bp_core_get_user_domain')) {
                /* BP users */
                $like = "";
                if ($searchData['search_in_bp_users']) {
                    if ($options['set_exactonly'] != 1) {
                        $sr = implode("%' OR lower($wpdb->users.display_name) like '%", $_s);
                        if ($like != "") {
                            $sr = " OR lower($wpdb->users.display_name) like '%" . $sr . "%'";
                        } else {
                            $sr = " lower($wpdb->users.display_name) like '%" . $sr . "%'";
                        }
                    } else {
                        if ($like != "") {
                            $sr = " OR lower($wpdb->users.display_name) like '%" . $s . "%'";
                        } else {
                            $sr = " lower($wpdb->users.display_name) like '%" . $s . "%'";
                        }
                    }
                    $like .= $sr;

                    $querystr = "
                       SELECT
                         $wpdb->users.ID as id,
                         $wpdb->users.display_name as title,
                         '' as date,
                         '' as author
                       FROM
                         $wpdb->users
                       WHERE
                        (" . $like . ")
                    ";

                    $userresults = $wpdb->get_results($querystr, OBJECT);
                    foreach ($userresults as $k => $v) {
                        $userresults[$k]->link = bp_core_get_user_domain($v->id);
                        if ($searchData['image_options']['show_images'] == 1) {
                            $im = bp_core_fetch_avatar(array('item_id' => $userresults[$k]->id, 'html' => false));
                            if ($im != '') {
                                $userresults[$k]->image = $im;
                            }
                        }
                        $update = get_user_meta($v->id, 'bp_latest_update', true);
                        if (is_array($update) && isset($update['content']))
                            $userresults[$k]->content = $update['content'];
                        if ($userresults[$k]->content != '') {
                            $userresults[$k]->content = wd_substr_at_word(strip_tags($userresults[$k]->content), $searchData['descriptionlength']) . "...";
                        } else {
                            $userresults[$k]->content = "";
                        }

                    }
                }
                /* BP groups */
                $like = "";
                if ($searchData['search_in_bp_groups'] && bp_is_active('groups')) {
                    if ($options['set_exactonly'] != 1) {
                        $sr = implode("%' OR lower(" . $wpdb->prefix . "bp_groups.name) like '%", $_s);
                        if ($like != "") {
                            $sr = " OR lower(" . $wpdb->prefix . "bp_groups.name) like '%" . $sr . "%'";
                        } else {
                            $sr = " lower(" . $wpdb->prefix . "bp_groups.name) like '%" . $sr . "%'";
                        }
                    } else {
                        if ($like != "") {
                            $sr = " OR lower(" . $wpdb->prefix . "bp_groups.name) like '%" . $s . "%'";
                        } else {
                            $sr = " lower(" . $wpdb->prefix . "bp_groups.name) like '%" . $s . "%'";
                        }
                    }
                    $like .= $sr;
                    if ($options['set_exactonly'] != 1) {
                        $sr = implode("%' OR lower(" . $wpdb->prefix . "bp_groups.description) like '%", $_s);
                        if ($like != "") {
                            $sr = " OR lower(" . $wpdb->prefix . "bp_groups.description) like '%" . $sr . "%'";
                        } else {
                            $sr = " lower(" . $wpdb->prefix . "bp_groups.description) like '%" . $sr . "%'";
                        }
                    } else {
                        if ($like != "") {
                            $sr = " OR lower(" . $wpdb->prefix . "bp_groups.description) like '%" . $s . "%'";
                        } else {
                            $sr = " lower(" . $wpdb->prefix . "bp_groups.description) like '%" . $s . "%'";
                        }
                    }
                    $like .= $sr;
                    if (isset($searchData['searchinbpprivategroups']) && $searchData['searchinbpprivategroups'] == 0) {
                        $_and = "AND " . $wpdb->prefix . "bp_groups.status = 'public'";
                    } else {
                        $_and = "";
                    }
                    $querystr = "
             SELECT
               " . $wpdb->prefix . "bp_groups.id as id,
               " . $wpdb->prefix . "bp_groups.name as title,
               " . $wpdb->prefix . "bp_groups.description as content,
               " . $wpdb->prefix . "bp_groups.date_created as date,
               $wpdb->users.user_nicename as author             
             FROM
               " . $wpdb->prefix . "bp_groups
             LEFT JOIN $wpdb->users ON $wpdb->users.ID = " . $wpdb->prefix . "bp_groups.creator_id
             WHERE 
              (" . $like . ")
              " . $_and; //AND ".$wpdb->prefix."bp_groups.status = 'public'

                    $groupresults = $wpdb->get_results($querystr, OBJECT);
                    foreach ($groupresults as $k => $v) {
                        $group = new BP_Groups_Group($v->id);
                        $groupresults[$k]->link = bp_get_group_permalink($group);
                        if ($searchData['image_options']['show_images'] == 1) {
                            $avatar_options = array('item_id' => $v->id, 'object' => 'group', 'type' => 'full', 'html' => false);
                            $im = bp_core_fetch_avatar($avatar_options);

                            if ($im != '') {
                                $groupresults[$k]->image = $im;
                            }
                        }
                        if ($groupresults[$k]->content != '')
                            $groupresults[$k]->content = wd_substr_at_word(strip_tags($groupresults[$k]->content), $searchData['descriptionlength']) . "...";
                    }
                }

                if ($searchData['search_in_bp_activities'] && bp_is_active('groups')) {
                    /*---------------------- Content query --------------------------*/
                    $words = $options['set_exactonly'] == 1 ? $s : $_si;
                    $parts[] = "(lower(" . $wpdb->prefix . "bp_activity.content) REGEXP '$words')";
                    /*---------------------------------------------------------------*/

                    $like_query = implode(' OR ', $parts);
                    if ($like_query == "")
                        $like_query = "(1)";
                    else {
                        $like_query = "($like_query)";
                    }

                    $querystr = "
                 SELECT
                   " . $wpdb->prefix . "bp_activity.id as id,
                   " . $wpdb->prefix . "bp_activity.content as title,
                   " . $wpdb->prefix . "bp_activity.content as content,
                   " . $wpdb->prefix . "bp_activity.date_recorded as date,
                   $wpdb->users.user_nicename as author,
                   " . $wpdb->prefix . "bp_activity.user_id as author_id
                 FROM
                   " . $wpdb->prefix . "bp_activity
                 LEFT JOIN $wpdb->users ON $wpdb->users.ID = " . $wpdb->prefix . "bp_activity.user_id
                 WHERE
                   (" . $wpdb->prefix . "bp_activity.component = 'activity' AND " . $wpdb->prefix . "bp_activity.is_spam = 0)
                   AND $like_query";

                    $activityresults = $wpdb->get_results($querystr, OBJECT);

                    foreach ($activityresults as $k=>$v) {
                        $activityresults[$k]->link = bp_activity_get_permalink( $v->id );
                        $activityresults[$k]->image = bp_core_fetch_avatar(array('item_id' => $v->author_id, 'html' => false));
                    }
                }


                do_action('bbpress_init');
            }

            $this->results = array(
                'repliesresults' => $repliesresults,
                'groupresults' => $groupresults,
                'userresults' => $userresults,
                'activityresults' => $activityresults
            );
            return $this->results;
        }

    }
}
?>