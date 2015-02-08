<?php get_header(); ?>

<div class="container clearfix titlecontainer">
  
    <!-- Page Title
    ================================================== -->
    <div class="pagetitlewrap">
        <h3 class="pagetitle"><?php _e('Page Not Found', 'framework'); ?></h3>
        <span class="description">
          <p>
            <?php _e("Sorry, but you are looking for something that isn't here.", 'framework'); ?>
          </p>
        </span>
    </div>
    <div class="clear"></div>

    <!-- Page Content
      ================================================== -->
    <div class="maincontent page">
        <!-- Nothing found -->
        <h4><?php _e('Try searching for it:', 'framework'); ?></h4>
        <p><?php get_search_form(true); ?></p>

        <div class="clear"></div>
    </div>

    <!-- Sidebar
      ================================================== -->      
    <div class="sidebar">
        <?php  /* Widget Area */ if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Page Sidebar') ) ?>
    </div>

    <div class="clear"></div>

</div>
<?php get_footer(); ?>