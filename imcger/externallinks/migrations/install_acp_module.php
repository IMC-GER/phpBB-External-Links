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

namespace imcger\externallinks\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['imcger_ext_link_img_show']);
	}

	public static function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v314');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('imcger_ext_link_img_show', 0)),
			array('config.add', array('imcger_ext_link_links_text', 1)),
			array('config.add', array('imcger_ext_link_links_img', 1)),
			array('config.add', array('imcger_ext_link_links_newwin', 0)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_EXT_LINK_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_EXT_LINK_TITLE',
				array(
					'module_basename'	=> '\imcger\externallinks\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
