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

class up01_acp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['imcger_ext_link_domain_level']);
	}

	public static function depends_on()
	{
		return ['\imcger\externallinks\migrations\add_ucp_settings'];
	}

	public function update_data()
	{
		return [
			['config.add', ['imcger_ext_link_domain_level', 2]],
		];
	}
}
