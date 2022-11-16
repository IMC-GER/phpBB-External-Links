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

namespace imcger\externallinks\controller;

class admin_controller_userset
{
	/** @var config */
	protected $config;

	/** @var template */
	protected $template;

	/** @var language */
	protected $language;

	/** @var request */
	protected $request;

	/** @var \phpbb\user */
	protected $user;

	/** @var string Custom form action */
	protected $u_action;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config				$config
	 * @param \phpbb\template\template			$template
	 * @param \phpbb\language\language			$language
	 * @param \phpbb\request\request			$request
	 * @param \phpbb\user						$user			User object
	 * @param \phpbb\db\driver\driver_interface $db
	 *
	 */
	public function __construct
	(
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db
	)
	{
		$this->config	= $config;
		$this->template	= $template;
		$this->language	= $language;
		$this->request	= $request;
		$this->user 	= $user;
		$this->db		= $db;
	}

	/**
	 * Display the options a user can configure for this extension
	 *
	 * @return null
	 * @access public
	 */
	public function display_options()
	{
		// Add ACP lang file
		$this->language->add_lang(['common', 'ucp_externallinks', ], 'imcger/externallinks');

		add_form_key('imcger/externallinks');

		// Is the form being submitted to us?
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('imcger/externallinks'))
			{
				trigger_error('FORM_INVALID' . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// Store the variable to the db
			$this->set_variable();

			trigger_error($this->language->lang('ACP_EXT_LINK_USER_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		$this->template->assign_vars([
			'U_ACTION'					=> $this->u_action,
			'S_IMCGER_USER_NEWWIN'		=> $this->config['imcger_extlink_user_newwin'],
			'S_IMCGER_USER_TEXT'		=> $this->config['imcger_extlink_user_text'],
			'S_IMCGER_USER_IMAGE'		=> $this->config['imcger_extlink_user_image'],
			'S_IMCGER_USER_NONE_SECURE'	=> $this->config['imcger_extlink_user_none_secure'],
			'S_IMCGER_USERSET_TIME'		=> (BOOL) $this->config['imcger_extlink_user_setting_time'],

			'IMCGER_USERSET_TIME'		=> sprintf($this->language->lang('EXT_LINK_USERSET_TIME'), $this->user->format_date($this->config['imcger_extlink_user_setting_time'], false, true)),
		]);
	}

	/**
	 * Store the variable to the db
	 *
	 * @return null
	 * @access protected
	 */
	protected function set_variable()
	{
		$this->config->set('imcger_extlink_user_newwin', $this->request->variable('imcger_extlink_user_newwin', 0));
		$this->config->set('imcger_extlink_user_text', $this->request->variable('imcger_extlink_user_text', 0));
		$this->config->set('imcger_extlink_user_image', $this->request->variable('imcger_extlink_user_image', 0));
		$this->config->set('imcger_extlink_user_none_secure', $this->request->variable('imcger_extlink_user_none_secure', 0));

		$overwrite_userset = $this->request->variable('imcger_extlink_overwrite_userset', 0);

		if ($overwrite_userset)
		{
			$this->config->set('imcger_extlink_user_setting_time', time());

			$sql_ary = [
				'user_extlink_newwin'		=> (bool) $this->config['imcger_extlink_user_newwin'],
				'user_extlink_text'			=> (bool) $this->config['imcger_extlink_user_text'],
				'user_extlink_image'		=> (bool) $this->config['imcger_extlink_user_image'],
				'user_extlink_none_secure'	=> (bool) $this->config['imcger_extlink_user_none_secure'],
			];

			// Upate user settings whith default data
			$sql =	'UPDATE ' . USERS_TABLE .
					' SET ' . $this->db->sql_build_array('UPDATE', $sql_ary);

			$this->db->sql_query($sql);
		}
	}

	/**
	 * Set page url
	 *
	 * @param string $u_action Custom form action
	 * @return null
	 * @access public
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
