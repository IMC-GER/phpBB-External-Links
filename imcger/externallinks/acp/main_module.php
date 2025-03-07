<?php
/**
 * External Links
 * An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021, Thorsten Ahlers
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace imcger\externallinks\acp;

/**
 * External Links ACP module.
 */
class main_module
{
	/** @var page_title */
	public $page_title;

	/** @var tpl_name */
	public $tpl_name;

	/** @var u_action */
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container;

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		switch ($mode)
		{
			// General settings
			case 'settings':
				// Get an instance of the admin controller
				$admin_controller = $phpbb_container->get('imcger.externallinks.admin.controller');

				// Make the $u_action url available in the admin controller
				$admin_controller->set_page_url($this->u_action);

				// Load a template from adm/style for our ACP page
				$this->tpl_name = 'acp_ext_link_body';

				// Set the page title for our ACP page
				$this->page_title = $language->lang('ACP_EXT_LINK_TITLE');

				// Load the display options handle in the admin controller
				$admin_controller->display_options();
			break;

			// User settings
			case 'user_settings':
				// Get an instance of the admin controller
				$admin_controller = $phpbb_container->get('imcger.externallinks.admin.controller.userset');

				// Make the $u_action url available in the admin controller
				$admin_controller->set_page_url($this->u_action);

				// Load a template from adm/style for our ACP page
				$this->tpl_name = 'acp_ext_link_user_body';

				// Set the page title for our ACP page
				$this->page_title = $language->lang('ACP_EXT_LINK_USER_TITLE');

				// Load the display options handle in the admin controller
				$admin_controller->display_options();
			break;
		}
	}
}
