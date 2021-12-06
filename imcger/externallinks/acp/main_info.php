<?php
/**
 *
 * An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021, Thorsten Ahlers
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace imcger\externallinks\acp;

/**
 * External Links ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\imcger\externallinks\acp\main_module',
			'title'		=> 'ACP_EXT_LINK_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_EXT_LINK_SETTINGS',
					'auth'	=> 'ext_imcger/externallinks && acl_a_board',
					'cat'	=> array('ACP_EXT_LINK_TITLE'),
				),
			),
		);
	}
}
