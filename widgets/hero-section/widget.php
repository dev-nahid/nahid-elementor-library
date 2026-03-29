<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Nahid_Hero_Section_Widget extends \Nahid_Widget_Base {

	public function get_name() {
		return 'nahid_hero_section';
	}

	public function get_title() {
		return esc_html__( 'Hero Section', 'nahid-elementor-library' );
	}

	public function get_icon() {
		return 'eicon-image-rollover';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'nahid-elementor-library' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'headline',
			[
				'label' => esc_html__( 'Headline', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Hero Headline', 'nahid-elementor-library' ),
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo '<div class="nahid-hero-section"><h1>' . esc_html( $settings['headline'] ) . '</h1></div>';
	}
}
