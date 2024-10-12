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

	// Language pack author
	'ACP_IMCGER_LANG_DESC'	  => 'Deutsch (Sie)',
	'ACP_IMCGER_LANG_EXT_VER' => '1.6.0',
	'ACP_IMCGER_LANG_AUTHOR'  => 'IMC-Ger',

	// Message text
	'EXT_LINK_SETTING_SAVED'		 => 'Die Einstellungen wurden erfolgreich gespeichert.',
	'EXT_LINK_USER_SETTING_SAVED'	 => 'Die Einstellungen wurden für alle Benutzern erfolgreich gespeichert.',
	'EXT_LINK_DEFAULT_SETTING_SAVED' => 'Die Standarteinstellungen für neue Benutzer und Gäste wurden erfolgreich gespeichert.',

	// Confirm Box
	'EXT_LINK_SAVE'				=> 'Speichern',
	'EXT_LINK_USER_SET'			=> 'Bitte bestätigen',
	'EXT_LINK_USER_SET_CONFIRM'	=> 'Sind sie sicher dass sie die Benutzereinstellungen überschreiben möchten?<br><br>Dadurch werden die Einstellungen aller Benutzer mit ihren Vorgaben überschrieben.<br><strong>Dieser Vorgang kann nicht rückgängig gemacht werden!</strong>',

	// Extension description
	'EXT_LINK_TITLE'			=> 'Externe Links',
	'EXT_LINK_TITLE_EXPLAIN'	=> 'Mit dieser Extension ist es möglich die Anzeige von Links und Bilder zu beeinflussen. Einige Einstellungen sind im "Persönlicher Bereich" zu erreichen. Damit kann der Benutzer selbst darüber entscheiden was ihm wichtiger ist. Sichere Datenübertragung, komfortable Anzeige oder schnelle Ladezeiten der Forumsseite.',

	// General settings
	'EXT_LINK_DOMAIN'			=> 'Domain',
	'EXT_LINK_DOMAIN_TEXT'		=> 'Domain auswählen',
	'EXT_LINK_DOMAIN_DESC'		=> 'Domain auswählen, die als eigene Domain erkannt werden soll. Subdomains unterhalb der ausgewählten sind eingeschlossen.',

	'EXT_LINK_LINKS'			=> 'Links markieren',
	'EXT_LINK_LINKS_SYMBOL'		=> 'Symbol',
	'EXT_LINK_LINKS_SYMBOL_DESC' => 'Geben sie hier den Unicode des Font Awesome Icon ein mit dem der externe Link markiert werden soll. Zum Beispiel "f08e" für <i class="fa fa-external-link" aria-hidden="true"></i> oder "f14c" für <i class="fa fa-external-link-square" aria-hidden="true"></i>. Lassen sie das Feld leer, wenn sie keine Links markieren möchten.',
	'EXT_LINK_LINKS_POS'		=> 'Symbol Position',
	'EXT_LINK_LINKS_POS_DESC'	=> 'Wenn sie diese Option auswählen, wird das Symbol links vom Linktext eingefügt. Andernfalls wird das Symbol rechts angefügt. ',
	'EXT_LINK_LINKS_IMG'		=> 'Externes Bild',
	'EXT_LINK_LINKS_IMG_DESC'	=> 'Bei Bildern von externen Webseiten wird die Quelle des Bildes als Bildunterschrift hinzugefügt.',

	'EXT_LINK_SHOW'				=> 'Links verdecken',
	'EXT_LINK_SHOW_LINK'		=> 'Nur externe Links',
	'EXT_LINK_SHOW_LINK_DESC'	=> 'Mit den Forenrechten können Links und Bilder verdeckt werden. Mit der Auswahl dieser Option nur nur externe Links und Bilder verdeckt. Ist sie nicht ausgewählt werden alle Links verdeckt.',
	'EXT_LINK_EXT'				=> 'externe',
	'EXT_LINK_ALL'				=> 'alle',

	'EXT_LINK_FIND'				=> 'Bilder erkennen',
	'EXT_LINK_FIND_IMG'			=> 'Verbessertes erkennen von Links zu Bilder',
	'EXT_LINK_FIND_IMG_DESC'	=> 'Es werden auch Links zu Bilder erkannt wenn diese keine Dateinamenserweiterung für Bilder beinhalten.<br><strong>Achtung:</strong> Wenn sich in Beiträgen Tote Links befinden verlängert sich die Ladezeit der Forenseite.',

	// User settings
	'EXT_LINK_IMAGE'			=> 'Externes Bild',
	'EXT_LINK_IMAGE_LINK'		=> 'Abmessungen, ab denen externe Bilder verlinkt werden',
	'EXT_LINK_IMAGE_LINK_DESC'	=> 'Externe Bilder werden als Link dargestellt, wenn deren Größe diese Werte überschreitet. Bei der Verwendung von 0px &times; 0px wird dieses Verhalten abgeschaltet.',

	'EXT_LINK_LINKS_USERSET'	=> 'Benutzereinstellungen',
	'EXT_LINK_USERSET_TIME'		=> 'Die Benutzereinstellungen wurden zuletzt am %s überschrieben.',

	'EXT_LINK_OVERWRITE_USERSET'	 => 'Benutzereinstellungen überschreiben',
	'EXT_LINK_OVERWRITE_USERSET_DEC' => 'Bei dieser Auswahl werden die Einstellungen aller Benutzer überschrieben. Bei der Auswahl "Nein" werden nur Standartwerte für neue Benutzer gesetzt.',
]);
