<div class="item">
    <?php
    $o = new wpdreamsYesNo("keywordsuggestions", "Keyword suggestions on no results?",
        wpdreams_setval_or_getoption($sd, 'keywordsuggestions', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsLanguageSelect("keywordsuggestionslang", "Keyword suggestions language",
        wpdreams_setval_or_getoption($sd, 'keywordsuggestionslang', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsCustomSelect("orderby", "Result ordering",
        array(
            'selects' => wpdreams_setval_or_getoption($sd, 'orderby_def', $_dk),
            'value' => wpdreams_setval_or_getoption($sd, 'orderby', $_dk)
        ));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("triggeronclick", "Trigger search when clicking on search icon?",
        wpdreams_setval_or_getoption($sd, 'triggeronclick', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("redirectonclick", "<b>Redirect</b> to search results page when clicking on search icon?",
        wpdreams_setval_or_getoption($sd, 'redirectonclick', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("redirect_on_enter", "<b>Redirect</b> to search results page when hitting the return key?",
        wpdreams_setval_or_getoption($sd, 'redirect_on_enter', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsText("redirect_url", "<b>Redirect</b> to url?",
        wpdreams_setval_or_getoption($sd, 'redirect_url', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("override_default_results", "<b>Override</b> the default WordPress search results page?",
        wpdreams_setval_or_getoption($sd, 'override_default_results', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("triggerontype", "Trigger search when typing?",
        wpdreams_setval_or_getoption($sd, 'triggerontype', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsTextSmall("charcount", "Minimal character count to trigger search",
        wpdreams_setval_or_getoption($sd, 'charcount', $_dk), array(array("func" => "ctype_digit", "op" => "eq", "val" => true)));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsTextSmall("maxresults", "Max. results", wpdreams_setval_or_getoption($sd, 'maxresults', $_dk), array(array("func" => "ctype_digit", "op" => "eq", "val" => true)));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsTextSmall("itemscount", "Results box viewport (in item numbers)", wpdreams_setval_or_getoption($sd, 'itemscount', $_dk), array(array("func" => "ctype_digit", "op" => "eq", "val" => true)));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
