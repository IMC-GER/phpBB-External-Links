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
	'UCP_EXT_LINK_LINK2_IMAGE'	=> 'Alle Links zu Bildern als Bild anzeigen',
	'UCP_EXT_LINK_LINK2_IMAGE_DEC'	=> 'Nur "jpg, jpeg, png, gif, webp, svg"',
	'UCP_EXT_LINK_NONE_SECURE'		=> 'Unsicher übertragene Bilder nicht anzeigen',
	'UCP_EXT_LINK_NONE_SECURE_DEC'	=> 'Bilder von http:// Seiten als Textlink anzeigen.',
));
