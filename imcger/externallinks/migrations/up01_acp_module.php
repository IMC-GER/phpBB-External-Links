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

class up01_acp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['imcger_ext_link_domain_level']);
	}

	static public function depends_on()
	{
		return array('\imcger\externallinks\migrations\add_ucp_settings');
	}

	public function update_data()
	{		
		return array(
			array('config.add', array('imcger_ext_link_domain_level', 2)),
		);
	}
}
