<?php
/**
 *
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
	'EXT_LINK_TITLE' => 'External Links',
	'EXT_LINK_TITLE_EXPLAIN' => 'Mark images and links from other websites. View images from other websites as a link in text form or as an image in the post.',

	'EXT_LINK_BILD' => 'Link display images',
	'EXT_LINK_BILD_DESC' => 'If you select "Text", images from external websites are displayed as links in text form. If you select "Image", linked images will be displayed as an image in the post.',
	'EXT_LINK_BILD_NO_CHANGE' => 'no change',
	'EXT_LINK_BILD_TEXT' => 'Text form',
	'EXT_LINK_BILD_IMAGE' => 'Image',

	'EXT_LINK_LINKS' => 'Mark links',
	'EXT_LINK_LINKS_TEXT' => 'Text form',
	'EXT_LINK_LINKS_TEXT_DESC' => 'The symbol "external-link" is added to the text of links that lead to external websites.',
	'EXT_LINK_LINKS_NEWWIN' => 'New Tab',
	'EXT_LINK_LINKS_NEWWIN_DESC' => 'Links that refer to other websites will be opened in a new tab / window.',
	'EXT_LINK_LINKS_IMG' => 'External picture',
	'EXT_LINK_LINKS_IMG_DESC' => 'Images from other websites, the source will be added to the image as a caption.',
));
