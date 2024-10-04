<?php
/**
 *
 * External Links
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
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_EXT_LINK_TITLE' 		 => 'External links',
	'ACP_EXT_LINK_USER_TITLE' 	 => 'External Links',
	'ACP_EXT_LINK_SETTINGS' 	 => 'Settings',
	'ACP_EXT_LINK_USER_SETTINGS' => 'User settings',

	'IMCGER_REQUIRE_PHPBB' => 'This extension requires a phpBB version greater or equal than %1$s and less than %2$s. Your version is %3$s.',
	'IMCGER_REQUIRE_PHP'   => 'This extension requires a php version greater or equal than %1$s and less than %2$s. Your version is %3$s.',
]);
