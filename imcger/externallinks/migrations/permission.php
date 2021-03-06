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

class permission  extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\imcger\externallinks\migrations\install_acp_module');
	}

	public function update_data()
	{
		return [
			['permission.add', ['f_imcger_show_link', false, 'f_list',]],
		];
	}
}
