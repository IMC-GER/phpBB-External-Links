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
	'EXT_LINK_TITLE' => 'External links',
	'EXT_LINK_TITLE_EXPLAIN' => 'With this extension it is possible to influence the display of links and pictures. Some settings are available in the "User Control Panel". This allows the user to decide for himself what is more important to him. Secure data transfer, comfortable display or fast loading times of the forum page.',

	'EXT_LINK_DOMAIN' => 'Domain',
	'EXT_LINK_DOMAIN_TEXT' => 'Select domain:',
	'EXT_LINK_DOMAIN_DESC' => 'Select domain to be recognized as own domain. Subdomains below the selected one are included.',

	'EXT_LINK_LINKS' => 'Mark links',
	'EXT_LINK_LINKS_TEXT' => 'Text form:',
	'EXT_LINK_LINKS_TEXT_DESC' => 'The symbol <i class="fa fa-external-link" aria-hidden="true"></i> is added to the text of links that lead to external websites.',
	'EXT_LINK_LINKS_IMG' => 'External image:',
	'EXT_LINK_LINKS_IMG_DESC' => 'Images from other websites, the source will be added to the image as a caption.',

	'EXT_LINK_SHOW' => 'Hide links',
	'EXT_LINK_SHOW_LINK' => 'External links:',
	'EXT_LINK_SHOW_LINK_DESC' => 'With the forum permissions links can be hidden. By selecting "Yes" only external links will be hidden. With "No" all links will be hidden.',

	'EXT_LINK_IMAGE' => 'Only external image',
	'EXT_LINK_IMAGE_LINK' => 'Image link dimensions:',
	'EXT_LINK_IMAGE_LINK_DESC' => 'Display image as an inline text link if image is larger than this. To disable this behaviour, set the values to 0px by 0px.',
));
