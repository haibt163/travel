<?php
class Shortcodes_Ultimate {

	/**
	 * Constructor
	 */
	function __construct() {
		add_action( 'plugins_loaded',             array( __CLASS__, 'init' ) );
		add_action( 'init',                       array( __CLASS__, 'register' ) );
		add_action( 'init',                       array( __CLASS__, 'update' ), 20 );
		register_activation_hook( SU_PLUGIN_FILE, array( __CLASS__, 'activation' ) );
		register_activation_hook( SU_PLUGIN_FILE, array( __CLASS__, 'deactivation' ) );
	}

	/**
	 * Plugin init
	 */
	public static function init() {
		// Make plugin available for translation
		load_plugin_textdomain( 'su', false, dirname( plugin_basename( SU_PLUGIN_FILE ) ) . '/languages/' );
		// Setup admin class
		$admin = new Sunrise4( array(
				'file'       => SU_PLUGIN_FILE,
				'slug'       => 'su',
				'prefix'     => 'su_option_',
				'textdomain' => 'su'
			) );
		// Top-level menu
		$admin->add_menu( array(
				'page_title'  => __( 'Settings', 'su' ) . ' &lsaquo; ' . __( 'Shortcodes Ultimate', 'su' ),
				'menu_title'  => apply_filters( 'su/menu/shortcodes', __( 'Shortcodes', 'su' ) ),
				'capability'  => 'manage_options',
				'slug'        => 'shortcodes-ultimate',
				'icon_url'    => 'dashicons-editor-code',
				'position'    => '80.11',
				'options'     => array(
					array(
						'type' => 'opentab',
						'name' => __( 'About', 'su' )
					),
					array(
						'type'     => 'about',
						'callback' => array( 'Su_Admin_Views', 'about' )
					),
					array(
						'type'    => 'closetab',
						'actions' => false
					),
					array(
						'type' => 'opentab',
						'name' => __( 'Settings', 'su' )
					),
					array(
						'type'    => 'checkbox',
						'id'      => 'custom-formatting',
						'name'    => __( 'Custom formatting', 'su' ),
						'desc'    => __( 'Disable this option if you have some problems with other plugins or content formatting', 'su' ) . '<br /><a href="http://gndev.info/kb/custom-formatting/" target="_blank">' . __( 'Documentation article', 'su' ) . '</a>',
						'default' => 'on',
						'label'   => __( 'Enabled', 'su' )
					),
					array(
						'type'    => 'checkbox',
						'id'      => 'skip',
						'name'    => __( 'Skip default values', 'su' ),
						'desc'    => __( 'Enable this option and the generator will insert a shortcode without default attribute values that you have not changed. As a result, the generated code will be shorter.', 'su' ),
						'default' => 'on',
						'label'   => __( 'Enabled', 'su' )
					),
					array(
						'type'    => 'text',
						'id'      => 'prefix',
						'name'    => __( 'Shortcodes prefix', 'su' ),
						'desc'    => sprintf( __( 'This prefix will be added to all shortcodes by this plugin. For example, type here %s and you\'ll get shortcodes like %s and %s. Please keep in mind: this option is not affects your already inserted shortcodes and if you\'ll change this value your old shortcodes will be broken', 'su' ), '<code>su_</code>', '<code>[su_button]</code>', '<code>[su_column]</code>' ),
						'default' => 'su_'
					),
					array(
						'type'    => 'text',
						'id'      => 'skin',
						'name'    => __( 'Skin', 'su' ),
						'desc'    => __( 'Choose global skin for shortcodes', 'su' ),
						'default' => 'default'
					),
					array(
						'type' => 'closetab'
					),
					array(
						'type' => 'opentab',
						'name' => __( 'Custom CSS', 'su' )
					),
					array(
						'type'     => 'custom_css',
						'id'       => 'custom-css',
						'default'  => '',
						'callback' => array( 'Su_Admin_Views', 'custom_css' )
					),
					array(
						'type' => 'closetab'
					)
				)
			) );
		// Settings submenu
		$admin->add_submenu( array(
				'parent_slug' => 'shortcodes-ultimate',
				'page_title'  => __( 'Settings', 'su' ) . ' &lsaquo; ' . __( 'Shortcodes Ultimate', 'su' ),
				'menu_title'  => apply_filters( 'su/menu/settings', __( 'Settings', 'su' ) ),
				'capability'  => 'manage_options',
				'slug'        => 'shortcodes-ultimate',
				'options'     => array()
			) );
		// Examples submenu
		$admin->add_submenu( array(
				'parent_slug' => 'shortcodes-ultimate',
				'page_title'  => __( 'Examples', 'su' ) . ' &lsaquo; ' . __( 'Shortcodes Ultimate', 'su' ),
				'menu_title'  => apply_filters( 'su/menu/examples', __( 'Examples', 'su' ) ),
				'capability'  => 'edit_others_posts',
				'slug'        => 'shortcodes-ultimate-examples',
				'options'     => array(
					array(
						'type' => 'examples',
						'callback' => array( 'Su_Admin_Views', 'examples' )
					)
				)
			) );
		// Cheatsheet submenu
		$admin->add_submenu( array(
				'parent_slug' => 'shortcodes-ultimate',
				'page_title'  => __( 'Cheatsheet', 'su' ) . ' &lsaquo; ' . __( 'Shortcodes Ultimate', 'su' ),
				'menu_title'  => apply_filters( 'su/menu/examples', __( 'Cheatsheet', 'su' ) ),
				'capability'  => 'edit_others_posts',
				'slug'        => 'shortcodes-ultimate-cheatsheet',
				'options'     => array(
					array(
						'type' => 'cheatsheet',
						'callback' => array( 'Su_Admin_Views', 'cheatsheet' )
					)
				)
			) );
		// Add-ons submenu
		$admin->add_submenu( array(
				'parent_slug' => 'shortcodes-ultimate',
				'page_title'  => __( 'Add-ons', 'su' ) . ' &lsaquo; ' . __( 'Shortcodes Ultimate', 'su' ),
				'menu_title'  => apply_filters( 'su/menu/addons', __( 'Add-ons', 'su' ) ),
				'capability'  => 'edit_others_posts',
				'slug'        => 'shortcodes-ultimate-addons',
				'options'     => array(
					array(
						'type' => 'addons',
						'callback' => array( 'Su_Admin_Views', 'addons' )
					)
				)
			) );
		// Translate plugin meta
		__( 'Shortcodes Ultimate', 'su' );
		__( 'Vladimir Anokhin', 'su' );
		__( 'Supercharge your WordPress theme with mega pack of shortcodes', 'su' );
		// Add plugin actions links
		add_filter( 'plugin_action_links_' . plugin_basename( SU_PLUGIN_FILE ), array( __CLASS__, 'actions_links' ), -10 );
		// Add plugin meta links
		add_filter( 'plugin_row_meta', array( __CLASS__, 'meta_links' ), 10, 2 );
		// Shortcodes Ultimate is ready
		do_action( 'su/init' );
	}

	/**
	 * Plugin activation
	 */
	public static function activation() {
		self::timestamp();
		self::skins_dir();
		update_option( 'su_option_version', SU_PLUGIN_VERSION );
		do_action( 'su/activation' );
	}

	/**
	 * Plugin deactivation
	 */
	public static function deactivation() {
		do_action( 'su/deactivation' );
	}

	/**
	 * Plugin update hook
	 */
	public static function update() {
		$option = get_option( 'su_option_version' );
		if ( $option !== SU_PLUGIN_VERSION ) {
			update_option( 'su_option_version', SU_PLUGIN_VERSION );
			do_action( 'su/update' );
		}
	}

	/**
	 * Register shortcodes
	 */
	public static function register() {
		// Prepare compatibility mode prefix
		$prefix = su_cmpt();
		// Loop through shortcodes
		foreach ( ( array ) Su_Data::shortcodes() as $id => $data ) {
			if ( isset( $data['function'] ) && is_callable( $data['function'] ) ) $func = $data['function'];
			elseif ( is_callable( array( 'Su_Shortcodes', $id ) ) ) $func = array( 'Su_Shortcodes', $id );
			elseif ( is_callable( array( 'Su_Shortcodes', 'su_' . $id ) ) ) $func = array( 'Su_Shortcodes', 'su_' . $id );
			else continue;
			// Register shortcode
			add_shortcode( $prefix . $id, $func );
		}
		// Register [media] manually // 3.x
		add_shortcode( $prefix . 'media', array( 'Su_Shortcodes', 'media' ) );
	}

	/**
	 * Add timestamp
	 */
	public static function timestamp() {
		if ( !get_option( 'su_installed' ) ) update_option( 'su_installed', time() );
	}

	/**
	 * Create directory /wp-content/uploads/shortcodes-ultimate-skins/ on activation
	 */
	public static function skins_dir() {
		$upload_dir = wp_upload_dir();
		$path = trailingslashit( path_join( $upload_dir['basedir'], 'shortcodes-ultimate-skins' ) );
		if ( !file_exists( $path ) ) mkdir( $path, 0755 );
	}

	/**
	 * Add plugin actions links
	 */
	public static function actions_links( $links ) {
		$links[] = '<a href="' . admin_url( 'admin.php?page=shortcodes-ultimate-examples' ) . '">' . __( 'Examples', 'su' ) . '</a>';
		$links[] = '<a href="' . admin_url( 'admin.php?page=shortcodes-ultimate' ) . '#tab-0">' . __( 'Where to start?', 'su' ) . '</a>';
		return $links;
	}

	/**
	 * Add plugin meta links
	 */
	public static function meta_links( $links, $file ) {
		// Check plugin
		if ( $file === plugin_basename( SU_PLUGIN_FILE ) ) {
			unset( $links[2] );
			$links[] = '<a href="http://gndev.info/shortcodes-ultimate/" target="_blank">' . __( 'Project homepage', 'su' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/support/plugin/shortcodes-ultimate/" target="_blank">' . __( 'Support forum', 'su' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/extend/plugins/shortcodes-ultimate/changelog/" target="_blank">' . __( 'Changelog', 'su' ) . '</a>';
		}
		return $links;
	}
}

/**
 * Register plugin function to perform checks that plugin is installed
 */
function shortcodes_ultimate() {
	return true;
}

new Shortcodes_Ultimate;
