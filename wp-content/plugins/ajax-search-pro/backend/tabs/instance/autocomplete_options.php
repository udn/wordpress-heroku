<div class="item"><?php
    $o = new wpdreamsYesNo("autocomplete", "Turn on search autocomplete?", setval_or_getoption($sd, 'autocomplete', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpdreamsCustomSelect("autocompletesource", "Autocomplete source", array(
        'selects'=>wpdreams_setval_or_getoption($sd, 'autocompletesource_def', $_dk),
        'value'=>wpdreams_setval_or_getoption($sd, 'autocompletesource', $_dk)
    ));
    $params[$o->getName()] = $o->getData();
    $params["selected-".$o->getName()] = $o->getSelected();
    ?></div>
<div class="item"><?php
    $o = new wpdreamsTextarea("autocompleteexceptions", "Keyword exceptions (comma separated)", wpdreams_setval_or_getoption($sd, 'autocompleteexceptions', $_dk));
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <input name="submit_<?php echo $search['id']; ?>" type="submit" value="Save all tabs!" />
</div>