<!-- BEGIN: MAIN -->
<table>
	<tr>
		<td colspan="2">Редактор экстраполей</td>
	</tr>
<!-- BEGIN: EXTRAFLD -->
	<!-- IF {EXTRAFLD_TYPE} == 'separator' -->
	<tr>
		<td colspan="2">{EXTRAFLD_TITLE}</td>
	</tr>
	<!-- ELSE -->
	
		<!-- IF {EXTRAFLD_TYPE} != 'checkbox' -->
		<tr>
			<td>{EXTRAFLD_TITLE}:</td>
			<td>{EXTRAFLD}</td>
		</tr>
		<!-- ELSE -->
		<tr>
			<td></td>
			<td>{EXTRAFLD}</td>
		</tr>		
		<!-- ENDIF -->
	<!-- ENDIF -->
	
<!-- END: EXTRAFLD -->
</table>
<!-- END: MAIN -->