<?php
/**
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
	'ACP_EXT_LINK_TITLE' 		 => 'Externe Links',
	'ACP_EXT_LINK_USER_TITLE' 	 => 'Externe Links',
	'ACP_EXT_LINK_SETTINGS' 	 => 'Einstellungen',
	'ACP_EXT_LINK_USER_SETTINGS' => 'Benutzereinstellungen',

	'IMCGER_REQUIRE_PHPBB' => 'Diese Erweiterung benötigt eine phpBB Version gleich oder grösser %1$s und kleiner %2$s. Deine Version ist %3$s.',
	'IMCGER_REQUIRE_PHP'   => 'Diese Erweiterung benötigt eine php Version gleich oder grösser %1$s und kleiner %2$s. Deine Version ist %3$s.',
]);
