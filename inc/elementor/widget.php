<?php

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class MBAI_Elementor_Widget extends Widget_Base {
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'mbai-event-move', MBAI_URL . '/assets/js/jquery.event.move.js', array(), '2.0.0' );
		wp_register_script( 'mbai-twentytwenty', MBAI_URL . '/assets/js/jquery.twentytwenty.js', array(), '2.0.0' );

		wp_register_script( 'mbai-widget', MBAI_URL . '/assets/js/before-after-frontend.js', array( 'elementor-frontend', 'mbai-event-move', 'mbai-twentytwenty' ), MBAI_VERSION, true );

		wp_register_style( 'mbai-twentytwenty', MBAI_URL . '/assets/css/twentytwenty.css' );
		wp_register_style( 'mbai-widget', MBAI_URL . '/assets/css/main.css', array( 'mbai-twentytwenty' ) );
	}

	public function get_script_depends() {
		return array( 'mbai-widget' );
	}

	public function get_style_depends() {
		return array( 'mbai-widget' );
	}

	public function get_name() {
		return 'mbai-before-after';
	}

	public function get_title() {
		return esc_html__( 'Majestic Before After Image', 'majestic-before-after-image' );
	}

	public function get_icon() {
		return 'eicon-h-align-stretch';
	}

	public function get_categories() {
		return array( 'mbai-widgets' );
	}

	protected function register_controls() {
		$this->baice_content_general_options();
		$this->baice_content_handler_options();

		$this->baice_style_labels_options();
		$this->baice_style_handler_options();
	}

	/**
	 * Content General Options.
	 */
	private function baice_content_general_options() {
		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'General', 'before-after-image-comparison-for-elementor' ),
			)
		);

		$this->add_control(
			'before_image',
			array(
				'label'   => esc_html__( 'Before Image', 'before-after-image-comparison-for-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_control(
			'after_image',
			array(
				'label'   => esc_html__( 'After Image', 'before-after-image-comparison-for-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'         => 'post_thumbnail',
				'exclude'      => array( 'custom' ),
				'default'      => 'full',
				'prefix_class' => 'post-thumbnail-size-',
			)
		);

		$this->add_control(
			'enable_overlay',
			array(
				'label'     => esc_html__( 'Enable Overlay', 'before-after-image-comparison-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'before-after-image-comparison-for-elementor' ),
				'label_off' => __( 'No', 'before-after-image-comparison-for-elementor' ),
				'default'   => 'yes',
				'separator' => 'before',
			)
		);

		// Overlay color.
		$this->add_control(
			'overlay_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Overlay Color', 'before-after-image-comparison-for-elementor' ),
				'default'   => 'rgba(0, 0, 0, 0.5)',
				'condition' => array(
					'enable_overlay' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .twentytwenty-overlay:hover' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'enable_labels',
			array(
				'label'     => esc_html__( 'Enable Labels', 'before-after-image-comparison-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'hover',
				'options'   => array(
					'hover'  => esc_html__( 'On Hover', 'before-after-image-comparison-for-elementor' ),
					'always' => esc_html__( 'Always', 'before-after-image-comparison-for-elementor' ),
					'never'  => esc_html__( 'Never', 'before-after-image-comparison-for-elementor' ),
				),
				'separator' => 'before',
				'condition' => array(
					'enable_overlay' => 'yes',
				),
			)
		);

		$this->add_control(
			'before_text',
			array(
				'label'     => esc_html__( 'Before Text', 'before-after-image-comparison-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Before', 'before-after-image-comparison-for-elementor' ),
				'condition' => array(
					'enable_overlay' => 'yes',
					'enable_labels!' => 'never',
				),
			)
		);

		$this->add_control(
			'after_text',
			array(
				'label'     => esc_html__( 'After Text', 'before-after-image-comparison-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'After', 'before-after-image-comparison-for-elementor' ),
				'condition' => array(
					'enable_overlay' => 'yes',
					'enable_labels!' => 'never',
				),
			)
		);

		$this->add_control(
			'slider_orientation',
			array(
				'label'     => esc_html__( 'Orientation', 'before-after-image-comparison-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'horizontal' => array(
						'title' => __( 'Horizontal', 'before-after-image-comparison-for-elementor' ),
						'icon'  => 'eicon-h-align-stretch',
					),
					'vertical'   => array(
						'title' => __( 'Vertical', 'before-after-image-comparison-for-elementor' ),
						'icon'  => 'eicon-v-align-stretch',
					),
				),
				'default'   => 'horizontal',
				'separator' => 'before',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Content Handler Options.
	 */
	private function baice_content_handler_options() {
		$this->start_controls_section(
			'section_handler',
			array(
				'label' => __( 'Handler', 'before-after-image-comparison-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'handler_style',
			array(
				'label'   => __( 'Handler Style', 'before-after-image-comparison-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => array(
					'1' => esc_html__( 'Style 1', 'before-after-image-comparison-for-elementor' ),
					'2' => esc_html__( 'Style 2', 'before-after-image-comparison-for-elementor' ),
					'3' => esc_html__( 'Style 3', 'before-after-image-comparison-for-elementor' ),
					'4' => esc_html__( 'Style 4', 'before-after-image-comparison-for-elementor' ),
					'5' => esc_html__( 'Style 5', 'before-after-image-comparison-for-elementor' ),
				),
			)
		);

		$this->add_control(
			'handler_offset',
			array(
				'label'   => esc_html__( 'Default Offset', 'before-after-image-comparison-for-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 0.5,
				),
				'range'   => array(
					'px' => array(
						'max'  => 1,
						'min'  => 0.1,
						'step' => 0.1,
					),
				),
			)
		);

		$this->add_control(
			'move_slider_on_hover',
			array(
				'label'     => esc_html__( 'Enable On Mouse Hover', 'before-after-image-comparison-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'before-after-image-comparison-for-elementor' ),
				'label_off' => __( 'No', 'before-after-image-comparison-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Labels.
	 */
	private function baice_style_labels_options() {
		// Tab.
		$this->start_controls_section(
			'section_labels_style',
			array(
				'label'     => esc_html__( 'Labels', 'before-after-image-comparison-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'enable_overlay' => 'yes',
					'enable_labels!' => 'never',
				),
			)
		);

		// Labels typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'labels_style_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				),
				'selector' => '{{WRAPPER}} .twentytwenty-before-label:before, {{WRAPPER}} .twentytwenty-after-label:before',
			)
		);

		// Labels color.
		$this->add_control(
			'labels_style_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'before-after-image-comparison-for-elementor' ),
				'separator' => 'before',
				'default'   => '#fff',
				'selectors' => array(
					'{{WRAPPER}} .twentytwenty-before-label:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-after-label:before' => 'color: {{VALUE}};',
				),
			)
		);

		// Labels background color.
		$this->add_control(
			'labels_style_background_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'before-after-image-comparison-for-elementor' ),
				'selectors' => array(
					'{{WRAPPER}} .twentytwenty-before-label:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-after-label:before' => 'background-color: {{VALUE}};',
				),
			)
		);

		// Labels border color.
		$this->add_control(
			'labels_style_border_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'before-after-image-comparison-for-elementor' ),
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .twentytwenty-before-label:before' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-after-label:before' => 'border-color: {{VALUE}};',
				),
			)
		);

		// Labels border width.
		$this->add_control(
			'labels_style_border_width',
			array(
				'type'       => Controls_Manager::DIMENSIONS,
				'label'      => __( 'Border Width', 'before-after-image-comparison-for-elementor' ),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .twentytwenty-before-label:before' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .twentytwenty-after-label:before' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		// Labels border radius.
		$this->add_control(
			'labels_style_border_radius',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => __( 'Border Radius', 'before-after-image-comparison-for-elementor' ),
				'default'   => array(
					'size' => 0,
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .twentytwenty-before-label:before' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .twentytwenty-after-label:before' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		// Labels button padding.
		$this->add_responsive_control(
			'labels_style_button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'before-after-image-comparison-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .twentytwenty-before-label:before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .twentytwenty-after-label:before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Handler.
	 */
	private function baice_style_handler_options() {
		// Tab.
		$this->start_controls_section(
			'section_handler_style',
			array(
				'label' => esc_html__( 'Handler', 'before-after-image-comparison-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		// Labels background color.
		$this->add_control(
			'handler_style_background_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Handler Color', 'before-after-image-comparison-for-elementor' ),
				'default'   => '#fff',
				'selectors' => array(
					'{{WRAPPER}} .twentytwenty-handle'     => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:after' => 'background: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:after' => 'background: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-left-arrow' => 'border-right-color: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-right-arrow' => 'border-left-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render( $instance = array() ) {

		// Get settings.
		$settings = $this->get_settings();

		?>
		<div class="baice-before-after-wrap">

			<div class="baice-before-after-container" data-orientation="<?php echo $settings['slider_orientation']; ?>">

				<?php $this->render_images(); ?>

				<?php // $this->render_labels(); ?>
			</div>
		</div>
		<?php
	}

	protected function render_images() {
		$settings = $this->get_settings();

		$before_image = $settings['before_image'];
		$after_image  = $settings['after_image'];

		if ( ! ( $before_image['id'] || $after_image['id'] ) ) {
			return;
		}

		$post_thumbnail_size = $settings['post_thumbnail_size'];

		echo wp_get_attachment_image( $before_image['id'], $post_thumbnail_size, '', array( 'class' => 'img-before' ) );
		echo wp_get_attachment_image( $after_image['id'], $post_thumbnail_size, '', array( 'class' => 'img-after' ) );
	}

	protected function render_labels() {
		$settings = $this->get_settings();

		$enable_labels = $settings['enable_labels'];
		$before_text   = $settings['before_text'];
		$after_text    = $settings['after_text'];

		if ( 'yes' !== $enable_labels ) {
			return;
		}

		?>
		<a class="read-more-btn" href="<?php the_permalink(); ?>"><?php echo esc_html( $before_text ); ?></a>
		<?php

	}
}
