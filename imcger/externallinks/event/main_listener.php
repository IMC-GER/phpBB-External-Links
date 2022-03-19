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


	public function __construct
	(
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\language\language $language,
		\phpbb\request\request $request
	)
	{
		$this->config   = $config;
		$this->template = $template;
		$this->user 	= $user;
		$this->language = $language;
		$this->request	= $request;
	}

	public static function getSubscribedEvents()
	{
		return array(
			'core.page_header'					=> 'show_ext_links_var',
			'core.user_setup_after'				=> 'user_setup_after',
			'core.ucp_prefs_view_data'			=> 'ucp_prefs_get_data',
			'core.ucp_prefs_view_update_data'	=> 'ucp_prefs_set_data',
			'core.text_formatter_s9e_configure_after' => 'configure_textformatter',
			'core.text_formatter_s9e_renderer_setup'  => 'set_textformatter_parameters',
		);
	}

	/** Add External Links language file in UCP */
	public function user_setup_after()
	{
		$this->language->add_lang('ucp_externallinks', 'imcger/externallinks');
	}

	public function show_ext_links_var()
	{
		/* Add External Links language file for JS */
		$this->language->add_lang('externallinks_lang','imcger/externallinks');

		/* Get intern domain name */
		$hostname = parse_url(generate_board_url(true));

		/* Set domain array with increase domain level */
		$host = explode('.', $hostname['host']);
		$internal_domain = $host[count($host)-1];

		for ($i = 2; $i <= count($host); $i++)
		{
			$internal_domain = $host[count($host) - $i] . '.' . $internal_domain;

			if ($i >= $this->config['imcger_ext_link_domain_level'])
			{
				break;
			}
		}

		/* Set template variable for js script */
		$this->template->assign_vars([
			'IMCGER_EXT_LINK_INTERNAL_DOMAIN'	=> $internal_domain,
		]);
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
		$url_template_new_window = str_replace(
			'href="{@url}"',
			'href="{@url}" target="_blank" rel="noopener noreferrer"',
			$default_url_template
		);
		$url_template_new_window_mark = str_replace(
			'postlink',
			'postlink  imcger-ext-link',
			$url_template_new_window
		);
		$url_template_mark = str_replace(
			'postlink',
			'postlink  imcger-ext-link',
			$default_url_template
		);

		/* Select the appropriate template based on the parameters and the URL */
		$configurator->tags['IMG']->template =
			'<xsl:choose>' .
				/* Check if the image comes from external and the display should be changed */
				'<xsl:when test="($S_IMCGER_LINKS_IMG_TO_TEXT or $S_IMCGER_LINKS_IMG_CAPTION or (starts-with(@src, \'http://\') and $S_IMCGER_LINKS_NONE_SECURE))  and not(' . $query_domain_src . ')">' .
					/* Add the link to the image as a subline */
					'<xsl:if test="$S_IMCGER_LINKS_IMG_CAPTION and not($S_IMCGER_LINKS_IMG_TO_TEXT) and not(starts-with(@src, \'http://\') and $S_IMCGER_LINKS_NONE_SECURE)">' .
						'<div class="imcger-img-wrap">' .
							$default_img_template .
							'<span class="imcger-ext-image"><span>Source</span>: ' . $img_caption_src . '</span>' .
						'</div>' .
					'</xsl:if>' .
					/* Show the image as link */
					'<xsl:if test="$S_IMCGER_LINKS_IMG_TO_TEXT or (starts-with(@src, \'http://\') and $S_IMCGER_LINKS_NONE_SECURE)">' .
						/* Simple link */
						'<xsl:if test="not($S_IMCGER_LINKS_TEXT_MARK) and not($S_IMCGER_LINKS_OPEN_NEWWIN)">' .
							'<a href="{@src}" class="postlink">' . $img_caption_src . '</a>' .
						'</xsl:if>' .
						/* Mark link */
						'<xsl:if test="$S_IMCGER_LINKS_TEXT_MARK and not($S_IMCGER_LINKS_OPEN_NEWWIN)">' .
							'<a href="{@src}" class="postlink imcger-ext-link">' . $img_caption_src . '</a>' .
						'</xsl:if>' .
						/* Open link in new tab/window */
						'<xsl:if test="not($S_IMCGER_LINKS_TEXT_MARK) and $S_IMCGER_LINKS_OPEN_NEWWIN">' .
							'<a href="{@src}" class="postlink" target="_blank" rel="noopener noreferrer">' . $img_caption_src . '</a>' .
						'</xsl:if>' .
						/* Open link in new tab/window and mark it */
						'<xsl:if test="$S_IMCGER_LINKS_TEXT_MARK and $S_IMCGER_LINKS_OPEN_NEWWIN">' .
							'<a href="{@src}" class="postlink imcger-ext-link" target="_blank" rel="noopener noreferrer">' . $img_caption_src . '</a>' .
						'</xsl:if>' .
					'</xsl:if>' .
				'</xsl:when>' .
				/* For internal image standard display */
				'<xsl:otherwise>' . $default_img_template . '</xsl:otherwise>' .
			'</xsl:choose>';

		/* Select the appropriate template based on the parameters and the URL */
		$configurator->tags['URL']->template =
			'<xsl:choose>' .
				/* Show links to  images as embedded image */
				'<xsl:when test="$S_IMCGER_LINKS_TEXT_TO_IMG and not(starts-with(@url, \'http://\') and $S_IMCGER_LINKS_NONE_SECURE) and (contains(@url, \'.jpg\') or contains(@url, \'.jpeg\') or contains(@url, \'.gif\') or contains(@url, \'.png\') or contains(@url, \'.webp\') or contains(@url, \'.svg\'))">' .
					'<xsl:choose>' .
						/* Add the link to the image as a subline */
						'<xsl:when test="$S_IMCGER_LINKS_IMG_CAPTION">' .
							'<div class="imcger-img-wrap">' .
								$url_img_template .
								'<span class="imcger-ext-image"><span>Source</span>: ' . $img_caption_url . '</span>' .
							'</div>' .
						'</xsl:when>' .
						/* Image standard display */
						'<xsl:otherwise>' . $url_img_template . '</xsl:otherwise>' .
					'</xsl:choose>' .
				'</xsl:when>' .
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
	}
}
