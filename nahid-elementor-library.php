<?php
/**
 * Plugin Name: Nahid Elementor Library
 * Description: A reusable Elementor widgets and sections library.
 * Plugin URI:  https://github.com/nahid/nahid-elementor-library
 * Version:     1.0.0
 * Author:      Nahid
 * Author URI:  https://example.com/
 * Text Domain: nahid-elementor-library
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Nahid Elementor Library Class
 */
final class Nahid_Elementor_Library {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 * @var Nahid_Elementor_Library The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return Nahid_Elementor_Library An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add Plugin actions
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );
		add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'nahid-elementor-library' ),
			'<strong>' . esc_html__( 'Nahid Elementor Library', 'nahid-elementor-library' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'nahid-elementor-library' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'nahid-elementor-library' ),
			'<strong>' . esc_html__( 'Nahid Elementor Library', 'nahid-elementor-library' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'nahid-elementor-library' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'nahid-elementor-library' ),
			'<strong>' . esc_html__( 'Nahid Elementor Library', 'nahid-elementor-library' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'nahid-elementor-library' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Register Custom Elementor Widget Category
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_elementor_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'nahid-library',
			[
				'title' => esc_html__( 'Nahid Library', 'nahid-elementor-library' ),
				'icon' => 'fa fa-folder',
			]
		);
	}

	/**
	 * Initialize Widgets
	 *
	 * Load widgets files and register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init_widgets( $widgets_manager ) {
		// Require the base widget class before loading widgets
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-widget-base.php';

		$widgets_dir = plugin_dir_path( __FILE__ ) . 'widgets/';

		if ( ! is_dir( $widgets_dir ) ) {
			return;
		}

		// Scan the widgets directory for subdirectories
		$widget_folders = glob( $widgets_dir . '*', GLOB_ONLYDIR );

		if ( ! $widget_folders ) {
			return;
		}

		foreach ( $widget_folders as $folder ) {
			$widget_file = $folder . '/widget.php';

			if ( file_exists( $widget_file ) ) {
				// Record declared classes before requiring the file
				$classes_before = get_declared_classes();
				
				require_once $widget_file;
				
				// Identify newly declared classes
				$classes_after = get_declared_classes();
				$new_classes   = array_diff( $classes_after, $classes_before );

				foreach ( $new_classes as $new_class ) {
					// Ensure the class extends our Base Widget before registering
					if ( is_subclass_of( $new_class, 'Nahid_Widget_Base' ) ) {
						$widgets_manager->register( new $new_class() );
					}
				}
			}
		}
	}

	// Removed global asset loaders in favor of dynamic base widget loaders.
}

Nahid_Elementor_Library::instance();
