<?php
/**
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
class ucp_listener implements EventSubscriberInterface
{
	protected object $config;
	protected object $template;
	protected object $user;
	protected object $language;
	protected object $request;
	protected object $db;

	/**
	 * Constructor
	 */
	public function __construct
	(
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\db\driver\driver_interface $db
	)
	{
		$this->config	= $config;
		$this->template = $template;
		$this->user 	= $user;
		$this->language = $language;
		$this->request	= $request;
		$this->db		= $db;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			'core.ucp_display_module_before'	=> 'ucp_display_module_before',
			'core.ucp_prefs_view_data'			=> 'ucp_prefs_get_data',
			'core.ucp_prefs_view_update_data'	=> 'ucp_prefs_set_data',
			'core.ucp_register_register_after'	=> 'ucp_register_set_data',
		];
	}

	/**
	 * Add External Links language file
	 */
	public function ucp_display_module_before(): void
	{
		// Add language file in UCP
		$this->language->add_lang('ucp_externallinks', 'imcger/externallinks');
	}

	/**
	 * Add UCP edit display options data before they are assigned to the template or submitted
	 */
	public function ucp_prefs_get_data(object $event): void
	{
		$event['data'] = array_merge($event['data'], [
			'user_extlink_newwin'		=> $this->request->variable('imcger_ucp_ext_link_links_newwin', $this->user->data['user_extlink_newwin']),
			'user_extlink_text'			=> $this->request->variable('imcger_ucp_ext_link_link2_text', $this->user->data['user_extlink_text']),
			'user_extlink_image'		=> $this->request->variable('imcger_ucp_ext_link_link2_image', $this->user->data['user_extlink_image']),
			'user_extlink_none_secure'	=> $this->request->variable('imcger_ucp_ext_link_none_secure', $this->user->data['user_extlink_none_secure']),
		]);

		if (!$event['submit'])
		{
			$this->template->assign_vars([
				'S_UCP_LINKS_NEWWIN'	  => $event['data']['user_extlink_newwin'],
				'S_UCP_LINKS_2TEXT'		  => $event['data']['user_extlink_text'],
				'S_UCP_LINKS_2IMAGE'	  => $event['data']['user_extlink_image'],
				'S_UCP_LINKS_NONE_SECURE' => $event['data']['user_extlink_none_secure'],
			]);
		}
	}

	/**
	 * Update UCP edit display options data on form submit
	 */
	public function ucp_prefs_set_data(object $event): void
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], [
			'user_extlink_newwin'		=> $event['data']['user_extlink_newwin'],
			'user_extlink_text'			=> $event['data']['user_extlink_text'],
			'user_extlink_image'		=> $event['data']['user_extlink_image'],
			'user_extlink_none_secure'	=> $event['data']['user_extlink_none_secure'],
		]);
	}

	/**
	 * After new user registration, set user parameters to default
	 */
	public function ucp_register_set_data(object $event): void
	{
		$sql_ary = [
			'user_extlink_newwin'		=> (bool) $this->config['imcger_extlink_user_newwin'],
			'user_extlink_text'			=> (bool) $this->config['imcger_extlink_user_text'],
			'user_extlink_image'		=> (bool) $this->config['imcger_extlink_user_image'],
			'user_extlink_none_secure'	=> (bool) $this->config['imcger_extlink_user_none_secure'],
		];

		// Set user data whith default
		$sql =	'UPDATE ' . USERS_TABLE .
				' SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) .
				' WHERE user_id = ' . (int) $event['user_id'];

		$this->db->sql_query($sql);
	}
}
