<ul id="subtabs"  class='tabs'>
    <li><a tabid="201" class='subtheme current'>Results layout</a></li>
    <li><a tabid="202" class='subtheme'>Results Behaviour</a></li>
</ul>
<div class='tabscontent'>
    <div tabid="201">
        <fieldset>
            <legend>Results layout</legend>
            <?php include(ASP_PATH."backend/tabs/instance/layout/results_layout.php"); ?>
        </fieldset>
    </div>
    <div tabid="202">
        <fieldset>
            <legend>Results Behaviour</legend>
            <?php include(ASP_PATH."backend/tabs/instance/layout/results_behaviour.php"); ?>
        </fieldset>
    </div>
</div>
<div class="item">
    <input name="submit_<?php echo $search['id']; ?>" type="submit" value="Save all tabs!" />
</div>