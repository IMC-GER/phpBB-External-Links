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

	/** @var \phpbb\request\request */
	protected $request;


	public function __construct
	(
		\phpbb\config\config $config, 
		\phpbb\template\template $template, 
		\phpbb\user $user, 
		\phpbb\language\language $language,
		\phpbb\request\request $request
	)
	{
		$this->config   = $config;
		$this->template = $template;
		$this->user 	= $user;
		$this->language = $language;
		$this->request	= $request;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'					=> 'show_ext_links_var',
			'core.user_setup_after'				=> 'user_setup_after',
			'core.ucp_prefs_view_data'			=> 'ucp_prefs_get_data',
			'core.ucp_prefs_view_update_data'	=> 'ucp_prefs_set_data',
		);
	}

	/** Add External Links language file in UCP */
	public function user_setup_after()
	{
		$this->language->add_lang('ucp_externallinks', 'imcger/externallinks');
	}

	public function show_ext_links_var()
	{
		/* Add External Links language file for JS */
		$this->language->add_lang('externallinks_lang','imcger/externallinks');

		$imcger_ext_link_img_show		= $this->user->data['user_extlink_text'] < $this->user->data['user_extlink_image'] ? $this->user->data['user_extlink_image'] : $this->user->data['user_extlink_text'];
		$imcger_ext_link_links_text		= $this->config['imcger_ext_link_links_text'];
		$imcger_ext_link_links_img		= $this->config['imcger_ext_link_links_img'];
		$imcger_ext_link_links_newwin	= $this->user->data['user_extlink_newwin'];


		$this->template->assign_vars([
			'S_IMCGER_EXT_LINK_IMG_SHOW'		=> $imcger_ext_link_img_show,
			'S_IMCGER_EXT_LINK_LINKS_TEXT'		=> $imcger_ext_link_links_text,
			'S_IMCGER_EXT_LINK_LINKS_IMG'		=> $imcger_ext_link_links_img,
			'S_IMCGER_EXT_LINK_LINKS_NEWWIN'	=> $imcger_ext_link_links_newwin,
		]);
	}

	public function ucp_prefs_get_data($event)
	{
		$event['data'] = array_merge($event['data'], [
			'user_extlink_newwin'	=> $this->request->variable('imcger_ucp_ext_link_links_newwin', $this->user->data['user_extlink_newwin']),
			'user_extlink_text'		=> $this->request->variable('imcger_ucp_ext_link_link2_text', $this->user->data['user_extlink_text']),
			'user_extlink_image'	=> $this->request->variable('imcger_ucp_ext_link_link2_image', $this->user->data['user_extlink_image']),
		]);

		if (!$event['submit'])
		{
			$this->template->assign_vars([
				'S_UCP_LINKS_NEWWIN'	=> $event['data']['user_extlink_newwin'],
				'S_UCP_LINKS_2TEXT'		=> $event['data']['user_extlink_text'],
				'S_UCP_LINKS_2IMAGE'	=> $event['data']['user_extlink_image'],
			]);
		}
	}

	public function ucp_prefs_set_data($event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], [
			'user_extlink_newwin'	=> $event['data']['user_extlink_newwin'],
			'user_extlink_text'		=> $event['data']['user_extlink_text'],
			'user_extlink_image'	=> $event['data']['user_extlink_image'],
		]);
	}
}
