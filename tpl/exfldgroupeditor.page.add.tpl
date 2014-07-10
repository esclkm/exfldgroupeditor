<!-- BEGIN: MAIN -->
	<tr>
		<td colspan="2">Редактор экстраполей</td>
	</tr>
<!-- BEGIN: EXTRAFLD -->
	<!-- IF {FORM_EXTRAFLD_TYPE} == 'separator' -->
	<tr>
		<td colspan="2">{FORM_EXTRAFLD_TITLE}</td>
	</tr>
	<!-- ELSE -->
	
		<!-- IF {FORM_EXTRAFLD_TYPE} != 'checkbox' -->
		<tr>
			<td>{FORM_EXTRAFLD_TITLE}:</td>
			<td>{FORM_EXTRAFLD}</td>
		</tr>
		<!-- ELSE -->
		<tr>
			<td></td>
			<td>{FORM_EXTRAFLD}</td>
		</tr>		
		<!-- ENDIF -->
	<!-- ENDIF -->
	
<!-- END: EXTRAFLD -->
<!-- END: MAIN -->