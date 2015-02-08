<ul id="subtabs"  class='tabs'>
    <li><a tabid="101" class='subtheme current'>Sources</a></li>
    <li><a tabid="102" class='subtheme'>Behaviour</a></li>
    <li><a tabid="103" class='subtheme'>Image Options</a></li>
    <li><a tabid="104" class='subtheme'>BuddyPress Options</a></li>
</ul>
<div class='tabscontent'>
    <div tabid="101">
        <fieldset>
            <legend>Output options</legend>
            <?php include(ASP_PATH."backend/tabs/instance/general/sources.php"); ?>
        </fieldset>
    </div>
    <div tabid="102">
        <fieldset>
            <legend>Filter display Options</legend>
            <?php include(ASP_PATH."backend/tabs/instance/general/behaviour.php"); ?>
        </fieldset>
    </div>
    <div tabid="103">
        <fieldset>
            <legend>Image Options</legend>
            <?php include(ASP_PATH."backend/tabs/instance/general/image_options.php"); ?>
        </fieldset>
    </div>
    <div tabid="104">
        <fieldset>
            <legend>BuddyPress Options</legend>
            <?php include(ASP_PATH."backend/tabs/instance/general/buddypress_options.php"); ?>
        </fieldset>
    </div>
</div>
<div class="item">
    <input name="submit_<?php echo $search['id']; ?>" type="submit" value="Save all tabs!" />
</div>