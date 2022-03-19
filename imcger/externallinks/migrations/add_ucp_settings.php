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

class add_ucp_settings extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\imcger\externallinks\migrations\install_acp_module');
	}

	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_extlink_newwin');
	}

	public function update_data()
	{
		return array(
			array('config.remove', array('imcger_ext_link_img_show')),
			array('config.remove', array('imcger_ext_link_links_newwin')),
		);
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'users' => array(
					'user_extlink_newwin'	=> array('BOOL', 1),
					'user_extlink_text'		=> array('UINT:2', 0),
					'user_extlink_image'	=> array('UINT:2', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'users' => array(
					'user_extlink_newwin',
					'user_extlink_text',
					'user_extlink_image',
				),
			),
		);
	}
}
