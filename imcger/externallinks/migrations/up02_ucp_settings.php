<?php
/**
*
* Implements the image viewer Fancybox in phpBB. 
* An extension for the phpBB Forum Software package.
*
* @copyright (c) 2021, Thorsten Ahlers
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace imcger\externallinks\migrations;

class up02_ucp_settings extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\imcger\externallinks\migrations\up01_acp_module');
	}

	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_extlink_none_secure');
	}

	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_extlink_none_secure' => array('BOOL', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_extlink_none_secure',
				),
			),
		);
	}
}
