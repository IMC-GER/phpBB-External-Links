<?php
/**
 *
 * External Links
 * An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2022, Thorsten Ahlers
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
	'ACP_EXT_LINK_USER_TITLE' => 'External Links',
	'ACP_EXT_LINK_SETTINGS' => 'Settings',
	'ACP_EXT_LINK_USER_SETTINGS' => 'User settings',
	'ACP_EXT_LINK_SETTING_SAVED' => 'Settings successfully saved.',
	'ACP_EXT_LINK_USER_SETTING_SAVED' => 'The user settings have been saved successfully.',

	'IMCGER_REQUIRE_PHPBB' => 'This extension requires a phpBB version greater or equal than 3.2.0 and less than 4.0.0',
	'IMCGER_REQUIRE_PHP' => 'This extension requires a php version greater or equal than 5.4.7 and less than 8.2.',
));
