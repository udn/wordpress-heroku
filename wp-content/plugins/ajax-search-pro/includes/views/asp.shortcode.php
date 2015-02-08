<?php
    $real_id = $id;
    $id = $id . '_' . self::$instanceCount;
?>
<div id='ajaxsearchpro<?php echo $id; ?>'>
<div class="probox">


    <?php do_action('asp_layout_before_magnifier', $id); ?>

    <div class='promagnifier'>
        <?php do_action('asp_layout_in_magnifier', $id); ?>
        <div class='innericon'>
            <?php
                if (w_isset_def($style['magnifierimage_custom'], "") == "" &&
                    pathinfo($style['magnifierimage'], PATHINFO_EXTENSION)=='svg')
                {
                    echo file_get_contents(ABSPATH . 'wp-content/plugins/' . $style['magnifierimage']);
                }
            ?>
        </div>
    </div>

    <?php do_action('asp_layout_after_magnifier', $id); ?>

    <?php do_action('asp_layout_before_settings', $id); ?>

    <div class='prosettings' <?php echo($settingsHidden ? "style='display:none;'" : ""); ?>opened=0>
        <?php do_action('asp_layout_in_settings', $id); ?>
        <div class='innericon'>
            <?php
            if (w_isset_def($style['settingsimage_custom'], "") == "" &&
                pathinfo($style['settingsimage'], PATHINFO_EXTENSION)=='svg')
            {
                echo file_get_contents(ABSPATH . 'wp-content/plugins/' . $style['settingsimage']);
            }
            ?>
        </div>
    </div>

    <?php do_action('asp_layout_after_settings', $id); ?>

    <?php do_action('asp_layout_before_input', $id); ?>

    <div class='proinput'>
        <form action='' autocomplete="off">
            <input type='search' class='orig' name='phrase' value='' autocomplete="off"/>
            <input type='text' class='autocomplete' name='phrase' value='' autocomplete="off"/>
            <span class='loading'></span>
            <input type='submit' style='width:0; height: 0; visibility: hidden;'>
        </form>
    </div>

    <?php do_action('asp_layout_after_input', $id); ?>

    <?php do_action('asp_layout_before_loading', $id); ?>

    <div class='proloading'>
        <?php
        if (w_isset_def($style['loadingimage_custom'], "") == "" &&
            pathinfo($style['loadingimage'], PATHINFO_EXTENSION)=='svg')
        {
            echo file_get_contents(ABSPATH . 'wp-content/plugins/' . $style['loadingimage']);
        }
        ?>
        <?php do_action('asp_layout_in_loading', $id); ?>
    </div>

    <?php if($style['show_close_icon']): ?>
    <div class='proclose'>
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
            <polygon id="x-mark-icon" points="438.393,374.595 319.757,255.977 438.378,137.348 374.595,73.607 255.995,192.225 137.375,73.622 73.607,137.352 192.246,255.983 73.622,374.625 137.352,438.393 256.002,319.734 374.652,438.378 "/>
        </svg>
    </div>
    <?php endif; ?>

    <?php do_action('asp_layout_after_loading', $id); ?>

</div>
<div id='ajaxsearchprosettings<?php echo $id; ?>' class="searchsettings">
<form name='options'>

<?php do_action('asp_layout_settings_before_first_item', $id); ?>
<fieldset class="asp_sett_scroll">
    <div class="option hiddend">
        <input type='hidden' name='qtranslate_lang' id='qtranslate_lang'
               value='<?php echo(function_exists('qtrans_getLanguage') ? qtrans_getLanguage() : '0'); ?>'/>
    </div>

    <div class="option<?php echo(($style['showexactmatches'] != 1) ? " hiddend" : ""); ?>">
        <input type="checkbox" value="checked" id="set_exactonly<?php echo $id; ?>"
               name="set_exactonly" <?php echo(($style['exactonly'] == 1) ? 'checked="checked"' : ''); ?>/>
        <label for="set_exactonly<?php echo $id; ?>"></label>
    </div>
    <div class="label<?php echo(($style['showexactmatches'] != 1) ? " hiddend" : ""); ?>">
        <?php echo $style['exactmatchestext']; ?>
    </div>
    <div class="option<?php echo(($style['showsearchintitle'] != 1) ? " hiddend" : ""); ?>">
        <input type="checkbox" value="None" id="set_intitle<?php echo $id; ?>"
               name="set_intitle" <?php echo(($style['searchintitle'] == 1) ? 'checked="checked"' : ''); ?>/>
        <label for="set_intitle<?php echo $id; ?>"></label>
    </div>
    <div class="label<?php echo(($style['showsearchintitle'] != 1) ? " hiddend" : ""); ?>">
        <?php echo $style['searchintitletext']; ?>
    </div>
    <div class="option<?php echo(($style['showsearchincontent'] != 1) ? " hiddend" : ""); ?>">
        <input type="checkbox" value="None" id="set_incontent<?php echo $id; ?>"
               name="set_incontent" <?php echo(($style['searchincontent'] == 1) ? 'checked="checked"' : ''); ?>/>
        <label for="set_incontent<?php echo $id; ?>"></label>
    </div>
    <div class="label<?php echo(($style['showsearchincontent'] != 1) ? " hiddend" : ""); ?>">
        <?php echo $style['searchincontenttext']; ?>
    </div>
    <div class="option<?php echo(($style['showsearchincomments'] != 1) ? " hiddend" : ""); ?>">
        <input type="checkbox" value="None" id="set_incomments<?php echo $id; ?>"
               name="set_incomments" <?php echo(($style['searchincomments'] == 1) ? 'checked="checked"' : ''); ?>/>
        <label for="set_incomments<?php echo $id; ?>"></label>
    </div>
    <div class="label<?php echo(($style['showsearchincomments'] != 1) ? " hiddend" : ""); ?>">
        <?php echo $style['searchincommentstext']; ?>
    </div>
    <div class="option<?php echo(($style['showsearchinexcerpt'] != 1) ? " hiddend" : ""); ?>">
        <input type="checkbox" value="None" id="set_inexcerpt<?php echo $id; ?>"
               name="set_inexcerpt" <?php echo(($style['searchinexcerpt'] == 1) ? 'checked="checked"' : ''); ?>/>
        <label for="set_inexcerpt<?php echo $id; ?>"></label>
    </div>
    <div class="label<?php echo(($style['showsearchinexcerpt'] != 1) ? " hiddend" : ""); ?>">
        <?php echo $style['searchinexcerpttext']; ?>
    </div>
    <div class="option<?php echo(($style['showsearchinposts'] != 1) ? " hiddend" : ""); ?>">
        <input type="checkbox" value="None" id="set_inposts<?php echo $id; ?>"
               name="set_inposts" <?php echo(($style['searchinposts'] == 1) ? 'checked="checked"' : ''); ?>/>
        <label for="set_inposts<?php echo $id; ?>"></label>
    </div>
    <div class="label<?php echo(($style['showsearchinposts'] != 1) ? " hiddend" : ""); ?>">
        <?php echo $style['searchinpoststext']; ?>
    </div>
    <div class="option<?php echo(($style['showsearchinpages'] != 1) ? " hiddend" : ""); ?>">
        <input type="checkbox" value="None" id="set_inpages<?php echo $id; ?>"
               name="set_inpages" <?php echo(($style['searchinpages'] == 1) ? 'checked="checked"' : ''); ?>/>
        <label for="set_inpages<?php echo $id; ?>"></label>
    </div>
    <div class="label<?php echo(($style['showsearchinpages'] != 1) ? " hiddend" : ""); ?>">
        <?php echo $style['searchinpagestext']; ?>
    </div>
    <div class="option<?php echo(($style['showsearchinbpgroups'] != 1) ? " hiddend" : ""); ?>">
        <input type="checkbox" value="None" id="set_inbpgroups<?php echo $id; ?>"
               name="set_inbpgroups" <?php echo(($style['searchinbpgroups'] == 1) ? 'checked="checked"' : ''); ?>/>
        <label for="set_inbpgroups<?php echo $id; ?>"></label>
    </div>
    <div class="label<?php echo(($style['showsearchinbpgroups'] != 1) ? " hiddend" : ""); ?>">
        <?php echo $style['searchinbpgroupstext']; ?>
    </div>
    <div class="option<?php echo(($style['showsearchinbpusers'] != 1) ? " hiddend" : ""); ?>">
        <input type="checkbox" value="None" id="set_inbpusers<?php echo $id; ?>"
               name="set_inbpusers" <?php echo(($style['searchinbpusers'] == 1) ? 'checked="checked"' : ''); ?>/>
        <label for="set_inbpusers<?php echo $id; ?>"></label>
    </div>
    <div class="label<?php echo(($style['showsearchinbpusers'] != 1) ? " hiddend" : ""); ?>">
        <?php echo $style['searchinbpuserstext']; ?>
    </div>
    <div class="option<?php echo(($style['showsearchinbpforums'] != 1) ? " hiddend" : ""); ?>">
        <input type="checkbox" value="None" id="set_inbpforums<?php echo $id; ?>"
               name="set_inbpforums" <?php echo(($style['searchinbpforums'] == 1) ? 'checked="checked"' : ''); ?>/>
        <label for="set_inbpforums<?php echo $id; ?>"></label>
    </div>
    <div class="label<?php echo(($style['showsearchinbpforums'] != 1) ? " hiddend" : ""); ?>">
        <?php echo $style['searchinbpforumstext']; ?>
    </div>

<?php

$types = get_post_types(array(
    '_builtin' => false
));
$i = 1;
if (!isset($style['selected-customtypes']) || !is_array($style['selected-customtypes']))
    $style['selected-customtypes'] = array();
if (!isset($style['selected-showcustomtypes']) || !is_array($style['selected-showcustomtypes']))
    $style['selected-showcustomtypes'] = array();
$flat_show_customtypes = array();

foreach ($style['selected-showcustomtypes'] as $k => $v) {
    $selected = in_array($v[0], $style['selected-customtypes']);
    $hidden = "";
    $flat_show_customtypes[] = $v[0];
    ?>
    <div class="option<?php echo $hidden; ?>">
        <input type="checkbox" value="<?php echo $v[0]; ?>" id="<?php echo $id; ?>customset_<?php echo $id . $i; ?>"
               name="customset[]" <?php echo(($selected) ? 'checked="checked"' : ''); ?>/>
        <label for="<?php echo $id; ?>customset_<?php echo $id . $i; ?>"></label>
    </div>
    <div class="label<?php echo $hidden; ?>">
        <?php echo $v[1]; ?>
    </div>
    <?php
    $i++;
}
?>
</fieldset>
<?php


$hidden_types = array();
$hidden_types = array_diff($style['selected-customtypes'], $flat_show_customtypes);

foreach ($hidden_types as $k => $v) {

    ?>
    <div class="option hiddend">
        <input type="checkbox" value="<?php echo $v; ?>"
               id="<?php echo $id; ?>customset_<?php echo $id . $i; ?>"
               name="customset[]" checked="checked"/>
        <label for="<?php echo $id; ?>customset_<?php echo $id . $i; ?>"></label>
    </div>
    <div class="label<?php echo $hidden; ?>"></div>
    <?php
    $i++;
}



?>
<?php
/* Category and term filters */
if ($style['showsearchincategories']) {
?>

<fieldset>
    <?php if ($style['exsearchincategoriestext'] != ""): ?>
        <legend><?php echo $style['exsearchincategoriestext']; ?></legend>
    <?php endif; ?>
    <div class='categoryfilter asp_sett_scroll'>
        <?php

        }

        /* Categories */
        if (!isset($style['selected-exsearchincategories']) || !is_array($style['selected-exsearchincategories']))
            $style['selected-exsearchincategories'] = array();
        if (!isset($style['selected-excludecategories']) || !is_array($style['selected-excludecategories']))
            $style['selected-excludecategories'] = array();
        //$_all_cat = get_all_category_ids();
        $_all_cat = get_terms('category', array('fields'=>'ids'));
        $_needed_cat = array_diff($_all_cat, $style['selected-exsearchincategories']);
        foreach ($_needed_cat as $k => $v) {
            $selected = !in_array($v, $style['selected-excludecategories']);
            $cat = get_category($v);
            $val = $cat->name;
            $hidden = (($style['showsearchincategories']) == 0 ? " hiddend" : "");
            if ($style['showuncategorised'] == 0 && $v == 1) {
                $hidden = ' hiddend';
            }
            ?>
            <div class="option<?php echo $hidden; ?>">
                <input type="checkbox" value="<?php echo $v; ?>"
                       id="<?php echo $id; ?>categoryset_<?php echo $v; ?>"
                       name="categoryset[]" <?php echo(($selected) ? 'checked="checked"' : ''); ?>/>
                <label for="<?php echo $id; ?>categoryset_<?php echo $v; ?>"></label>
            </div>
            <div class="label<?php echo $hidden; ?>">
                <?php echo $val; ?>
            </div>
        <?php
        }

        if ($style['showsearchincategories'] && $style['showseparatefilterboxes'] != 0) {
        ?>
    </div>
</fieldset>

<?php do_action('asp_layout_settings_after_last_item', $id); ?>

<?php
}


/* Terms */
if ($style['showsearchintaxonomies'] == 1) {
if (!isset($style['selected-excludeterms']) || !is_array($style['selected-excludeterms']))
    $style['selected-excludeterms'] = array();
if (!isset($style['selected-showterms']) || !is_array($style['selected-showterms']))
    $style['selected-showterms'] = array();

$_all_term_ids = wpdreams_get_all_term_ids();

$_needed_terms = array_diff($_all_term_ids, $style['selected-excludeterms']);
$_invisible_terms = array_diff($_needed_terms, $style['selected-showterms']);
//$counter = 0;

$_close_fieldset = false;

$_terms = array();
$visible_terms = array();

foreach ($style['selected-showterms'] as $taxonomy => $terms) {
    if (is_array($terms)) {

        if ($style['showseparatefilterboxes'] != 0) {
            $_x_term = get_taxonomies(array("name" => $taxonomy), "objects");
            //var_dump($_x_term);
            if (isset($_x_term[$taxonomy]))
                $_tax_name = $_x_term[$taxonomy]->label;
            ?>
            <fieldset>
            <legend><?php echo $style['exsearchintaxonomiestext'] . " " . $_tax_name; ?></legend>
            <div class='categoryfilter'>
        <?php
        }

        foreach ($terms as $k => $term) {
            $checked = in_array_r($term, $style['selected-excludeterms'])?'':'checked="checked"';
            ?>
            <div class="option">
                <input type="checkbox" value="<?php echo $term; ?>" id="<?php echo $id; ?>termset_<?php echo $term; ?>"
                       name="termset[]" <?php echo $checked; ?>/>
                <label for="<?php echo $id; ?>termset_<?php echo $term; ?>"></label>
            </div>
            <div class="label">
                <?php 
        				  $tterm = get_term( $term, $taxonomy );
        				  echo $tterm->name;
        				?>
            </div>
            <?php
            //$counter++;
        }

        if ($style['showseparatefilterboxes'] != 0) {
            ?>
            </div>
            </fieldset>
        <?php
        }

    }
}


if ($style['showsearchincategories'] && $style['showseparatefilterboxes'] != 1) {
?>
</div>
</fieldset>

<?php do_action('asp_layout_settings_after_last_item', $id); ?>

<?php
}
}
?>
</form>
</div>
</div>
<div id='ajaxsearchprores<?php echo $id; ?>' class='<?php echo $style['resultstype']; ?>'>

    <?php if ($style['resultstype'] == "isotopic" && $style['i_pagination_position'] == 'top'): ?>
    <nav class="asp_navigation">

        <a class="asp_prev">
           <?php echo file_get_contents(ABSPATH . 'wp-content/plugins/' . $style['i_pagination_arrow']); ?>
        </a>

        <ul></ul>

        <a class="asp_next">
            <?php echo file_get_contents(ABSPATH . 'wp-content/plugins/' . $style['i_pagination_arrow']); ?>
        </a>

        <div class="clear"></div>

    </nav>
    <?php endif; ?>

    <?php do_action('asp_layout_before_results', $id); ?>

    <div class="results">

        <?php do_action('asp_layout_before_first_result', $id); ?>

        <div class="resdrg">
        </div>

        <?php do_action('asp_layout_after_last_result', $id); ?>

    </div>

    <?php do_action('asp_layout_after_results', $id); ?>

    <?php if ($style['showmoreresults'] == 1): ?>
        <?php do_action('asp_layout_before_showmore', $id); ?>
        <p class='showmore'>
            <a href='<?php home_url('/'); ?>?s='><?php echo $style['showmoreresultstext']; ?></a>
        </p>
        <?php do_action('asp_layout_after_showmore', $id); ?>
    <?php endif; ?>

    <?php if ($style['resultstype'] == "isotopic" && $style['i_pagination_position'] == 'bottom'): ?>
        <nav class="asp_navigation">

            <a class="asp_prev">
                <?php echo file_get_contents(ABSPATH . 'wp-content/plugins/' . $style['i_pagination_arrow']); ?>
            </a>

            <ul></ul>

            <a class="asp_next">
                <?php echo file_get_contents(ABSPATH . 'wp-content/plugins/' . $style['i_pagination_arrow']); ?>
            </a>

            <div class="clear"></div>

        </nav>
    <?php endif; ?>

</div>

<?php if (self::$instanceCount<2): ?>
    <div id="asp_hidden_data">

        <div class='asp_item_overlay'>
            <div class='asp_item_inner'>
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
            <path id="magnifier-7-icon" d="M460.475,408.443L351.4,299.37c15.95-25.137,25.2-54.923,25.2-86.833
                C376.601,122.914,303.687,50,214.062,50c-89.623,0-162.537,72.914-162.537,162.537s72.914,162.537,162.537,162.537
                c30.325,0,58.732-8.356,83.055-22.876L406.918,462L460.475,408.443z M96.315,212.538c0-64.927,52.819-117.748,117.746-117.748
                c64.926,0,117.748,52.821,117.748,117.748c0,64.926-52.822,117.747-117.748,117.747C149.135,330.285,96.315,277.464,96.315,212.538z
                 M282.276,231.882H149.957v-36.86h132.319V231.882z"/>
            </svg>
            </div>
        </div>

        <svg style="position:absolute" height="0" width="0"><filter id="aspblur"><feGaussianBlur in="SourceGraphic" stdDeviation="4"/></filter></svg>
        <svg style="position:absolute" height="0" width="0"><filter id="no_aspblur"></filter></svg>

    </div>
<?php endif; ?>

<?php if (w_isset_def($style['custom_css'], "") != ""): ?>
<style>
    <?php echo stripcslashes(base64_decode($style['custom_css'])); ?>
</style>
<?php endif; ?>

<?php $ana_options = get_option('asp_analytics'); ?>

<?php
    $comp_options = get_option('asp_compatibility');
    if (ASP_DEBUG < 1 && strpos(w_isset_def($comp_options['js_source'], 'min-scoped'), "scoped") !== false) {
        $scope = "aspjQuery";
    } else {
        $scope = "jQuery";
    }
?>

<script>
    <?php echo $scope; ?>(document).ready(function () {
        <?php echo $scope; ?>("#ajaxsearchpro<?php echo $id; ?>").ajaxsearchpro({
            homeurl: '<?php echo home_url('/'); ?>',
            resultstype: '<?php echo ((isset($style['resultstype']) && $style['resultstype']!="")?$style['resultstype']:"vertical"); ?>',
            resultsposition: '<?php echo ((isset($style['resultsposition']) && $style['resultsposition']!="")?$style['resultsposition']:"vertical"); ?>',
            itemscount: <?php echo ((isset($style['itemscount']) && $style['itemscount']!="")?$style['itemscount']:"2"); ?>,
            imagewidth: <?php echo ((isset($style['settings-imagesettings']['width']))?$style['settings-imagesettings']['width']:"70"); ?>,
            imageheight: <?php echo ((isset($style['settings-imagesettings']['height']))?$style['settings-imagesettings']['height']:"70"); ?>,
            resultitemheight: '<?php echo ((isset($style['resultitemheight']) && $style['resultitemheight']!="")?$style['resultitemheight']:"70"); ?>',
            showauthor: <?php echo ((isset($style['showauthor']) && $style['showauthor']!="")?$style['showauthor']:"1"); ?>,
            showdate: <?php echo ((isset($style['showdate']) && $style['showdate']!="")?$style['showdate']:"1"); ?>,
            showdescription: <?php echo ((isset($style['showdescription']) && $style['showdescription']!="")?$style['showdescription']:"1"); ?>,
            charcount:  <?php echo ((isset($style['charcount']) && $style['charcount']!="")?$style['charcount']:"3"); ?>,
            noresultstext: '<?php echo ((isset($style['noresultstext']) && $style['noresultstext']!="")?$style['noresultstext']:"3"); ?>',
            didyoumeantext: '<?php echo ((isset($style['didyoumeantext']) && $style['didyoumeantext']!="")?$style['didyoumeantext']:"3"); ?>',
            defaultImage: '<?php echo w_isset_def($style['image_default'], "")==""?ASP_URL."img/default.jpg":$style['image_default']; ?>',
            highlight: <?php echo ((isset($style['highlight']) && $style['highlight']!="")?$style['highlight']:1); ?>,
            highlightwholewords: <?php echo ((isset($style['highlightwholewords']) && $style['highlightwholewords']!="")?$style['highlightwholewords']:1); ?>,
            scrollToResults: <?php echo w_isset_def($style['scroll_to_results'], 1); ?>,
            resultareaclickable: <?php echo ((isset($style['resultareaclickable']) && $style['resultareaclickable']!="")?$style['resultareaclickable']:0); ?>,
            defaultsearchtext: '<?php echo ((isset($style['defaultsearchtext']) && $style['defaultsearchtext']!="")?$style['defaultsearchtext']:""); ?>',
            autocomplete: <?php echo ((isset($style['autocomplete']) && $style['autocomplete']!="")?$style['autocomplete']:1); ?>,
            triggerontype: <?php echo ((isset($style['triggerontype']) && $style['triggerontype']!="")?$style['triggerontype']:1); ?>,
            triggeronclick: <?php echo ((isset($style['triggeronclick']) && $style['triggeronclick']!="")?$style['triggeronclick']:1); ?>,
            overridewpdefault: <?php echo w_isset_def($style['override_default_results'], 0); ?>,
            redirectonclick: <?php echo ((isset($style['redirectonclick']) && $style['redirectonclick']!="")?$style['redirectonclick']:0); ?>,
            redirect_on_enter: <?php echo w_isset_def($style['redirect_on_enter'], 0); ?>,
            redirect_url: "<?php echo w_isset_def($style['redirect_url'], '?s={phrase}'); ?>",
            more_redirect_url: "<?php echo w_isset_def($style['more_redirect_url'], '?s={phrase}'); ?>",
            settingsimagepos: '<?php echo ((isset($style['settingsimagepos']) && $style['settingsimagepos']!="")?$style['settingsimagepos']:0); ?>',
            hresultanimation: '<?php echo ((isset($style['hresultinanim']) && $style['hresultinanim']!="")?$style['hresultinanim']:0); ?>',
            vresultanimation: '<?php echo ((isset($style['vresultinanim']) && $style['vresultinanim']!="")?$style['vresultinanim']:0); ?>',
            hresulthidedesc: '<?php echo ((isset($style['hhidedesc']) && $style['hhidedesc']!="")?$style['hhidedesc']:1); ?>',
            prescontainerheight: '<?php echo ((isset($style['prescontainerheight']) && $style['prescontainerheight']!="")?$style['prescontainerheight']:"400px"); ?>',
            pshowsubtitle: '<?php echo ((isset($style['pshowsubtitle']) && $style['pshowsubtitle']!="")?$style['pshowsubtitle']:0); ?>',
            pshowdesc: '<?php echo ((isset($style['pshowdesc']) && $style['pshowdesc']!="")?$style['pshowdesc']:1); ?>',
            closeOnDocClick: <?php echo w_isset_def($style['close_on_document_click'], 1); ?>,
            iifNoImage: '<?php echo w_isset_def($style['i_ifnoimage'], 'description'); ?>',
            iiRows: <?php echo w_isset_def($style['i_rows'], 2); ?>,
            iitemsWidth: <?php echo w_isset_def($style['i_item_width'], 200); ?>,
            iitemsHeight: <?php echo w_isset_def($style['i_item_height'], 200); ?>,
            iishowOverlay: <?php echo w_isset_def($style['i_overlay'], 1); ?>,
            iiblurOverlay: <?php echo w_isset_def($style['i_overlay_blur'], 1); ?>,
            iihideContent: <?php echo w_isset_def($style['i_hide_content'], 1); ?>,
            iianimation: '<?php echo w_isset_def($style['i_animation'], 1); ?>',
            analytics: <?php echo w_isset_def($ana_options['analytics'], 0); ?>,
            analyticsString: '<?php echo w_isset_def($ana_options['analytics_string'], ""); ?>'
        });
    });
</script>