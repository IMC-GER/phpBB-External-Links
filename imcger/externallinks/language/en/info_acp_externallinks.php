<?php
/**
 *
 * An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021, Thorsten Ahlers
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_EXT_LINK_TITLE' => 'External links',
	'ACP_EXT_LINK_SETTINGS' => 'Settings',
	'ACP_EXT_LINK_SETTING_SAVED' => 'Settings successfully saved .'
));
