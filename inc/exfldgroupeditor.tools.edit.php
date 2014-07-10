<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=tools
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
require_once cot_incfile('exfldgroupeditor', 'plug');

require_once cot_incfile('page', 'module');
require_once cot_incfile('forms');

$c = cot_import('c', 'G', 'TXT');

$rfield = cot_import('rfield', 'P', 'ARR');
$rdesc = cot_import('rdesc', 'P', 'ARR');
$rnum = cot_import('rnum', 'P', 'ARR');
$rid = cot_import('rid', 'P', 'ARR');
$radd = cot_import('radd', 'P', 'ARR');
$redit = cot_import('redit', 'P', 'ARR');
$rlist = cot_import('rlist', 'P', 'ARR');
$rpage = cot_import('rpage', 'P', 'ARR');
$rany = cot_import('rany', 'P', 'ARR');

if (count($rfield) && !empty($c))
{

	foreach ($rid as $key => $val)
	{
		$menu['ex_field'] = cot_import($rfield[$key], 'D', 'TXT');
		$menu['ex_cat'] = $c;
		$menu['ex_desc'] = cot_import($rdesc[$key], 'D', 'TXT');
		$menu['ex_num'] = cot_import($rnum[$key], 'D', 'TXT');
		
		$menu['ex_add'] = cot_import($radd[$key], 'D', 'BOL') ? 1 : 0;
		$menu['ex_edit'] = cot_import($redit[$key], 'D', 'BOL') ? 1 : 0;
		$menu['ex_list'] = cot_import($rlist[$key], 'D', 'BOL') ? 1 : 0;
		$menu['ex_page'] = cot_import($rpage[$key], 'D', 'BOL') ? 1 : 0;
		$menu['ex_any'] = cot_import($rany[$key], 'D', 'BOL') ? 1 : 0;
			
		if ($val == 'new' && (!empty($menu['ex_field']) || !empty($menu['ex_desc'])))
		{
			$db->insert($db_exflgroupeditor, $menu);
		}
		else
		{
			if(!empty($menu['ex_field']) || !empty($menu['ex_desc']))
			{
				$db->update($db_exflgroupeditor, $menu, "ex_id='".(int)$val."'");
			}
			else
			{
				$db->delete($db_exflgroupeditor, "ex_id='".(int)$val."'");
			}
		}
	}
	$cache && $cache->db->remove('exfldcat_list', 'system');

}

$cache && $cache->db->remove('exfldcat_list', 'system');

$sskin = cot_tplfile('exfldgroupeditor.tools.edit', 'plug');
$tt = new XTemplate($sskin);

	$tt->assign(array(
		'EXFLD_CAT' => cot_selectbox_structure('page', $c, 'c'),
		'EXFLD_CATACTION' => cot_url('admin', 'm=other&p=exfldgroupeditor'),
	));


$sql_count = $db->query("SELECT ex_cat, COUNT(*) as ex_count FROM $db_exflgroupeditor WHERE 1 GROUP BY ex_cat");
foreach ($sql_count->fetchAll() as $rowC)
{
	$tt->assign(array(
		'EXFLD_CAT_NAME' => $structure['page'][$rowC['ex_cat']]['title'],
		'EXFLD_CAT_URL' => cot_url('admin', 'm=other&p=exfldgroupeditor&c='.$rowC['ex_cat']),
	));	
	$tt->parse('MAIN.CATEXISTS');
}


if(!empty($c))
{
	$res = $db->query("SELECT * FROM $db_extra_fields WHERE field_location = '".$db_pages."' ORDER BY field_name ASC");
	$exfld = array();
	foreach ($res->fetchAll() as $row)
	{
		$desc = (!empty($row['field_description'])) ? $row['field_name'] . ": " . $row['field_description'] : $row['field_name'];
		$exfld[$row['field_name']] = $desc;
	}
	
	$sql = $db->query("SELECT * FROM $db_exflgroupeditor WHERE ex_cat = '" . $db->prep($c) . "' ORDER BY ex_num ASC");
	$i = 0;
	while ($row = $sql->fetch())
	{
		$i++;
		$qid = $row['ex_id'];
		$tt->assign(array(
			'EXFLD_NUM' => cot_inputbox('hidden', 'rid['.$i.']', $row['ex_id'], 'size="4"  class="rid"')
				.cot_inputbox('text', 'rnum['.$i.']', $row['ex_num'], 'class="rnum"'),
			'EXFLD_EXFLD' => cot_selectbox($row['ex_field'], 'rfield['.$i.']', array_keys($exfld), array_values($exfld), true, 'class="rfield"'),
			'EXFLD_DESC' => cot_inputbox('text', 'rdesc['.$i.']', $row['ex_desc'], 'size="16" class="rdesc"'),
			'EXFLD_ADD' => cot_checkbox($row['ex_add'], 'radd['.$i.']', '', 'title="'.$L['ex_Add'].'"'),
			'EXFLD_EDIT' => cot_checkbox($row['ex_edit'], 'redit['.$i.']', '', 'title="'.$L['ex_Edit'].'"'),
			'EXFLD_LIST' => cot_checkbox($row['ex_list'], 'rlist['.$i.']', '', 'title="'.$L['ex_List'].'"'),
			'EXFLD_PAGE' => cot_checkbox($row['ex_page'], 'rpage['.$i.']', '', 'title="'.$L['ex_Page'].'"'),
			'EXFLD_ANY' => cot_checkbox($row['ex_any'], 'rany['.$i.']', '', 'title="'.$L['ex_Any'].'"'),
			'EXFLD_ID' => $qid,
		));
		
		$tt->parse('MAIN.EDIT.ROW');
	}
	
	$tt->assign(array(
		'EXFLD_NUM' => cot_inputbox('hidden', 'rid[]', 'new', 'size="4"  class="rid"')
			.cot_inputbox('text', 'rnum[]', '', 'class="rnum"'),
		'EXFLD_EXFLD' => cot_selectbox('', 'rfield[]', array_keys($exfld), array_values($exfld), true, 'class="rfield"'),
		'EXFLD_DESC' => cot_inputbox('text', 'rdesc[]', '', 'size="16" class="rdesc"'),
		'EXFLD_ADD' => cot_checkbox(1, 'radd[]', '', 'title="'.$L['ex_Add'].'"'),
		'EXFLD_EDIT' => cot_checkbox(1, 'redit[]', '', 'title="'.$L['ex_Edit'].'"'),
		'EXFLD_LIST' => cot_checkbox(1, 'rlist[]', '', 'title="'.$L['ex_List'].'"'),
		'EXFLD_PAGE' => cot_checkbox(1, 'rpage[]', '', 'title="'.$L['ex_Page'].'"'),
		'EXFLD_ANY' => cot_checkbox(1, 'rany[]', '', 'title="'.$L['ex_Any'].'"'),
		'EXFLD_ID' => 'new',
	));
	$tt->parse('MAIN.EDIT.ROW');
	$tt->assign(array(
		'EXFLD_ACTION' => cot_url('admin', 'm=other&p=exfldgroupeditor&c='.$c),
	));	
	$tt->parse('MAIN.EDIT');
}

$tt->parse('MAIN');
$plugin_body =$tt->text('MAIN');
