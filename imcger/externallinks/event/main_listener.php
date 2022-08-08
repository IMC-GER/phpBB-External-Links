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

namespace imcger\externallinks\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * External Links listener
 */
class main_listener implements EventSubscriberInterface
{
	/** @var int forum_id */
	protected $forum_id;

	/** @var string table_prefix */
	protected $table_prefix;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \FastImageSize\FastImageSize */
	protected $imagesize;

	public function __construct
	(
		$table_prefix,
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\auth\auth $auth,
		\FastImageSize\FastImageSize $imagesize
	)
	{
		$this->table_prefix	= $table_prefix;
		$this->config	= $config;
		$this->template = $template;
		$this->user 	= $user;
		$this->language = $language;
		$this->request	= $request;
		$this->db		= $db;
		$this->auth		= $auth;
		$this->imagesize = $imagesize;
	}

	public static function getSubscribedEvents()
	{
		return array(
			'core.phpbb_content_visibility_get_visibility_sql_before' => 'module_auth',
			'core.modify_text_for_display_after'		=> 'modify_text_for_display_after',
			'core.permissions'							=> 'permissions',
			'core.user_setup_after'						=> 'user_setup_after',
			'core.ucp_prefs_view_data'					=> 'ucp_prefs_get_data',
			'core.ucp_prefs_view_update_data'			=> 'ucp_prefs_set_data',
			'core.text_formatter_s9e_configure_after'	=> 'configure_textformatter',
			'core.text_formatter_s9e_renderer_setup'	=> 'set_textformatter_parameters',
			'core.posting_modify_message_text'			=> 'posting_modify_message_text',
		);
	}

	/** Add permissions */
	public function permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions += ['f_imcger_show_link' => ['lang' => 'ACL_F_IMCGER_LINK', 'cat' => 'actions']];
		$event['permissions'] = $permissions;
	}

	/** Get forum id */
	public function module_auth($event)
	{
		$this->forum_id = $event['forum_id'];
	}

	private function is_external_link($link)
	{
		/* Get intern domain name */
		$hostname = parse_url(generate_board_url(true));
		$host = explode('.', $hostname['host']);

		/* Get domain level */
		$domain_level = $this->config['imcger_ext_link_domain_level'];

		/* Set domain with increase domain level */
		$internal_domain = $host[count($host)-1];

		/* Domainname for compare */
		for ($i = 2; $i <= $domain_level; $i++)
		{
			$internal_domain = $host[count($host) - $i] . '.' . $internal_domain;
		}

		/* URL select */
		$start_pos	= stripos($link, 'href="') === false ? (stripos($link, 'src="') + 5) : (stripos($link, 'href="') + 6);
		$end_pos	= stripos($link, '"', $start_pos);
		$link_url	= substr($link, $start_pos, $end_pos - $start_pos);

		/* Check if url internal */
		if ($this->str_starts_with($link_url, './') || $this->str_starts_with($link_url, '/') || $this->str_contains($link_url, $internal_domain))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	/** Check permissions and hide or show links */
	public function modify_text_for_display_after($event)
	{
		if (!empty($this->forum_id))
		{
			$acl_get = $this->auth->acl_get('f_imcger_show_link', $this->forum_id);

			if (!$acl_get)
			{
				/* Set Variable */
				$text = $event['text'];
				$offset = 0;
				$find_regex = ['#(<img\s)(.*?)(>)#i', // Image
							   '#(<div class="imcger-img-wrap">)(.*?)(</div>)#i', // Image with caption
							   '#(<a\s[^>]+?>)(.*?)(</a>)#i', ]; // Link

				$new_text = $this->language->lang('IMCGER_EXT_LINK_NO_LINK');
				$new_link = '<div class="rules">' . $new_text . '</div>';

				$only_external = $this->config['imcger_ext_link_show_link'];

				/* Check if link in text */
				if ($this->str_contains($text, '<a') || $this->str_contains($text, '<img'))
				{
					/* Change only external links */
					if ($only_external)
					{
						foreach ($find_regex as $regex)
						{
							$offset = 0;

							/* Find links in post */
							while (preg_match($regex, $text, $match, PREG_OFFSET_CAPTURE, $offset))
							{
								/* Check if external */
								if ($this->is_external_link($match[0][0]))
								{
									/* replace link with alternate text */
									$text = str_replace($match[0][0], $new_link, $text);
									$offset = $match[0][1];
								}
								else
								{
									$offset = $match[3][1];
								}
							}
						}

						$event['text'] = $text;
					}
					else
					{
						/* Change internal und external links */
						$event['text'] = preg_replace($find_regex, $new_link, $text);
					}
				}
			}
		}
	}

	/** Add External Links language file */
	public function user_setup_after()
	{
		/* Add language file in textformatter */
		$this->language->add_lang('externallinks_lang', 'imcger/externallinks');

		/* Add language file in UCP */
		$this->language->add_lang('ucp_externallinks', 'imcger/externallinks');
	}

	public function ucp_prefs_get_data($event)
	{
		$event['data'] = array_merge($event['data'], [
			'user_extlink_newwin'		=> $this->request->variable('imcger_ucp_ext_link_links_newwin', $this->user->data['user_extlink_newwin']),
			'user_extlink_text'			=> $this->request->variable('imcger_ucp_ext_link_link2_text', $this->user->data['user_extlink_text']),
			'user_extlink_image'		=> $this->request->variable('imcger_ucp_ext_link_link2_image', $this->user->data['user_extlink_image']),
			'user_extlink_none_secure'	=> $this->request->variable('imcger_ucp_ext_link_none_secure', $this->user->data['user_extlink_none_secure']),
		]);

		if (!$event['submit'])
		{
			$this->template->assign_vars([
				'S_UCP_LINKS_NEWWIN'	  => $event['data']['user_extlink_newwin'],
				'S_UCP_LINKS_2TEXT'		  => $event['data']['user_extlink_text'],
				'S_UCP_LINKS_2IMAGE'	  => $event['data']['user_extlink_image'],
				'S_UCP_LINKS_NONE_SECURE' => $event['data']['user_extlink_none_secure'],
			]);
		}
	}

	public function ucp_prefs_set_data($event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], [
			'user_extlink_newwin'		=> $event['data']['user_extlink_newwin'],
			'user_extlink_text'			=> $event['data']['user_extlink_text'],
			'user_extlink_image'		=> $event['data']['user_extlink_image'],
			'user_extlink_none_secure'	=> $event['data']['user_extlink_none_secure'],
		]);
	}

	/**
	 * Extends the s9e TextFormatter template for the URL and IMG tag to include more
	 * templates.
	 *
	 * @param	object		$event	The event object
	 * @return	null
	 * @access	public
	 */
	public function configure_textformatter($event)
	{
		/** @var \s9e\TextFormatter\Configurator $configurator */
		$configurator = $event['configurator'];

		/* The default URL tag template is this:
		   <a href="{@url}" class="postlink"><xsl:apply-templates/></a> */
		$default_url_template = $configurator->tags['URL']->template;

		/* The default IMG tag template is this:
		   <img src="{@src}" class="postimage" alt="{$L_IMAGE}"/> */
		$default_img_template = $configurator->tags['IMG']->template;

		/* Get intern domain name */
		$hostname = parse_url(generate_board_url(true));
		$host = explode('.', $hostname['host']);

		/* Set domain array with increase domain level */
		$internal_domain = array('','*?*','*?*','*?*','*?*','*?*');
		$internal_domain[1] = $host[count($host)-1];

		for ($i = 2; $i <= count($host); $i++)
		{
			$internal_domain[$i] = $host[count($host) - $i] . '.' . $internal_domain[$i - 1];
		}

		/* Query whether own domain */
		$query_domain_src = '(contains(@src, \'' . $internal_domain[2] . '\') and $S_IMCGER_DOMAIN_LEVEL_2) or ' .
							'(contains(@src, \'' . $internal_domain[3] . '\') and $S_IMCGER_DOMAIN_LEVEL_3) or ' .
							'(contains(@src, \'' . $internal_domain[4] . '\') and $S_IMCGER_DOMAIN_LEVEL_4) or ' .
							'(contains(@src, \'' . $internal_domain[5] . '\') and $S_IMCGER_DOMAIN_LEVEL_5) or ' .
							'starts-with(@src, \'/\') or starts-with(@src, \'./\')';

		$query_domain_url = str_replace('@src', '@url', $query_domain_src);

		/* Shorten URL for caption */
		$img_caption_src = 	'<xsl:choose>' .
								'<xsl:when test="string-length(@src) &gt; 55"><xsl:value-of select="concat(substring(@src, 0, 40),\' ... \',substring(@src, string-length(@src)-9))"/></xsl:when>' .
								'<xsl:otherwise><xsl:value-of select="string(@src)"/></xsl:otherwise>' .
							'</xsl:choose>';

		$img_caption_url = str_replace('@src', '@url', $img_caption_src);

		$url_img_template = str_replace(
			'src="{@src}"',
			'src="{@url}"',
			$default_img_template
		);
		/* Add title tag for external image */
		$default_img_template_ext = str_replace(
			'alt="{$L_IMAGE}"',
			'alt="{$L_IMCGER_EXT_LINK_EXT_IMG}" title="{$L_IMCGER_EXT_LINK_EXT_IMG}"',
			$default_img_template
		);
		$url_img_template_ext = str_replace(
			'alt="{$L_IMAGE}"',
			'alt="{$L_IMCGER_EXT_LINK_EXT_IMG}" title="{$L_IMCGER_EXT_LINK_EXT_IMG}"',
			$url_img_template
		);

		/* Add attribute for external links */
		$default_url_template_ext = str_replace(
			'href="{@url}"',
			'href="{@url}" title="{$L_IMCGER_EXT_LINK_EXT_LINK}"',
			$default_url_template
		);
		$url_template_new_window = str_replace(
			'href="{@url}"',
			'href="{@url}" target="_blank" rel="noopener noreferrer"',
			$default_url_template_ext
		);
		$url_template_new_window_mark = str_replace(
			'postlink',
			'postlink  imcger-ext-link',
			$url_template_new_window
		);
		$url_template_mark = str_replace(
			'postlink',
			'postlink  imcger-ext-link',
			$default_url_template_ext
		);

		$fancy_default_url_template = str_replace(
			'href="{@url}"',
			'href="{@url}" data-fancybox="image" data-caption="{@url}"',
			$default_url_template_ext
		);
		$fancy_url_template_new_window = str_replace(
			'href="{@url}"',
			'href="{@url}" target="_blank" rel="noopener noreferrer"',
			$fancy_default_url_template
		);
		$fancy_url_template_new_window_mark = str_replace(
			'postlink',
			'postlink  imcger-ext-link',
			$fancy_url_template_new_window
		);
		$fancy_url_template_mark = str_replace(
			'postlink',
			'postlink  imcger-ext-link',
			$fancy_default_url_template
		);

		/* "imcger/fancybox aktive set attribute in template */
		$fancybox_attribute  = ' data-fancybox="image" data-caption="{@src}"';
		$fancybox_start_link = '<a href="{@src}"' . $fancybox_attribute . '>';
		$fancybox_end_link	 = '</a>';

		/* Select the appropriate template based on the parameters and the URL */
		$configurator->tags['IMG']->template =
			'<xsl:choose>' .
				/* Check if the image comes from external and the display should be changed */
				'<xsl:when test="($S_IMCGER_LINKS_IMG_TO_TEXT or $S_IMCGER_LINKS_IMG_CAPTION or (starts-with(@src, \'http://\') and $S_IMCGER_LINKS_NONE_SECURE))  and not(' . $query_domain_src . ')">' .
					/* Add the link to the image as a subline */
					'<xsl:if test="$S_IMCGER_LINKS_IMG_CAPTION and not($S_IMCGER_LINKS_IMG_TO_TEXT) and not(starts-with(@src, \'http://\') and $S_IMCGER_LINKS_NONE_SECURE)">' .
						'<div class="imcger-img-wrap">' .
						/* Check if fancybox is aktive */
						'<xsl:if test="$S_IMCGER_FANCYBOX_AKTIVE">' .
							$fancybox_start_link . $default_img_template_ext . $fancybox_end_link .
						'</xsl:if>' .
						/* Check if fancybox is not aktive */
						'<xsl:if test="not($S_IMCGER_FANCYBOX_AKTIVE)">' .
							$default_img_template_ext .
						'</xsl:if>' .
						'<span class="imcger-ext-image"><span><xsl:value-of select="string($L_IMCGER_EXT_LINK_BILD_SOURCE)"/></span>: ' . $img_caption_src . '</span>' .
						'</div>' .
					'</xsl:if>' .
					/* Show the image as link */
					'<xsl:if test="$S_IMCGER_FANCYBOX_AKTIVE and ($S_IMCGER_LINKS_IMG_TO_TEXT or (starts-with(@src, \'http://\') and $S_IMCGER_LINKS_NONE_SECURE))">' .
						/* Simple link */
						'<xsl:if test="not($S_IMCGER_LINKS_TEXT_MARK) and not($S_IMCGER_LINKS_OPEN_NEWWIN)">' .
							'<a href="{@src}" class="postlink" title="{$L_IMCGER_EXT_LINK_EXT_LINK}"' . $fancybox_attribute . '>' . $img_caption_src . '</a>' .
						'</xsl:if>' .
						/* Mark link */
						'<xsl:if test="$S_IMCGER_LINKS_TEXT_MARK and not($S_IMCGER_LINKS_OPEN_NEWWIN)">' .
							'<a href="{@src}" class="postlink imcger-ext-link" title="{$L_IMCGER_EXT_LINK_EXT_LINK}"' . $fancybox_attribute . '>' . $img_caption_src . '</a>' .
						'</xsl:if>' .
						/* Open link in new tab/window */
						'<xsl:if test="not($S_IMCGER_LINKS_TEXT_MARK) and $S_IMCGER_LINKS_OPEN_NEWWIN">' .
							'<a href="{@src}" class="postlink" title="{$L_IMCGER_EXT_LINK_EXT_LINK}" target="_blank" rel="noopener noreferrer"' . $fancybox_attribute . '>' . $img_caption_src . '</a>' .
						'</xsl:if>' .
						/* Open link in new tab/window and mark it */
						'<xsl:if test="$S_IMCGER_LINKS_TEXT_MARK and $S_IMCGER_LINKS_OPEN_NEWWIN">' .
							'<a href="{@src}" class="postlink imcger-ext-link" title="{$L_IMCGER_EXT_LINK_EXT_LINK}" target="_blank" rel="noopener noreferrer"' . $fancybox_attribute . '>' . $img_caption_src . '</a>' .
						'</xsl:if>' .
					'</xsl:if>' .
					'<xsl:if test="not($S_IMCGER_FANCYBOX_AKTIVE) and ($S_IMCGER_LINKS_IMG_TO_TEXT or (starts-with(@src, \'http://\') and $S_IMCGER_LINKS_NONE_SECURE))">' .
						/* Simple link */
						'<xsl:if test="not($S_IMCGER_LINKS_TEXT_MARK) and not($S_IMCGER_LINKS_OPEN_NEWWIN)">' .
							'<a href="{@src}" class="postlink" title="{$L_IMCGER_EXT_LINK_EXT_LINK}">' . $img_caption_src . '</a>' .
						'</xsl:if>' .
						/* Mark link */
						'<xsl:if test="$S_IMCGER_LINKS_TEXT_MARK and not($S_IMCGER_LINKS_OPEN_NEWWIN)">' .
							'<a href="{@src}" class="postlink imcger-ext-link" title="{$L_IMCGER_EXT_LINK_EXT_LINK}">' . $img_caption_src . '</a>' .
						'</xsl:if>' .
						/* Open link in new tab/window */
						'<xsl:if test="not($S_IMCGER_LINKS_TEXT_MARK) and $S_IMCGER_LINKS_OPEN_NEWWIN">' .
							'<a href="{@src}" class="postlink" title="{$L_IMCGER_EXT_LINK_EXT_LINK}" target="_blank" rel="noopener noreferrer">' . $img_caption_src . '</a>' .
						'</xsl:if>' .
						/* Open link in new tab/window and mark it */
						'<xsl:if test="$S_IMCGER_LINKS_TEXT_MARK and $S_IMCGER_LINKS_OPEN_NEWWIN">' .
							'<a href="{@src}" class="postlink imcger-ext-link" title="{$L_IMCGER_EXT_LINK_EXT_LINK}" target="_blank" rel="noopener noreferrer">' . $img_caption_src . '</a>' .
						'</xsl:if>' .
					'</xsl:if>' .
				'</xsl:when>' .
				/* For internal image standard display */
				'<xsl:otherwise>' .
					'<xsl:choose>' .
						/* Check if fancybox is aktive */
						'<xsl:when test="$S_IMCGER_FANCYBOX_AKTIVE">' .
							$fancybox_start_link . $default_img_template . $fancybox_end_link .
						'</xsl:when>' .
						'<xsl:otherwise>' .
							$default_img_template .
						'</xsl:otherwise>' .
					'</xsl:choose>' .
				'</xsl:otherwise>' .
			'</xsl:choose>';

		/* "imcger/fancybox aktive set attribute in template */
		$fancybox_attribute  = ' data-fancybox="image" data-caption="{@url}"';
		$fancybox_start_link = '<a href="{@url}"' . $fancybox_attribute . '>';

		/* Select the appropriate template based on the parameters and the URL */
		$configurator->tags['URL']->template =
			'<xsl:choose>' .
				/* Show links to  images as embedded image */
				'<xsl:when test="$S_IMCGER_LINKS_TEXT_TO_IMG and not(starts-with(@url, \'http://\') and $S_IMCGER_LINKS_NONE_SECURE) and (contains(@url, \'.jpg\') or contains(@url, \'.jpeg\') or contains(@url, \'.gif\') or contains(@url, \'.png\') or contains(@url, \'.webp\') or contains(@url, \'.svg\'))">' .
					'<xsl:choose>' .
						/* Add the link to the image as a subline */
						'<xsl:when test="$S_IMCGER_LINKS_IMG_CAPTION">' .
							'<div class="imcger-img-wrap">' .
							/* Check if fancybox is aktive */
							'<xsl:if test="$S_IMCGER_FANCYBOX_AKTIVE">' .
								$fancybox_start_link . $url_img_template_ext . $fancybox_end_link .
							'</xsl:if>' .
							/* Check if fancybox is not aktive */
							'<xsl:if test="not($S_IMCGER_FANCYBOX_AKTIVE)">' .
								$url_img_template_ext .
							'</xsl:if>' .
							'<span class="imcger-ext-image"><span><xsl:value-of select="string($L_IMCGER_EXT_LINK_BILD_SOURCE)"/></span>: ' . $img_caption_url . '</span>' .
							'</div>' .
						'</xsl:when>' .
						/* Image standard display */
						'<xsl:otherwise>' .
							'<xsl:choose>' .
								/* Check if fancybox is aktive */
								'<xsl:when test="$S_IMCGER_FANCYBOX_AKTIVE">' .
									$fancybox_start_link . $url_img_template_ext . $fancybox_end_link .
								'</xsl:when>' .
								'<xsl:otherwise>' .
									$url_img_template_ext .
								'</xsl:otherwise>' .
							'</xsl:choose>' .
						'</xsl:otherwise>' .
					'</xsl:choose>' .
				'</xsl:when>' .
				'<xsl:otherwise>' .
					'<xsl:choose>' .
						/* Check if it an image */
						'<xsl:when test="$S_IMCGER_FANCYBOX_AKTIVE and (contains(@url, \'.jpg\') or contains(@url, \'.jpeg\') or contains(@url, \'.gif\') or contains(@url, \'.png\') or contains(@url, \'.webp\') or contains(@url, \'.svg\'))">' .
							'<xsl:choose>' .
								/* Check if URL domain from external */
								'<xsl:when test="($S_IMCGER_LINKS_TEXT_MARK or $S_IMCGER_LINKS_OPEN_NEWWIN)  and not(' . $query_domain_url . ')">' .
									/* Open the link in new tab/window */
									'<xsl:if test="(not($S_IMCGER_LINKS_TEXT_MARK) and $S_IMCGER_LINKS_OPEN_NEWWIN)">' .
										$fancy_url_template_new_window .
									'</xsl:if>' .
									/* Mark the link with icon */
									'<xsl:if test="($S_IMCGER_LINKS_TEXT_MARK and not($S_IMCGER_LINKS_OPEN_NEWWIN))">' .
										$fancy_url_template_mark .
									'</xsl:if>' .
									/* Open the link in new tab/window and mark it with icon */
									'<xsl:if test="($S_IMCGER_LINKS_TEXT_MARK and $S_IMCGER_LINKS_OPEN_NEWWIN)">' .
										$fancy_url_template_new_window_mark .
									'</xsl:if>' .
								'</xsl:when>' .
								/* For internal link standard display */
								'<xsl:otherwise>' . $fancy_default_url_template . '</xsl:otherwise>' .
							'</xsl:choose>' .
						'</xsl:when>' .
						/* Link standard display */
						'<xsl:otherwise>' .
							'<xsl:choose>' .
								/* Check if URL domain from external */
								'<xsl:when test="($S_IMCGER_LINKS_TEXT_MARK or $S_IMCGER_LINKS_OPEN_NEWWIN)  and not(' . $query_domain_url . ')">' .
									/* Open the link in new tab/window */
									'<xsl:if test="(not($S_IMCGER_LINKS_TEXT_MARK) and $S_IMCGER_LINKS_OPEN_NEWWIN)">' .
										$url_template_new_window .
									'</xsl:if>' .
									/* Mark the link with icon */
									'<xsl:if test="($S_IMCGER_LINKS_TEXT_MARK and not($S_IMCGER_LINKS_OPEN_NEWWIN))">' .
										$url_template_mark .
									'</xsl:if>' .
									/* Open the link in new tab/window and mark it with icon */
									'<xsl:if test="($S_IMCGER_LINKS_TEXT_MARK and $S_IMCGER_LINKS_OPEN_NEWWIN)">' .
										$url_template_new_window_mark .
									'</xsl:if>' .
								'</xsl:when>' .
								/* For internal link standard display */
								'<xsl:otherwise>' . $default_url_template . '</xsl:otherwise>' .
							'</xsl:choose>' .
						'</xsl:otherwise>' .
					'</xsl:choose>' .
				'</xsl:otherwise>' .
			'</xsl:choose>';
	}

	/**
	 * Sets parameters for the s9e TextFormatter, which will be used to select
	 * the appropriate template for the URL and IMG tag.
	 *
	 * @param	object		$event	The event object
	 * @return	null
	 * @access	public
	 */
	public function set_textformatter_parameters($event)
	{
		/** @var \s9e\TextFormatter\Renderer $renderer */
		$renderer = $event['renderer']->get_renderer();

		/* Check if extension "imcger/externallinks" aktive */
		$sql = 'SELECT ext_active FROM ' . $this->table_prefix . 'ext WHERE ext_name = "imcger/fancybox"';
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$is_fancybox = empty($row['ext_active']) ? false : $row['ext_active'];

		/* Set Domain Level for template */
		$domain_level = array(0, 0, 0, 0, 0, 0);
		$domain_level[$this->config['imcger_ext_link_domain_level']] = 1;
		$renderer->setParameter('S_IMCGER_DOMAIN_LEVEL_2', (bool) $domain_level[2]);
		$renderer->setParameter('S_IMCGER_DOMAIN_LEVEL_3', (bool) $domain_level[3]);
		$renderer->setParameter('S_IMCGER_DOMAIN_LEVEL_4', (bool) $domain_level[4]);
		$renderer->setParameter('S_IMCGER_DOMAIN_LEVEL_5', (bool) $domain_level[5]);

		/* Don`t display insecurely transferred images (http://) */
		$renderer->setParameter('S_IMCGER_LINKS_NONE_SECURE', (bool) $this->user->data['user_extlink_none_secure']);

		/* Convert an external image into a link */
		$renderer->setParameter('S_IMCGER_LINKS_IMG_TO_TEXT', (bool) $this->user->data['user_extlink_text']);

		/* Convert a external link to an image into an image */
		$renderer->setParameter('S_IMCGER_LINKS_TEXT_TO_IMG', (bool) $this->user->data['user_extlink_image'] && (bool) $this->user->optionget('viewimg'));

		/* Add a subline to an external image */
		$renderer->setParameter('S_IMCGER_LINKS_IMG_CAPTION', (bool) $this->config['imcger_ext_link_links_img'] && (bool) $this->user->optionget('viewimg'));

		/* Open an external link in a new tab/window */
		$renderer->setParameter('S_IMCGER_LINKS_OPEN_NEWWIN', (bool) $this->user->data['user_extlink_newwin']);

		/* Mark external link */
		$renderer->setParameter('S_IMCGER_LINKS_TEXT_MARK', (bool) $this->config['imcger_ext_link_links_text']);

		/* Fancybox aktive */
		$renderer->setParameter('S_IMCGER_FANCYBOX_AKTIVE', (bool) $is_fancybox);
	}

	/**
	 *
	 */
	public function posting_modify_message_text($event)
	{
		/* Initialize variable */
		$match = [];
		$error = [];
		$offset = 0;
		$i = 0;

		/* Regular expression to search for image */
		$regex = '#(\[img\])(.*?)(\[\/img\])#i';

		/* Get max image dimension */
		$max_width = $this->config['imcger_ext_img_show_link_width'];
		$max_heigth = $this->config['imcger_ext_img_show_link_height'];

		/* Get message text */
		$message_parser = $event['message_parser'];
		$message = $message_parser->message;

		if ($max_width || $max_heigth)
		{
			/* Find image in post message */
			while (preg_match($regex, $message, $match, PREG_OFFSET_CAPTURE, $offset))
			{
				if ($i > 0)
				{
					$error += [$i++ => "\n", ];
				}

				/* Get image dimension */
				$image_data = $this->imagesize->getImageSize(trim($match[2][0]));

				/* If no image data tranform to link */
				if (empty($image_data) || $image_data['width'] <= 0 || $image_data['height'] <= 0)
				{
					$error += [$i++ => $this->language->lang('IMCGER_EXT_LINK_NO_IMAGEDATA'),
							   $i++ => $match[2][0], ];

					$message = str_replace($match[0][0], '[url]' . $match[2][0] . '[/url]', $message);
				}

				/* If image to large tranform to link */
				if (!empty($image_data) && ($image_data['width'] > $max_width || $image_data['height'] > $max_heigth))
				{
					$error += [$i++ => $this->language->lang('IMCGER_EXT_LINK_IMAGE_TOLARGE', $max_width, $max_heigth),
							   $i++ => $match[2][0], ];

					$message = str_replace($match[0][0], '[url]' . $match[2][0] . '[/url]', $message);
				}

				$offset = $match[3][1];
			}

			$event['error'] = $error;
			$message_parser->message = $message;
		}
	}

	/* Function is available from php 8 */
	private function str_starts_with($haystack, $needle)
	{
		if (function_exists('str_starts_with'))
		{
			return str_starts_with($haystack, $needle);
		}
		else
		{
			return ($needle == substr($haystack, 0, strlen($needle))) ? true : false;
		}
	}

	/* Function is available from php 8 */
	private function str_contains($haystack, $needle)
	{
		if (function_exists('str_contains'))
		{
			return str_contains($haystack, $needle);
		}
		else
		{
			return strpos($haystack, $needle) ? true : false;
		}
	}
}
