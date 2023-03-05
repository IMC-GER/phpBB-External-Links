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

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\extension\manager */
	protected $ext_manager;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config				$config
	 * @param \phpbb\template\template			$template
	 * @param \phpbb\language\language			$language
	 * @param \phpbb\request\request			$request
	 * @param \phpbb\user						$user
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbb\extension\manager			$ext_manager
	 *
	 */
	public function __construct
	(
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\extension\manager $ext_manager
	)
	{
		$this->config		= $config;
		$this->template		= $template;
		$this->language		= $language;
		$this->request		= $request;
		$this->user 		= $user;
		$this->db			= $db;
		$this->ext_manager	= $ext_manager;
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
		if ($this->request->is_set_post('action'))
		{
			if (!check_form_key('imcger/externallinks'))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$action = $this->request->variable('action', 'default');
			$overwrite_userset = $this->request->variable('imcger_extlink_overwrite_userset', 0);

			switch ($action)
			{
				case 'write_data':
					if (!$overwrite_userset)
					{
						$this->set_vars_config();
						$this->set_template_vars('config');
						trigger_error($this->language->lang('EXT_LINK_DEFAULT_SETTING_SAVED') . adm_back_link($this->u_action));
					}
					else
					{
						if (!confirm_box(true))
						{
							// Request confirmation from the user to delete the auto group rule
							confirm_box(false, 'EXT_LINK_USER_SET',
										build_hidden_fields([
											'action'							=> $action,
											'imcger_extlink_user_newwin'		=> $this->request->variable('imcger_extlink_user_newwin', 0),
											'imcger_extlink_user_text'			=> $this->request->variable('imcger_extlink_user_text', 0),
											'imcger_extlink_user_image'			=> $this->request->variable('imcger_extlink_user_image', 0),
											'imcger_extlink_user_none_secure'	=> $this->request->variable('imcger_extlink_user_none_secure', 0),
											'imcger_extlink_overwrite_userset'	=> $this->request->variable('imcger_extlink_overwrite_userset', 0),
										]),
										'@imcger_externallinks/acp_ext_link_user_body_confirm_box.html');

							$this->set_template_vars('request', false);
						}
						else
						{
							$this->set_vars_config();
							$this->set_vars_userset();
							$this->set_template_vars('config');
							trigger_error($this->language->lang('EXT_LINK_USER_SETTING_SAVED') . adm_back_link($this->u_action));
						}
					}
				break;

				case 'cancel':
					$this->set_template_vars('request');
				break;

				default:
					$this->set_template_vars('config');
				break;
			}
		}
		else
		{
			$this->set_template_vars('config');
		}
	}

	/**
	 * Set template variables
	 *
	 * @param string	$get_data			Data to set in template
	 * @param bool		$overwrite_userset	Display message box
	 * @return null
	 * @access protected
	 */
	protected function set_template_vars($get_data = 'config', $overwrite_userset = false)
	{
		$metadata_manager = $this->ext_manager->create_extension_metadata_manager('imcger/externallinks');

		$this->template->assign_vars([
			'U_ACTION'					 => $this->u_action,
			'EXT_LINK_TITLE'			 => $metadata_manager->get_metadata('display-name'),
			'EXT_LINK_EXT_VER'			 => $metadata_manager->get_metadata('version'),
			'S_IMCGER_USERSET_TIME'		 => (BOOL) $this->config['imcger_extlink_user_setting_time'],
			'S_IMCGER_OVERWRITE_USERSET' => $overwrite_userset,
			'IMCGER_USERSET_TIME'		 => sprintf($this->language->lang('EXT_LINK_USERSET_TIME'), $this->user->format_date($this->config['imcger_extlink_user_setting_time'], false, true)),
		]);

		if ($get_data == 'config')
		{
			$this->template->assign_vars([
				'S_IMCGER_USER_NEWWIN'		=> $this->config['imcger_extlink_user_newwin'],
				'S_IMCGER_USER_TEXT'		=> $this->config['imcger_extlink_user_text'],
				'S_IMCGER_USER_IMAGE'		=> $this->config['imcger_extlink_user_image'],
				'S_IMCGER_USER_NONE_SECURE'	=> $this->config['imcger_extlink_user_none_secure'],
				'S_IMCGER_RESET_BUTTON'		=> true,
			]);
		}

		if ($get_data == 'request')
		{
			$this->template->assign_vars([
				'S_IMCGER_USER_NEWWIN'		=> $this->request->variable('imcger_extlink_user_newwin', 0),
				'S_IMCGER_USER_TEXT'		=> $this->request->variable('imcger_extlink_user_text', 0),
				'S_IMCGER_USER_IMAGE'		=> $this->request->variable('imcger_extlink_user_image', 0),
				'S_IMCGER_USER_NONE_SECURE'	=> $this->request->variable('imcger_extlink_user_none_secure', 0),
				'S_IMCGER_RESET_BUTTON'		=> false,
			]);
		}
	}

	/**
	 * Store the variable to config
	 *
	 * @return null
	 * @access protected
	 */
	protected function set_vars_config()
	{
		$this->config->set('imcger_extlink_user_newwin', $this->request->variable('imcger_extlink_user_newwin', 0));
		$this->config->set('imcger_extlink_user_text', $this->request->variable('imcger_extlink_user_text', 0));
		$this->config->set('imcger_extlink_user_image', $this->request->variable('imcger_extlink_user_image', 0));
		$this->config->set('imcger_extlink_user_none_secure', $this->request->variable('imcger_extlink_user_none_secure', 0));
	}

	/**
	 * Overwrite settings for all user
	 *
	 * @return null
	 * @access protected
	 */
	protected function set_vars_userset()
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
