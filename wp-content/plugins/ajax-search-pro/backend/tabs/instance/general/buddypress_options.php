<div class="item">
    <?php
    $o = new wpdreamsYesNo("search_in_bp_users", "Search in buddypress users?",
        wpdreams_setval_or_getoption($sd, 'search_in_bp_users', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("search_in_bp_groups", "Search in buddypress groups?",
        wpdreams_setval_or_getoption($sd, 'search_in_bp_groups', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("search_in_bp_activities", "Search in buddypress activities?",
        wpdreams_setval_or_getoption($sd, 'search_in_bp_activities', $_dk));
    $params[$o->getName()] = $o->getData();
    ?>
</div>