<?php
/**
 * The Theme Header
 * @package WordPress
 * @subpackage Bookcase
 * @since ExtraNews 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<?php
global $browser;
$browser = $_SERVER['HTTP_USER_AGENT'];
?>
<!-- Basic Page Needs
  ================================================== -->
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php if ( $favicon = of_get_option('of_custom_favicon') ) { echo '<link rel="shortcut icon" href="'. $favicon.'"/>'; } ?>
<title>
<?php 
  /*
   * Print the <title> tag based on what is being viewed.
   */
  global $page, $paged;

  wp_title( '|', true, 'right' );

  // Add the blog name.
  bloginfo( 'name' );

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) )
    echo " | $site_description";

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 )
    echo ' | ' . sprintf( __( 'Page %s', 'ellipsis' ), max( $paged, $page ) );

  ?>
</title>
<?php 

$cyrillic = of_get_option('of_cyrillic_chars');

  if ($cyrillic == 'Yes') { $cyrillic_suffix = '::cyrillic,latin'; } else { $cyrillic_suffix = ''; }   ?>  

    <!-- Embed Google Web Fonts Via API -->
    <script type="text/javascript">
          WebFontConfig = {
            google: { families: [ 
                    "<?php if ( $slide_header = of_get_option('of_heading_font') ) { 
                        echo (function_exists('ag_is_default')) ? ag_is_default($slide_header['face']) . $cyrillic_suffix : $slide_header['face'] . $cyrillic_suffix; 
                      } else { 
                        echo 'Bitter';
                      } ?>",
                    "<?php if ( $slide_subtitle = of_get_option('of_secondary_font') ) { 
                        echo (function_exists('ag_is_default')) ? ag_is_default($slide_subtitle['face']) . $cyrillic_suffix : $slide_subtitle['face'] . $cyrillic_suffix; 
                      } else { 
                        echo 'Bitter';
                      } ?>",                   
                    "<?php if ( $sf_font = of_get_option('of_nav_font') ) { 
                        echo (function_exists('ag_is_default')) ? ag_is_default($sf_font['face']) . $cyrillic_suffix : $sf_font['face'] . $cyrillic_suffix; 
                      } else { 
                        echo 'Droid Sans';
                      } ?>",                   
                    "<?php if ( $h1font = of_get_option('of_p_font') ) { 
                        echo (function_exists('ag_is_default')) ? ag_is_default($h1font['face']) . $cyrillic_suffix : $h1font['face'] . $cyrillic_suffix; 
                      } else { 
                        echo 'Open Sans'; 
                      } ?>", 
                    "<?php if ( $h2font = of_get_option('of_tiny_font') ) { 
                        echo (function_exists('ag_is_default')) ? ag_is_default($h2font['face']) . $cyrillic_suffix : $h2font['face'] . $cyrillic_suffix; 
                      } else { 
                        echo 'Open Sans';
                      } ?>"] }
          };
          (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
          })();
    </script>

<link href="<?php bloginfo( 'stylesheet_url' ); ?>" rel="stylesheet" type="text/css" media="all" />
<!--Site Layout -->
<?php wp_head(); ?>

<?php if ( $customcss = of_get_option('of_custom_css') ) { 
echo '<style type="text/css">
' . $customcss . '
</style>'; } ?>

<!-- Mobile Specific Metas
  ================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

</head>
<body <?php body_class(); ?>>

<noscript>
  <div class="alert">
    <p><?php _e('Please enable javascript to view this site.', 'framework'); ?></p>
  </div>
</noscript>

<!-- Preload Images 
  ================================================== -->
<div id="preloaded-images"> 
  <!-- Icons -->
  <img src="<?php echo get_template_directory_uri();?>/images/icons/social/e_light.png" width="1" height="1" alt="Image" />
  <img src="<?php echo get_template_directory_uri();?>/images/icons/social/fb_light.png" width="1" height="1" alt="Image" />
  <img src="<?php echo get_template_directory_uri();?>/images/icons/social/g_light.png" width="1" height="1" alt="Image" />
  <img src="<?php echo get_template_directory_uri();?>/images/icons/social/p_light.png" width="1" height="1" alt="Image" />
  <img src="<?php echo get_template_directory_uri();?>/images/icons/social/tw_light.png" width="1" height="1" alt="Image" />
  <!-- Slider Elements -->
  <img src="<?php echo get_template_directory_uri();?>/images/linebg-fade.png" width="1" height="1" alt="Image" />
  <img src="<?php echo get_template_directory_uri();?>/images/75black.png" width="1" height="1" alt="Image" />
  <!--Loading Images -->
  <img src="<?php echo get_template_directory_uri();?>/images/loading.gif" width="1" height="1" alt="Image" />
  <img src="<?php echo get_template_directory_uri();?>/images/small-loading.gif" width="1" height="1" alt="Image" />
  <!-- Arrows -->
  <img src="<?php echo get_template_directory_uri();?>/images/stars-over.png" width="1" height="1" alt="Image" />
</div>

<!-- Top Bar
  ================================================== -->
 <?php if ( $topbar = of_get_option('of_top_bar') ) { 
    if ($topbar == 'On') { ?>
      <div class="topbar">
      <div class="container clearfix">
        <div class="alignleft">
          <a href="<?php echo home_url(); ?>">
            <?php if ( $logo = of_get_option('of_logo') ) { ?>
            <img src="<?php echo $logo; ?>" alt="<?php bloginfo( 'name' ); ?>" class="logo_force_height"/>
            <?php } else { bloginfo( 'name' );} ?>
          </a> 
        </div>

        <div class="alignleft_menu ">            
          <div class="not_show_on_mobile">
            <?php if ( has_nav_menu( 'top_nav_menu' ) ) { /* if menu location 'Top Navigation Menu' exists then use custom menu */ ?>
            <?php wp_nav_menu( array('menu' => 'Top Bar Navigation Menu', 'theme_location' => 'top_nav_menu', 'menu_class' => 'sf-menu')); ?>
            <?php } ?>
          </div>

          <div class="mobilenavcontainer"> 
            <?php $menutext = of_get_option('of_menu_text');
            if ($menutext == ''){ $menutext = __('Select a Page', 'framework'); } ?>
            <a id="jump_top" href="#mobilenav_top" class="scroll"><?php echo  $menutext; ?></a><div class="clear"></div>
            <div class="mobilenavigation">
              <?php if ( has_nav_menu( 'top_nav_menu' ) ) { /* if menu location 'Top Navigation Menu' exists then use custom menu */ ?>
              <?php wp_nav_menu( array('menu' => 'Top Navigation Menu', 'theme_location' => 'top_nav_menu', 'items_wrap' => '<ul id="mobilenav_top"><li id="back_top"><a href="#top" class="menutop">'. __('Hide Navigation', 'framework') . '</a></li>%3$s</ul>')); ?>
              <?php } ?>
            </div> 
            <div class="clear"></div>
          </div> 
          <div class="clear"></div>
        </div>

        <div class="alignleft">
            <?php  /* Widget Area */ if ( !function_exists( 'dynamic_sidebar' ) || '<h1>Search</h1>'.!dynamic_sidebar('Top Menu') ) ?>
        </div> 

        <div class="clear"></div>
      </div>
    </div>
<?php }
} ?>

<!-- Site Container 
  ================================================== -->
<div class="sitecontainer container">
<div class="container clearfix navcontainer">
    
    <div class="mobileclear"></div>
    <div class="headerwidget">
        <div class="logowidget">
          <?php  /* Widget Area */ if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Top Area') ) ?>
        </div>
    </div>
    <div class="clear"></div>

        <!--End Navigation-->
    <div class="clear"></div>
</div>
<div class="top"> <a href="#"><?php _e('Scroll to top', 'framework'); ?></a>
    <div class="clear"></div>
    <div class="scroll">
        <p>
            <?php _e('Top', 'framework'); ?>
        </p>
    </div>
</div>
<?php   if ( !($sidebar = of_get_option('of_sidebar_width') ) ) { $sidebar = 'default'; } else { $sidebar = of_get_option('of_sidebar_width'); } ?>
<!-- Start Mainbody
  ================================================== -->
<div class="mainbody <?php echo ($sidebar == 'extended') ? 'extended' : ''; ?>">