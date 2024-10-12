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

class up03_permission extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\imcger\externallinks\migrations\up02_ucp_settings'];
	}

	public function effectively_installed()
	{
		return isset($this->config['imcger_ext_link_show_link']);
	}

	public function update_data()
	{
		return [
			['config.add', ['imcger_ext_link_show_link', 1,]],
		];
	}
}
