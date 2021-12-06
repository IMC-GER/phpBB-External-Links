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
	'EXT_LINK_TITLE' => 'Externe Links',
	'EXT_LINK_TITLE_EXPLAIN' => 'Bilder und Links von anderen Websites kenntlich machen. Bilder von anderen Websites als Link in Textform anzeigen oder als Bild im Post anzeigen.',
	
	'EXT_LINK_BILD' => 'Bilder  Linkanzeige',
	'EXT_LINK_BILD_DESC' => 'Bei Auswahl von "Text" werden Bilder von fremden Websites als Link in Textform anzeigen. Bei der Auswahl von "Bild" werden verlinkte Bilder als Bild im Post angezeigen.',
	'EXT_LINK_BILD_NO_CHANGE' => 'keine Änderung',
	'EXT_LINK_BILD_TEXT' => 'Textform',
	'EXT_LINK_BILD_IMAGE' => 'Bild',
	
	'EXT_LINK_LINKS' => 'Links markieren',
	'EXT_LINK_LINKS_TEXT' => 'Textform',
	'EXT_LINK_LINKS_TEXT_DESC' => 'Dem Text von Links, die auf externe Websites führen, wird das Symbol "external-link" im Anschluss hinzugefügt.',
	'EXT_LINK_LINKS_NEWWIN' => 'Neuer Tab',
	'EXT_LINK_LINKS_NEWWIN_DESC' => 'Links die auf andere Websites verweisen werden in einem neuen Tab/Fenster geöffnet.',
	'EXT_LINK_LINKS_IMG' => 'Externes Bild',
	'EXT_LINK_LINKS_IMG_DESC' => 'Bildern von anderen Websites, werden die Quelle das Bildes als Bildunterschrift hinzugefügt.',
));
