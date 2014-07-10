<!-- BEGIN: MAIN -->
<a class="button" href="{PHP|cot_url('admin','m=other&p=exfldgroupeditor&l=filter')}">{PHP.L.Filter}</a>
<a class="button" href="{PHP|cot_url('admin','m=other&p=exfldgroupeditor')}">{PHP.L.Add} / {PHP.L.Edit}</a>
<a class="button" href="{PHP.db_pages|cot_url('admin', 'm=extrafields&n=$this')}">{PHP.L.adm_extrafields_desc}</a>


<div class="block">
	<form action="{EXFLD_CATACTION}" method="get" name="general">
    <!-- IF {EXFLD_CAT_URL} -->
    <div>
    Существующие фильтры:
<!-- BEGIN: CATEXISTS -->
    <a class="button" href="{EXFLD_CAT_URL}">{EXFLD_CAT_NAME}</a>
 <!-- END: CATEXISTS -->   
    </div>
    <!-- ENDIF -->
{PHP.L.Select_cat} : {EXFLD_CAT} <br />
	<input type="hidden" name="m" value="other" />
	<input type="hidden" name="p" value="exfldgroupeditor" />
	<input class="button confirm large" type="submit"  value="{PHP.L.Submit}" />
</form>
</div>
<!-- BEGIN: EDIT -->
<script type="text/javascript" src="js/jquery.tablednd.min.js"></script>
<script type="text/javascript">
    var qid={PHP.i};
	qid++;
    function removemenugenerator(object)
    {
        var objectparent = $(object).parent();
        objectparent = $(objectparent).parent();
        $(objectparent).find('.rfield').empty();
		$(objectparent).find('.rdesc').attr('value', '');
        $(objectparent).hide();
        return false;
    }

    $(document).ready(function(){
        $("#menugenerator").tableDnD({
            onDragClass:'tabledrag',
            onDrop:function(table,row) {
                var rows = table.tBodies[0].rows;
                for (var i=0; i<rows.length; i++)
                {
                    $(rows[i]).find('.rnum').attr('value', i);
                }
            }
        });
        $(".rnum").hide();
        $("#mg_new").hide();

        $("#addoption").click(function () {
            var object = $('#mg_new').clone().attr("id", 'mg_'+qid);

            $(object).find('.rid').attr('name', 'rid['+qid+']');
            $(object).find('.rnum').attr('name', 'rnum['+qid+']');
            $(object).find('.rfield').attr('name', 'rfield['+qid+']');
            $(object).find('.rdesc').attr('name', 'rdesc['+qid+']');		
			$(object).find('[name^="radd"]').attr('name', 'radd['+qid+']');
			$(object).find('[name^="redit"]').attr('name', 'redit['+qid+']');
			$(object).find('[name^="rpage"]').attr('name', 'rpage['+qid+']');
			$(object).find('[name^="rlist"]').attr('name', 'rlist['+qid+']');
			$(object).find('[name^="rany"]').attr('name', 'rany['+qid+']');
            $(object).insertBefore('#mg_new').show();
            $("#menugenerator").tableDnDUpdate();
            qid++;
        });
        $("#menugeneratorbefore").show();

        if($('.mg_line').length < 2)
        {$("#addoption").click();}

    });
</script>
<div class="block">
<form action="{EXFLD_ACTION}" method="post" name="general">
    <table id="menugenerator" class="cells">
        <tr class="nodrag nodrop">
            <td class="coltop width30">{PHP.L.Extrafield}</td>
            <td class="coltop width20">{PHP.L.Description}</td>
			<td class="coltop width20">{PHP.L.Area}</td>
            <td class="coltop width15"></td>
        </tr>
        <!-- BEGIN: ROW  -->
        <tr id="mg_{EXFLD_ID}" class="mg_line">
            <td>{EXFLD_NUM}{EXFLD_EXFLD}</td>
            <td>{EXFLD_DESC}</td>
			<td>{EXFLD_ADD}{EXFLD_EDIT}{EXFLD_LIST}{EXFLD_PAGE}{EXFLD_ANY}</td>
            <td><input  name='addoption' value='{PHP.L.Delete}' onclick='removemenugenerator(this)' type='button' /></td>
        </tr>
        <!-- END: ROW -->
        <tr id="menugeneratorbefore" class="nodrag nodrop" style="display:none;">
			<td colspan='4'>
                <input  name="addoption" value="{PHP.L.Add}" id="addoption" type="button" class="button special" />
			</td>
		</tr>
    </table>
    <div class="centerall"><input class="button confirm large" type="submit"  value="{PHP.L.Submit}" /></div>
</form>
</div>

<!-- END: EDIT -->

<!-- END: MAIN -->
