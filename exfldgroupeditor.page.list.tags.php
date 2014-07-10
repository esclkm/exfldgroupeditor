<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=page.list.tags
 * [END_COT_EXT]
 */
/**
 * plugin Exfld Group Editor for Cotonti Siena
 * 
 * @package Exfld Group Editor
 * @version 1.0.0
 * @author esclkm
 * @copyright esclkm
 * @license BSD
 *  */
// Generated by Cotonti developer tool (littledev.ru)
defined('COT_CODE') or die('Wrong URL.');



require_once cot_langfile('exfldgroupeditor', 'plug');
require_once cot_langfile('pageplus', 'plug');
require_once cot_incfile('forms');
require_once cot_incfile('exfldgroupeditor', 'plug');
global $exfldcat_list;

function cot_multiadd ($name, $values, $options, $options_titles, $divname)
{
	global $L, $cfg;
			$ppfmiltiadd = '';
			$values = (is_string($values) && !empty($values)) ? array($values) : $values;
			$values = (is_array($values)) ? $values : array('ppf_nomatter');
			foreach ($values as $ppfval)
			{
				$ppfmiltiadd .= '<div class="option'.$divname.'">'
					.cot_selectbox($ppfval, $name.'[]', $options, $options_titles, false, '')
					.'<button name="deloption" type="button" class="deloption'.$row['field_name'].'" title="'.$L['Delete']
					.'" style="display:none;"><img src="'.$cfg['plugins_dir'].'/pageplus/img/minus.png" alt="'.$L['Delete'].'" /></button></div>';
			}
			$ppfmiltiadd.'<button id="addoption'.$divname.'" name="addoption" type="button" title="'.$L['Add'].'" style="display:none;">'
				.'<img src="'.$cfg['plugins_dir'].'/pageplus/img/plus.png" alt="'.$L['Add'].'" /></button>
<script type="text/javascript">
$(".deloption'.$divname.'").live("click",function () {
	$(this).parent().children("select").attr("value", "ppf_nomatter");
	if ($(".option'.$divname.'").length > 1)
	{
		$(this).parent().remove();
	}
	return false;
});

$(document).ready(function(){
	$("#addoption'.$divname.'").click(function () {
	$(".option'.$divname.'").last().clone().insertAfter($(".option'.$divname.'").last()).show().children("select").attr("value","ppf_nomatter");
	return false;
	});
	$("#addoption'.$divname.'").show();
	$(".deloption'.$divname.'").show();
});
</script>';	
			return $ppfmiltiadd;
}

$tex = new XTemplate(cot_tplfile(array('exfldgroupeditor', 'page', 'filter', $c), 'plug'));

$extrafields = cot_exfld_cat_get($c, 'filter');

$matrix = array(
	'inputint' => array('is', 'more', 'less', 'more-less', 'isset', 'select'),
	'currency' => array('is', 'more', 'less', 'more-less', 'isset', 'select'),
	'double' => array('is', 'more', 'less', 'more-less', 'isset', 'select'),
	'datetime' => array('is', 'more', 'less', 'more-less', 'isset', 'shortmore', 'shortless', 'shortmore-less'),
	'file' => array('is', 'like', 'isset'),
	'input' => array('is', 'like', 'isset', 'select'),
	'textarea' => array('is', 'like', 'isset', 'select'),
	'checkbox' => array('is', 'check'),
	'select' => array('is', 'multi', 'radio', 'multiadd'),
	'radio' => array('is', 'multi', 'radio', 'multiadd'),
	'country' => array('is', 'multi', 'radio', 'multiadd'),
);

$order_f = array();
$order_link = array();

foreach ($extrafields as $ex)
{
	$exfld = $cot_extrafields[$db_pages][$ex['ex_field']];
	$row = $exfld;


	if (empty($ex['ex_field']))
	{
		$tex->assign(array(
			'NUM' => $ex['ex_num'],
			'EXTRAFLD' => '',
			'EXTRAFLD_TITLE' => $ex['ex_desc'],
			'EXTRAFLD_TYPE' => 'separator',
			'EXTRAFLD_VALUE' => ''
		));
	}
	else
	{
		if (!in_array($ex['ex_type'], $matrix[$exfld['field_type']]))
		{
			$ex['ex_type'] = 'is';
		}

		$exfld = $cot_extrafields[$db_pages][$ex['ex_field']];
		
		if (!empty($ex['ex_desc']))
		{
			$exfld_title = $ex['ex_desc'];
		}
		else
		{
			$exfld_title = isset($L['page_'.$exfld['field_name'].'_title']) ? $L['page_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
		}
		
		if($ex['ex_filter'])
		{
			$order_f[$ex['ex_field']] = $exfld_title;
			$order_link[cot_url_modify('s='.$ex['ex_field'])] = $exfld_title;
		}
		$exfld_val = '';
		switch ($exfld['field_type'])
		{
		case 'inputint':
		case 'currency':
		case 'double':
			$opt_array = explode(',', $ex['ex_vars']);
			$options = array();
			$options_titles = array();

			$options[] = '';
			$options_titles[] = $L['ppf_nomatter'];
			if (count($opt_array) != 0)
			{
				foreach ($opt_array as $var)
				{
					$options_titles[] = (!empty($L['page_'.$row['field_name'].'_'.$var])) ? $L['page_'.$row['field_name'].'_'.$var] : $var;
					$options[] = $var;
				}
			}

			$ex['ex_type'] == 'is' && $exfld_val = cot_inputbox('text', 'ppf['.$row['field_name'].'][is]', $ppf[$row['field_name']]['is']);
			$ex['ex_type'] == 'isset' && $exfld_val = cot_checkbox($ppf[$row['field_name']]['isset'], 'ppf['.$row['field_name'].'][isset]');
			$ex['ex_type'] == 'more' && $exfld_val = cot_inputbox('text', 'ppf['.$row['field_name'].'][more]', $ppf[$row['field_name']]['more']);
			$ex['ex_type'] == 'less' && $exfld_val = cot_inputbox('text', 'ppf['.$row['field_name'].'][less]', $ppf[$row['field_name']]['less']);
			$ex['ex_type'] == 'more-less' && $exfld_val = cot_inputbox('text', 'ppf['.$row['field_name'].'][more]', $ppf[$row['field_name']]['more'])
				.' - '. cot_inputbox('text', 'ppf['.$row['field_name'].'][less]', $ppf[$row['field_name']]['less']);
			$ex['ex_type'] == 'select' && $exfld_val = cot_selectbox((isset($ppf[$row['field_name']])) ? $ppf[$row['field_name']] : 'ppf_nomatter', 'ppf['.$row['field_name'].'][is]', $options, $options_titles, false, ' multiple="multiple"');	
			break;
		case 'datetime':
			$ex['ex_type'] == 'is' && $exfld_val = cot_selectbox_date($ppf[$row['field_name']]['is'], 'long', 'ppf['.$row['field_name'].'][is]');
			$ex['ex_type'] == 'isset' && $exfld_val = cot_checkbox($ppf[$row['field_name']]['isset'], 'ppf['.$row['field_name'].'][isset]');
			$ex['ex_type'] == 'more' && $exfld_val = cot_selectbox_date($ppf[$row['field_name']]['more'], 'long', 'ppf['.$row['field_name'].'][more]');
			$ex['ex_type'] == 'less' && $exfld_val = cot_selectbox_date($ppf[$row['field_name']]['less'], 'long', 'ppf['.$row['field_name'].'][less]');
			$ex['ex_type'] == 'more-less' && $exfld_val = cot_selectbox_date($ppf[$row['field_name']]['more'], 'long', 'ppf['.$row['field_name'].'][more]')
				.' - '. cot_selectbox_date($ppf[$row['field_name']]['less'], 'long', 'ppf['.$row['field_name'].'][less]');			
			$ex['ex_type'] == 'shortmore' && $exfld_val = cot_selectbox_date($ppf[$row['field_name']]['more'], 'short', 'ppf['.$row['field_name'].'][more]');
			$ex['ex_type'] == 'shortless' && $exfld_val = cot_selectbox_date($ppf[$row['field_name']]['less'], 'short', 'ppf['.$row['field_name'].'][less]');
			$ex['ex_type'] == 'shortmore-less' && $exfld_val = cot_selectbox_date($ppf[$row['field_name']]['more'], 'short', 'ppf['.$row['field_name'].'][more]')
				.' - '. cot_selectbox_date($ppf[$row['field_name']]['less'], 'short', 'ppf['.$row['field_name'].'][less]');				
			break;
		case 'checkbox':

			$R['checkbox_res'] = $R['input_checkbox'];
			$R['input_checkbox'] = '<label><input type="checkbox" name="{$name}" value="{$value}"{$checked}{$attrs} /> {$title}</label>';
			$cfg_params_titles = (isset($L['ppf_'.$row['field_name'].'_params']) && is_array($L['ppf_'.$row['field_name'].'_params'])) ? $L['ppf_'.$row['field_name'].'_params'] : $L['ppf_checkbox'];
			if(!empty($ex['ex_vars']))
			{
				$cfg_params_titles = explode(',', $ex['ex_vars']);
			}
			$ex['ex_type'] == 'is' && $exfld_val = cot_selectbox((isset($ppf[$row['field_name']])) ? $ppf[$row['field_name']] : 2, 'ppf['.$row['field_name'].']', range(0, 2), $cfg_params_titles, false);
			$ex['ex_type'] == 'check' && $exfld_val = cot_checkbox((isset($ppf[$row['field_name']])) ? $ppf[$row['field_name']] : 0, 'ppf['.$row['field_name'].']', isset($L['page_'.$row['field_name'].'_title']) ? $L['page_'.$row['field_name'].'_title'] : $row['field_description']);			
			$R['input_checkbox'] = $R['checkbox_res'];


			break;
		case 'select':
		case 'radio':
		case 'country':
			$opt_array = explode(',', $row['field_variants']);
			$options = array();
			$options_titles = array();

			$options[] = 'ppf_nomatter';
			$options_titles[] = $L['ppf_nomatter'];
			if ($row['field_type'] != 'country')
			{
				if (count($opt_array) != 0)
				{
					foreach ($opt_array as $var)
					{
						$options_titles[] = (!empty($L['page_'.$row['field_name'].'_'.$var])) ? $L['page_'.$row['field_name'].'_'.$var] : $var;
						$options[] = $var;
					}
				}
			}
			else
			{
				if (!$cot_countries)
					include_once cot_langfile('countries', 'core');
				$options[] = array_keys($cot_countries);
				$options_titles[] = array_values($cot_countries);
			}
			//options gen
			$ppfmiltiadd = '';
			$ppf[$row['field_name']] = (is_string($ppf[$row['field_name']]) && !empty($ppf[$row['field_name']])) ? array($ppf[$row['field_name']]) : $ppf[$row['field_name']];
			$ppf[$row['field_name']] = (is_array($ppf[$row['field_name']])) ? $ppf[$row['field_name']] : array('ppf_nomatter');
			foreach ($ppf[$row['field_name']] as $ppfval)
			{
				$ppfmiltiadd .= '<div class="option'.$row['field_name'].'">
'.cot_selectbox($ppfval, 'ppf['.$row['field_name'].'][]', $options, $options_titles, false, '').'<button name="deloption" type="button" class="deloption'.$row['field_name'].'" title="'.$L['Delete'].'" style="display:none;"><img src="'.$cfg['plugins_dir'].'/pageplus/img/minus.png" alt="'.$L['Delete'].'" /></button>
</div>';
			}
			$ppfselval = ((is_array($ppf[$row['field_name']]) && count($ppf[$row['field_name']]) > 0)) ? $ppf[$row['field_name']][0] : 'ppf_nomatter';
			//end options gen
			$ex['ex_type'] == 'is' && $exfld_val = cot_selectbox($ppfselval, 'ppf['.$row['field_name'].'][]', $options, $options_titles, false);
			$ex['ex_type'] == 'multi' && $exfld_val = cot_selectbox((isset($ppf[$row['field_name']])) ? $ppf[$row['field_name']] : 'ppf_nomatter', 'ppf['.$row['field_name'].'][]', $options, $options_titles, false);
			$ex['ex_type'] == 'radio' && $exfld_val = cot_radiobox($ppfselval, 'ppf['.$row['field_name'].'][]', $options, $options_titles, false);
			$ex['ex_type'] == 'multiadd' && $exfld_val = $ppfmiltiadd.'<button id="addoption'.$row['field_name'].'" name="addoption" type="button" title="'.$L['Add'].'" style="display:none;"><img src="'.$cfg['plugins_dir'].'/pageplus/img/plus.png" alt="'.$L['Add'].'" /></button>
<script type="text/javascript">
$(".deloption'.$row['field_name'].'").live("click",function () {
	$(this).parent().children("select").attr("value", "ppf_nomatter");
	if ($(".option'.$row['field_name'].'").length > 1)
	{
		$(this).parent().remove();
	}
	return false;
});

$(document).ready(function(){
	$("#addoption'.$row['field_name'].'").click(function () {
	$(".option'.$row['field_name'].'").last().clone().insertAfter($(".option'.$row['field_name'].'").last()).show().children("select").attr("value","ppf_nomatter");
	return false;
	});
	$("#addoption'.$row['field_name'].'").show();
	$(".deloption'.$row['field_name'].'").show();
});
</script>';
			break;
			
		case 'file':
		case 'input':
		case 'textarea':
		default:
			$opt_array = explode(',', $ex['ex_vars']);
			$options = array();
			$options_titles = array();

			$options[] = '';
			$options_titles[] = $L['ppf_nomatter'];
			if (count($opt_array) != 0)
			{
				foreach ($opt_array as $var)
				{
					$options_titles[] = (!empty($L['page_'.$row['field_name'].'_'.$var])) ? $L['page_'.$row['field_name'].'_'.$var] : $var;
					$options[] = $var;
				}
			}

			$ex['ex_type'] == 'is' && $exfld_val = cot_inputbox('text', 'ppf['.$row['field_name'].'][is]', $ppf[$row['field_name']]['is']);
			$ex['ex_type'] == 'like' && $exfld_val = cot_inputbox('text', 'ppf['.$row['field_name'].'][like]', $ppf[$row['field_name']]['like']);
			$ex['ex_type'] == 'isset' && $exfld_val = cot_checkbox($ppf[$row['field_name']]['isset'], 'ppf['.$row['field_name'].'][isset]');
			$ex['ex_type'] == 'select' && $exfld_val = cot_selectbox((isset($ppf[$row['field_name']])) ? $ppf[$row['field_name']] : 'ppf_nomatter', 'ppf['.$row['field_name'].'][is]', $options, $options_titles, false);	
			break;
	}

		$tex->assign(array(
			'NUM' => $ex['ex_num'],
			'EXTRAFLD' => $exfld_val,
			'EXTRAFLD_TITLE' => $exfld_title,
			'EXTRAFLD_TYPE' => $exfld['field_type'],
			'EXTRAFLD_VALUE' => $pag['page_'.$exfld['field_name']]
		));
	}
	$tex->parse('MAIN.EXTRAFLD');
}



$ppfparams = $_GET;
unset($ppfparams['ppf']);
foreach ($ppfparams as $key => $val)
{
	$ppfhidden .= cot_inputbox('hidden', $key, $val);
}

if (count($order_f))
{
	$tex->assign(array(
		'LIST_FILTERS_ORDER' => cot_selectbox($s, 's', array_keys($order_f), array_values($order_f), false),
		'LIST_FILTERS_WAY' => cot_selectbox($w , 'w', array('asc', 'desc'), array($L['Ascending'], $L['Descending']), false),
	));	
	$t->assign(array(
		'LIST_FILTERS_ORDER' => cot_selectbox($s, 'jumpbox', array_keys($order_link), array_values($order_link), false, 'onchange="redirect(this)"'),
		'LIST_FILTERS_WAY' => cot_selectbox($w , 'order', array(cot_url_modify('w=asc'), cot_url_modify('w=desc')), array($L['Ascending'], $L['Descending']), false)
	));
}
$tex->assign(array(
	'LIST_FILTERS_COUNT' => count($extrafields),
	'LIST_FILTERS_HIDDEN' => $ppfhidden,
	'LIST_FILTERS_CAT' => cot_selectbox((!isset($ppf['ppfcat'])) ? 'all' : $ppf['ppfcat'], 'ppf[ppfcat][]', array_keys($ppf_pages_cat_list), array_values($ppf_pages_cat_list), false, ' multiple="multiple" style="width:50%"'),
	'LIST_FILTERS_SEARCH' => cot_inputbox('text', 'ppf[search]', $ppf['search']),
	'LIST_FILTERS_URL' => cot_url('page', "c=$c&s=$s&w=$w&o=$o&p=$p")
));
$tex->parse('MAIN');
$t->assign("LIST_ROW_EXFLDGROUPEDITOR_FILTER", $tex->text('MAIN'));
