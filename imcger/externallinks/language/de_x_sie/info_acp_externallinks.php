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
	'ACP_EXT_LINK_TITLE' => 'Externe Links',
	'ACP_EXT_LINK_USER_TITLE' => 'Externe Links',
	'ACP_EXT_LINK_SETTINGS' => 'Einstellungen',
	'ACP_EXT_LINK_USER_SETTINGS' => 'Benutzereinstellungen',
	'ACP_EXT_LINK_SETTING_SAVED' => 'Die Einstellungen wurden erfolgreich gespeichert.',
	'ACP_EXT_LINK_USER_SETTING_SAVED' => 'Die Benuzereinstellungen wurden erfolgreich gespeichert.',

	'IMCGER_REQUIRE_PHPBB' => 'Diese Erweiterung benötigt eine phpBB Version gleich oder grösser %1$s und kleiner %2$s. Deine Version ist %3$s.',
	'IMCGER_REQUIRE_PHP'   => 'Diese Erweiterung benötigt eine php Version gleich oder grösser %1$s und kleiner %2$s. Deine Version ist %3$s.',
));
