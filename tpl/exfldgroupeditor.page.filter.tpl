<!-- BEGIN: MAIN -->
<!-- IF {LIST_FILTERS_COUNT} -->
<div style="float:right; width:350px;">
	<form action="{LIST_FILTERS_URL}" method="get" name="general">
{LIST_FILTERS_HIDDEN}
{LIST_FILTERS_ORDER}{LIST_FILTERS_WAY}
<h2>Подбор товара:</h2>
<table>
<!-- BEGIN: EXTRAFLD -->
	<!-- IF {EXTRAFLD_TYPE} == 'separator' -->
	<tr>
		<td colspan="2">{EXTRAFLD_TITLE}</td>
	</tr>
	<!-- ELSE -->
		<tr>

<!-- IF {EXTRAFLD_TYPE} == 'checkbox' -->

		
			<td colspan="2"> {EXTRAFLD}</td>
<!-- ELSE -->
	<td>{EXTRAFLD_TITLE}:</td>
			<td>{EXTRAFLD}</td>
<!-- ENDIF -->
		</tr>

	<!-- ENDIF -->
	
<!-- END: EXTRAFLD -->
</table>
	<input class="button" type="submit"  value="{PHP.L.Submit}" />
</form>
</div>
<!-- ENDIF -->
<!-- END: MAIN -->