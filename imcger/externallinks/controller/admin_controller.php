<?php
/**
 * External Links
 * An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021, Thorsten Ahlers
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

	/** @var \phpbb\extension\manager */
	protected $ext_manager;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor
	 *
	 * @param config	$config
	 * @param template	$template
	 * @param language	$language
	 * @param request	$request
	 * @param \phpbb\extension\manager	$ext_manager
	 *
	 */
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\extension\manager $ext_manager
	)
	{
		$this->config		= $config;
		$this->template		= $template;
		$this->language		= $language;
		$this->request		= $request;
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
		$this->language->add_lang('common', 'imcger/externallinks');

		add_form_key('imcger/externallinks');

		// Is the form being submitted to us?
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('imcger/externallinks'))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// Store the variable to the db
			$this->set_vars_config();

			trigger_error($this->language->lang('EXT_LINK_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		$this->set_template_vars();
	}

	/**
	 * Set the template variable
	 *
	 * @return null
	 * @access protected
	 */
	protected function set_template_vars()
	{
		// Get intern domain name
		$hostname = parse_url(generate_board_url(true),  PHP_URL_HOST);
		$host = explode('.', $hostname);

		// Set domain array with increase domain level
		$internal_domain = [false, false, false, false, false, false, ];
		$internal_domain[1] = $host[count($host)-1];

		for ($i = 2; $i <= count($host); $i++)
		{
			$internal_domain[$i] = $host[count($host) - $i] . '.' . $internal_domain[$i - 1];
		}

		$metadata_manager = $this->ext_manager->create_extension_metadata_manager('imcger/externallinks');

		$this->template->assign_vars([
			'U_ACTION'					=> $this->u_action,
			'EXT_LINK_TITLE'			=> $metadata_manager->get_metadata('display-name'),
			'EXT_LINK_EXT_VER'			=> $metadata_manager->get_metadata('version'),
			'DOMIAN_LEVEL_2'			=> $internal_domain[2],
			'DOMIAN_LEVEL_3'			=> $internal_domain[3],
			'DOMIAN_LEVEL_4'			=> $internal_domain[4],
			'DOMIAN_LEVEL_5'			=> $internal_domain[5],
			'S_IMCGER_EXT_LINK_DOMAIN'	=> $this->config['imcger_ext_link_domain_level'],
			'IMCGER_LINKS_SYMBOL'		=> $this->config['imcger_ext_link_symbol'],
			'S_IMCGER_LINKS_SYMBOL_POS'	=> $this->config['imcger_ext_link_symbol_pos'],
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
	protected function set_vars_config()
	{
		$this->config->set('imcger_ext_link_domain_level', $this->request->variable('imcger_ext_link_domain_level', 0));
		$this->config->set('imcger_ext_link_symbol', $this->request->variable('imcger_ext_link_symbol', ''));
		$this->config->set('imcger_ext_link_symbol_pos', $this->request->variable('imcger_ext_link_symbol_pos', 0));
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
