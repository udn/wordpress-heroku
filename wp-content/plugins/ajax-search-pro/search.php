<?php   
  add_action('wp_ajax_nopriv_ajaxsearchpro_autocomplete', 'ajaxsearchpro_autocomplete');
  add_action('wp_ajax_ajaxsearchpro_autocomplete', 'ajaxsearchpro_autocomplete');
  add_action('wp_ajax_nopriv_ajaxsearchpro_search', 'ajaxsearchpro_search');
  add_action('wp_ajax_ajaxsearchpro_search', 'ajaxsearchpro_search');
  add_action('wp_ajax_ajaxsearchpro_preview', 'ajaxsearchpro_preview');
  add_action('wp_ajax_ajaxsearchpro_precache', 'ajaxsearchpro_precache');
  add_action('wp_ajax_ajaxsearchpro_deletecache', 'ajaxsearchpro_deletecache');
  
  require_once(ASP_PATH."/includes/suggest.class.php");
  require_once(ASP_PATH."/includes/imagecache.class.php");
  require_once(ASP_PATH."/includes/textcache.class.php");
  //require_once(ASP_PATH."/backend/settings/types.inc.php");
  
  require_once(ASP_PATH."/includes/search.class.php");
  require_once(ASP_PATH."/includes/search_blogs.class.php");
  require_once(ASP_PATH."/includes/search_content.class.php");
  require_once(ASP_PATH."/includes/search_content_fulltext.class.php");
  require_once(ASP_PATH."/includes/search_demo.class.php");
  require_once(ASP_PATH."/includes/search_comments.class.php");
  require_once(ASP_PATH."/includes/search_buddypress.class.php");

    if (!function_exists('wpd_adv_title')) {
        function wpd_adv_title($title, $id) {
            global $search;
            $titlefield = $search['data']['advtitlefield'];
            if ($titlefield=='') return $title;
            preg_match_all( "/{(.*?)}/", $titlefield, $matches);
            if (isset($matches[0]) && isset($matches[1]) && is_array($matches[1])) {
                foreach ($matches[1] as $field) {
                    if ($field=='titlefield') {
                        $titlefield = str_replace('{titlefield}', $title, $titlefield);
                    } else {
                        $val = get_post_meta($id, $field, true);
                        $titlefield = str_replace('{'.$field.'}', $val, $titlefield);
                    }
                }
            }
            return $titlefield;
        }
    }

    if (!function_exists('wpd_adv_desc')) {
        function wpd_adv_desc($desc, $id) {
            global $search;
            $descfield = $search['data']['advdescriptionfield'];
            if ($descfield=='') return $desc;
            preg_match_all( "/{(.*?)}/", $descfield, $matches);
            if (isset($matches[0]) && isset($matches[1]) && is_array($matches[1])) {
                foreach ($matches[1] as $field) {
                    if ($field=='descriptionfield') {
                        $descfield = str_replace('{descriptionfield}', $desc, $descfield);
                    } else {
                        $val = get_post_meta($id, $field, true);
                        $descfield = str_replace('{'.$field.'}', $val, $descfield);
                    }
                }
            }
            return $descfield;
        }
    }

if (!function_exists('ajaxsearchpro_search')) {
  function ajaxsearchpro_search() {
  	global $wpdb;
    global $switched;
    global $search;
    
    /*print "in ajaxsearchpro_search();";
    print_r(array()); return;  */
      
    $s = $_POST['aspp'];
    $s = apply_filters( 'asp_search_phrase_before_cleaning', $s );

    $s = strtolower(trim($s));
    $s = preg_replace( '/\s+/', ' ', $s);
    
    $s = apply_filters( 'asp_search_phrase_after_cleaning', $s );
                                               
    $stat = get_option("asp_stat");
    if (isset($wpdb->base_prefix)) {
      $_prefix = $wpdb->base_prefix;
    } else {
      $_prefix = $wpdb->prefix;
    }      
    if ($stat==1) {
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      $in = $wpdb->query("UPDATE ".$_prefix."ajaxsearchpro_statistics SET num=num+1, last_date=".time()." WHERE (keyword='".$s."' AND search_id=".$_POST['asid'].")");	 
      if ($in==false) {
      	dbDelta("INSERT INTO ".$_prefix."ajaxsearchpro_statistics (search_id, keyword, num, last_date) VALUES (".$_POST['asid'].", '".$s."', 1, ".time().")");
      }
    }

    $def_data = get_option('asp_defaults');
    $search = $wpdb->get_row("SELECT * FROM ".$_prefix."ajaxsearchpro WHERE id=".$_POST['asid'], ARRAY_A);
    $search['data'] = json_decode($search['data'], true);
    $search['data'] = array_merge($def_data, $search['data']);

      $search['data']['image_options'] = array(
          'show_images' => $search['data']['show_images'],
          'image_bg_color' => $search['data']['image_bg_color'],
          'image_transparency' => $search['data']['image_transparency'],
          'image_crop_location' => w_isset_def($search['data']['image_crop_location'], "c"),
          'image_width' => $search['data']['image_width'],
          'image_height' => $search['data']['image_height'],
          'image_source1' => $search['data']['image_source1'],
          'image_source2' => $search['data']['image_source2'],
          'image_source3' => $search['data']['image_source3'],
          'image_source4' => $search['data']['image_source4'],
          'image_source5' => $search['data']['image_source5'],
          'image_default' => $search['data']['image_default'],
          'image_custom_field' => $search['data']['image_custom_field']
      );
      
      if (isset($_POST['asp_get_as_array']))
        $search['data']['image_options']['show_images'] = 0;

      // ----------------- Recalculate image width/height ---------------
      switch ($search['data']['resultstype']) {
          case "horizontal":
              /* Same width as height */
              $search['data']['image_options']['image_width'] = wpdreams_width_from_px($search['data']['image_options']['hreswidth']);
              $search['data']['image_options']['image_height'] = wpdreams_width_from_px($search['data']['image_options']['hreswidth']);
              break;
          case "polaroid":
              $search['data']['image_options']['image_width'] = intval($search['data']['preswidth']);
              $search['data']['image_options']['image_height'] = intval($search['data']['preswidth']);
              break;
          case "isotopic":
              $search['data']['image_options']['image_width'] = intval($search['data']['i_item_width'] * 1.5);
              $search['data']['image_options']['image_height'] = intval($search['data']['i_item_height'] * 1.5);
              break;
      }

    if (isset($search['data']['selected-imagesettings'])) {
      $search['data']['settings-imagesettings'] = $search['data']['selected-imagesettings'];
    } 
    /*if (isset($search) && $search['data']['exactonly']!=1) {
      $_s = explode(" ", $s);
    }*/                                   
    if (isset($_POST['options'])) {
      if (is_array($_POST['options']))
        $search['options'] = $_POST['options'];
      else
        parse_str($_POST['options'], $search['options']);   
    }
    //Advanced title and description fields
    
    add_filter('asp_result_title_after_prostproc', 'wpd_adv_title', 1, 2);
    add_filter('asp_result_content_after_prostproc', 'wpd_adv_desc', 1, 2);


    $blogresults = array();
    
    $allbuddypresults = array(
      'repliesresults' => array(),
      'groupresults' => array(),
      'userresults' => array(),
      'activityresults' => array()
    );

    $allpageposts = array();
    $pageposts = array();
    $repliesresults = array();
    $allcommentsresults = array();
    $commentsresults = array();
    
    if (!isset($search['data']['selected-blogs']) || $search['data']['selected-blogs']==null || count($search['data']['selected-blogs'])<=0) {
      $search['data']['selected-blogs'] = array(0=>1);
    }
    
    do_action('asp_before_search', $s);   
  
    $caching_options = w_false_def(get_option('asp_caching'), get_option('asp_caching_def'));

    if (w_isset_def($caching_options['caching'], 0) && ASP_DEBUG!=1) {
      $filename = ASP_PATH.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR.md5(json_encode($search['options']).$s).".wp";
      $textcache = new wpdreamsTextCache($filename, w_isset_def($caching_options['cachinginterval'], 3600)*60);
      $cache_content = $textcache->getCache();
      if ($cache_content!=false) {
        $cache_content = apply_filters( 'asp_cached_content_json', $cache_content);
        do_action('asp_after_search', $s, json_decode($cache_content, true));
        print "cached(".date ("F d Y H:i:s.", filemtime($filename)).")";
        print_r($cache_content);
        die;
      }
    }
    


    foreach ($search['data']['selected-blogs'] as $blog) {
      if (is_multisite()) switch_to_blog($blog);
      if ($_POST['asid']=="") {
        $_dposts = new wpdreams_searchDemo(array());
        $dpageposts =  $_dposts->search($s); 
        $allpageposts = array_merge($allpageposts, $dpageposts);      
      } else {
        $params = array('data'=>$search['data'], 'options'=>$search['options']);

        $ful_options = get_option('asp_fulltexto');

        if (get_option('asp_fulltext') && w_isset_def($ful_options['dbusefulltext'], 1))
          $_posts = new wpdreams_searchContentFulltext($params);
        else 
          $_posts = new wpdreams_searchContent($params);
        $pageposts =  $_posts->search($s);
          //var_dump($pageposts);die();
        $allpageposts = array_merge($allpageposts, $pageposts);
        
        do_action('asp_after_pagepost_results', $s, $pageposts);
  
        $_comments = new wpdreams_searchComments($params);
        $commentsresults =  $_comments->search($s);
        $allcommentsresults = array_merge($allcommentsresults, $commentsresults);
        
        do_action('asp_after_comments_results', $s, $commentsresults);
                
        $_buddyp = new wpdreams_searchBuddyPress($params);
        $buddypresults =  $_buddyp->search($s);      // !!! returns array for each result (group, user, reply) !!!
        foreach ($buddypresults as $k=>$v) {
          $allbuddypresults[$k] = array_merge($allbuddypresults[$k], $v);
        }
        
        do_action('asp_after_buddypress_results', $s, $buddypresults);      
      }

       
    }

    if (is_multisite()) restore_current_blog();    

    $_blogs = new wpdreams_searchBlogs($params);
    $blogresults =  $_blogs->search($s);
    
    $allpageposts = apply_filters( 'asp_pagepost_results', $allpageposts );
    $allcommentsresults = apply_filters( 'asp_comment_results', $allcommentsresults );
    $buddypresults = apply_filters( 'asp_buddyp_results', $buddypresults );      
    $blogresults = apply_filters( 'asp_blog_results', $blogresults );
    
    
    /* Remove the results in polaroid mode */
    if ($search['data']['resultstype']=='polaroid' && $search['data']['pifnoimage'] == 'removeres') {
      foreach($allpageposts as $_k=>$_v) {
         if ($_v->image==null || $_v->image=='')
          unset($allpageposts[$_k]);
      }
      foreach($allcommentsresults as $_k=>$_v) {
         if ($_v->image==null || $_v->image=='')
          unset($allcommentsresults[$_k]);
      }
      foreach($buddypresults as $_k=>$_v) {
         if ($_v->image==null || $_v->image=='')
          unset($buddypresults[$_k]);
      }
      foreach($blogresults as $_k=>$_v) {
         if ($_v->image==null || $_v->image=='')
          unset($blogresults[$_k]);
      }
    }

    // Grouping again
    if ($search['data']['resultstype'] == 'vertical' && ($search['data']['groupby']==1 || $search['data']['groupby']==2)) {
    
       $results = $allpageposts;

       if (!isset($results['items']) && count($allpageposts)>0) {
          $results['items'] = array();
          $results['grouped'] = 1;
       }
       
       if (count($blogresults)>0) {
         if ($search['data']['showpostnumber']==1) {
          $num = " (".count($blogresults).")";
         } else {
          $num = "";
         }
         $results['items'][90000] = array();
         $results['items'][90000]['name'] = $search['data']['blogresultstext'].$num;
         $results['items'][90000]['data'] = $blogresults;
         $results['grouped'] = 1;
       }
       
       $repliesresults = $allbuddypresults['repliesresults'];
       if (count($repliesresults)>0) {
         if ($search['data']['showpostnumber']==1) {
          $num = " (".count($repliesresults).")";
         } else {
          $num = "";
         }
         $results['items'][90001] = array();
         $results['items'][90001]['name'] = $search['data']['bbpressreplytext'].$num;
         $results['items'][90001]['data'] = $repliesresults;
         $results['grouped'] = 1;
       }
       
       if (count($allcommentsresults)>0) {
         if ($search['data']['showpostnumber']==1) {
          $num = " (".count($allcommentsresults).")";
         } else {
          $num = "";
         }
         $results['items'][90002] = array();
         $results['items'][90002]['name'] = $search['data']['commentstext'].$num;
         $results['items'][90002]['data'] = $allcommentsresults;
         $results['grouped'] = 1;
       }
       
       $groupresults = $allbuddypresults['groupresults'];
       if (count($groupresults)>0) {
         if ($search['data']['showpostnumber']==1) {
          $num = " (".count($groupresults).")";
         } else {
          $num = "";
         }
         $results['items'][90003] = array();
         $results['items'][90003]['name'] = $search['data']['bbpressgroupstext'].$num;
         $results['items'][90003]['data'] = $groupresults;
         $results['grouped'] = 1;
       }
       
       $userresults = $allbuddypresults['userresults'];
       if (count($userresults)>0) {
         if ($search['data']['showpostnumber']==1) {
          $num = " (".count($userresults).")";
         } else {
          $num = "";
         }
         $results['items'][90004] = array();
         $results['items'][90004]['name'] = $search['data']['bbpressuserstext'].$num;
         $results['items'][90004]['data'] = $userresults;
         $results['grouped'] = 1;
       }
       
    } else {
       $results = array_merge(
        $blogresults, 
        $allbuddypresults['activityresults'],
        $allcommentsresults, 
        $allbuddypresults['groupresults'], 
        $allbuddypresults['userresults'], 
        $allpageposts
      ); 
    }
    
    

    if (count($results)<=0 && $search['data']['keywordsuggestions']) {
      $t = new keywordSuggest($search['data']['keywordsuggestionslang']);
      $keywords = $t->getKeywords($s);
      if ($keywords!=false) {
        $results['keywords'] = $keywords;
        $results['nores'] = 1;
        $results = apply_filters( 'asp_only_keyword_results', $results );    
      }
    } else if (count($results>0)) {
        $results = apply_filters( 'asp_only_non_keyword_results', $results );
    } 
    
    
    $results = apply_filters( 'asp_results', $results ); 
    
    do_action('asp_after_search', $s, $results);
    
    if (w_isset_def($caching_options['caching'], 0) && ASP_DEBUG!=1)
      $cache_content = $textcache->setCache('!!ASPSTART!!'.json_encode($results)."!!ASPEND!!");
    if (isset($_POST['asp_get_as_array'])) return $results;  
    /* Clear output buffer, possible warnings */
    print "!!ASPSTART!!";                                   
    //var_dump($results);die();  
    print_r(json_encode($results));
    print "!!ASPEND!!";
    die();
  }
}

  function ajaxsearchpro_autocomplete() {
      
      global $wpdb;
      $s = trim($_POST['sauto']);
      $s= preg_replace( '/\s+/', ' ', $s);
      $keyword = "";
 
      do_action('asp_before_autocomplete', $s);

      if (!isset($_POST['asid'])) return "";

      $search = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ajaxsearchpro WHERE id=".$_POST['asid'], ARRAY_A);
      $search['data'] = json_decode($search['data'], true);
      if (!isset($search['data']['autocompletesource'])) $search['data']['autocompletesource'] = 0; 
      if ($search['data']['autocompletesource']==0) {
        $keywords = array();
        $_keywords = $wpdb->get_results("SELECT keyword FROM ".$wpdb->prefix."ajaxsearchpro_statistics WHERE keyword LIKE '".$s."%' ORDER BY num desc", ARRAY_A);
        foreach($_keywords as $k=>$v) {
          $keywords[] = $v['keyword'];
        }
        $banned = explode(',', $search['data']['autocompleteexceptions']);
        if (is_array($banned)) {
          foreach ($banned as $k=>$v) {
            $banned[$k] = trim(preg_replace( '/\s+/', ' ', $v));
          }
        }
        if (!is_array($keywords)) $keywords = array();
        if (!is_array($banned)) $keywords = array();
        $possible = array_diff($keywords, $banned);
        if (is_array($possible)) {
          $keyword = reset($possible);
        } else {
          $keyword = "";
        }
      } else if ($search['data']['autocompletesource']==1) {
        $t = new keywordSuggest();
        $keywords = $t->getKeywords($s);
        if ($keywords==false) {
          $keyword = ''; 
        } else {
          $keyword = $keywords[0];
        }      
      }
    
      do_action('asp_after_autocomplete', $s, $keyword);
      print $keyword;
      die();
      
  }
  
  function ajaxsearchpro_preview() {
    require_once(ASP_PATH."/includes/shortcodes.php");
    $o = aspShortcodeContainer::get_instance();
    $out = $o->wpdreams_asp_shortcode(array("id"=>$_POST['asid']));
    print $out;
    die();
  }
  
  
  /*
  * Precaching images, with max 10 sec of execution time
  */
  function ajaxsearchpro_precache() {
      
      global $wpdb;
      $from = $_POST['from'];

      if (isset($wpdb->base_prefix)) {
        $_prefix = $wpdb->base_prefix;
      } else {
        $_prefix = $wpdb->prefix;
      }   
      $start = microtime(true);
    	$querystr = "
    		SELECT 
          $wpdb->posts.post_title as title,
          $wpdb->posts.ID as id,
          $wpdb->posts.post_date as date,
          $wpdb->posts.post_content as content,
          $wpdb->posts.post_excerpt as excerpt,
          $wpdb->posts.post_type as post_type
    		FROM $wpdb->posts
    		WHERE
        $wpdb->posts.ID > $from AND
        $wpdb->posts.post_status='publish'
        LIMIT 5
    	 ";
      $pageposts = $wpdb->get_results($querystr, OBJECT);
      
      $searches = $wpdb->get_results("SELECT * FROM ".$_prefix."ajaxsearchpro", ARRAY_A);
      if (is_array($searches)) {
        foreach ($searches as $search) {
          $searchData = json_decode($search['data'], true);
          //$image_settings = w_isset_def($searchData['image_options'], array());
          if (isset($searchData['show_images']) && $searchData['show_images']==1) {
            
            if ($searchData['resultstype'] == 'vertical') {
                $_width = $searchData['image_width'];
                $_height = $searchData['image_width'];
            } else {
                $_width = wpdreams_width_from_px($searchData['hreswidth']);
                $_vimageratio =  $_width / $searchData['image_width'];
                $_height = $_vimageratio * $searchData['image_height'];
            }    
            
            if (is_array($pageposts) && count($pageposts)>0) {
              foreach( $pageposts as $_post ) {
                  $im = wp_get_attachment_url( get_post_thumbnail_id($_post->id) ); 
                  $img = new wpdreamsImageCache($im, "post".$_post->id, ASP_PATH."cache".DIRECTORY_SEPARATOR, $_width, $_height, -1, $searchData['image_bg_color']);
                  $img = new wpdreamsImageCache($_post->content, "post".$_post->id, ASP_PATH."cache".DIRECTORY_SEPARATOR, $_width, $_height, 1, $searchData['image_bg_color']);
                  $img = new wpdreamsImageCache($_post->excerpt, "post".$_post->id, ASP_PATH."cache".DIRECTORY_SEPARATOR, $_width, $_height, 1, $searchData['image_bg_color']);
              }
            } else {
              print_r(json_encode(
                array(
                  'msg' => 'Done!',
                  'affected' => 0,
                  'lastid' => $from
                )
              ));
              exit;
            }
          }
        }
        $current = microtime(true);
        $runtime = $current-$start;
        print_r(json_encode(
          array(
            'msg' => 'Done!',
            'affected' => count($pageposts),
            'lastid' => $from + count($pageposts)
          )
        ));
        exit;
      }
      print_r(json_encode(
        array(
          'msg' => 'Error!',
          'affected' => 0,
          'lastid' => $from
        )
      ));
      exit;
  }
  /* Delete the cache */
  function ajaxsearchpro_deletecache() {
    $count = 0;
    function delTree($dir) {
        $count = 0;
        $files = @glob( $dir . '*', GLOB_MARK );
        foreach( $files as $file ){
            if( substr( $file, -1 ) == '/' )
                @delTree( $file );
            else
                @unlink( $file );
            $count++;
        }
        return $count;
    }
    print delTree(ASP_PATH.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR);
    exit;
  }

    function ajaxsearchpro_deletekeyword() {
        global $wpdb;
        if (isset($_POST['keywordid'])) {
            echo $wpdb->query("DELETE FROM ".$wpdb->base_prefix."ajaxsearchpro_statistics WHERE id=".$_POST['keywordid']);
            exit;
        }
        echo 0; exit;
    }