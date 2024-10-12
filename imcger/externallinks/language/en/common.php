<?php
/**
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
	$lang = [];
}

$lang = array_merge($lang, [

	// language pack author
	'ACP_IMCGER_LANG_DESC'			=> 'British English',
	'ACP_IMCGER_LANG_EXT_VER' 		=> '1.6.0',
	'ACP_IMCGER_LANG_AUTHOR' 		=> 'IMC-Ger',

	// Message text
	'EXT_LINK_SETTING_SAVED'		 => 'The settings have been saved successfully.',
	'EXT_LINK_USER_SETTING_SAVED'	 => 'The settings were successfully saved for all users.',
	'EXT_LINK_DEFAULT_SETTING_SAVED' => 'The default settings for new users and guests have been saved successfully.',

	// Confirm Box
	'EXT_LINK_SAVE'				=> 'Save',
	'EXT_LINK_USER_SET'			=> 'Please confirm',
	'EXT_LINK_USER_SET_CONFIRM'	=> 'Are you sure you want to overwrite the user settings?<br><br>This will overwrite all user settings with your defaults.<br><strong>This process cannot be undone!</strong>',

	// Extension description
	'EXT_LINK_TITLE'			=> 'External links',
	'EXT_LINK_TITLE_EXPLAIN'	=> 'With this extension it is possible to influence the display of links and pictures. Some settings are available in the "User Control Panel". This allows the user to decide for himself what is more important to him. Secure data transfer, comfortable display or fast loading times of the forum page.',

	// General settings
	'EXT_LINK_DOMAIN'			=> 'Domain',
	'EXT_LINK_DOMAIN_TEXT'		=> 'Select domain',
	'EXT_LINK_DOMAIN_DESC'		=> 'Select domain to be recognized as own domain. Subdomains below the selected one are included.',

	'EXT_LINK_LINKS'			=> 'Mark links',
	'EXT_LINK_LINKS_SYMBOL'		=> 'Symbol',
	'EXT_LINK_LINKS_SYMBOL_DESC' => 'Enter the Unicode of the Font Awesome Icon with which the external link is to be marked. For example "f08e" for <i class="fa fa-external-link" aria-hidden="true"></i> or "f14c" für <i class="fa fa-external-link-square" aria-hidden="true"></i>. Leave the field empty if you do not want to mark any links.',
	'EXT_LINK_LINKS_POS'		=> 'Symbol position',
	'EXT_LINK_LINKS_POS_DESC'	=> 'If you select this option, the symbol is inserted to the left of the link text. Otherwise, the symbol will be added to the right.',
	'EXT_LINK_LINKS_IMG'		=> 'External image',
	'EXT_LINK_LINKS_IMG_DESC'	=> 'Images from other websites, the source will be added to the image as a caption.',

	'EXT_LINK_SHOW'				=> 'Hide links',
	'EXT_LINK_SHOW_LINK'		=> 'External links',
	'EXT_LINK_SHOW_LINK_DESC'	=> 'With the forum permissions links and images can be hidden. If this option is selected, only external links and images are hidden. If it is not selected, all links are hidden.',
	'EXT_LINK_EXT'				=> 'external',
	'EXT_LINK_ALL'				=> 'all',

	'EXT_LINK_FIND'				=> 'Recognize images',
	'EXT_LINK_FIND_IMG'			=> 'Improved recognition of links to images',
	'EXT_LINK_FIND_IMG_DESC'	=> 'Links to images are also recognized if they do not contain a file name extension for images.<br><strong>Attention:</strong> If there are dead links in posts, the loading time of the forum page will increase.',

	// User settings
	'EXT_LINK_IMAGE'			=> 'Only external image',
	'EXT_LINK_IMAGE_LINK'		=> 'Image link dimensions',
	'EXT_LINK_IMAGE_LINK_DESC'	=> 'Display image as an inline text link if image is larger than this. To disable this behaviour, set the values to 0px by 0px.',

	'EXT_LINK_LINKS_USERSET'	=> 'User settings',
	'EXT_LINK_USERSET_TIME'		=> 'User settings were last overwritten on %s.',

	'EXT_LINK_OVERWRITE_USERSET'	 => 'Overwrite user settings',
	'EXT_LINK_OVERWRITE_USERSET_DEC' => 'With this selection, the settings of all users are overwritten. If you select "No", only default values for new users will be set.',
]);
