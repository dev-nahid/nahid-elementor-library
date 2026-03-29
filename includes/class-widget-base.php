<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Base Widget Class
 *
 * All custom widgets in the Nahid Elementor Library should extend this class.
 */
abstract class Nahid_Widget_Base extends \Elementor\Widget_Base {

	/**
	 * Get widget categories.
	 *
	 * By default, all widgets using this base class will be added to the 'nahid-library' category.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'nahid-library' ];
	}

	/**
	 * Get default widget icon.
	 *
	 * Provides a fallback icon if a child widget does not define one.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-plug';
	}

	/**
	 * Autoload CSS
	 *
	 * Dynamically checks if a CSS file matching the widget's name exists in /assets/css/
	 * and registers/enqueues it automatically ONLY if the widget is used on the page.
	 */
	public function get_style_depends() {
		$widget_name = $this->get_name();
		$css_handle  = 'nahid-' . $widget_name . '-style';
		$css_file    = 'assets/css/' . $widget_name . '.css';
		$file_path   = plugin_dir_path( dirname( __FILE__ ) ) . $css_file;
		
		if ( file_exists( $file_path ) ) {
			wp_register_style( $css_handle, plugins_url( $css_file, dirname( __FILE__ ) ), [], filemtime( $file_path ) );
			return [ $css_handle ];
		}
		
		return [];
	}

	/**
	 * Autoload JS
	 *
	 * Dynamically checks if a JS file matching the widget's name exists in /assets/js/
	 * and registers/enqueues it automatically ONLY if the widget is used on the page.
	 */
	public function get_script_depends() {
		$widget_name = $this->get_name();
		$js_handle   = 'nahid-' . $widget_name . '-script';
		$js_file     = 'assets/js/' . $widget_name . '.js';
		$file_path   = plugin_dir_path( dirname( __FILE__ ) ) . $js_file;
		
		if ( file_exists( $file_path ) ) {
			wp_register_script( $js_handle, plugins_url( $js_file, dirname( __FILE__ ) ), [ 'jquery' ], filemtime( $file_path ), true );
			return [ $js_handle ];
		}
		
		return [];
	}
}
