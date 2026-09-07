<?php
/**
 * Class for managing plugin data
 */
class Su_Data {

	/**
	 * Constructor
	 */
	function __construct() {}

	/**
	 * Shortcode groups
	 */
	public static function groups() {
		return ( array ) apply_filters( 'su/data/groups', array(
				'all'     => __( 'All', 'su' ),
				'content' => __( 'Content', 'su' ),
				'box'     => __( 'Box', 'su' ),
				'media'   => __( 'Media', 'su' ),
				'gallery' => __( 'Gallery', 'su' ),
				'data'    => __( 'Data', 'su' ),
				'other'   => __( 'Other', 'su' )
			) );
	}

	/**
	 * Border styles
	 */
	public static function borders() {
		return ( array ) apply_filters( 'su/data/borders', array(
				'none'   => __( 'None', 'su' ),
				'solid'  => __( 'Solid', 'su' ),
				'dotted' => __( 'Dotted', 'su' ),
				'dashed' => __( 'Dashed', 'su' ),
				'double' => __( 'Double', 'su' ),
				'groove' => __( 'Groove', 'su' ),
				'ridge'  => __( 'Ridge', 'su' )
			) );
	}

	/**
	 * Font-Awesome icons
	 */
	public static function icons() {
		return apply_filters( 'su/data/icons', array( 'glass', 'music', 'search', 'envelope-o', 'heart', 'star', 'star-o', 'user', 'film', 'th-large', 'th', 'th-list', 'check', 'times', 'search-plus', 'search-minus', 'power-off', 'signal', 'cog', 'trash-o', 'home', 'file-o', 'clock-o', 'road', 'download', 'arrow-circle-o-down', 'arrow-circle-o-up', 'inbox', 'play-circle-o', 'repeat', 'refresh', 'list-alt', 'lock', 'flag', 'headphones', 'volume-off', 'volume-down', 'volume-up', 'qrcode', 'barcode', 'tag', 'tags', 'book', 'bookmark', 'print', 'camera', 'font', 'bold', 'italic', 'text-height', 'text-width', 'align-left', 'align-center', 'align-right', 'align-justify', 'list', 'outdent', 'indent', 'video-camera', 'picture-o', 'pencil', 'map-marker', 'adjust', 'tint', 'pencil-square-o', 'share-square-o', 'check-square-o', 'arrows', 'step-backward', 'fast-backward', 'backward', 'play', 'pause', 'stop', 'forward', 'fast-forward', 'step-forward', 'eject', 'chevron-left', 'chevron-right', 'plus-circle', 'minus-circle', 'times-circle', 'check-circle', 'question-circle', 'info-circle', 'crosshairs', 'times-circle-o', 'check-circle-o', 'ban', 'arrow-left', 'arrow-right', 'arrow-up', 'arrow-down', 'share', 'expand', 'compress', 'plus', 'minus', 'asterisk', 'exclamation-circle', 'gift', 'leaf', 'fire', 'eye', 'eye-slash', 'exclamation-triangle', 'plane', 'calendar', 'random', 'comment', 'magnet', 'chevron-up', 'chevron-down', 'retweet', 'shopping-cart', 'folder', 'folder-open', 'arrows-v', 'arrows-h', 'bar-chart-o', 'twitter-square', 'facebook-square', 'camera-retro', 'key', 'cogs', 'comments', 'thumbs-o-up', 'thumbs-o-down', 'star-half', 'heart-o', 'sign-out', 'linkedin-square', 'thumb-tack', 'external-link', 'sign-in', 'trophy', 'github-square', 'upload', 'lemon-o', 'phone', 'square-o', 'bookmark-o', 'phone-square', 'twitter', 'facebook', 'github', 'unlock', 'credit-card', 'rss', 'hdd-o', 'bullhorn', 'bell', 'certificate', 'hand-o-right', 'hand-o-left', 'hand-o-up', 'hand-o-down', 'arrow-circle-left', 'arrow-circle-right', 'arrow-circle-up', 'arrow-circle-down', 'globe', 'wrench', 'tasks', 'filter', 'briefcase', 'arrows-alt', 'users', 'link', 'cloud', 'flask', 'scissors', 'files-o', 'paperclip', 'floppy-o', 'square', 'bars', 'list-ul', 'list-ol', 'strikethrough', 'underline', 'table', 'magic', 'truck', 'pinterest', 'pinterest-square', 'google-plus-square', 'google-plus', 'money', 'caret-down', 'caret-up', 'caret-left', 'caret-right', 'columns', 'sort', 'sort-asc', 'sort-desc', 'envelope', 'linkedin', 'undo', 'gavel', 'tachometer', 'comment-o', 'comments-o', 'bolt', 'sitemap', 'umbrella', 'clipboard', 'lightbulb-o', 'exchange', 'cloud-download', 'cloud-upload', 'user-md', 'stethoscope', 'suitcase', 'bell-o', 'coffee', 'cutlery', 'file-text-o', 'building-o', 'hospital-o', 'ambulance', 'medkit', 'fighter-jet', 'beer', 'h-square', 'plus-square', 'angle-double-left', 'angle-double-right', 'angle-double-up', 'angle-double-down', 'angle-left', 'angle-right', 'angle-up', 'angle-down', 'desktop', 'laptop', 'tablet', 'mobile', 'circle-o', 'quote-left', 'quote-right', 'spinner', 'circle', 'reply', 'github-alt', 'folder-o', 'folder-open-o', 'smile-o', 'frown-o', 'meh-o', 'gamepad', 'keyboard-o', 'flag-o', 'flag-checkered', 'terminal', 'code', 'reply-all', 'mail-reply-all', 'star-half-o', 'location-arrow', 'crop', 'code-fork', 'chain-broken', 'question', 'info', 'exclamation', 'superscript', 'subscript', 'eraser', 'puzzle-piece', 'microphone', 'microphone-slash', 'shield', 'calendar-o', 'fire-extinguisher', 'rocket', 'maxcdn', 'chevron-circle-left', 'chevron-circle-right', 'chevron-circle-up', 'chevron-circle-down', 'html5', 'css3', 'anchor', 'unlock-alt', 'bullseye', 'ellipsis-h', 'ellipsis-v', 'rss-square', 'play-circle', 'ticket', 'minus-square', 'minus-square-o', 'level-up', 'level-down', 'check-square', 'pencil-square', 'external-link-square', 'share-square', 'compass', 'caret-square-o-down', 'caret-square-o-up', 'caret-square-o-right', 'eur', 'gbp', 'usd', 'inr', 'jpy', 'rub', 'krw', 'btc', 'file', 'file-text', 'sort-alpha-asc', 'sort-alpha-desc', 'sort-amount-asc', 'sort-amount-desc', 'sort-numeric-asc', 'sort-numeric-desc', 'thumbs-up', 'thumbs-down', 'youtube-square', 'youtube', 'xing', 'xing-square', 'youtube-play', 'dropbox', 'stack-overflow', 'instagram', 'flickr', 'adn', 'bitbucket', 'bitbucket-square', 'tumblr', 'tumblr-square', 'long-arrow-down', 'long-arrow-up', 'long-arrow-left', 'long-arrow-right', 'apple', 'windows', 'android', 'linux', 'dribbble', 'skype', 'foursquare', 'trello', 'female', 'male', 'gittip', 'sun-o', 'moon-o', 'archive', 'bug', 'vk', 'weibo', 'renren', 'pagelines', 'stack-exchange', 'arrow-circle-o-right', 'arrow-circle-o-left', 'caret-square-o-left', 'dot-circle-o', 'wheelchair', 'vimeo-square', 'try', 'plus-square-o' ) );
	}

	/**
	 * Animate.css animations
	 */
	public static function animations() {
		return apply_filters( 'su/data/animations', array( 'flash', 'bounce', 'shake', 'tada', 'swing', 'wobble', 'pulse', 'flip', 'flipInX', 'flipOutX', 'flipInY', 'flipOutY', 'fadeIn', 'fadeInUp', 'fadeInDown', 'fadeInLeft', 'fadeInRight', 'fadeInUpBig', 'fadeInDownBig', 'fadeInLeftBig', 'fadeInRightBig', 'fadeOut', 'fadeOutUp', 'fadeOutDown', 'fadeOutLeft', 'fadeOutRight', 'fadeOutUpBig', 'fadeOutDownBig', 'fadeOutLeftBig', 'fadeOutRightBig', 'slideInDown', 'slideInLeft', 'slideInRight', 'slideOutUp', 'slideOutLeft', 'slideOutRight', 'bounceIn', 'bounceInDown', 'bounceInUp', 'bounceInLeft', 'bounceInRight', 'bounceOut', 'bounceOutDown', 'bounceOutUp', 'bounceOutLeft', 'bounceOutRight', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'lightSpeedIn', 'lightSpeedOut', 'hinge', 'rollIn', 'rollOut' ) );
	}

	/**
	 * Examples section
	 */
	public static function examples() {
		return ( array ) apply_filters( 'su/data/examples', array(
				'basic' => array(
					'title' => __( 'Basic examples', 'su' ),
					'items' => array(
						array(
							'name' => __( 'Accordions, spoilers, different styles, anchors', 'su' ),
							'id'   => 'spoilers',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/spoilers.example',
							'icon' => 'tasks'
						),
						array(
							'name' => __( 'Tabs, vertical tabs, tab anchors', 'su' ),
							'id'   => 'tabs',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/tabs.example',
							'icon' => 'folder'
						),
						array(
							'name' => __( 'Column layouts', 'su' ),
							'id'   => 'columns',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/columns.example',
							'icon' => 'th-large'
						),
						array(
							'name' => __( 'Media elements, YouTube, Vimeo, Screenr and self-hosted videos, audio player', 'su' ),
							'id'   => 'media',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/media.example',
							'icon' => 'play-circle'
						),
						array(
							'name' => __( 'Unlimited buttons', 'su' ),
							'id'   => 'buttons',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/buttons.example',
							'icon' => 'heart'
						),
						array(
							'name' => __( 'Animations', 'su' ),
							'id'   => 'animations',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/animations.example',
							'icon' => 'bolt'
						),
					)
				),
				'advanced' => array(
					'title' => __( 'Advanced examples', 'su' ),
					'items' => array(
						array(
							'name' => __( 'Interacting with posts shortcode', 'su' ),
							'id' => 'posts',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/posts.example',
							'icon' => 'list'
						),
						array(
							'name' => __( 'Nested shortcodes, shortcodes inside of attributes', 'su' ),
							'id' => 'nested',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/nested.example',
							'icon' => 'indent'
						),
					)
				),
			) );
	}

	/**
	 * Shortcodes
	 */
	public static function shortcodes( $shortcode = false ) {
		$shortcodes = apply_filters( 'su/data/shortcodes', array(
				// heading
				'heading' => array(
					'name' => __( 'Heading', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ),
							'desc' => sprintf( '%s. <a href="http://gndev.info/shortcodes-ultimate/skins/" target="_blank">%s</a>', __( 'Choose style for this heading', 'su' ), __( 'Install additional styles', 'su' ) )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 7,
							'max' => 48,
							'step' => 1,
							'default' => 13,
							'name' => __( 'Size', 'su' ),
							'desc' => __( 'Select heading size (pixels)', 'su' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'su' ),
								'center' => __( 'Center', 'su' ),
								'right' => __( 'Right', 'su' )
							),
							'default' => 'center',
							'name' => __( 'Align', 'su' ),
							'desc' => __( 'Heading text alignment', 'su' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 200,
							'step' => 10,
							'default' => 20,
							'name' => __( 'Margin', 'su' ),
							'desc' => __( 'Bottom margin (pixels)', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Heading text', 'su' ),
					'desc' => __( 'Styled heading', 'su' ),
					'icon' => 'h-square'
				),
				// tabs
				'tabs' => array(
					'name' => __( 'Tabs', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ),
							'desc' => sprintf( '%s. <a href="http://gndev.info/shortcodes-ultimate/skins/" target="_blank">%s</a>', __( 'Choose style for this tabs', 'su' ), __( 'Install additional styles', 'su' ) )
						),
						'active' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 100,
							'step' => 1,
							'default' => 1,
							'name' => __( 'Active tab', 'su' ),
							'desc' => __( 'Select which tab is open by default', 'su' )
						),
						'vertical' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Vertical', 'su' ),
							'desc' => __( 'Show tabs vertically', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( "[%prefix_tab title=\"Title 1\"]Content 1[/%prefix_tab]\n[%prefix_tab title=\"Title 2\"]Content 2[/%prefix_tab]\n[%prefix_tab title=\"Title 3\"]Content 3[/%prefix_tab]", 'su' ),
					'desc' => __( 'Tabs container', 'su' ),
					'example' => 'tabs',
					'icon' => 'list-alt'
				),
				// tab
				'tab' => array(
					'name' => __( 'Tab', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'default' => __( 'Tab name', 'su' ),
							'name' => __( 'Title', 'su' ),
							'desc' => __( 'Enter tab name', 'su' )
						),
						'disabled' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Disabled', 'su' ),
							'desc' => __( 'Is this tab disabled', 'su' )
						),
						'anchor' => array(
							'default' => '',
							'name' => __( 'Anchor', 'su' ),
							'desc' => __( 'You can use unique anchor for this tab to access it with hash in page url. For example: type here <b%value>Hello</b> and then use url like http://example.com/page-url#Hello. This tab will be activated and scrolled in', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Tab content', 'su' ),
					'desc' => __( 'Single tab', 'su' ),
					'note' => __( 'Did you know that you need to wrap single tabs with [tabs] shortcode?', 'su' ),
					'example' => 'tabs',
					'icon' => 'list-alt'
				),
				// spoiler
				'spoiler' => array(
					'name' => __( 'Spoiler', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'default' => __( 'Spoiler title', 'su' ),
							'name' => __( 'Title', 'su' ), 'desc' => __( 'Text in spoiler title', 'su' )
						),
						'open' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Open', 'su' ),
							'desc' => __( 'Is spoiler content visible by default', 'su' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'fancy' => __( 'Fancy', 'su' ),
								'simple' => __( 'Simple', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ),
							'desc' => sprintf( '%s. <a href="http://gndev.info/shortcodes-ultimate/skins/" target="_blank">%s</a>', __( 'Choose style for this spoiler', 'su' ), __( 'Install additional styles', 'su' ) )
						),
						'icon' => array(
							'type' => 'select',
							'values' => array(
								'plus'           => __( 'Plus', 'su' ),
								'plus-circle'    => __( 'Plus circle', 'su' ),
								'plus-square-1'  => __( 'Plus square 1', 'su' ),
								'plus-square-2'  => __( 'Plus square 2', 'su' ),
								'arrow'          => __( 'Arrow', 'su' ),
								'arrow-circle-1' => __( 'Arrow circle 1', 'su' ),
								'arrow-circle-2' => __( 'Arrow circle 2', 'su' ),
								'chevron'        => __( 'Chevron', 'su' ),
								'chevron-circle' => __( 'Chevron circle', 'su' ),
								'caret'          => __( 'Caret', 'su' ),
								'caret-square'   => __( 'Caret square', 'su' ),
								'folder-1'       => __( 'Folder 1', 'su' ),
								'folder-2'       => __( 'Folder 2', 'su' )
							),
							'default' => 'plus',
							'name' => __( 'Icon', 'su' ),
							'desc' => __( 'Icons for spoiler', 'su' )
						),
						'anchor' => array(
							'default' => '',
							'name' => __( 'Anchor', 'su' ),
							'desc' => __( 'You can use unique anchor for this spoiler to access it with hash in page url. For example: type here <b%value>Hello</b> and then use url like http://example.com/page-url#Hello. This spoiler will be open and scrolled in', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Hidden content', 'su' ),
					'desc' => __( 'Spoiler with hidden content', 'su' ),
					'note' => __( 'Did you know that you can wrap multiple spoilers with [accordion] shortcode to create accordion effect?', 'su' ),
					'example' => 'spoilers',
					'icon' => 'list-ul'
				),
				// accordion
				'accordion' => array(
					'name' => __( 'Accordion', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( "[%prefix_spoiler]Content[/%prefix_spoiler]\n[%prefix_spoiler]Content[/%prefix_spoiler]\n[%prefix_spoiler]Content[/%prefix_spoiler]", 'su' ),
					'desc' => __( 'Accordion with spoilers', 'su' ),
					'note' => __( 'Did you know that you can wrap multiple spoilers with [accordion] shortcode to create accordion effect?', 'su' ),
					'example' => 'spoilers',
					'icon' => 'list'
				),
				// divider
				'divider' => array(
					'name' => __( 'Divider', 'su' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'top' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show TOP link', 'su' ),
							'desc' => __( 'Show link to top of the page or not', 'su' )
						),
						'text' => array(
							'values' => array( ),
							'default' => __( 'Go to top', 'su' ),
							'name' => __( 'Link text', 'su' ), 'desc' => __( 'Text for the GO TOP link', 'su' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'dotted'  => __( 'Dotted', 'su' ),
								'dashed'  => __( 'Dashed', 'su' ),
								'double'  => __( 'Double', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ),
							'desc' => __( 'Choose style for this divider', 'su' )
						),
						'divider_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#999999',
							'name' => __( 'Divider color', 'su' ),
							'desc' => __( 'Pick the color for divider', 'su' )
						),
						'link_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#999999',
							'name' => __( 'Link color', 'su' ),
							'desc' => __( 'Pick the color for TOP link', 'su' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 40,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Size', 'su' ),
							'desc' => __( 'Height of the divider (in pixels)', 'su' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 200,
							'step' => 5,
							'default' => 15,
							'name' => __( 'Margin', 'su' ),
							'desc' => __( 'Adjust the top and bottom margins of this divider (in pixels)', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Content divider with optional TOP link', 'su' ),
					'icon' => 'ellipsis-h'
				),
				// spacer
				'spacer' => array(
					'name' => __( 'Spacer', 'su' ),
					'type' => 'single',
					'group' => 'content other',
					'atts' => array(
						'size' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 800,
							'step' => 10,
							'default' => 20,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Height of the spacer in pixels', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Empty space with adjustable height', 'su' ),
					'icon' => 'arrows-v'
				),
				// highlight
				'highlight' => array(
					'name' => __( 'Highlight', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'background' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#DDFF99',
							'name' => __( 'Background', 'su' ),
							'desc' => __( 'Highlighted text background color', 'su' )
						),
						'color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#000000',
							'name' => __( 'Text color', 'su' ), 'desc' => __( 'Highlighted text color', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Highlighted text', 'su' ),
					'desc' => __( 'Highlighted text', 'su' ),
					'icon' => 'pencil'
				),
				// label
				'label' => array(
					'name' => __( 'Label', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'type' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'success' => __( 'Success', 'su' ),
								'warning' => __( 'Warning', 'su' ),
								'important' => __( 'Important', 'su' ),
								'black' => __( 'Black', 'su' ),
								'info' => __( 'Info', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Type', 'su' ),
							'desc' => __( 'Style of the label', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Label', 'su' ),
					'desc' => __( 'Styled label', 'su' ),
					'icon' => 'tag'
				),
				// quote
				'quote' => array(
					'name' => __( 'Quote', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ),
							'desc' => sprintf( '%s. <a href="http://gndev.info/shortcodes-ultimate/skins/" target="_blank">%s</a>', __( 'Choose style for this quote', 'su' ), __( 'Install additional styles', 'su' ) )
						),
						'cite' => array(
							'default' => '',
							'name' => __( 'Cite', 'su' ),
							'desc' => __( 'Quote author name', 'su' )
						),
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Cite url', 'su' ),
							'desc' => __( 'Url of the quote author. Leave empty to disable link', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Quote', 'su' ),
					'desc' => __( 'Blockquote alternative', 'su' ),
					'icon' => 'quote-right'
				),
				// pullquote
				'pullquote' => array(
					'name' => __( 'Pullquote', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'su' ),
								'right' => __( 'Right', 'su' )
							),
							'default' => 'left',
							'name' => __( 'Align', 'su' ), 'desc' => __( 'Pullquote alignment (float)', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Pullquote', 'su' ),
					'desc' => __( 'Pullquote', 'su' ),
					'icon' => 'quote-left'
				),
				// dropcap
				'dropcap' => array(
					'name' => __( 'Dropcap', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'flat' => __( 'Flat', 'su' ),
								'light' => __( 'Light', 'su' ),
								'simple' => __( 'Simple', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ), 'desc' => __( 'Dropcap style preset', 'su' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 5,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Size', 'su' ),
							'desc' => __( 'Choose dropcap size', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'D', 'su' ),
					'desc' => __( 'Dropcap', 'su' ),
					'icon' => 'bold'
				),
				// frame
				'frame' => array(
					'name' => __( 'Frame', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'su' ),
								'center' => __( 'Center', 'su' ),
								'right' => __( 'Right', 'su' )
							),
							'default' => 'left',
							'name' => __( 'Align', 'su' ),
							'desc' => __( 'Frame alignment', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => '<img src="http://lorempixel.com/g/400/200/" />',
					'desc' => __( 'Styled image frame', 'su' ),
					'icon' => 'picture-o'
				),
				// row
				'row' => array(
					'name' => __( 'Row', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( "[%prefix_column size=\"1/3\"]Content[/%prefix_column]\n[%prefix_column size=\"1/3\"]Content[/%prefix_column]\n[%prefix_column size=\"1/3\"]Content[/%prefix_column]", 'su' ),
					'desc' => __( 'Row for flexible columns', 'su' ),
					'icon' => 'columns'
				),
				// column
				'column' => array(
					'name' => __( 'Column', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'size' => array(
							'type' => 'select',
							'values' => array(
								'1/1' => __( 'Full width', 'su' ),
								'1/2' => __( 'One half', 'su' ),
								'1/3' => __( 'One third', 'su' ),
								'2/3' => __( 'Two third', 'su' ),
								'1/4' => __( 'One fourth', 'su' ),
								'3/4' => __( 'Three fourth', 'su' ),
								'1/5' => __( 'One fifth', 'su' ),
								'2/5' => __( 'Two fifth', 'su' ),
								'3/5' => __( 'Three fifth', 'su' ),
								'4/5' => __( 'Four fifth', 'su' ),
								'1/6' => __( 'One sixth', 'su' ),
								'5/6' => __( 'Five sixth', 'su' )
							),
							'default' => '1/2',
							'name' => __( 'Size', 'su' ),
							'desc' => __( 'Select column width. This width will be calculated depend page width', 'su' )
						),
						'center' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Centered', 'su' ),
							'desc' => __( 'Is this column centered on the page', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Column content', 'su' ),
					'desc' => __( 'Flexible and responsive columns', 'su' ),
					'note' => __( 'Did you know that you need to wrap columns with [row] shortcode?', 'su' ),
					'example' => 'columns',
					'icon' => 'columns'
				),
				// list
				'list' => array(
					'name' => __( 'List', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'su' ),
							'desc' => __( 'You can upload custom icon for this list or pick a built-in icon', 'su' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Icon color', 'su' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( "<ul>\n<li>List item</li>\n<li>List item</li>\n<li>List item</li>\n</ul>", 'su' ),
					'desc' => __( 'Styled unordered list', 'su' ),
					'icon' => 'list-ol'
				),
				// button
				'button' => array(
					'name' => __( 'Button', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => get_option( 'home' ),
							'name' => __( 'Link', 'su' ),
							'desc' => __( 'Button link', 'su' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same tab', 'su' ),
								'blank' => __( 'New tab', 'su' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'su' ),
							'desc' => __( 'Button link target', 'su' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'flat' => __( 'Flat', 'su' ),
								'ghost' => __( 'Ghost', 'su' ),
								'soft' => __( 'Soft', 'su' ),
								'glass' => __( 'Glass', 'su' ),
								'bubbles' => __( 'Bubbles', 'su' ),
								'noise' => __( 'Noise', 'su' ),
								'stroked' => __( 'Stroked', 'su' ),
								'3d' => __( '3D', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ), 'desc' => __( 'Button background style preset', 'su' )
						),
						'background' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#2D89EF',
							'name' => __( 'Background', 'su' ), 'desc' => __( 'Button background color', 'su' )
						),
						'color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFFFF',
							'name' => __( 'Text color', 'su' ),
							'desc' => __( 'Button text color', 'su' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Size', 'su' ),
							'desc' => __( 'Button size', 'su' )
						),
						'wide' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Fluid', 'su' ), 'desc' => __( 'Fluid buttons has 100% width', 'su' )
						),
						'center' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Centered', 'su' ), 'desc' => __( 'Is button centered on the page', 'su' )
						),
						'radius' => array(
							'type' => 'select',
							'values' => array(
								'auto' => __( 'Auto', 'su' ),
								'round' => __( 'Round', 'su' ),
								'0' => __( 'Square', 'su' ),
								'5' => '5px',
								'10' => '10px',
								'20' => '20px'
							),
							'default' => 'auto',
							'name' => __( 'Radius', 'su' ),
							'desc' => __( 'Radius of button corners. Auto-radius calculation based on button size', 'su' )
						),
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'su' ),
							'desc' => __( 'You can upload custom icon for this button or pick a built-in icon', 'su' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#FFFFFF',
							'name' => __( 'Icon color', 'su' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'su' )
						),
						'text_shadow' => array(
							'type' => 'shadow',
							'default' => 'none',
							'name' => __( 'Text shadow', 'su' ),
							'desc' => __( 'Button text shadow', 'su' )
						),
						'desc' => array(
							'default' => '',
							'name' => __( 'Description', 'su' ),
							'desc' => __( 'Small description under button text. This option is incompatible with icon.', 'su' )
						),
						'onclick' => array(
							'default' => '',
							'name' => __( 'onClick', 'su' ),
							'desc' => __( 'Advanced JavaScript code for onClick action', 'su' )
						),
						'rel' => array(
							'default' => '',
							'name' => __( 'Rel attribute', 'su' ),
							'desc' => __( 'Here you can add value for the rel attribute.<br>Example values: <b%value>nofollow</b>, <b%value>lightbox</b>', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Button text', 'su' ),
					'desc' => __( 'Styled button', 'su' ),
					'example' => 'buttons',
					'icon' => 'heart'
				),
				// service
				'service' => array(
					'name' => __( 'Service', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'Service title', 'su' ),
							'name' => __( 'Title', 'su' ),
							'desc' => __( 'Service name', 'su' )
						),
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'su' ),
							'desc' => __( 'You can upload custom icon for this box', 'su' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Icon color', 'su' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'su' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 128,
							'step' => 2,
							'default' => 32,
							'name' => __( 'Icon size', 'su' ),
							'desc' => __( 'Size of the uploaded icon in pixels', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Service description', 'su' ),
					'desc' => __( 'Service box with title', 'su' ),
					'icon' => 'check-square-o'
				),
				// box
				'box' => array(
					'name' => __( 'Box', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'Box title', 'su' ),
							'name' => __( 'Title', 'su' ), 'desc' => __( 'Text for the box title', 'su' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'soft' => __( 'Soft', 'su' ),
								'glass' => __( 'Glass', 'su' ),
								'bubbles' => __( 'Bubbles', 'su' ),
								'noise' => __( 'Noise', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ),
							'desc' => __( 'Box style preset', 'su' )
						),
						'box_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#333333',
							'name' => __( 'Color', 'su' ),
							'desc' => __( 'Color for the box title and borders', 'su' )
						),
						'title_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFFFF',
							'name' => __( 'Title text color', 'su' ), 'desc' => __( 'Color for the box title text', 'su' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Radius', 'su' ),
							'desc' => __( 'Box corners radius', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Box content', 'su' ),
					'desc' => __( 'Colored box with caption', 'su' ),
					'icon' => 'list-alt'
				),
				// note
				'note' => array(
					'name' => __( 'Note', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'note_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFF66',
							'name' => __( 'Background', 'su' ), 'desc' => __( 'Note background color', 'su' )
						),
						'text_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#333333',
							'name' => __( 'Text color', 'su' ),
							'desc' => __( 'Note text color', 'su' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Radius', 'su' ), 'desc' => __( 'Note corners radius', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Note text', 'su' ),
					'desc' => __( 'Colored box', 'su' ),
					'icon' => 'list-alt'
				),
				// expand
				'expand' => array(
					'name' => __( 'Expand', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'more_text' => array(
							'default' => __( 'Show more', 'su' ),
							'name' => __( 'More text', 'su' ),
							'desc' => __( 'Enter the text for more link', 'su' )
						),
						'less_text' => array(
							'default' => __( 'Show less', 'su' ),
							'name' => __( 'Less text', 'su' ),
							'desc' => __( 'Enter the text for less link', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 1000,
							'step' => 10,
							'default' => 100,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Height for collapsed state (in pixels)', 'su' )
						),
						'hide_less' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Hide less link', 'su' ),
							'desc' => __( 'This option allows you to hide less link, when the text block has been expanded', 'su' )
						),
						'text_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#333333',
							'name' => __( 'Text color', 'su' ),
							'desc' => __( 'Pick the text color', 'su' )
						),
						'link_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#0088FF',
							'name' => __( 'Link color', 'su' ),
							'desc' => __( 'Pick the link color', 'su' )
						),
						'link_style' => array(
							'type' => 'select',
							'values' => array(
								'default'    => __( 'Default', 'su' ),
								'underlined' => __( 'Underlined', 'su' ),
								'dotted'     => __( 'Dotted', 'su' ),
								'dashed'     => __( 'Dashed', 'su' ),
								'button'     => __( 'Button', 'su' ),
							),
							'default' => 'default',
							'name' => __( 'Link style', 'su' ),
							'desc' => __( 'Select the style for more/less link', 'su' )
						),
						'link_align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'su' ),
								'center' => __( 'Center', 'su' ),
								'right' => __( 'Right', 'su' ),
							),
							'default' => 'left',
							'name' => __( 'Link align', 'su' ),
							'desc' => __( 'Select link alignment', 'su' )
						),
						'more_icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'More icon', 'su' ),
							'desc' => __( 'Add an icon to the more link', 'su' )
						),
						'less_icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Less icon', 'su' ),
							'desc' => __( 'Add an icon to the less link', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'This text block can be expanded', 'su' ),
					'desc' => __( 'Expandable text block', 'su' ),
					'icon' => 'sort-amount-asc'
				),
				// lightbox
				'lightbox' => array(
					'name' => __( 'Lightbox', 'su' ),
					'type' => 'wrap',
					'group' => 'gallery',
					'atts' => array(
						'type' => array(
							'type' => 'select',
							'values' => array(
								'iframe' => __( 'Iframe', 'su' ),
								'image' => __( 'Image', 'su' ),
								'inline' => __( 'Inline (html content)', 'su' )
							),
							'default' => 'iframe',
							'name' => __( 'Content type', 'su' ),
							'desc' => __( 'Select type of the lightbox window content', 'su' )
						),
						'src' => array(
							'default' => '',
							'name' => __( 'Content source', 'su' ),
							'desc' => __( 'Insert here URL or CSS selector. Use URL for Iframe and Image content types. Use CSS selector for Inline content type.<br />Example values:<br /><b%value>http://www.youtube.com/watch?v=XXXXXXXXX</b> - YouTube video (iframe)<br /><b%value>http://example.com/wp-content/uploads/image.jpg</b> - uploaded image (image)<br /><b%value>http://example.com/</b> - any web page (iframe)<br /><b%value>#contact-form</b> - any HTML content (inline)', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( '[%prefix_button] Click Here to Watch the Video [/%prefix_button]', 'su' ),
					'desc' => __( 'Lightbox window with custom content', 'su' ),
					'icon' => 'external-link'
				),
				// tooltip
				'tooltip' => array(
					'name' => __( 'Tooltip', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'light' => __( 'Basic: Light', 'su' ),
								'dark' => __( 'Basic: Dark', 'su' ),
								'yellow' => __( 'Basic: Yellow', 'su' ),
								'green' => __( 'Basic: Green', 'su' ),
								'red' => __( 'Basic: Red', 'su' ),
								'blue' => __( 'Basic: Blue', 'su' ),
								'youtube' => __( 'Youtube', 'su' ),
								'tipsy' => __( 'Tipsy', 'su' ),
								'bootstrap' => __( 'Bootstrap', 'su' ),
								'jtools' => __( 'jTools', 'su' ),
								'tipped' => __( 'Tipped', 'su' ),
								'cluetip' => __( 'Cluetip', 'su' ),
							),
							'default' => 'yellow',
							'name' => __( 'Style', 'su' ),
							'desc' => __( 'Tooltip window style', 'su' )
						),
						'position' => array(
							'type' => 'select',
							'values' => array(
								'north' => __( 'Top', 'su' ),
								'south' => __( 'Bottom', 'su' ),
								'west' => __( 'Left', 'su' ),
								'east' => __( 'Right', 'su' )
							),
							'default' => 'top',
							'name' => __( 'Position', 'su' ),
							'desc' => __( 'Tooltip position', 'su' )
						),
						'shadow' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Shadow', 'su' ),
							'desc' => __( 'Add shadow to tooltip. This option is only works with basic styes, e.g. blue, green etc.', 'su' )
						),
						'rounded' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Rounded corners', 'su' ),
							'desc' => __( 'Use rounded for tooltip. This option is only works with basic styes, e.g. blue, green etc.', 'su' )
						),
						'size' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'1' => 1,
								'2' => 2,
								'3' => 3,
								'4' => 4,
								'5' => 5,
								'6' => 6,
							),
							'default' => 'default',
							'name' => __( 'Font size', 'su' ),
							'desc' => __( 'Tooltip font size', 'su' )
						),
						'title' => array(
							'default' => '',
							'name' => __( 'Tooltip title', 'su' ),
							'desc' => __( 'Enter title for tooltip window. Leave this field empty to hide the title', 'su' )
						),
						'content' => array(
							'default' => __( 'Tooltip text', 'su' ),
							'name' => __( 'Tooltip content', 'su' ),
							'desc' => __( 'Enter tooltip content here', 'su' )
						),
						'behavior' => array(
							'type' => 'select',
							'values' => array(
								'hover' => __( 'Show and hide on mouse hover', 'su' ),
								'click' => __( 'Show and hide by mouse click', 'su' ),
								'always' => __( 'Always visible', 'su' )
							),
							'default' => 'hover',
							'name' => __( 'Behavior', 'su' ),
							'desc' => __( 'Select tooltip behavior', 'su' )
						),
						'close' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Close button', 'su' ),
							'desc' => __( 'Show close button', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( '[%prefix_button] Hover me to open tooltip [/%prefix_button]', 'su' ),
					'desc' => __( 'Tooltip window with custom content', 'su' ),
					'icon' => 'comment-o'
				),
				// private
				'private' => array(
					'name' => __( 'Private', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Private note text', 'su' ),
					'desc' => __( 'Private note for post authors', 'su' ),
					'icon' => 'lock'
				),
				// youtube
				'youtube' => array(
					'name' => __( 'YouTube', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'su' ),
							'desc' => __( 'Url of YouTube page with video. Ex: http://youtube.com/watch?v=XXXXXX', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'su' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Play video automatically when page is loaded', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'YouTube video', 'su' ),
					'example' => 'media',
					'icon' => 'youtube-play'
				),
				// youtube_advanced
				'youtube_advanced' => array(
					'name' => __( 'YouTube Advanced', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'su' ),
							'desc' => __( 'Url of YouTube page with video. Ex: http://youtube.com/watch?v=XXXXXX', 'su' )
						),
						'playlist' => array(
							'default' => '',
							'name' => __( 'Playlist', 'su' ),
							'desc' => __( 'Value is a comma-separated list of video IDs to play. If you specify a value, the first video that plays will be the VIDEO_ID specified in the URL path, and the videos specified in the playlist parameter will play thereafter', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'su' )
						),
						'controls' => array(
							'type' => 'select',
							'values' => array(
								'no' => __( '0 - Hide controls', 'su' ),
								'yes' => __( '1 - Show controls', 'su' ),
								'alt' => __( '2 - Show controls when playback is started', 'su' )
							),
							'default' => 'yes',
							'name' => __( 'Controls', 'su' ),
							'desc' => __( 'This parameter indicates whether the video player controls will display', 'su' )
						),
						'autohide' => array(
							'type' => 'select',
							'values' => array(
								'no' => __( '0 - Do not hide controls', 'su' ),
								'yes' => __( '1 - Hide all controls on mouse out', 'su' ),
								'alt' => __( '2 - Hide progress bar on mouse out', 'su' )
							),
							'default' => 'alt',
							'name' => __( 'Autohide', 'su' ),
							'desc' => __( 'This parameter indicates whether the video controls will automatically hide after a video begins playing', 'su' )
						),
						'showinfo' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show title bar', 'su' ),
							'desc' => __( 'If you set the parameter value to NO, then the player will not display information like the video title and uploader before the video starts playing.', 'su' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Play video automatically when page is loaded', 'su' )
						),
						'loop' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Loop', 'su' ),
							'desc' => __( 'Setting of YES will cause the player to play the initial video again and again', 'su' )
						),
						'rel' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Related videos', 'su' ),
							'desc' => __( 'This parameter indicates whether the player should show related videos when playback of the initial video ends', 'su' )
						),
						'fs' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show full-screen button', 'su' ),
							'desc' => __( 'Setting this parameter to NO prevents the fullscreen button from displaying', 'su' )
						),
						'modestbranding' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => 'modestbranding',
							'desc' => __( 'This parameter lets you use a YouTube player that does not show a YouTube logo. Set the parameter value to YES to prevent the YouTube logo from displaying in the control bar. Note that a small YouTube text label will still display in the upper-right corner of a paused video when the user\'s mouse pointer hovers over the player', 'su' )
						),
						'theme' => array(
							'type' => 'select',
							'values' => array(
								'dark' => __( 'Dark theme', 'su' ),
								'light' => __( 'Light theme', 'su' )
							),
							'default' => 'dark',
							'name' => __( 'Theme', 'su' ),
							'desc' => __( 'This parameter indicates whether the embedded player will display player controls (like a play button or volume control) within a dark or light control bar', 'su' )
						),
						'https' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Force HTTPS', 'su' ),
							'desc' => __( 'Use HTTPS in player iframe', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'YouTube video player with advanced settings', 'su' ),
					'example' => 'media',
					'icon' => 'youtube-play'
				),
				// vimeo
				'vimeo' => array(
					'name' => __( 'Vimeo', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'su' ), 'desc' => __( 'Url of Vimeo page with video', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'su' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Play video automatically when page is loaded', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Vimeo video', 'su' ),
					'example' => 'media',
					'icon' => 'youtube-play'
				),
				// screenr
				'screenr' => array(
					'name' => __( 'Screenr', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'default' => '',
							'name' => __( 'Url', 'su' ),
							'desc' => __( 'Url of Screenr page with video', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Screenr video', 'su' ),
					'icon' => 'youtube-play'
				),
				// dailymotion
				'dailymotion' => array(
					'name' => __( 'Dailymotion', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'default' => '',
							'name' => __( 'Url', 'su' ),
							'desc' => __( 'Url of Dailymotion page with video', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'su' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Start the playback of the video automatically after the player load. May not work on some mobile OS versions', 'su' )
						),
						'background' => array(
							'type' => 'color',
							'default' => '#FFC300',
							'name' => __( 'Background color', 'su' ),
							'desc' => __( 'HTML color of the background of controls elements', 'su' )
						),
						'foreground' => array(
							'type' => 'color',
							'default' => '#F7FFFD',
							'name' => __( 'Foreground color', 'su' ),
							'desc' => __( 'HTML color of the foreground of controls elements', 'su' )
						),
						'highlight' => array(
							'type' => 'color',
							'default' => '#171D1B',
							'name' => __( 'Highlight color', 'su' ),
							'desc' => __( 'HTML color of the controls elements\' highlights', 'su' )
						),
						'logo' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show logo', 'su' ),
							'desc' => __( 'Allows to hide or show the Dailymotion logo', 'su' )
						),
						'quality' => array(
							'type' => 'select',
							'values' => array(
								'240'  => '240',
								'380'  => '380',
								'480'  => '480',
								'720'  => '720',
								'1080' => '1080'
							),
							'default' => '380',
							'name' => __( 'Quality', 'su' ),
							'desc' => __( 'Determines the quality that must be played by default if available', 'su' )
						),
						'related' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show related videos', 'su' ),
							'desc' => __( 'Show related videos at the end of the video', 'su' )
						),
						'info' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show video info', 'su' ),
							'desc' => __( 'Show videos info (title/author) on the start screen', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Dailymotion video', 'su' ),
					'icon' => 'youtube-play'
				),
				// audio
				'audio' => array(
					'name' => __( 'Audio', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'File', 'su' ),
							'desc' => __( 'Audio file url. Supported formats: mp3, ogg', 'su' )
						),
						'width' => array(
							'values' => array(),
							'default' => '100%',
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width. You can specify width in percents and player will be responsive. Example values: <b%value>200px</b>, <b%value>100&#37;</b>', 'su' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Play file automatically when page is loaded', 'su' )
						),
						'loop' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Loop', 'su' ),
							'desc' => __( 'Repeat when playback is ended', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Custom audio player', 'su' ),
					'example' => 'media',
					'icon' => 'play-circle'
				),
				// video
				'video' => array(
					'name' => __( 'Video', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'File', 'su' ),
							'desc' => __( 'Url to mp4/flv video-file', 'su' )
						),
						'poster' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Poster', 'su' ),
							'desc' => __( 'Url to poster image, that will be shown before playback', 'su' )
						),
						'title' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Title', 'su' ),
							'desc' => __( 'Player title', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 300,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'controls' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Controls', 'su' ),
							'desc' => __( 'Show player controls (play/pause etc.) or not', 'su' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Play file automatically when page is loaded', 'su' )
						),
						'loop' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Loop', 'su' ),
							'desc' => __( 'Repeat when playback is ended', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Custom video player', 'su' ),
					'example' => 'media',
					'icon' => 'play-circle'
				),
				// table
				'table' => array(
					'name' => __( 'Table', 'su' ),
					'type' => 'mixed',
					'group' => 'content',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'CSV file', 'su' ),
							'desc' => __( 'Upload CSV file if you want to create HTML-table from file', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( "<table>\n<tr>\n\t<td>Table</td>\n\t<td>Table</td>\n</tr>\n<tr>\n\t<td>Table</td>\n\t<td>Table</td>\n</tr>\n</table>", 'su' ),
					'desc' => __( 'Styled table from HTML or CSV file', 'su' ),
					'icon' => 'table'
				),
				// permalink
				'permalink' => array(
					'name' => __( 'Permalink', 'su' ),
					'type' => 'mixed',
					'group' => 'content other',
					'atts' => array(
						'id' => array(
							'values' => array( ), 'default' => 1,
							'name' => __( 'ID', 'su' ),
							'desc' => __( 'Post or page ID', 'su' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same tab', 'su' ),
								'blank' => __( 'New tab', 'su' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'su' ),
							'desc' => __( 'Link target. blank - link will be opened in new window/tab', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => '',
					'desc' => __( 'Permalink to specified post/page', 'su' ),
					'icon' => 'link'
				),
				// members
				'members' => array(
					'name' => __( 'Members', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'message' => array(
							'default' => __( 'This content is for registered users only. Please %login%.', 'su' ),
							'name' => __( 'Message', 'su' ), 'desc' => __( 'Message for not logged users', 'su' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#ffcc00',
							'name' => __( 'Box color', 'su' ), 'desc' => __( 'This color will applied only to box for not logged users', 'su' )
						),
						'login_text' => array(
							'default' => __( 'login', 'su' ),
							'name' => __( 'Login link text', 'su' ), 'desc' => __( 'Text for the login link', 'su' )
						),
						'login_url' => array(
							'default' => wp_login_url(),
							'name' => __( 'Login link url', 'su' ), 'desc' => __( 'Login link url', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Content for logged members', 'su' ),
					'desc' => __( 'Content for logged in members only', 'su' ),
					'icon' => 'lock'
				),
				// guests
				'guests' => array(
					'name' => __( 'Guests', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Content for guests', 'su' ),
					'desc' => __( 'Content for guests only', 'su' ),
					'icon' => 'user'
				),
				// feed
				'feed' => array(
					'name' => __( 'RSS Feed', 'su' ),
					'type' => 'single',
					'group' => 'content other',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'su' ),
							'desc' => __( 'Url to RSS-feed', 'su' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Limit', 'su' ), 'desc' => __( 'Number of items to show', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Feed grabber', 'su' ),
					'icon' => 'rss'
				),
				// menu
				'menu' => array(
					'name' => __( 'Menu', 'su' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'name' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Menu name', 'su' ), 'desc' => __( 'Custom menu name. Ex: Main menu', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Custom menu by name', 'su' ),
					'icon' => 'bars'
				),
				// subpages
				'subpages' => array(
					'name' => __( 'Sub pages', 'su' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'depth' => array(
							'type' => 'select',
							'values' => array( 1, 2, 3, 4, 5 ), 'default' => 1,
							'name' => __( 'Depth', 'su' ),
							'desc' => __( 'Max depth level of children pages', 'su' )
						),
						'p' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Parent ID', 'su' ),
							'desc' => __( 'ID of the parent page. Leave blank to use current page', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'List of sub pages', 'su' ),
					'icon' => 'bars'
				),
				// siblings
				'siblings' => array(
					'name' => __( 'Siblings', 'su' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'depth' => array(
							'type' => 'select',
							'values' => array( 1, 2, 3 ), 'default' => 1,
							'name' => __( 'Depth', 'su' ),
							'desc' => __( 'Max depth level', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'List of cureent page siblings', 'su' ),
					'icon' => 'bars'
				),
				// document
				'document' => array(
					'name' => __( 'Document', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Url', 'su' ),
							'desc' => __( 'Url to uploaded document. Supported formats: doc, xls, pdf etc.', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Viewer width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Viewer height', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make viewer responsive', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Document viewer by Google', 'su' ),
					'icon' => 'file-text'
				),
				// gmap
				'gmap' => array(
					'name' => __( 'Gmap', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Map width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Map height', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make map responsive', 'su' )
						),
						'address' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Marker', 'su' ),
							'desc' => __( 'Address for the marker. You can type it in any language', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Maps by Google', 'su' ),
					'icon' => 'globe'
				),
				// slider
				'slider' => array(
					'name' => __( 'Slider', 'su' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'source' => array(
							'type'    => 'image_source',
							'default' => 'none',
							'name'    => __( 'Source', 'su' ),
							'desc'    => __( 'Choose images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'su' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Limit', 'su' ),
							'desc' => __( 'Maximum number of image source posts (for recent posts, category and custom taxonomy)', 'su' )
						),
						'link' => array(
							'type' => 'select',
							'values' => array(
								'none'       => __( 'None', 'su' ),
								'image'      => __( 'Full-size image', 'su' ),
								'lightbox'   => __( 'Lightbox', 'su' ),
								'custom'     => __( 'Slide link (added in media editor)', 'su' ),
								'attachment' => __( 'Attachment page', 'su' ),
								'post'       => __( 'Post permalink', 'su' )
							),
							'default' => 'none',
							'name' => __( 'Links', 'su' ),
							'desc' => __( 'Select which links will be used for images in this gallery', 'su' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same window', 'su' ),
								'blank' => __( 'New window', 'su' )
							),
							'default' => 'self',
							'name' => __( 'Links target', 'su' ),
							'desc' => __( 'Open links in', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ), 'desc' => __( 'Slider width (in pixels)', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 300,
							'name' => __( 'Height', 'su' ), 'desc' => __( 'Slider height (in pixels)', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make slider responsive', 'su' )
						),
						'title' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show titles', 'su' ), 'desc' => __( 'Display slide titles', 'su' )
						),
						'centered' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Center', 'su' ), 'desc' => __( 'Is slider centered on the page', 'su' )
						),
						'arrows' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Arrows', 'su' ), 'desc' => __( 'Show left and right arrows', 'su' )
						),
						'pages' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Pagination', 'su' ),
							'desc' => __( 'Show pagination', 'su' )
						),
						'mousewheel' => array(
							'type' => 'bool',
							'default' => 'yes', 'name' => __( 'Mouse wheel control', 'su' ),
							'desc' => __( 'Allow to change slides with mouse wheel', 'su' )
						),
						'autoplay' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 100000,
							'step' => 100,
							'default' => 5000,
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Choose interval between slide animations. Set to 0 to disable autoplay', 'su' )
						),
						'speed' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 20000,
							'step' => 100,
							'default' => 600,
							'name' => __( 'Speed', 'su' ), 'desc' => __( 'Specify animation speed', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Customizable image slider', 'su' ),
					'icon' => 'picture-o'
				),
				// carousel
				'carousel' => array(
					'name' => __( 'Carousel', 'su' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'source' => array(
							'type'    => 'image_source',
							'default' => 'none',
							'name'    => __( 'Source', 'su' ),
							'desc'    => __( 'Choose images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'su' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Limit', 'su' ),
							'desc' => __( 'Maximum number of image source posts (for recent posts, category and custom taxonomy)', 'su' )
						),
						'link' => array(
							'type' => 'select',
							'values' => array(
								'none'       => __( 'None', 'su' ),
								'image'      => __( 'Full-size image', 'su' ),
								'lightbox'   => __( 'Lightbox', 'su' ),
								'custom'     => __( 'Slide link (added in media editor)', 'su' ),
								'attachment' => __( 'Attachment page', 'su' ),
								'post'       => __( 'Post permalink', 'su' )
							),
							'default' => 'none',
							'name' => __( 'Links', 'su' ),
							'desc' => __( 'Select which links will be used for images in this gallery', 'su' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same window', 'su' ),
								'blank' => __( 'New window', 'su' )
							),
							'default' => 'self',
							'name' => __( 'Links target', 'su' ),
							'desc' => __( 'Open links in', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 100,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Carousel width (in pixels)', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 20,
							'max' => 1600,
							'step' => 20,
							'default' => 100,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Carousel height (in pixels)', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make carousel responsive', 'su' )
						),
						'items' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Items to show', 'su' ),
							'desc' => __( 'How much carousel items is visible', 'su' )
						),
						'scroll' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 20,
							'step' => 1, 'default' => 1,
							'name' => __( 'Scroll number', 'su' ),
							'desc' => __( 'How much items are scrolled in one transition', 'su' )
						),
						'title' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show titles', 'su' ), 'desc' => __( 'Display titles for each item', 'su' )
						),
						'centered' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Center', 'su' ), 'desc' => __( 'Is carousel centered on the page', 'su' )
						),
						'arrows' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Arrows', 'su' ), 'desc' => __( 'Show left and right arrows', 'su' )
						),
						'pages' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Pagination', 'su' ),
							'desc' => __( 'Show pagination', 'su' )
						),
						'mousewheel' => array(
							'type' => 'bool',
							'default' => 'yes', 'name' => __( 'Mouse wheel control', 'su' ),
							'desc' => __( 'Allow to rotate carousel with mouse wheel', 'su' )
						),
						'autoplay' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 100000,
							'step' => 100,
							'default' => 5000,
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Choose interval between auto animations. Set to 0 to disable autoplay', 'su' )
						),
						'speed' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 20000,
							'step' => 100,
							'default' => 600,
							'name' => __( 'Speed', 'su' ), 'desc' => __( 'Specify animation speed', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Customizable image carousel', 'su' ),
					'icon' => 'picture-o'
				),
				// custom_gallery
				'custom_gallery' => array(
					'name' => __( 'Gallery', 'su' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'source' => array(
							'type'    => 'image_source',
							'default' => 'none',
							'name'    => __( 'Source', 'su' ),
							'desc'    => __( 'Choose images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'su' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Limit', 'su' ),
							'desc' => __( 'Maximum number of image source posts (for recent posts, category and custom taxonomy)', 'su' )
						),
						'link' => array(
							'type' => 'select',
							'values' => array(
								'none'       => __( 'None', 'su' ),
								'image'      => __( 'Full-size image', 'su' ),
								'lightbox'   => __( 'Lightbox', 'su' ),
								'custom'     => __( 'Slide link (added in media editor)', 'su' ),
								'attachment' => __( 'Attachment page', 'su' ),
								'post'       => __( 'Post permalink', 'su' )
							),
							'default' => 'none',
							'name' => __( 'Links', 'su' ),
							'desc' => __( 'Select which links will be used for images in this gallery', 'su' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same window', 'su' ),
								'blank' => __( 'New window', 'su' )
							),
							'default' => 'self',
							'name' => __( 'Links target', 'su' ),
							'desc' => __( 'Open links in', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 90,
							'name' => __( 'Width', 'su' ), 'desc' => __( 'Single item width (in pixels)', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 90,
							'name' => __( 'Height', 'su' ), 'desc' => __( 'Single item height (in pixels)', 'su' )
						),
						'title' => array(
							'type' => 'select',
							'values' => array(
								'never' => __( 'Never', 'su' ),
								'hover' => __( 'On mouse over', 'su' ),
								'always' => __( 'Always', 'su' )
							),
							'default' => 'hover',
							'name' => __( 'Show titles', 'su' ),
							'desc' => __( 'Title display mode', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Customizable image gallery', 'su' ),
					'icon' => 'picture-o'
				),
				// posts
				'posts' => array(
					'name' => __( 'Posts', 'su' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'template' => array(
							'default' => 'templates/default-loop.php', 'name' => __( 'Template', 'su' ),
							'desc' => __( '<b>Do not change this field value if you do not understand description below.</b><br/>Relative path to the template file. Default templates is placed under the plugin directory (templates folder). You can copy it under your theme directory and modify as you want. You can use following default templates that already available in the plugin directory:<br/><b%value>templates/default-loop.php</b> - posts loop<br/><b%value>templates/teaser-loop.php</b> - posts loop with thumbnail and title<br/><b%value>templates/single-post.php</b> - single post template<br/><b%value>templates/list-loop.php</b> - unordered list with posts titles', 'su' )
						),
						'id' => array(
							'default' => '',
							'name' => __( 'Post ID\'s', 'su' ),
							'desc' => __( 'Enter comma separated ID\'s of the posts that you want to show', 'su' )
						),
						'posts_per_page' => array(
							'type' => 'number',
							'min' => -1,
							'max' => 10000,
							'step' => 1,
							'default' => get_option( 'posts_per_page' ),
							'name' => __( 'Posts per page', 'su' ),
							'desc' => __( 'Specify number of posts that you want to show. Enter -1 to get all posts', 'su' )
						),
						'post_type' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => Su_Tools::get_types(),
							'default' => 'post',
							'name' => __( 'Post types', 'su' ),
							'desc' => __( 'Select post types. Hold Ctrl key to select multiple post types', 'su' )
						),
						'taxonomy' => array(
							'type' => 'select',
							'values' => Su_Tools::get_taxonomies(),
							'default' => 'category',
							'name' => __( 'Taxonomy', 'su' ),
							'desc' => __( 'Select taxonomy to show posts from', 'su' )
						),
						'tax_term' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => Su_Tools::get_terms( 'category' ),
							'default' => '',
							'name' => __( 'Terms', 'su' ),
							'desc' => __( 'Select terms to show posts from', 'su' )
						),
						'tax_operator' => array(
							'type' => 'select',
							'values' => array( 'IN', 'NOT IN', 'AND' ),
							'default' => 'IN', 'name' => __( 'Taxonomy term operator', 'su' ),
							'desc' => __( 'IN - posts that have any of selected categories terms<br/>NOT IN - posts that is does not have any of selected terms<br/>AND - posts that have all selected terms', 'su' )
						),
						// 'author' => array(
						// 	'type' => 'select',
						// 	'multiple' => true,
						// 	'values' => Su_Tools::get_users(),
						// 	'default' => 'default',
						// 	'name' => __( 'Authors', 'su' ),
						// 	'desc' => __( 'Choose the authors whose posts you want to show. Enter here comma-separated list of users (IDs). Example: 1,7,18', 'su' )
						// ),
						'author' => array(
							'default' => '',
							'name' => __( 'Authors', 'su' ),
							'desc' => __( 'Enter here comma-separated list of author\'s IDs. Example: 1,7,18', 'su' )
						),
						'meta_key' => array(
							'default' => '',
							'name' => __( 'Meta key', 'su' ),
							'desc' => __( 'Enter meta key name to show posts that have this key', 'su' )
						),
						'offset' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 1, 'default' => 0,
							'name' => __( 'Offset', 'su' ),
							'desc' => __( 'Specify offset to start posts loop not from first post', 'su' )
						),
						'order' => array(
							'type' => 'select',
							'values' => array(
								'desc' => __( 'Descending', 'su' ),
								'asc' => __( 'Ascending', 'su' )
							),
							'default' => 'DESC',
							'name' => __( 'Order', 'su' ),
							'desc' => __( 'Posts order', 'su' )
						),
						'orderby' => array(
							'type' => 'select',
							'values' => array(
								'none' => __( 'None', 'su' ),
								'id' => __( 'Post ID', 'su' ),
								'author' => __( 'Post author', 'su' ),
								'title' => __( 'Post title', 'su' ),
								'name' => __( 'Post slug', 'su' ),
								'date' => __( 'Date', 'su' ), 'modified' => __( 'Last modified date', 'su' ),
								'parent' => __( 'Post parent', 'su' ),
								'rand' => __( 'Random', 'su' ), 'comment_count' => __( 'Comments number', 'su' ),
								'menu_order' => __( 'Menu order', 'su' ), 'meta_value' => __( 'Meta key values', 'su' ),
							),
							'default' => 'date',
							'name' => __( 'Order by', 'su' ),
							'desc' => __( 'Order posts by', 'su' )
						),
						'post_parent' => array(
							'default' => '',
							'name' => __( 'Post parent', 'su' ),
							'desc' => __( 'Show childrens of entered post (enter post ID)', 'su' )
						),
						'post_status' => array(
							'type' => 'select',
							'values' => array(
								'publish' => __( 'Published', 'su' ),
								'pending' => __( 'Pending', 'su' ),
								'draft' => __( 'Draft', 'su' ),
								'auto-draft' => __( 'Auto-draft', 'su' ),
								'future' => __( 'Future post', 'su' ),
								'private' => __( 'Private post', 'su' ),
								'inherit' => __( 'Inherit', 'su' ),
								'trash' => __( 'Trashed', 'su' ),
								'any' => __( 'Any', 'su' ),
							),
							'default' => 'publish',
							'name' => __( 'Post status', 'su' ),
							'desc' => __( 'Show only posts with selected status', 'su' )
						),
						'ignore_sticky_posts' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Ignore sticky', 'su' ),
							'desc' => __( 'Select Yes to ignore posts that is sticked', 'su' )
						)
					),
					'desc' => __( 'Custom posts query with customizable template', 'su' ),
					'icon' => 'th-list'
				),
				// dummy_text
				'dummy_text' => array(
					'name' => __( 'Dummy text', 'su' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'what' => array(
							'type' => 'select',
							'values' => array(
								'paras' => __( 'Paragraphs', 'su' ),
								'words' => __( 'Words', 'su' ),
								'bytes' => __( 'Bytes', 'su' ),
							),
							'default' => 'paras',
							'name' => __( 'What', 'su' ),
							'desc' => __( 'What to generate', 'su' )
						),
						'amount' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 100,
							'step' => 1,
							'default' => 1,
							'name' => __( 'Amount', 'su' ),
							'desc' => __( 'How many items (paragraphs or words) to generate. Minimum words amount is 5', 'su' )
						),
						'cache' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Cache', 'su' ),
							'desc' => __( 'Generated text will be cached. Be careful with this option. If you disable it and insert many dummy_text shortcodes the page load time will be highly increased', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Text placeholder', 'su' ),
					'icon' => 'text-height'
				),
				// dummy_image
				'dummy_image' => array(
					'name' => __( 'Dummy image', 'su' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'width' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 500,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Image width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 300,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Image height', 'su' )
						),
						'theme' => array(
							'type' => 'select',
							'values' => array(
								'any'       => __( 'Any', 'su' ),
								'abstract'  => __( 'Abstract', 'su' ),
								'animals'   => __( 'Animals', 'su' ),
								'business'  => __( 'Business', 'su' ),
								'cats'      => __( 'Cats', 'su' ),
								'city'      => __( 'City', 'su' ),
								'food'      => __( 'Food', 'su' ),
								'nightlife' => __( 'Night life', 'su' ),
								'fashion'   => __( 'Fashion', 'su' ),
								'people'    => __( 'People', 'su' ),
								'nature'    => __( 'Nature', 'su' ),
								'sports'    => __( 'Sports', 'su' ),
								'technics'  => __( 'Technics', 'su' ),
								'transport' => __( 'Transport', 'su' )
							),
							'default' => 'any',
							'name' => __( 'Theme', 'su' ),
							'desc' => __( 'Select the theme for this image', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Image placeholder with random image', 'su' ),
					'icon' => 'picture-o'
				),
				// animate
				'animate' => array(
					'name' => __( 'Animation', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'type' => array(
							'type' => 'select',
							'values' => array_combine( self::animations(), self::animations() ),
							'default' => 'bounceIn',
							'name' => __( 'Animation', 'su' ),
							'desc' => __( 'Select animation type', 'su' )
						),
						'duration' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 0.5,
							'default' => 1,
							'name' => __( 'Duration', 'su' ),
							'desc' => __( 'Animation duration (seconds)', 'su' )
						),
						'delay' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 0.5,
							'default' => 0,
							'name' => __( 'Delay', 'su' ),
							'desc' => __( 'Animation delay (seconds)', 'su' )
						),
						'inline' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Inline', 'su' ),
							'desc' => __( 'This parameter determines what HTML tag will be used for animation wrapper. Turn this option to YES and animated element will be wrapped in SPAN instead of DIV. Useful for inline animations, like buttons', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Animated content', 'su' ),
					'desc' => __( 'Wrapper for animation. Any nested element will be animated', 'su' ),
					'example' => 'animations',
					'icon' => 'bolt'
				),
				// meta
				'meta' => array(
					'name' => __( 'Meta', 'su' ),
					'type' => 'single',
					'group' => 'data',
					'atts' => array(
						'key' => array(
							'default' => '',
							'name' => __( 'Key', 'su' ),
							'desc' => __( 'Meta key name', 'su' )
						),
						'default' => array(
							'default' => '',
							'name' => __( 'Default', 'su' ),
							'desc' => __( 'This text will be shown if data is not found', 'su' )
						),
						'before' => array(
							'default' => '',
							'name' => __( 'Before', 'su' ),
							'desc' => __( 'This content will be shown before the value', 'su' )
						),
						'after' => array(
							'default' => '',
							'name' => __( 'After', 'su' ),
							'desc' => __( 'This content will be shown after the value', 'su' )
						),
						'post_id' => array(
							'default' => '',
							'name' => __( 'Post ID', 'su' ),
							'desc' => __( 'You can specify custom post ID. Leave this field empty to use an ID of the current post. Current post ID may not work in Live Preview mode', 'su' )
						),
						'filter' => array(
							'default' => '',
							'name' => __( 'Filter', 'su' ),
							'desc' => __( 'You can apply custom filter to the retrieved value. Enter here function name. Your function must accept one argument and return modified value. Example function: ', 'su' ) . "<br /><pre><code style='display:block;padding:5px'>function my_custom_filter( \$value ) {\n\treturn 'Value is: ' . \$value;\n}</code></pre>"
						)
					),
					'desc' => __( 'Post meta', 'su' ),
					'icon' => 'info-circle'
				),
				// user
				'user' => array(
					'name' => __( 'User', 'su' ),
					'type' => 'single',
					'group' => 'data',
					'atts' => array(
						'field' => array(
							'type' => 'select',
							'values' => array(
								'display_name'        => __( 'Display name', 'su' ),
								'ID'                  => __( 'ID', 'su' ),
								'user_login'          => __( 'Login', 'su' ),
								'user_nicename'       => __( 'Nice name', 'su' ),
								'user_email'          => __( 'Email', 'su' ),
								'user_url'            => __( 'URL', 'su' ),
								'user_registered'     => __( 'Registered', 'su' ),
								'user_activation_key' => __( 'Activation key', 'su' ),
								'user_status'         => __( 'Status', 'su' )
							),
							'default' => 'display_name',
							'name' => __( 'Field', 'su' ),
							'desc' => __( 'User data field name', 'su' )
						),
						'default' => array(
							'default' => '',
							'name' => __( 'Default', 'su' ),
							'desc' => __( 'This text will be shown if data is not found', 'su' )
						),
						'before' => array(
							'default' => '',
							'name' => __( 'Before', 'su' ),
							'desc' => __( 'This content will be shown before the value', 'su' )
						),
						'after' => array(
							'default' => '',
							'name' => __( 'After', 'su' ),
							'desc' => __( 'This content will be shown after the value', 'su' )
						),
						'user_id' => array(
							'default' => '',
							'name' => __( 'User ID', 'su' ),
							'desc' => __( 'You can specify custom user ID. Leave this field empty to use an ID of the current user', 'su' )
						),
						'filter' => array(
							'default' => '',
							'name' => __( 'Filter', 'su' ),
							'desc' => __( 'You can apply custom filter to the retrieved value. Enter here function name. Your function must accept one argument and return modified value. Example function: ', 'su' ) . "<br /><pre><code style='display:block;padding:5px'>function my_custom_filter( \$value ) {\n\treturn 'Value is: ' . \$value;\n}</code></pre>"
						)
					),
					'desc' => __( 'User data', 'su' ),
					'icon' => 'info-circle'
				),
				// post
				'post' => array(
					'name' => __( 'Post', 'su' ),
					'type' => 'single',
					'group' => 'data',
					'atts' => array(
						'field' => array(
							'type' => 'select',
							'values' => array(
								'ID'                    => __( 'Post ID', 'su' ),
								'post_author'           => __( 'Post author', 'su' ),
								'post_date'             => __( 'Post date', 'su' ),
								'post_date_gmt'         => __( 'Post date', 'su' ) . ' GMT',
								'post_content'          => __( 'Post content', 'su' ),
								'post_title'            => __( 'Post title', 'su' ),
								'post_excerpt'          => __( 'Post excerpt', 'su' ),
								'post_status'           => __( 'Post status', 'su' ),
								'comment_status'        => __( 'Comment status', 'su' ),
								'ping_status'           => __( 'Ping status', 'su' ),
								'post_name'             => __( 'Post name', 'su' ),
								'post_modified'         => __( 'Post modified', 'su' ),
								'post_modified_gmt'     => __( 'Post modified', 'su' ) . ' GMT',
								'post_content_filtered' => __( 'Filtered post content', 'su' ),
								'post_parent'           => __( 'Post parent', 'su' ),
								'guid'                  => __( 'GUID', 'su' ),
								'menu_order'            => __( 'Menu order', 'su' ),
								'post_type'             => __( 'Post type', 'su' ),
								'post_mime_type'        => __( 'Post mime type', 'su' ),
								'comment_count'         => __( 'Comment count', 'su' )
							),
							'default' => 'post_title',
							'name' => __( 'Field', 'su' ),
							'desc' => __( 'Post data field name', 'su' )
						),
						'default' => array(
							'default' => '',
							'name' => __( 'Default', 'su' ),
							'desc' => __( 'This text will be shown if data is not found', 'su' )
						),
						'before' => array(
							'default' => '',
							'name' => __( 'Before', 'su' ),
							'desc' => __( 'This content will be shown before the value', 'su' )
						),
						'after' => array(
							'default' => '',
							'name' => __( 'After', 'su' ),
							'desc' => __( 'This content will be shown after the value', 'su' )
						),
						'post_id' => array(
							'default' => '',
							'name' => __( 'Post ID', 'su' ),
							'desc' => __( 'You can specify custom post ID. Leave this field empty to use an ID of the current post. Current post ID may not work in Live Preview mode', 'su' )
						),
						'filter' => array(
							'default' => '',
							'name' => __( 'Filter', 'su' ),
							'desc' => __( 'You can apply custom filter to the retrieved value. Enter here function name. Your function must accept one argument and return modified value. Example function: ', 'su' ) . "<br /><pre><code style='display:block;padding:5px'>function my_custom_filter( \$value ) {\n\treturn 'Value is: ' . \$value;\n}</code></pre>"
						)
					),
					'desc' => __( 'Post data', 'su' ),
					'icon' => 'info-circle'
				),
				// post_terms
				// 'post_terms' => array(
				// 	'name' => __( 'Post terms', 'su' ),
				// 	'type' => 'single',
				// 	'group' => 'data',
				// 	'atts' => array(
				// 		'post_id' => array(
				// 			'default' => '',
				// 			'name' => __( 'Post ID', 'su' ),
				// 			'desc' => __( 'You can specify custom post ID. Leave this field empty to use an ID of the current post. Current post ID may not work in Live Preview mode', 'su' )
				// 		),
				// 		'links' => array(
				// 			'type' => 'bool',
				// 			'default' => 'yes',
				// 			'name' => __( 'Show links', 'su' ),
				// 			'desc' => __( 'Show terms names as hyperlinks', 'su' )
				// 		),
				// 		'format' => array(
				// 			'type' => 'select',
				// 			'values' => array(
				// 				'text' => __( 'Terms separated by commas', 'su' ),
				// 				'br' => __( 'Terms separated by new lines', 'su' ),
				// 				'ul' => __( 'Unordered list', 'su' ),
				// 				'ol' => __( 'Ordered list', 'su' ),
				// 			),
				// 			'default' => 'text',
				// 			'name' => __( 'Format', 'su' ),
				// 			'desc' => __( 'Choose how to output the terms', 'su' )
				// 		),
				// 	),
				// 	'desc' => __( 'Terms list', 'su' ),
				// 	'icon' => 'info-circle'
				// ),
				// template
				'template' => array(
					'name' => __( 'Template', 'su' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'name' => array(
							'default' => '',
							'name' => __( 'Template name', 'su' ),
							'desc' => sprintf( __( 'Use template file name (with optional .php extension). If you need to use templates from theme sub-folder, use relative path. Example values: %s, %s, %s', 'su' ), '<b%value>page</b>', '<b%value>page.php</b>', '<b%value>includes/page.php</b>' )
						)
					),
					'desc' => __( 'Theme template', 'su' ),
					'icon' => 'puzzle-piece'
				),
				// qrcode
				'qrcode' => array(
					'name' => __( 'QR code', 'su' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'data' => array(
							'default' => '',
							'name' => __( 'Data', 'su' ),
							'desc' => __( 'The text to store within the QR code. You can use here any text or even URL', 'su' )
						),
						'title' => array(
							'default' => '',
							'name' => __( 'Title', 'su' ),
							'desc' => __( 'Enter here short description. This text will be used in alt attribute of QR code', 'su' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1000,
							'step' => 10,
							'default' => 200,
							'name' => __( 'Size', 'su' ),
							'desc' => __( 'Image width and height (in pixels)', 'su' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 50,
							'step' => 5,
							'default' => 0,
							'name' => __( 'Margin', 'su' ),
							'desc' => __( 'Thickness of a margin (in pixels)', 'su' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'none' => __( 'None', 'su' ),
								'left' => __( 'Left', 'su' ),
								'center' => __( 'Center', 'su' ),
								'right' => __( 'Right', 'su' ),
							),
							'default' => 'none',
							'name' => __( 'Align', 'su' ),
							'desc' => __( 'Choose image alignment', 'su' )
						),
						'link' => array(
							'default' => '',
							'name' => __( 'Link', 'su' ),
							'desc' => __( 'You can make this QR code clickable. Enter here the URL', 'su' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Open link in same window/tab', 'su' ),
								'blank' => __( 'Open link in new window/tab', 'su' ),
							),
							'default' => 'blank',
							'name' => __( 'Link target', 'su' ),
							'desc' => __( 'Select link target', 'su' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#000000',
							'name' => __( 'Primary color', 'su' ),
							'desc' => __( 'Pick a primary color', 'su' )
						),
						'background' => array(
							'type' => 'color',
							'default' => '#ffffff',
							'name' => __( 'Background color', 'su' ),
							'desc' => __( 'Pick a background color', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Advanced QR code generator', 'su' ),
					'icon' => 'qrcode'
				),
				// scheduler
				'scheduler' => array(
					'name' => __( 'Scheduler', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'time' => array(
							'default' => '',
							'name' => __( 'Time', 'su' ),
							'desc' => sprintf( __( 'In this field you can specify one or more time ranges. Every day at this time the content of shortcode will be visible. %s %s %s - show content from 9:00 to 18:00 %s - show content from 9:00 to 13:00 and from 14:00 to 18:00 %s - example with minutes (content will be visible each day, 45 minutes) %s - example with seconds', 'su' ), '<br><br>', __( 'Examples (click to set)', 'su' ), '<br><b%value>9-18</b>', '<br><b%value>9-13, 14-18</b>', '<br><b%value>9:30-10:15</b>', '<br><b%value>9:00:00-17:59:59</b>' )
						),
						'days_week' => array(
							'default' => '',
							'name' => __( 'Days of the week', 'su' ),
							'desc' => sprintf( __( 'In this field you can specify one or more days of the week. Every week at these days the content of shortcode will be visible. %s 0 - Sunday %s 1 - Monday %s 2 - Tuesday %s 3 - Wednesday %s 4 - Thursday %s 5 - Friday %s 6 - Saturday %s %s %s - show content from Monday to Friday %s - show content only at Sunday %s - show content at Sunday and from Wednesday to Friday', 'su' ), '<br><br>', '<br>', '<br>', '<br>', '<br>', '<br>', '<br>', '<br><br>', __( 'Examples (click to set)', 'su' ), '<br><b%value>1-5</b>', '<br><b%value>0</b>', '<br><b%value>0, 3-5</b>' )
						),
						'days_month' => array(
							'default' => '',
							'name' => __( 'Days of the month', 'su' ),
							'desc' => sprintf( __( 'In this field you can specify one or more days of the month. Every month at these days the content of shortcode will be visible. %s %s %s - show content only at first day of month %s - show content from 1th to 5th %s - show content from 10th to 15th and from 20th to 25th', 'su' ), '<br><br>', __( 'Examples (click to set)', 'su' ), '<br><b%value>1</b>', '<br><b%value>1-5</b>', '<br><b%value>10-15, 20-25</b>' )
						),
						'months' => array(
							'default' => '',
							'name' => __( 'Months', 'su' ),
							'desc' => sprintf( __( 'In this field you can specify the month or months in which the content will be visible. %s %s %s - show content only in January %s - show content from February to June %s - show content in January, March and from May to July', 'su' ), '<br><br>', __( 'Examples (click to set)', 'su' ), '<br><b%value>1</b>', '<br><b%value>2-6</b>', '<br><b%value>1, 3, 5-7</b>' )
						),
						'years' => array(
							'default' => '',
							'name' => __( 'Years', 'su' ),
							'desc' => sprintf( __( 'In this field you can specify the year or years in which the content will be visible. %s %s %s - show content only in 2014 %s - show content from 2014 to 2016 %s - show content in 2014, 2018 and from 2020 to 2022', 'su' ), '<br><br>', __( 'Examples (click to set)', 'su' ), '<br><b%value>2014</b>', '<br><b%value>2014-2016</b>', '<br><b%value>2014, 2018, 2020-2022</b>' )
						),
						'alt' => array(
							'default' => '',
							'name' => __( 'Alternative text', 'su' ),
							'desc' => __( 'In this field you can type the text which will be shown if content is not visible at the current moment', 'su' )
						)
					),
					'content' => __( 'Scheduled content', 'su' ),
					'desc' => __( 'Allows to show the content only at the specified time period', 'su' ),
					'note' => __( 'This shortcode allows you to show content only at the specified time.', 'su' ) . '<br><br>' . __( 'Please pay special attention to the descriptions, which are located below each text field. It will save you a lot of time', 'su' ) . '<br><br>' . __( 'By default, the content of this shortcode will be visible all the time. By using fields below, you can add some limitations. For example, if you type 1-5 in the Days of the week field, content will be only shown from Monday to Friday. Using the same principles, you can limit content visibility from years to seconds.', 'su' ),
					'icon' => 'clock-o'
				),
			) );
		// Return result
		return ( is_string( $shortcode ) ) ? $shortcodes[sanitize_text_field( $shortcode )] : $shortcodes;
	}
}

class Shortcodes_Ultimate_Data extends Su_Data {
	function __construct() {
		parent::__construct();
	}
}
