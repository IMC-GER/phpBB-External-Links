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

class add_ucp_settings extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\imcger\externallinks\migrations\install_acp_module'];
	}

	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_extlink_newwin');
	}

	public function update_data()
	{
		return [
			['config.remove', ['imcger_ext_link_img_show']],
			['config.remove', ['imcger_ext_link_links_newwin']],
		];
	}

	public function update_schema()
	{
		return [
			'add_columns'	=> [
				$this->table_prefix . 'users' => [
					'user_extlink_newwin'	=> ['BOOL', 1],
					'user_extlink_text'		=> ['UINT:2', 0],
					'user_extlink_image'	=> ['UINT:2', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns'	=> [
				$this->table_prefix . 'users' => [
					'user_extlink_newwin',
					'user_extlink_text',
					'user_extlink_image',
				],
			],
		];
	}
}
