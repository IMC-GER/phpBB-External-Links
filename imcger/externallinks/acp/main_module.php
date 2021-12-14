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
 
namespace imcger\externallinks\acp;

/**
 * External Links ACP module.
 */
class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main($id, $mode)
	{
		global $config, $request, $template, $user;

		$user->add_lang_ext('imcger/externallinks', 'common');
		$this->tpl_name = 'acp_ext_link_body';
		$this->page_title = $user->lang('ACP_EXT_LINK_TITLE');
		add_form_key('imcger/externallinks');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('imcger/externallinks'))
			{
				trigger_error('FORM_INVALID', E_USER_WARNING);
			}
			
			$config->set('imcger_ext_link_links_text', $request->variable('imcger_ext_link_links_text', 0));
			$config->set('imcger_ext_link_links_img', $request->variable('imcger_ext_link_links_img', 0));
			
			trigger_error($user->lang('ACP_EXT_LINK_SETTING_SAVED') . adm_back_link($this->u_action));
		}
		
		$template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
			'S_IMCGER_LINKS_TEXT'	=> $config['imcger_ext_link_links_text'],
			'S_IMCGER_LINKS_IMG'	=> $config['imcger_ext_link_links_img'],
		));
	}
}
