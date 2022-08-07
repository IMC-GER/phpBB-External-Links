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

namespace imcger\externallinks;

/**
 * Extension base
 */
class ext extends \phpbb\extension\base
{
	/**
	 * Check the minimum and maximum requirements.
	 *
	 * @return bool|string/array A error message
	 */
	public function is_enableable()
	{
		/* If phpBB version 3.1 or less cancel */
		if (phpbb_version_compare(PHPBB_VERSION, '3.2.0', '<'))
		{
			return false;
		}

		$language = $this->container->get('language');
		$language->add_lang('info_acp_externallinks', 'imcger/externallinks');
		$error_message = [];

		/* phpBB version greater equal 3.2.0 and less then 4.0 */
		if (phpbb_version_compare(PHPBB_VERSION, '3.2.0', '<') || phpbb_version_compare(PHPBB_VERSION, '4.0.0', '>='))
		{
			$error_message += ['error1' => $language->lang('IMCGER_REQUIRE_PHPBB'),];
		}

		/* php version equal or greater 5.4.7 and less 8.2 */
		if (version_compare(PHP_VERSION, '5.4.7', '<') || version_compare(PHP_VERSION, '8.2', '>='))
		{
			$error_message += ['error2' => $language->lang('IMCGER_REQUIRE_PHP'),];
		}

		/* When phpBB v3.2 use trigger_error() for message output. For v3.1 return false. */
		if (phpbb_version_compare(PHPBB_VERSION, '3.3.0', '<') && !empty($error_message))
		{
			$message = implode('<br>', $error_message);
			trigger_error($message, E_USER_WARNING);
		}

		return empty($error_message) ? true : $error_message;
	}
}
