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

class up06_acp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['imcger_extlink_user_setting_time']);
	}

	public static function depends_on()
	{
		return ['\imcger\externallinks\migrations\up05_acp_module'];
	}

	public function update_data()
	{
		return [
			['config.add', ['imcger_extlink_user_newwin', 1]],
			['config.add', ['imcger_extlink_user_text', 0]],
			['config.add', ['imcger_extlink_user_image', 0]],
			['config.add', ['imcger_extlink_user_none_secure', 0]],
			['config.add', ['imcger_extlink_user_setting_time', 0]],

			['module.add', [
				'acp',
				'ACP_EXT_LINK_TITLE',
				[
					'module_basename'	=> '\imcger\externallinks\acp\main_module',
					'modes'				=> ['user_settings'],
				],
			]],
		];
	}
}
