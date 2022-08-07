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

namespace imcger\externallinks\migrations;

class up04_acp_module extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\imcger\externallinks\migrations\up03_permission');
	}

	public function effectively_installed()
	{
		return isset($this->config['imcger_ext_img_show_link_width']);
	}

	public function update_data()
	{
		return array(
			array('config.add', array('imcger_ext_img_show_link_width', 0)),
			array('config.add', array('imcger_ext_img_show_link_height', 0)),
		);
	}
}
