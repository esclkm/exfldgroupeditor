-- Main comments table
CREATE TABLE IF NOT EXISTS `cot_exflgroupeditor` (
	`ex_id` int(11) NOT NULL auto_increment,
	`ex_cat` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`ex_field` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`ex_desc` varchar(255) collate utf8_unicode_ci NOT NULL,
	`ex_num` int(11) default NULL,
	`ex_add` tinyint(1) NOT NULL default '0',
	`ex_edit` tinyint(1) NOT NULL default '0',
	`ex_list` tinyint(1) NOT NULL default '0',
	`ex_page` tinyint(1) NOT NULL default '0',
	`ex_any` tinyint(1) NOT NULL default '0',
	PRIMARY KEY (`ex_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Main comments table
CREATE TABLE IF NOT EXISTS `cot_exflgroupeditor_filter` (
	`ex_id` int(11) NOT NULL auto_increment,
	`ex_cat` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`ex_field` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`ex_desc` varchar(255) collate utf8_unicode_ci NOT NULL,
	`ex_num` int(11) default NULL,
	`ex_type` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`ex_filter` tinyint(1) NOT NULL default '0',
	`ex_vars` varchar(255) collate utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`ex_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;