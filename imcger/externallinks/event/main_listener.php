<?php
/**
*
* An extension for the phpBB Forum Software package.
*
* @copyright (c) 2021, Thorsten Ahlers
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace imcger\externallinks\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * External Links listener
 */
class main_listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;
	
	/** @var \phpbb\language\language */
	protected $language;


	public function __construct(\phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user, \phpbb\language\language $language)
	{
		$this->config   = $config;
		$this->template = $template;
		$this->user 	= $user;
		$this->language = $language;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'		=>	'show_ext_links_var',
		);
	}

	public function show_ext_links_var()
	{  
		// Add External Links language file
		$this->language->add_lang('externallinks_lang','imcger/externallinks');

		$imcger_ext_link_bild			= $this->config['imcger_ext_link_bild'];
		$imcger_ext_link_links_text		= $this->config['imcger_ext_link_links_text'];
		$imcger_ext_link_links_img		= $this->config['imcger_ext_link_links_img'];
		$imcger_ext_link_links_newwin	= $this->config['imcger_ext_link_links_newwin'];
		

		$this->template->assign_vars([
			'IMCGER_EXT_LINK_BILD'			=> $imcger_ext_link_bild,
			'IMCGER_EXT_LINK_LINKS_TEXT'	=> $imcger_ext_link_links_text,
			'IMCGER_EXT_LINK_LINKS_IMG'		=> $imcger_ext_link_links_img,
			'IMCGER_EXT_LINK_LINKS_NEWWIN'	=> $imcger_ext_link_links_newwin,
		]);
	}
}
