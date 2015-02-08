<div class="item">
    <?php
    $o = new wpdreamsYesNo("show_frontend_search_settings", "Show search settings on the frontend?", wpdreams_setval_or_getoption($sd, 'show_frontend_search_settings', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item" style="text-align:center;">
    The default values of the checkboxes on the frontend are the values set above.
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showexactmatches", "Show exact matches selector?", wpdreams_setval_or_getoption($sd, 'showexactmatches', $_dk));
    $params[$o->getName()] = $o->getData();
    $o = new wpdreamsText("exactmatchestext", "Text", wpdreams_setval_or_getoption($sd, 'exactmatchestext', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showsearchinposts", "Show search in posts selector?", wpdreams_setval_or_getoption($sd, 'showsearchinposts', $_dk));
    $params[$o->getName()] = $o->getData();
    $o = new wpdreamsText("searchinpoststext", "Text", wpdreams_setval_or_getoption($sd, 'searchinpoststext', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showsearchinpages", "Show search in pages selector?", wpdreams_setval_or_getoption($sd, 'showsearchinpages', $_dk));
    $params[$o->getName()] = $o->getData();
    $o = new wpdreamsText("searchinpagestext", "Text", wpdreams_setval_or_getoption($sd, 'searchinpagestext', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showsearchintitle", "Show search in title selector?", wpdreams_setval_or_getoption($sd, 'showsearchintitle', $_dk));
    $params[$o->getName()] = $o->getData();
    $o = new wpdreamsText("searchintitletext", "Text", wpdreams_setval_or_getoption($sd, 'searchintitletext', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showsearchincontent", "Show search in content selector?", wpdreams_setval_or_getoption($sd, 'showsearchincontent', $_dk));
    $params[$o->getName()] = $o->getData();
    $o = new wpdreamsText("searchincontenttext", "Text", wpdreams_setval_or_getoption($sd, 'searchincontenttext', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showsearchincomments", "Show search in comments selector?", wpdreams_setval_or_getoption($sd, 'showsearchincomments', $_dk));
    $params[$o->getName()] = $o->getData();
    $o = new wpdreamsText("searchincommentstext", "Text", wpdreams_setval_or_getoption($sd, 'searchincommentstext', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showsearchinexcerpt", "Show search in excerpt selector?", wpdreams_setval_or_getoption($sd, 'showsearchinexcerpt', $_dk));
    $params[$o->getName()] = $o->getData();
    $o = new wpdreamsText("searchinexcerpttext", "Text", wpdreams_setval_or_getoption($sd, 'searchinexcerpttext', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpdreamsCustomPostTypesEditable("showcustomtypes", "Show search in custom post types selectors", wpdreams_setval_or_getoption($sd, 'showcustomtypes', $_dk));
    $params[$o->getName()] = $o->getData();
    $params['selected-'.$o->getName()] = $o->getSelected();
    ?></div>
<div class="item">
    <p class='infoMsg'>Nor recommended if you have more than 500 categories! (the HTML output will get too big)</p>
    <?php
    $o = new wpdreamsYesNo("showsearchincategories", "Show the categories selectors?", wpdreams_setval_or_getoption($sd, 'showsearchincategories', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showuncategorised", "Show the uncategorised category?", wpdreams_setval_or_getoption($sd, 'showuncategorised', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpdreamsCategories("exsearchincategories", "Select which categories exclude", wpdreams_setval_or_getoption($sd, 'exsearchincategories', $_dk));
    $params[$o->getName()] = $o->getData();
    $params['selected-'.$o->getName()] = $o->getSelected();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showsearchintaxonomies", "Show the taxonomy selectors?", wpdreams_setval_or_getoption($sd, 'showsearchintaxonomies', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsCustomTaxonomyTerm("showterms", "Show the following taxonomy term selectors on frontend", array("value"=>wpdreams_setval_or_getoption($sd, 'showterms', $_dk), "type"=>"include"));
    $params[$o->getName()] = $o->getData();
    $params['selected-'.$o->getName()] = $o->getSelected();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsText("exsearchincategoriesheight", "Filter boxes max-height (0 for auto, default 200)", wpdreams_setval_or_getoption($sd, 'exsearchincategoriesheight', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("showseparatefilterboxes", "Show separate filter boxes for each taxonomy?", wpdreams_setval_or_getoption($sd, 'showseparatefilterboxes', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsText("exsearchincategoriestext", "Categories filter box header text", wpdreams_setval_or_getoption($sd, 'exsearchincategoriestext', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsText("exsearchintaxonomiestext", "Taxonomies filter box header text", wpdreams_setval_or_getoption($sd, 'exsearchintaxonomiestext', $_dk));
    ?>{taxonomy name}<?php
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <input name="submit_<?php echo $search['id']; ?>" type="submit" value="Save all tabs!" />
</div>   