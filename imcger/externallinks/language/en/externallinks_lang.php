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
	'IMCGER_EXT_LINK_BILD_SOURCE' => 'Source',
	'IMCGER_EXT_LINK_EXT_LINK'	=> 'External link, the privacy policy and terms of use of the selected page apply.',
	'IMCGER_EXT_LINK_EXT_IMG'	=> 'External image, the privacy policy and terms of use of the selected page apply.',
	'IMCGER_EXT_LINK_NO_LINK'	=> 'You do not have sufficient permission to view this link.',

	'IMCGER_EXT_LINK_NO_IMAGEDATA'	=> 'The image dimension could not be determined. The following image is inserted as a link.',
	'IMCGER_EXT_LINK_IMAGE_TOLARGE'	=> 'The following image is larger than %upx x %upx and has therefore been inserted as a link.',
));
