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
	$lang = array();
}

$lang = array_merge($lang, array(
	'UCP_EXT_LINK_LINKS_NEWWIN' => 'Externen Link in neuen Tab öffnen',
	'UCP_EXT_LINK_LINK2_TEXT'	=> 'Alle externe Bilder als Textlink anzeigen',
	'UCP_EXT_LINK_LINK2_IMAGE'	=> 'Alle externe Bildlinks als Bild anzeigen',
));
