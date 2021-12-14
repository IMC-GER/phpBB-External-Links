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
	'EXT_LINK_TITLE' => 'External links',
	'EXT_LINK_TITLE_EXPLAIN' => 'Mark images and links from other websites.',

	'EXT_LINK_LINKS' => 'Mark links',
	'EXT_LINK_LINKS_TEXT' => 'Text form',
	'EXT_LINK_LINKS_TEXT_DESC' => 'The symbol <i class="fa fa-external-link" aria-hidden="true"></i> is added to the text of links that lead to external websites.',
	'EXT_LINK_LINKS_IMG' => 'External picture',
	'EXT_LINK_LINKS_IMG_DESC' => 'Images from other websites, the source will be added to the image as a caption.',
));
