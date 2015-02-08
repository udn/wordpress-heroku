<?php $asp_div_ids = 'div[id*="ajaxsearchpro'.$id.'_"]'; ?>
<?php $asp_res_ids = 'div[id*="ajaxsearchprores'.$id.'_"]'; ?>
<?php $asp_set_ids = 'div[id*="ajaxsearchprosettings'.$id.'_"]'; ?>

<?php //var_dump($style);die; ?>

<?php echo ((isset($style['import-inputfont']))?$style['import-inputfont']:""); ?>
<?php echo ((isset($style['import-descfont']))?$style['import-descfont']:""); ?>
<?php echo ((isset($style['import-titlefont']))?$style['import-titlefont']:""); ?>
<?php echo ((isset($style['import-titlehoverfont']))?$style['import-titlehoverfont']:""); ?>
<?php echo ((isset($style['import-authorfont']))?$style['import-authorfont']:""); ?>
<?php echo ((isset($style['import-datefont']))?$style['import-datefont']:""); ?>
<?php echo ((isset($style['import-showmorefont']))?$style['import-showmorefont']:""); ?>
<?php echo ((isset($style['import-groupfont']))?$style['import-groupfont']:""); ?>
<?php echo ((isset($style['import-exsearchincategoriestextfont']))?$style['import-exsearchincategoriestextfont']:""); ?>
<?php echo ((isset($style['import-groupbytextfont']))?$style['import-groupbytextfont']:""); ?>
<?php echo ((isset($style['import-settingsdropfont']))?$style['import-settingsdropfont']:""); ?>
<?php echo ((isset($style['import-prestitlefont']))?$style['import-prestitlefont']:""); ?>
<?php echo ((isset($style['import-presdescfont']))?$style['import-presdescfont']:""); ?>
<?php echo ((isset($style['import-pressubtitlefont']))?$style['import-pressubtitlefont']:""); ?>


@font-face {
    font-family: 'asppsicons';
    src: url('<?php echo plugins_url(); ?>/ajax-search-pro/css/fonts/icons/icons.eot');
    src: url('<?php echo plugins_url(); ?>/ajax-search-pro/css/fonts/icons/icons.eot?#iefix') format('embedded-opentype'), url('<?php echo plugins_url(); ?>/ajax-search-pro/css/fonts/icons/icons.woff') format('woff'), url('<?php echo plugins_url(); ?>/ajax-search-pro/css/fonts/icons/icons.ttf') format('truetype'), url('<?php echo plugins_url(); ?>/ajax-search-pro/css/fonts/icons/icons.svg#icons') format('svg');
    font-weight: normal;
    font-style: normal;
}

<?php echo $asp_div_ids; ?> {
  width: 100%;
  height: auto;
  border-radius: 5px;
  background: #d1eaff;
  <?php wpdreams_gradient_css($style['boxbackground']); ?>;
  overflow: hidden;
  <?php echo $style['boxborder']; ?>
  <?php echo $style['boxshadow']; ?>
}

<?php echo $asp_div_ids; ?> .probox {
  margin: <?php echo $style['boxmargin']; ?>;
  height: <?php echo $style['boxheight']; ?>;
  <?php wpdreams_gradient_css($style['inputbackground']); ?>;
  <?php echo $style['inputborder']; ?>
  <?php echo $style['inputshadow']; ?>
}

<?php echo $asp_div_ids; ?> .probox .proinput {
  <?php echo str_replace("--g--", "", $style['inputfont']); ?>
}

<?php echo $asp_div_ids; ?> .probox .proinput input {
  <?php echo str_replace("--g--", "", $style['inputfont']); ?>
  border: 0;
  box-shadow: none;
}

<?php echo $asp_div_ids; ?> .probox .proinput input.autocomplete {
  <?php echo str_replace("--g--", "", $style['inputfont']); ?>
}


<?php echo $asp_div_ids; ?> .probox .proloading,
<?php echo $asp_div_ids; ?> .probox .proclose,
<?php echo $asp_div_ids; ?> .probox .promagnifier,
<?php echo $asp_div_ids; ?> .probox .prosettings  {
  width: <?php echo wpdreams_width_from_px($style['boxheight']); ?>px;
  height: <?php echo wpdreams_width_from_px($style['boxheight']); ?>px;
}

<?php echo $asp_div_ids; ?> .probox .promagnifier .innericon svg {
  fill: <?php echo $style['magnifierimage_color']; ?>;
}

<?php echo $asp_div_ids; ?> .probox .proloading svg {
  fill: <?php echo $style['loadingimage_color']; ?>;
}

<?php echo $asp_div_ids; ?> .probox .prosettings .innericon svg {
  fill: <?php echo $style['settingsimage_color']; ?>;
}

<?php if (w_isset_def($style['loadingimage_custom'], "") != ""): ?>
    <?php echo $asp_div_ids; ?> .probox .proloading {
    background-image: url("<?php echo  $style['loadingimage_custom']; ?>");
    }
<?php elseif (pathinfo($style['loadingimage'], PATHINFO_EXTENSION)!='svg'): ?>
    <?php echo $asp_div_ids; ?> .probox .proloading {
    background-image: url("<?php echo  plugins_url().$style['loadingimage']; ?>");
    }
<?php endif; ?>


<?php echo $asp_div_ids; ?> .probox .proloading.asp_msie {
    background-image: url("<?php echo ASP_URL."/img/loading/newload1.gif"; ?>");
}

<?php echo $asp_div_ids; ?> .probox .promagnifier {

  width: <?php echo (wpdreams_width_from_px($style['boxheight'])-2*wpdreams_border_width($style['magnifierbackgroundborder'])); ?>px;
  height: <?php echo (wpdreams_width_from_px($style['boxheight'])-2*wpdreams_border_width($style['magnifierbackgroundborder'])); ?>px;
  background-image: -o-<?php wpdreams_gradient_css_rgba($style['magnifierbackground']); ?>;
  background-image: -ms-<?php wpdreams_gradient_css_rgba($style['magnifierbackground']); ?>;
  background-image: -webkit-<?php wpdreams_gradient_css_rgba($style['magnifierbackground']); ?>;
  background-image: <?php wpdreams_gradient_css_rgba($style['magnifierbackground']); ?>;
  background-position:center center;
  background-repeat: no-repeat;

  <?php echo $style['magnifierbackgroundborder']; ?>
  <?php echo $style['magnifierboxshadow']; ?>
  cursor: pointer;
  background-size: 100% 100%;

  background-position:center center;
  background-repeat: no-repeat;
  cursor: pointer;
}


<?php if (w_isset_def($style['magnifierimage_custom'], "") != ""): ?>
    <?php echo $asp_div_ids; ?> .probox .promagnifier .innericon {
    background-image: url("<?php echo  $style['magnifierimage_custom']; ?>");
    }
<?php elseif (pathinfo($style['magnifierimage'], PATHINFO_EXTENSION)!='svg'): ?>
    <?php echo $asp_div_ids; ?> .probox .promagnifier .innericon {
    background-image: url("<?php echo  plugins_url().$style['magnifierimage']; ?>");
    }
<?php endif; ?>

<?php echo $asp_div_ids; ?> .probox .prosettings {

  width: <?php echo (wpdreams_width_from_px($style['boxheight'])-2*wpdreams_border_width($style['settingsbackgroundborder'])); ?>px;
  height: <?php echo (wpdreams_width_from_px($style['boxheight'])-2*wpdreams_border_width($style['settingsbackgroundborder'])); ?>px;
  background-image: -o-<?php wpdreams_gradient_css_rgba($style['settingsbackground']); ?>;
  background-image: -ms-<?php wpdreams_gradient_css_rgba($style['settingsbackground']); ?>;
  background-image: -webkit-<?php wpdreams_gradient_css_rgba($style['settingsbackground']); ?>;
  background-image: <?php wpdreams_gradient_css_rgba($style['settingsbackground']); ?>;
  background-position:center center;
  background-repeat: no-repeat;
  float: <?php echo $style['settingsimagepos']; ?>;
  <?php echo $style['settingsbackgroundborder']; ?>
  <?php echo $style['settingsboxshadow']; ?>
  cursor: pointer;
  background-size: 100% 100%;
}

<?php if (w_isset_def($style['settingsimage_custom'], "") != ""): ?>
    <?php echo $asp_div_ids; ?> .probox .prosettings .innericon {
      background-image: url("<?php echo  $style['settingsimage_custom']; ?>");
    }
<?php elseif (pathinfo($style['settingsimage'], PATHINFO_EXTENSION)!='svg'): ?>
    <?php echo $asp_div_ids; ?> .probox .prosettings .innericon {
    background-image: url("<?php echo  plugins_url().$style['settingsimage']; ?>");
    }
<?php endif; ?>

<?php echo $asp_res_ids; ?> {
    position: <?php echo (($style['resultsposition']=='hover')?'absolute':'static'); ?>;
    z-index:1100;
}

<?php echo $asp_res_ids; ?>.vertical {
  padding: 4px;
  background: <?php echo $style['resultsbackground']; ?>;
  border-radius: 3px;
  <?php echo $style['resultsborder']; ?>
  <?php echo $style['resultshadow']; ?>
  visibility: hidden;
  display: none;
}

<?php echo $asp_res_ids; ?>.horizontal {
  <?php wpdreams_gradient_css($style['hboxbg']); ?>;
  <?php echo $style['hboxborder']; ?>
  <?php echo wpdreams_box_shadow_css($style['hboxshadow']); ?>
  margin-top: <?php echo $style['resultsmargintop']; ?>;
}

<?php echo $asp_res_ids; ?> .results .nores .keyword{
  padding: 0 6px;
  cursor: pointer;
  <?php echo str_replace("--g--", "", $style['descfont']); ?>
  font-weight: bold;
}

<?php echo $asp_res_ids; ?> .results .item {
  height: <?php echo $style['resultitemheight']; ?>;
  background: <?php echo $style['resultscontainerbackground']; ?>;
}

<?php echo $asp_res_ids; ?>.vertical .results .item:after {
  background: <?php echo $style['spacercolor']; ?>;
}


<?php echo $asp_res_ids; ?> .results .item.hovered {
  <?php wpdreams_gradient_css($style['vresulthbg']); ?>;
}

<?php echo $asp_res_ids; ?>.horizontal .results .item {
  height: <?php echo $style['hresheight']; ?>;
  width: <?php echo $style['hreswidth']; ?>;
  margin: 10px <?php echo $style['hressidemargin']; ?>;
  padding: <?php echo $style['hrespadding']; ?>;
  float: left;
  <?php wpdreams_gradient_css($style['hresultbg']); ?>;
  <?php echo $style['hresultborder']; ?>
  <?php wpdreams_box_shadow_css($style['hresultshadow']); ?>
}

<?php echo $asp_res_ids; ?>.horizontal .results .item:hover {
  <?php wpdreams_gradient_css($style['hresulthbg']); ?>;
}

<?php echo $asp_res_ids; ?> .results .item .image {
  width: <?php echo $style['image_width']; ?>px;
  height: <?php echo $style['image_height']; ?>px;
}

<?php echo $asp_res_ids; ?>.horizontal .results .item .image {
  margin: 0 auto;
  <?php wpdreams_gradient_css($style['hresultbg']); ?>;
}

<?php
  $_vimagew = wpdreams_width_from_px($style['hreswidth']);
  $_vimageratio =  $_vimagew / $style['image_width'];
  $_vimageh = $_vimageratio * $style['image_height'];
?>

<?php echo $asp_res_ids; ?>.horizontal .results .item .image {
  width: <?php echo $_vimagew ?>px;
  height: <?php echo $_vimageh; ?>px;
  <?php echo $style['hresultimageborder']; ?>
  float: none;
  margin: 0 auto 6px;
  position: relative;
}

<?php echo $asp_res_ids; ?>.horizontal .results .item .image img + div {
  <?php echo $style['hresultimageshadow']; ?>
  position: absolute;
  width: <?php echo $_vimagew ?>px;
  height: <?php echo $_vimageh; ?>px;
  top: 0;
  left: 0;
}

<?php echo $asp_res_ids; ?> .results .item .content {
  overflow: hidden;
  width: 50%;
  height: <?php echo $style['resultitemheight']; ?>;
  background: transparent;
  margin: 0;
  padding: 0 10px;
}

<?php echo $asp_res_ids; ?> .results .item .content h3 {
  margin: 0;
  padding: 0;
  line-height: inherit;
  <?php echo str_replace("--g--", "", $style['titlefont']); ?>
}

<?php echo $asp_res_ids; ?>.horizontal .results .item .content h3 a {
  text-align: center;
}

<?php echo $asp_res_ids; ?> .results .item .content h3 a {
  margin: 0;
  padding: 0;
  line-height: inherit;
  <?php echo str_replace("--g--", "", $style['titlefont']); ?>
}

<?php echo $asp_res_ids; ?> .results .item .content h3 a:hover {
  <?php echo $style['titlehoverfont']; ?>
}

<?php echo $asp_res_ids; ?> .results .item div.etc {
  padding: 0;
  line-height: 10px;
  <?php echo str_replace("--g--", "", $style['authorfont']); ?>
}

<?php echo $asp_res_ids; ?> .results .item .etc .author {
  padding: 0;
  <?php echo str_replace("--g--", "", $style['authorfont']); ?>
}

<?php echo $asp_res_ids; ?> .results .item .etc .date {
  margin: 0 0 0 10px;
  padding: 0;
  <?php echo str_replace("--g--", "", $style['datefont']); ?>
}

<?php echo $asp_res_ids; ?> .results .item p.desc {
  margin: 2px 0px;
  padding: 0;
  <?php echo str_replace("--g--", "", $style['descfont']); ?>
}

<?php echo $asp_res_ids; ?> .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
	background:#fff; /* rgba fallback */
	background:rgba(<?php echo wpdreams_hex2rgb($style['overflowcolor']); ?>,0.9);
	filter:"alpha(opacity=90)"; -ms-filter:"alpha(opacity=90)"; /* old ie */
}

<?php echo $asp_res_ids; ?> .mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{
	background:rgba(<?php echo wpdreams_hex2rgb($style['overflowcolor']); ?>,0.95);
	filter:"alpha(opacity=95)"; -ms-filter:"alpha(opacity=95)"; /* old ie */
}
<?php echo $asp_res_ids; ?> .mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
<?php echo $asp_res_ids; ?> .mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{
	background:rgba(<?php echo wpdreams_hex2rgb($style['overflowcolor']); ?>,1);
	filter:"alpha(opacity=100)"; -ms-filter:"alpha(opacity=100)"; /* old ie */
}

<?php echo $asp_res_ids; ?>.horizontal .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
	background:#fff; /* rgba fallback */
	background:<?php echo $style['hoverflowcolor']; ?>;
  opacity: 0.9;
	filter:"alpha(opacity=90)"; -ms-filter:"alpha(opacity=90)"; /* old ie */
}
<?php echo $asp_res_ids; ?>.horizontal .mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{
	background:<?php echo $style['hoverflowcolor']; ?>;
  opacilty: 0.95;
	filter:"alpha(opacity=95)"; -ms-filter:"alpha(opacity=95)"; /* old ie */
}

<?php echo $asp_res_ids; ?>.horizontal .mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
<?php echo $asp_res_ids; ?>.horizontal .mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{
	background: <?php echo $style['hoverflowcolor']; ?>;
	filter:"alpha(opacity=100)"; -ms-filter:"alpha(opacity=100)"; /* old ie */
}

<?php echo $asp_res_ids; ?> .mCSB_scrollTools .mCSB_buttonDown:after { border-color: rgba(136, 183, 213, 0); border-top-color: <?php echo $style['arrowcolor']; ?>; border-width: 6px; left: 50%; margin-left: -6px; }
<?php echo $asp_res_ids; ?> .mCSB_scrollTools .mCSB_buttonUp:after { border-color: rgba(136, 183, 213, 0); border-bottom-color:  <?php echo $style['arrowcolor']; ?>; border-width: 6px; left: 50%; margin-left: -6px; }

<?php echo $asp_res_ids; ?> span.highlighted{
    font-weight: bold;
    color: #d9312b;
    background-color: #eee;
    color: <?php echo $style['highlightcolor'] ?>;
    background-color: <?php echo $style['highlightbgcolor'] ?>;
}

<?php echo $asp_res_ids; ?> p.showmore {
  text-align: center;
  padding: 0;
  margin: 0;
  <?php echo str_replace("--g--", "", $style['showmorefont']); ?>
}

<?php echo $asp_res_ids; ?> p.showmore a{
  <?php echo str_replace("--g--", "", $style['showmorefont']); ?>
}

<?php echo $asp_res_ids; ?> .group {
  background: #DDDDDD;
  background: <?php echo $style['exsearchincategoriesboxcolor']; ?>;
  border-radius: 3px 3px 0 0;
  border-top: 1px solid <?php echo $style['groupingbordercolor']; ?>;
  border-left: 1px solid <?php echo $style['groupingbordercolor']; ?>;
  border-right: 1px solid <?php echo $style['groupingbordercolor']; ?>;
  margin: 10px 0 -3px;
  padding: 7px 0 7px 10px;
  position: relative;
  z-index: 1000;
  <?php echo str_replace("--g--", "", $style['groupbytextfont']); ?>
}

<?php echo $asp_res_ids; ?>.isotopic {
    margin: <?php echo wpdreams_four_to_string($style['i_res_container_margin']); ?>;
    padding: <?php echo wpdreams_four_to_string($style['i_res_container_padding']); ?>;
    background: <?php echo $style['i_res_container_bg']; ?>;
}

<?php echo $asp_res_ids; ?>.isotopic .results .item {
    width: <?php echo $style['i_item_width']; ?>px;
    height: <?php echo $style['i_item_height']; ?>px;
}

<?php echo $asp_res_ids; ?>.isotopic .results .item .content {
    background: <?php echo $style['i_res_item_content_background']; ?>;
}

/* Isotopic navigation */
<?php echo $asp_res_ids; ?>.isotopic>nav,
<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation {
    background: <?php echo $style['i_pagination_background']; ?>;
}

<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation a.asp_prev,
<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation a.asp_next {
    background: <?php echo $style['i_pagination_arrow_background']; ?>;
}

<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation a.asp_prev svg,
<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation a.asp_next svg {
    fill: <?php echo $style['i_pagination_arrow_color']; ?>;
}

<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation ul li.asp_active {
    background: <?php echo $style['i_pagination_arrow_background']; ?>;
}

<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation ul li:hover {
    background: <?php echo $style['i_pagination_arrow_background']; ?>;
}

<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation ul li.asp_active {
    background: <?php echo $style['i_pagination_page_background']; ?>;
}

<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation ul li:hover {
    background: <?php echo $style['i_pagination_page_background']; ?>;
}

<?php echo $asp_res_ids; ?>.isotopic nav.asp_navigation ul li span {
    color:  <?php echo $style['i_pagination_font_color']; ?>;
}


/* Search settings */

<?php echo $asp_set_ids; ?>.searchsettings  {
  background: <?php echo wpdreams_gradient_css($style['settingsdropbackground']); ?>;
  <?php echo $style['settingsdropboxshadow']; ?>;
}

<?php echo $asp_set_ids; ?>.searchsettings .label {
  <?php echo str_replace("--g--", "", $style['settingsdropfont']); ?>
}


<?php echo $asp_set_ids; ?>.searchsettings .option label {
  <?php wpdreams_gradient_css($style['settingsdroptickbggradient']); ?>;
}

<?php echo $asp_set_ids; ?>.searchsettings .option label:after {
	border: 3px solid <?php echo $style['settingsdroptickcolor'] ?>;
    border-right: none;
    border-top: none;
}

<?php echo $asp_set_ids; ?>.searchsettings fieldset .categoryfilter {
  max-height: <?php echo $style['exsearchincategoriesheight']; ?>px;
  overflow: auto;
}

<?php echo $asp_set_ids; ?>.searchsettings  fieldset legend {
  padding: 5px 0 0 10px;
  margin: 0;
  <?php echo $style['exsearchincategoriestextfont']; ?>
}

<?php echo $asp_res_ids; ?>.horizontal .results .mCSB_scrollTools .mCSB_buttonLeft:after { border-color: rgba(136, 183, 213, 0); border-right-color: <?php echo $style['harrowcolor']; ?>; border-width: 7px; top: 50%; margin-top:  -7px; left: 5px; }
<?php echo $asp_res_ids; ?>.horizontal .results .mCSB_scrollTools .mCSB_buttonRight:after { border-color: rgba(136, 183, 213, 0); border-left-color: <?php echo $style['harrowcolor']; ?>; border-width: 7px; top: 50%; margin-top:  -7px; left: 5px; }


<?php echo $asp_res_ids; ?> .photostack {
  <?php wpdreams_gradient_css($style['prescontainerbg']); ?>;
}

<?php echo $asp_res_ids; ?> .photostack figure {
	width: <?php echo $style['preswidth'] ?>;
	height: <?php echo $style['presheight'] ?>;
	position: relative;
	display: inline-block;
	background: #fff;
	padding: <?php echo $style['prespadding'] ?>;
	text-align: center;
	margin: 5px;
}

<?php echo $asp_res_ids; ?> .photostack figcaption h2 {
	margin: 20px 0 0 0;
  <?php echo str_replace("--g--", "", $style['prestitlefont']); ?>;
}

<?php echo $asp_res_ids; ?> .photostack figcaption h2 a {
  <?php echo str_replace("--g--", "", $style['prestitlefont']); ?>;
}
<?php echo $asp_res_ids; ?> .photostack .etc {
  <?php echo str_replace("--g--", "", $style['pressubtitlefont']); ?>;
}

<?php echo $asp_res_ids; ?> .photostack-img {
	width: <?php echo (wpdreams_width_from_px($style['preswidth'])- 2*wpdreams_width_from_px($style['prespadding'])); ?>px;
	height: <?php echo (wpdreams_width_from_px($style['preswidth'])- 2*wpdreams_width_from_px($style['prespadding'])); ?>px;
  <?php echo str_replace("--g--", "", $style['pressubtitlefont']); ?>;
}

<?php echo $asp_res_ids; ?> .photostack-back {
  <?php echo str_replace("--g--", "", $style['presdescfont']); ?>;
}

<?php echo $asp_res_ids; ?> .photostack nav span {
  <?php wpdreams_gradient_css($style['pdotssmallcolor']); ?>;
}

<?php echo $asp_res_ids; ?> .photostack nav span.current {
  <?php wpdreams_gradient_css($style['pdotscurrentcolor']); ?>;
}

<?php echo $asp_res_ids; ?> .photostack nav span.current.flip {
  <?php wpdreams_gradient_css($style['pdotsflippedcolor']); ?>;
}