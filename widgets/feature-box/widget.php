<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Nahid_Feature_Box_Widget extends \Nahid_Widget_Base {

	public function get_name() {
		return 'nahid_feature_box';
	}

	public function get_title() {
		return esc_html__( 'Feature Box', 'nahid-elementor-library' );
	}

	public function get_icon() {
		return 'eicon-info-box';
	}

	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'nahid-elementor-library' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Feature Title', 'nahid-elementor-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'This is a description for the feature box. Add some details about your awesome feature here.', 'nahid-elementor-library' ),
				'rows' => 4,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button Text', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Read More', 'nahid-elementor-library' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Button Link', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'nahid-elementor-library' ),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab - Box
		$this->start_controls_section(
			'style_box_section',
			[
				'label' => esc_html__( 'Box Style', 'nahid-elementor-library' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'box_alignment',
			[
				'label' => esc_html__( 'Alignment', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'nahid-elementor-library' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'nahid-elementor-library' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'nahid-elementor-library' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label'      => esc_html__( 'Padding', 'nahid-elementor-library' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .nahid-feature-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'box_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'nahid-elementor-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .nahid-feature-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'box_background',
				'label' => esc_html__( 'Background', 'nahid-elementor-library' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .nahid-feature-box',
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__( 'Box Shadow', 'nahid-elementor-library' ),
                'selector' => '{{WRAPPER}} .nahid-feature-box',
            ]
        );

		$this->end_controls_section();

		// Style Tab - Icon
		$this->start_controls_section(
			'style_icon_section',
			[
				'label' => esc_html__( 'Icon Style', 'nahid-elementor-library' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label' => esc_html__( 'Spacing', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab - Content
		$this->start_controls_section(
			'style_content_section',
			[
				'label' => esc_html__( 'Content Style', 'nahid-elementor-library' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'nahid-elementor-library' ),
				'selector' => '{{WRAPPER}} .nahid-feature-box .nahid-fb-title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Title Spacing', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Description Color', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => esc_html__( 'Description Typography', 'nahid-elementor-library' ),
				'selector' => '{{WRAPPER}} .nahid-feature-box .nahid-fb-desc',
			]
		);

		$this->add_responsive_control(
			'desc_spacing',
			[
				'label' => esc_html__( 'Description Spacing', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab - Button
		$this->start_controls_section(
			'style_button_section',
			[
				'label' => esc_html__( 'Button Style', 'nahid-elementor-library' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => esc_html__( 'Typography', 'nahid-elementor-library' ),
				'selector' => '{{WRAPPER}} .nahid-feature-box .nahid-fb-button',
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		// Normal State Tab
		$this->start_controls_tab(
			'button_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'nahid-elementor-library' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover State Tab
		$this->start_controls_tab(
			'button_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'nahid-elementor-library' ),
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label' => esc_html__( 'Text Color', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_margin_top',
			[
				'label' => esc_html__( 'Margin Top', 'nahid-elementor-library' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .nahid-feature-box .nahid-fb-button-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// Setup link wrapper
		if ( ! empty( $settings['button_link']['url'] ) ) {
			$this->add_link_attributes( 'button', $settings['button_link'] );
			$this->add_render_attribute( 'button', 'class', 'nahid-fb-button' );
			$this->add_render_attribute( 'button', 'class', 'elementor-button' ); // Elementor standard class
		}
		
		// Fallback button class if no link is provided but text is provided just for display
		if( empty($this->get_render_attribute_string('button')) ) {
		    $this->add_render_attribute( 'button', 'class', 'nahid-fb-button elementor-button' );
		}
		
		// Base Wrapper
		$this->add_render_attribute( 'wrapper', 'class', 'nahid-feature-box' );
        
        $this->add_render_attribute( 'title', 'class', 'nahid-fb-title' );
        $this->add_inline_editing_attributes( 'title', 'none' );

        $this->add_render_attribute( 'description', 'class', 'nahid-fb-desc' );
        $this->add_inline_editing_attributes( 'description', 'basic' );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			
			<?php if ( ! empty( $settings['icon']['value'] ) ) : ?>
				<div class="nahid-fb-icon">
					<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $settings['title'] ) ) : ?>
				<h3 <?php $this->print_render_attribute_string( 'title' ); ?>><?php echo wp_kses_post( $settings['title'] ); ?></h3>
			<?php endif; ?>

			<?php if ( ! empty( $settings['description'] ) ) : ?>
				<div <?php $this->print_render_attribute_string( 'description' ); ?>><?php echo wp_kses_post( $settings['description'] ); ?></div>
			<?php endif; ?>

			<?php if ( ! empty( $settings['button_text'] ) && ! empty( $settings['button_link']['url'] ) ) : ?>
				<div class="nahid-fb-button-wrapper">
					<a <?php $this->print_render_attribute_string( 'button' ); ?>>
						<?php echo esc_html( $settings['button_text'] ); ?>
					</a>
				</div>
			<?php endif; ?>

		</div>
		<?php
	}

	protected function content_template() {
		?>
		<#
		var iconHTML = elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden': true }, 'i' , 'object' );
		
		view.addRenderAttribute( 'wrapper', 'class', 'nahid-feature-box' );
		
		view.addRenderAttribute( 'title', 'class', 'nahid-fb-title' );
		view.addInlineEditingAttributes( 'title', 'none' );
		
		view.addRenderAttribute( 'description', 'class', 'nahid-fb-desc' );
		view.addInlineEditingAttributes( 'description', 'basic' );
		
		var buttonLink = settings.button_link ? settings.button_link.url : '';
		
		if ( buttonLink ) {
			view.addRenderAttribute( 'button', 'href', buttonLink );
		}
		view.addRenderAttribute( 'button', 'class', 'nahid-fb-button elementor-button' );
		#>
		<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
			
			<# if ( settings.icon && settings.icon.value ) { #>
				<div class="nahid-fb-icon">
					{{{ iconHTML.value }}}
				</div>
			<# } #>

			<# if ( settings.title ) { #>
				<h3 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h3>
			<# } #>

			<# if ( settings.description ) { #>
				<div {{{ view.getRenderAttributeString( 'description' ) }}}>{{{ settings.description }}}</div>
			<# } #>

			<# if ( settings.button_text && buttonLink ) { #>
				<div class="nahid-fb-button-wrapper">
					<a {{{ view.getRenderAttributeString( 'button' ) }}}>
						{{{ settings.button_text }}}
					</a>
				</div>
			<# } #>

		</div>
		<?php
	}
}
