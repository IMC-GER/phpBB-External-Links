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
	'UCP_EXT_LINK_LINKS_NEWWIN' => 'Open external link in new tab',
	'UCP_EXT_LINK_LINK2_TEXT'	=> 'Show all external images as text link',
	'UCP_EXT_LINK_LINK2_IMAGE'	=> 'Show all external image links as image',
	'UCP_EXT_LINK_LINK2_IMAGE_DEC'	=> 'Only "jpg, jpeg, png, gif, webp, svg"',
	'UCP_EXT_LINK_NONE_SECURE'		=> 'Don`t show insecurely transferred images',
	'UCP_EXT_LINK_NONE_SECURE_DEC'	=> 'Show images from http:// websites as text link.',
));
