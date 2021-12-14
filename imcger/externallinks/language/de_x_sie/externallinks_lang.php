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
	'LA_EXT_LINK_BILD_SOURCE' => 'Quelle',
	'LA_EXT_LINK_EXT_LINK' => 'Externer Link',
	'LA_EXT_LINK_EXT_IMG' => 'Externes Bild',
));
