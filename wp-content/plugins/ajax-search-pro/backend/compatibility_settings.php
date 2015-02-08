<?php $com_options = get_option('asp_compatibility'); ?>

<div id="wpdreams" class='wpdreams wrap'>
<div class="wpdreams-box">
  <?php ob_start(); ?>
  <div class="item">
      <?php
      $o = new wpdreamsCustomSelect("js_source", "Javascript source", array(
              'selects'=>wpdreams_setval_or_getoption($com_options, 'js_source_def', 'asp_compatibility_def'),
              'value'=>wpdreams_setval_or_getoption($com_options, 'js_source', 'asp_compatibility_def')
          )
      );
      $params[$o->getName()] = $o->getData();
      ?>
      <p class="descMsg">
      <ul style="float:right;text-align:left;width:50%;">
          <li><b>Non minified</b> - Low Compatibility, Medium space</li>
          <li><b>Minified</b> - Low Compatibility, Low space</li>
          <li><b>Non minified Scoped</b> - High Compatibility, High space</li>
          <li><b>Minified Scoped</b> - High Compatibility, Medium space</li>
      </ul>
      <div class="clear"></div>
      </p>
  </div>
  <div class="item">
  <p class='infoMsg'>Set to yes if you are experiencing issues with the <b>search styling</b>, or if the styles are <b>not saving</b>!</p>
  <?php $o = new wpdreamsYesNo("forceinlinestyles", "Force inline styles?",
      wpdreams_setval_or_getoption($com_options, 'forceinlinestyles', 'asp_compatibility_def')
  ); ?>
  </div>
  <div class="item">
  <p class='infoMsg'>You can turn this off, if you are not using the polaroid-styled result list.</p>
  <?php $o = new wpdreamsYesNo("loadpolaroidjs", "Load the polaroid gallery js?",
        wpdreams_setval_or_getoption($com_options, 'loadpolaroidjs', 'asp_compatibility_def')
  ); ?>
  </div>
  <div class="item">
  <p class='infoMsg'>This might speed up the search, but also can cause incompatibility issues with other plugins.</p>
  <?php $o = new wpdreamsYesNo("usecustomajaxhandler", "Use the custom ajax handler?",
        wpdreams_setval_or_getoption($com_options, 'usecustomajaxhandler', 'asp_compatibility_def')
  ); ?>
  </div>
  <div class="item">
    <input type='submit' class='submit' value='Save options'/>
  </div>
  <?php $_r = ob_get_clean(); ?>
  

  <?php
    $updated = false;
    if (isset($_POST) && isset($_POST['asp_compatibility']) && (wpdreamsType::getErrorNum()==0)) {
        $values = array(
            "js_source" => $_POST['js_source'],
            "forceinlinestyles" => $_POST['forceinlinestyles'],
            "loadpolaroidjs" => $_POST['loadpolaroidjs'],
            "usecustomajaxhandler" => $_POST['usecustomajaxhandler']
        );
        update_option('asp_compatibility', $values);
        $updated = true;
    }
  ?>
  <?php
  $_comp = wpdreamsCompatibility::Instance();
  if ($_comp->has_errors()): 
  ?>
  <div class="wpdreams-slider errorbox">
          <p class='errors'>Possible incompatibility! Please go to the <a href="<?php echo get_admin_url()."admin.php?page=ajax-search-pro/comp_check.php"; ?>">error check</a> page to see the details and solutions!</p> 
  </div>
  <?php endif; ?>
  <div class='wpdreams-slider'>
  <form name='caching' method='post'>
    <?php if($updated): ?><div class='successMsg'>Search caching settings successfuly updated!</div><?php endif; ?>
    <fieldset>
      <legend>Compatibility Options</legend>
      <?php print $_r; ?> 
      <input type='hidden' name='asp_compatibility' value='1' />
    </fieldset>
  </form>
  </div>        
</div>
</div>