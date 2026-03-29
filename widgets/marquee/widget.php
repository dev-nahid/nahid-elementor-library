<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Nahid_Marquee_Widget extends \Nahid_Widget_Base {

	public function get_name() {
		return 'nahid_marquee';
	}

	public function get_title() {
		return esc_html__( 'Marquee (Infinite Loop)', 'nahid-elementor-library' );
	}

	public function get_icon() {
		return 'eicon-exchange';
	}

	protected function register_controls() {
		
		// 1. CONTENT TAB: Repeater Items
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Marquee Items', 'nahid-elementor-library' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'item_type',
			[
				'label' => esc_html__( 'Content Type', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'text',
				'options' => [
					'text'  => esc_html__( 'Text', 'nahid-elementor-library' ),
					'image' => esc_html__( 'Image', 'nahid-elementor-library' ),
					'video' => esc_html__( 'Video (Self Hosted .mp4)', 'nahid-elementor-library' ),
				],
			]
		);

		$repeater->add_control(
			'item_text',
			[
				'label' => esc_html__( 'Text', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Infinite Scrolling Text', 'nahid-elementor-library' ),
				'label_block' => true,
				'condition' => [
					'item_type' => 'text',
				],
			]
		);

		$repeater->add_control(
			'item_image',
			[
				'label' => esc_html__( 'Choose Image', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'item_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'item_video',
			[
				'label' => esc_html__( 'Video File (.mp4)', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_types' => [ 'video' ],
				'condition' => [
					'item_type' => 'video',
				],
			]
		);

		$this->add_control(
			'marquee_items',
			[
				'label' => esc_html__( 'Items', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'item_type' => 'text',
						'item_text' => esc_html__( 'High Performance', 'nahid-elementor-library' ),
					],
					[
						'item_type' => 'text',
						'item_text' => esc_html__( 'Zero Javascript', 'nahid-elementor-library' ),
					],
					[
						'item_type' => 'text',
						'item_text' => esc_html__( 'Smooth 60FPS', 'nahid-elementor-library' ),
					],
				],
				'title_field' => '{{{ item_type.toUpperCase() }}} ITEM',
			]
		);

		$this->end_controls_section();

		// 2. CONTENT TAB: Animation Settings
		$this->start_controls_section(
			'settings_section',
			[
				'label' => esc_html__( 'Animation Settings', 'nahid-elementor-library' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => esc_html__( 'Speed (Seconds)', 'nahid-elementor-library' ),
				'description' => esc_html__( 'Lower means faster scrolling.', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 's' ],
				'range' => [
					's' => [
						'min' => 1,
						'max' => 60,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 's',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .nahid-marquee' => '--speed: {{SIZE}}s;',
				],
			]
		);

		$this->add_control(
			'direction',
			[
				'label' => esc_html__( 'Direction', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'normal' => [
						'title' => esc_html__( 'Left', 'nahid-elementor-library' ),
						'icon' => 'eicon-h-align-left',
					],
					'reverse' => [
						'title' => esc_html__( 'Right', 'nahid-elementor-library' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'normal',
				'selectors' => [
					'{{WRAPPER}} .nahid-marquee' => '--direction: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => esc_html__( 'Pause on Hover', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'nahid-elementor-library' ),
				'label_off' => esc_html__( 'No', 'nahid-elementor-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		// 3. STYLE TAB: Container Spacing
		$this->start_controls_section(
			'style_container_section',
			[
				'label' => esc_html__( 'Container Space', 'nahid-elementor-library' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label' => esc_html__( 'Gap Between Items', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .nahid-marquee' => '--gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Container Padding', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .nahid-marquee' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => esc_html__( 'Background Color', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nahid-marquee' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// 4. STYLE TAB: Typography
		$this->start_controls_section(
			'style_text_section',
			[
				'label' => esc_html__( 'Text Design', 'nahid-elementor-library' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nahid-marquee-item.type-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .nahid-marquee-item.type-text',
			]
		);
		
		$this->add_control(
			'text_nowrap',
			[
				'label' => esc_html__( 'Prevent Short Wrapping', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'nowrap',
				'default' => 'nowrap',
				'selectors' => [
					'{{WRAPPER}} .nahid-marquee-item.type-text' => 'white-space: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// 5. STYLE TAB: Image/Video Boundaries
		$this->start_controls_section(
			'style_media_section',
			[
				'label' => esc_html__( 'Media Design (Images/Videos)', 'nahid-elementor-library' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'media_height',
			[
				'label' => esc_html__( 'Max Height', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'vh' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 600,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .nahid-marquee-item.type-image img' => 'max-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .nahid-marquee-item.type-video video' => 'max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'media_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .nahid-marquee-item.type-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .nahid-marquee-item.type-video video' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		
		$pause_on_hover = $settings['pause_on_hover'] === 'yes' ? 'yes' : 'no';
		$this->add_render_attribute( 'marquee', 'class', 'nahid-marquee' );
		$this->add_render_attribute( 'marquee', 'data-hover', $pause_on_hover );

		if ( empty( $settings['marquee_items'] ) ) {
			return; // Nothing to render
		}

		// Buffer the inner loop so we can duplicate it effortlessly
		ob_start();
		foreach ( $settings['marquee_items'] as $index => $item ) {
			$repeater_class = 'nahid-marquee-item type-' . esc_attr( $item['item_type'] ) . ' elementor-repeater-item-' . esc_attr( $item['_id'] );
			echo '<li class="' . $repeater_class . '">';

			if ( $item['item_type'] === 'text' ) {
				echo wp_kses_post( $item['item_text'] );
			} 
			elseif ( $item['item_type'] === 'image' && ! empty( $item['item_image']['url'] ) ) {
				$url = esc_url( $item['item_image']['url'] );
				// Extract alt text if using Elementor's native Control_Media fetcher
				$alt = isset( $item['item_image']['alt'] ) ? esc_attr( $item['item_image']['alt'] ) : esc_attr( $item['item_image']['title'] ?? '' );
				echo '<img src="' . $url . '" alt="' . $alt . '">';
			} 
			elseif ( $item['item_type'] === 'video' && ! empty( $item['item_video']['url'] ) ) {
				echo '<video src="' . esc_url( $item['item_video']['url'] ) . '" autoplay muted loop playsinline></video>';
			}

			echo '</li>';
		}
		$items_html = ob_get_clean();
		?>
		<div <?php $this->print_render_attribute_string( 'marquee' ); ?>>
			<ul class="nahid-marquee-content">
				<?php echo $items_html; // phpcs:ignore ?>
			</ul>
			<!-- Secondary cloned track for flawless looping boundary match -->
			<ul class="nahid-marquee-content" aria-hidden="true">
				<?php echo $items_html; // phpcs:ignore ?>
			</ul>
		</div>
		<?php
	}
}
