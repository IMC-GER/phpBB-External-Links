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
	'EXT_LINK_DOMAIN' => 'Domain',
	'EXT_LINK_DOMAIN_TEXT' => 'Domain auswählen',
	'EXT_LINK_DOMAIN_DESC' => 'Domain auswählen, die als eigene Domain erkannt werden soll. Subdomains unterhalb der ausgewählten sind eingeschlossen.',

	'EXT_LINK_TITLE' => 'Externe Links',
	'EXT_LINK_TITLE_EXPLAIN' => 'Bilder und Links von anderen Websites kenntlich machen.',

	'EXT_LINK_LINKS' => 'Links markieren',
	'EXT_LINK_LINKS_TEXT' => 'Textform',
	'EXT_LINK_LINKS_TEXT_DESC' => 'Dem Text von Links, die auf externe Websites führen, wird das Symbol <i class="fa fa-external-link" aria-hidden="true"></i> im Anschluss hinzugefügt.',
	'EXT_LINK_LINKS_IMG' => 'Externes Bild',
	'EXT_LINK_LINKS_IMG_DESC' => 'Bildern von anderen Websites, werden die Quelle das Bildes als Bildunterschrift hinzugefügt.',
));
