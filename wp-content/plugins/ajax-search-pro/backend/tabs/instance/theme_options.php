<ul id="tabs"  class='tabs'>
    <li><a tabid="8" class='subtheme current'>Overall box layout</a></li>
    <li><a tabid="9" class='subtheme'>Input field layout</a></li>
    <li><a tabid="10" class='subtheme'>Settings icon & dropdown</a></li>
    <li><a tabid="11" class='subtheme'>Magnifier & loading icon</a></li>
    <li><a tabid="16" class='subtheme'>Isotopic Results</a></li>
    <li><a tabid="17" class='subtheme'>Isotopic Navigation</a></li>
    <li><a tabid="12" class='subtheme'>Vertical Results</a></li>
    <li><a tabid="14" class='subtheme'>Horizontal Results</a></li>
    <li><a tabid="15" class='subtheme'>Polaroid Results</a></li>
    <li><a tabid="13" class='subtheme'>Typography</a></li>
    <li><a tabid="18" class='subtheme'>Custom CSS</a></li>
</ul>
<div class='tabscontent'>

    <div tabid="8">
        <?php include(ASP_PATH."backend/tabs/instance/theme/overall_box.php"); ?>
    </div> <!-- tab 8 -->
    <div tabid="9">
        <?php include(ASP_PATH."backend/tabs/instance/theme/input_field.php"); ?>
    </div> <!-- tab 9 -->
    <div tabid="10">
        <?php include(ASP_PATH."backend/tabs/instance/theme/sett_dropdown.php"); ?>
    </div> <!-- tab 10 -->
    <div tabid="11">
        <?php include(ASP_PATH."backend/tabs/instance/theme/magn_load.php"); ?>
    </div> <!-- tab 11 -->
    <div tabid="12">
        <?php include(ASP_PATH."backend/tabs/instance/theme/vertical_res.php"); ?>
    </div> <!-- tab 12 -->
    <div tabid="13">
        <?php include(ASP_PATH."backend/tabs/instance/theme/typography.php"); ?>
    </div> <!-- tab 13 -->

    <div tabid="14">
        <?php include(ASP_PATH."backend/tabs/instance/theme/horizontal_res.php"); ?>
    </div> <!-- tab 14 -->

    <div tabid="15">
        <?php include(ASP_PATH."backend/tabs/instance/theme/polaroid_res.php"); ?>
    </div> <!-- tab 15 -->

    <div tabid="16">
        <?php include(ASP_PATH."backend/tabs/instance/theme/isotopic_res.php"); ?>
    </div> <!-- tab 16 -->

    <div tabid="17">
        <?php include(ASP_PATH."backend/tabs/instance/theme/isotopic_nav.php"); ?>
    </div> <!-- tab 17 -->

    <div tabid="18">
        <?php include(ASP_PATH."backend/tabs/instance/theme/custom_css.php"); ?>
    </div> <!-- tab 18 -->

</div> <!-- .tabscontent -->

<?php if(ASP_DEBUG==1): ?>
    <textarea class='previewtextarea' style='display:block;width:600px;'>
    </textarea>
<?php endif; ?>

<script>
    jQuery(document).ready(function() {
        (function( $ ){
            $(".previewtextarea").click(function(){
                var parent = $(this).parent().parent();
                var content = "";
                var v = "";
                $("input[isparam=1], select[isparam=1]", parent).each(function(){
                    var name = $(this).attr("name");
                    var val = $(this).val().replace(/(\r\n|\n|\r)/gm,"");
                    content += '"'+name+'":"'+val+'",\n';
                });
                //$(this).val(content+v);

                $("div[tabid=4] input[isparam=1], div[tabid=4] select[isparam=1]").each(function(){
                    var name = $(this).attr("name");
                    var val = $(this).val().replace(/(\r\n|\n|\r)/gm,"");
                    content += '"'+name+'":"'+val+'",\n';
                });

                content = content.trim();
                content = content.slice(0, - 1);
                $(this).val('"theme": {\n' + content + "\n}");
            });
        }(jQuery))
    });
</script>
<div class="item">
    <input name="submit_<?php echo $search['id']; ?>" type="submit" value="Save this search!" />
</div>