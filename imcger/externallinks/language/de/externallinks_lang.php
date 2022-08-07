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
	'IMCGER_EXT_LINK_BILD_SOURCE' => 'Quelle',
	'IMCGER_EXT_LINK_EXT_LINK'	=> 'Externer Link',
	'IMCGER_EXT_LINK_EXT_IMG'	=> 'Externes Bild',
	'IMCGER_EXT_LINK_NO_LINK'	=> 'Du hast keine ausreichende Berechtigung, um diesen Link anzusehen.',

	'IMCGER_EXT_LINK_NO_IMAGEDATA'	=> 'Die Bilddimension konnte nicht ermittelt werden. Das folgende Bild wird als Link eingefügt.',
	'IMCGER_EXT_LINK_IMAGE_TOLARGE'	=> 'Das folgende Bild ist größer als %upx x %upx und wurde daher als Link eingefügt.',
));
