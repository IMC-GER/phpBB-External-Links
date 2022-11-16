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

class admin_controller
{
	/** @var config */
	protected $config;

	/** @var template */
	protected $template;

	/** @var language */
	protected $language;

	/** @var request */
	protected $request;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor
	 *
	 * @param config	$config
	 * @param template	$template
	 * @param language	$language
	 * @param request	$request
	 *
	 */
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\language\language $language,
		\phpbb\request\request $request
	)
	{
		$this->config	= $config;
		$this->template	= $template;
		$this->language	= $language;
		$this->request	= $request;
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
		$this->language->add_lang('common', 'imcger/externallinks');

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

			trigger_error($this->language->lang('ACP_EXT_LINK_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		$this->template->assign_vars([
			'U_ACTION'					=> $this->u_action,
			'S_IMCGER_EXT_LINK_DOMAIN'	=> $this->config['imcger_ext_link_domain_level'],
			'S_IMCGER_LINKS_TEXT'		=> $this->config['imcger_ext_link_links_text'],
			'S_IMCGER_LINKS_IMG'		=> $this->config['imcger_ext_link_links_img'],
			'S_IMCGER_FIND_IMG'			=> $this->config['imcger_ext_find_img'],
			'S_IMCGER_SHOW_LINK'		=> $this->config['imcger_ext_link_show_link'],
			'IMCGER_IMG_LINK_WIDTH'		=> $this->config['imcger_ext_img_show_link_width'],
			'IMCGER_IMG_LINK_HEIGHT'	=> $this->config['imcger_ext_img_show_link_height'],
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
		$this->config->set('imcger_ext_link_domain_level', $this->request->variable('imcger_ext_link_domain_level', 0));
		$this->config->set('imcger_ext_link_links_text', $this->request->variable('imcger_ext_link_links_text', 0));
		$this->config->set('imcger_ext_link_links_img', $this->request->variable('imcger_ext_link_links_img', 0));
		$this->config->set('imcger_ext_find_img', $this->request->variable('imcger_ext_find_img', 0));
		$this->config->set('imcger_ext_link_show_link', $this->request->variable('imcger_ext_link_show_link', 0));
		$this->config->set('imcger_ext_img_show_link_width', $this->request->variable('imcger_ext_img_show_link_width', 0));
		$this->config->set('imcger_ext_img_show_link_height', $this->request->variable('imcger_ext_img_show_link_height', 0));
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
