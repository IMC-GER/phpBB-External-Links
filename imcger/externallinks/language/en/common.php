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
	'EXT_LINK_SHOW_LINK_DESC' => 'With the forum permissions links and images can be hidden. By selecting "external" only external links and images will be hidden. With "No" all will be hidden.',
	'EXT_LINK_EXT' => 'external',
	'EXT_LINK_ALL' => 'all',

	'EXT_LINK_FIND' => 'Recognize images',
	'EXT_LINK_FIND_IMG' => 'Improved recognition of links to images:',
	'EXT_LINK_FIND_IMG_DESC' => 'Links to images are also recognized if they do not contain a file name extension for images.<br><strong>Attention:</strong> If there are dead links in posts, the loading time of the forum page will increase.',

	'EXT_LINK_IMAGE' => 'Only external image',
	'EXT_LINK_IMAGE_LINK' => 'Image link dimensions:',
	'EXT_LINK_IMAGE_LINK_DESC' => 'Display image as an inline text link if image is larger than this. To disable this behaviour, set the values to 0px by 0px.',

	'EXT_LINK_LINKS_USERSET' => 'User settings',
	'EXT_LINK_USERSET_TIME'	 => 'User settings were last overwritten on %s.',

	'EXT_LINK_OVERWRITE_USERSET' => 'Overwrite user settings',
	'EXT_LINK_OVERWRITE_USERSET_DEC' => 'With this selection, the settings of all users are overwritten. If you select "No", only default values for new users will be set.',

	'EXT_LINK_SAVE' => 'Save',
	'EXT_LINK_ERROR' => 'Are you sure you want to overwrite the user settings?',
	'EXT_LINK_ERROR_DEC' => 'This will overwrite all user settings with your defaults. <strong>This process cannot be reversed!</strong>',
));
