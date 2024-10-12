<?php
/**
 * External Links
 * An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021, Thorsten Ahlers
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace imcger\externallinks\migrations;

class up04_acp_module extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\imcger\externallinks\migrations\up03_permission'];
	}

	public function effectively_installed()
	{
		return isset($this->config['imcger_ext_img_show_link_width']);
	}

	public function update_data()
	{
		return [
			['config.add', ['imcger_ext_img_show_link_width', $this->config['img_link_width']]],
			['config.add', ['imcger_ext_img_show_link_height', $this->config['img_link_height']]],
		];
	}
}
