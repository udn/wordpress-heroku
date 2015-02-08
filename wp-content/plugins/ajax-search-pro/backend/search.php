<?php

$params = array();

$_themes = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'settings' . DIRECTORY_SEPARATOR . 'themes.json');

if (isset($wpdb->base_prefix)) {
    $_prefix = $wpdb->base_prefix;
} else {
    $_prefix = $wpdb->prefix;
}

$search = $wpdb->get_row("SELECT * FROM " . $_prefix . "ajaxsearchpro WHERE id=" . $_GET['asp_sid'], ARRAY_A);
$sd = json_decode($search['data'], true);
//var_dump($_sd);
$_def = get_option('asp_defaults');
$_dk = 'asp_defaults';
?>
<script>
    (function ($) {
        $(document).ready(function () {

            var ajaxurl = '<?php bloginfo("url"); ?>' + "/wp-content/plugins/ajax-search-pro/ajax_search.php";

            jQuery(jQuery('.tabs a')[0]).trigger('click');
            $('.tabs a[tabid=6]').click(function () {
                $('.tabs a[tabid=8]').click();
            });
            $('.tabs a[tabid=1]').click(function () {
                $('.tabs a[tabid=101]').click();
            });
            $('.tabs a[tabid=4]').click(function () {
                $('.tabs a[tabid=201]').click();
            });
            $('.tabs a[tabid=1]').click();
            $('#wpdreams .settings').click(function () {
                $("#preview input[name=refresh]").attr('searchid', $(this).attr('searchid'));
            });
            $("select[id^=wpdreamsThemeChooser]").change(function () {
                $("#preview input[name=refresh]").click();
            });
            $("#preview .refresh").click(function (e) {
                e.preventDefault();
                var $this = $(this).parent();
                var id = <?php echo $_GET['asp_sid']; ?>;
                var loading = $('.big-loading', $this);
                $('.data', $this).html("");
                $('.data', $this).addClass('hidden');
                loading.removeClass('hidden');
                var data = {
                    action: 'ajaxsearchpro_preview',
                    asid: id,
                    formdata: $('form[name="asp_data"]').serialize()
                };
                $.post(ajaxurl, data, function (response) {
                    loading.addClass('hidden');
                    $('.data', $this).html(response);
                    $('.data', $this).removeClass('hidden');
                    setTimeout(
                        function () {
                            if (typeof aspjQuery != 'undefined')
                                aspjQuery(window).resize();
                            else if (typeof jQuery != 'undefined')
                                jQuery(window).resize();
                        },
                        1000);
                });
            });
            $("#preview .refresh").click();
            $("#preview .maximise").click(function (e) {
                e.preventDefault();
                $this = $(this.parentNode);
                if ($(this).html() == "Show") {
                    $this.animate({
                        bottom: "-2px",
                        height: $(window).height() * 0.9
                    });
                    $(this).html('Hide');
                    $("#preview a.refresh").trigger('click');
                } else {
                    $this.animate({
                        bottom: "-2px",
                        height: "40px"
                    });
                    $(this).html('Show');
                }
            });
            $("#bgcolorpicker").spectrum({
                showInput: true,
                showPalette: true,
                showSelectionPalette: true,
                change: function (color) {
                    $("#preview").css("background", color.toHexString()); // #ff0000
                }
            });

        });
    }(jQuery));
</script>

<div id='preview'>
    <span>Preview</span>
    <a name='refresh' class='refresh' searchid='0' href='#'>Refresh</a>
    <a name='hide' class='maximise'/>Show</a>
    <label>Background: </label><input type="text" id="bgcolorpicker" value="#ffffff"/>

    <div style="text-align: center;
        margin: 11px 0 17px;
        font-size: 12px;
        color: #aaa;">Please note, that some functions may not work in preview mode.<br>The first loading can take up to
        15 seconds!
    </div>
    <div class='big-loading hidden'></div>
    <div class="data hidden asp_preview_data"></div>
</div>

<div id="wpdreams" class='wpdreams wrap'>
    <?php if (ASP_DEBUG == 1): ?>
        <p class='infoMsg'>Debug mode is on!</p>
    <?php endif; ?>

    <a class='back' href='<?php echo get_admin_url() . "admin.php?page=ajax-search-pro/backend/settings.php"; ?>'>Back
        to the search list</a>
    <a class='statistics'
       href='<?php echo get_admin_url() . "admin.php?page=ajax-search-pro/backend/statistics.php"; ?>'>Search
        Statistics</a>
    <a class='error' href='<?php echo get_admin_url() . "admin.php?page=ajax-search-pro/backend/comp_check.php"; ?>'>Compatibility
        checking</a>
    <a class='cache'
       href='<?php echo get_admin_url() . "admin.php?page=ajax-search-pro/backend/cache_settings.php"; ?>'>Caching
        options</a>
    <?php ob_start(); ?>
    <div class="wpdreams-box">
        <fieldset>
            <legend>
                <?php echo $search['name']; ?>
            </legend>
            <label class="shortcode">Search shortcode:</label>
            <input type="text" class="shortcode" value="[wpdreams_ajaxsearchpro id=<?php echo $search['id']; ?>]"
                   readonly="readonly"/>
            <label class="shortcode">Search shortcode for templates:</label>
            <input type="text" class="shortcode"
                   value="&lt;?php echo do_shortcode('[wpdreams_ajaxsearchpro id=<?php echo $search['id']; ?>]'); ?&gt;"
                   readonly="readonly"/>

            <p style='margin:19px 10px 9px;'>Shortcodes for placing the result box elswhere. (only works if the result
                layout position is <b>block</b> - see in layout options tab)</p>
            <label class="shortcode">Result box shortcode:</label>
            <input type="text" class="shortcode"
                   value="[wpdreams_ajaxsearchpro_results id=<?php echo $search['id']; ?> element='div']"
                   readonly="readonly"/>
            <label class="shortcode">Result shortcode for templates:</label>
            <input type="text" class="shortcode"
                   value="&lt;?php echo do_shortcode('[wpdreams_ajaxsearchpro_results id=<?php echo $search['id']; ?> element=&quot;div&quot;]'); ?&gt;"
                   readonly="readonly"/>

        </fieldset>
    </div>
    <div class="wpdreams-box">
        <form action='' method='POST' name='asp_data'>
            <ul id="tabs" class='tabs'>
                <li><a tabid="1" class='current general'>General Options</a></li>
                <li><a tabid="2" class='multisite'>Multisite Options</a></li>
                <li><a tabid="3" class='frontend'>Frontend Search Settings</a></li>
                <li><a tabid="4" class='layout'>Layout options</a></li>
                <li><a tabid="5" class='autocomplete'>Autocomplete options</a></li>
                <li><a tabid="6" class='theme'>Theme options</a></li>
                <li><a tabid="20" class='advanced'>Relevance options</a></li>
                <li><a tabid="7" class='advanced'>Advanced options</a></li>
            </ul>
            <div id="content" class='tabscontent'>
                <div tabid="1">
                    <fieldset>
                        <legend>Genearal Options</legend>

                        <?php include(ASP_PATH . "backend/tabs/instance/general_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="2">
                    <fieldset>
                        <legend>Multisite Options</legend>

                        <?php include(ASP_PATH . "backend/tabs/instance/multisite_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="3">
                    <fieldset>
                        <legend>Frontend Search Settings options</legend>

                        <?php include(ASP_PATH . "backend/tabs/instance/frontend_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="4">
                    <fieldset>
                        <legend>Layout Options</legend>

                        <?php include(ASP_PATH . "backend/tabs/instance/layout_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="5">
                    <fieldset>
                        <legend>Autocomplete Options</legend>

                        <?php include(ASP_PATH . "backend/tabs/instance/autocomplete_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="6">
                    <fieldset>
                        <legend>Theme Options</legend>

                        <?php include(ASP_PATH . "backend/tabs/instance/theme_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="20">
                    <fieldset>
                        <legend>Relevance Options</legend>

                        <?php include(ASP_PATH . "backend/tabs/instance/relevance_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="7">
                    <fieldset>
                        <legend>Advanced Options</legend>

                        <?php include(ASP_PATH . "backend/tabs/instance/advanced_options.php"); ?>

                    </fieldset>
                </div>
            </div>
        </form>
    </div>
    <?php $output = ob_get_clean(); ?>
    <?php
    if (isset($_POST['submit_' . $search['id']])) {
        /* update data */
        /*foreach ($_POST as $k => $v) {
            $params[$k] = $v;
        }
        foreach ($params as $k => $v) {
            $_tmp = explode('classname-', $k);
            if ($_tmp != null && count($_tmp) > 1) {
                ob_start();
                $c = new $v('0', '0', $params[$_tmp[1]]);
                $out = ob_get_clean();
                $params['selected-' . $_tmp[1]] = $c->getSelected();
            }
        }   */
        
        $params = wpdreams_parse_params($_POST);
        
        //print_r($params);
        $data = mysql_escape_mimic(json_encode($params));
        //print_r($_POST);
        $wpdb->query("
        UPDATE " . $_prefix . "ajaxsearchpro
        SET data = '" . $data . "'
        WHERE id = " . $search['id'] . "
      ");


        $style = $params;
        $id = $search['id'];

        /*
        $file = ASP_PATH . "/css/style" . $id . ".css";
        ob_start();
        include(ASP_PATH . "/css/style.css.php");
        $out = ob_get_contents();
        ob_end_clean();
        file_put_contents($file, $out, FILE_TEXT);
        */
        
        if (wpdreams_update_stylesheet(ASP_CSS_PATH, $id, $params ) === false) {
            $messages = "<div class='errorMsg'>Error saving the stylesheet, please check the permissions on the css folder or enable inline styles on the compatibility options!</div>";
        }

        echo "<div class='successMsg'>Search settings saved!</div>";
    }
    echo $output;
    ?>
</div>      