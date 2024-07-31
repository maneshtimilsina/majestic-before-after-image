<?php
/**
 * Widget
 *
 * @package MBAI
 */

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

/**
 * MBAI Elementor widget class.
 *
 * @since 1.0.0
 */
class MBAI_Elementor_Widget extends Widget_Base {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		wp_register_style( 'mbai-twentytwenty', MBAI_URL . '/third-party/twentytwenty/css/twentytwenty.css', array(), MBAI_VERSION );
		wp_register_style( 'mbai-widget', MBAI_URL . '/assets/css/mbai-elementor.css', array( 'mbai-twentytwenty' ), MBAI_VERSION );

		wp_register_script( 'mbai-event-move', MBAI_URL . '/third-party/event-move/event.move.js', array(), MBAI_VERSION, false );
		wp_register_script( 'mbai-twentytwenty', MBAI_URL . '/third-party/twentytwenty/js/twentytwenty.js', array(), MBAI_VERSION, false );

		wp_register_script( 'mbai-widget', MBAI_URL . '/assets/js/mbai-elementor.js', array( 'elementor-frontend', 'mbai-event-move', 'mbai-twentytwenty' ), MBAI_VERSION, true );
	}

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'mbai-before-after-image';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Majestic Before After Image', 'majestic-before-after-image' );
	}

	/**
	 * Get script handles on which widget depends.
	 *
	 * @since 1.0.0
	 *
	 * @return array Script handles.
	 */
	public function get_script_depends() {
		return array( 'mbai-widget' );
	}

	/**
	 * Get style handles on which widget depends.
	 *
	 * @since 1.0.0
	 *
	 * @return array Style handles.
	 */
	public function get_style_depends() {
		return array( 'mbai-widget' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-h-align-stretch';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'mbai-widgets' );
	}

	/**
	 * Get widget keywords.
	 *
	 * @since 1.0.0
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'image', 'before', 'after', 'comparison' );
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 */
	protected function register_controls() {
		$this->content_general_options();
		$this->content_handle_options();

		$this->style_labels_options();
		$this->style_handle_options();
		$this->style_handle_text_options();
	}

	/**
	 * Content General Options.
	 */
	private function content_general_options() {
		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'General', 'majestic-before-after-image' ),
			)
		);

		$this->add_control(
			'before_image',
			array(
				'label'   => esc_html__( 'Before Image', 'majestic-before-after-image' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_control(
			'after_image',
			array(
				'label'   => esc_html__( 'After Image', 'majestic-before-after-image' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
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
				'label'     => esc_html__( 'Enable Overlay', 'majestic-before-after-image' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'majestic-before-after-image' ),
				'label_off' => esc_html__( 'No', 'majestic-before-after-image' ),
				'default'   => 'no',
				'separator' => 'before',
			)
		);

		// Overlay color.
		$this->add_control(
			'overlay_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Overlay Color', 'majestic-before-after-image' ),
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
				'label'     => esc_html__( 'Enable Labels', 'majestic-before-after-image' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'hover',
				'options'   => array(
					'hover'  => esc_html__( 'On Hover', 'majestic-before-after-image' ),
					'always' => esc_html__( 'Always', 'majestic-before-after-image' ),
					'never'  => esc_html__( 'Never', 'majestic-before-after-image' ),
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'before_label',
			array(
				'label'     => esc_html__( 'Before Text', 'majestic-before-after-image' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Before', 'majestic-before-after-image' ),
				'condition' => array(
					'enable_labels!' => 'never',
				),
			)
		);

		$this->add_control(
			'after_label',
			array(
				'label'     => esc_html__( 'After Text', 'majestic-before-after-image' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'After', 'majestic-before-after-image' ),
				'condition' => array(
					'enable_labels!' => 'never',
				),
			)
		);

		$this->add_control(
			'slider_orientation',
			array(
				'label'     => esc_html__( 'Orientation', 'majestic-before-after-image' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'horizontal' => array(
						'title' => esc_html__( 'Horizontal', 'majestic-before-after-image' ),
						'icon'  => 'eicon-h-align-stretch',
					),
					'vertical'   => array(
						'title' => esc_html__( 'Vertical', 'majestic-before-after-image' ),
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
	 * Content Handle Options.
	 */
	private function content_handle_options() {
		$this->start_controls_section(
			'section_handle',
			array(
				'label' => esc_html__( 'Handle', 'majestic-before-after-image' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'handle_type',
			array(
				'label'   => esc_html__( 'Handle Type', 'majestic-before-after-image' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => array(
					'arrows' => esc_html__( 'Arrows', 'majestic-before-after-image' ),
					'text'   => esc_html__( 'Text', 'majestic-before-after-image' ),
				),
			)
		);

		$this->add_control(
			'handle_label',
			array(
				'label'     => esc_html__( 'Handle Text', 'majestic-before-after-image' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'DRAG', 'majestic-before-after-image' ),
				'condition' => array(
					'handle_type' => 'text',
				),
			)
		);

		// Handle text circle size.
		$this->add_control(
			'handle_text_style_size',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Circle Size', 'majestic-before-after-image' ),
				'default'   => array(
					'size' => 50,
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .handle-type-text .twentytwenty-handle' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; margin-left: calc(-{{SIZE}}{{UNIT}} / 2 - 3px); margin-top: calc(-{{SIZE}}{{UNIT}} / 2 - 3px)',
					'{{WRAPPER}} .handle-type-text .twentytwenty-handle-text' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .handle-type-text .twentytwenty-horizontal .twentytwenty-handle:before' => 'margin-bottom: calc({{SIZE}}{{UNIT}} / 2 + 3px);',
					'{{WRAPPER}} .handle-type-text .twentytwenty-horizontal .twentytwenty-handle:after' => 'margin-top: calc({{SIZE}}{{UNIT}} / 2 + 3px);',
					'{{WRAPPER}} .handle-type-text .twentytwenty-vertical .twentytwenty-handle:before' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2 + 3px);',
					'{{WRAPPER}} .handle-type-text .twentytwenty-vertical .twentytwenty-handle:after' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2 + 3px);',
				),
				'condition' => array(
					'handle_type' => 'text',
				),
			)
		);

		$this->add_control(
			'handle_style',
			array(
				'label'     => esc_html__( 'Handle Style', 'majestic-before-after-image' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => array(
					'1' => esc_html__( 'Style 1', 'majestic-before-after-image' ),
					'2' => esc_html__( 'Style 2', 'majestic-before-after-image' ),
					'3' => esc_html__( 'Style 3', 'majestic-before-after-image' ),
					'4' => esc_html__( 'Style 4', 'majestic-before-after-image' ),
					'5' => esc_html__( 'Style 5', 'majestic-before-after-image' ),
					'6' => esc_html__( 'Style 6', 'majestic-before-after-image' ),
				),
				'condition' => array(
					'handle_type' => 'arrows',
				),
			)
		);

		$this->add_control(
			'handle_offset',
			array(
				'label'     => esc_html__( 'Default Offset', 'majestic-before-after-image' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'default'   => array(
					'size' => 0.5,
				),
				'range'     => array(
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
				'label'       => esc_html__( 'Enable On Mouse Hover', 'majestic-before-after-image' ),
				'description' => esc_html__( 'If enabled, handle will move on mouse hover instead of dragging.', 'majestic-before-after-image' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Yes', 'majestic-before-after-image' ),
				'label_off'   => esc_html__( 'No', 'majestic-before-after-image' ),
				'default'     => 'no',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Labels.
	 */
	private function style_labels_options() {
		// Tab.
		$this->start_controls_section(
			'section_labels_style',
			array(
				'label'     => esc_html__( 'Labels', 'majestic-before-after-image' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
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
				'label'     => esc_html__( 'Color', 'majestic-before-after-image' ),
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
				'label'     => esc_html__( 'Background Color', 'majestic-before-after-image' ),
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
				'label'     => esc_html__( 'Border Color', 'majestic-before-after-image' ),
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
				'label'      => esc_html__( 'Border Width', 'majestic-before-after-image' ),
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
				'label'     => esc_html__( 'Border Radius', 'majestic-before-after-image' ),
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
				'label'      => esc_html__( 'Padding', 'majestic-before-after-image' ),
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
	 * Add handle text style options.
	 *
	 * @since 1.0.0
	 */
	private function style_handle_text_options() {
		// Tab.
		$this->start_controls_section(
			'section_handle_text_style',
			array(
				'label'     => esc_html__( 'Handle Text', 'majestic-before-after-image' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'handle_type' => 'text',
				),
			)
		);

		// Handle text typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'handle_text_style_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				),
				'selector' => '{{WRAPPER}} .twentytwenty-handle-text',
			)
		);

		// Handle text color.
		$this->add_control(
			'handle_text_style_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'majestic-before-after-image' ),
				'separator' => 'before',
				'default'   => '#000',
				'selectors' => array(
					'{{WRAPPER}} .twentytwenty-handle-text' => 'color: {{VALUE}};',
				),
			)
		);

		// Handle text background color.
		$this->add_control(
			'handle_text_style_background_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'majestic-before-after-image' ),
				'selectors' => array(
					'{{WRAPPER}} .twentytwenty-handle-text' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Handle.
	 */
	private function style_handle_options() {
		// Tab.
		$this->start_controls_section(
			'section_handle_style',
			array(
				'label' => esc_html__( 'Handle', 'majestic-before-after-image' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		// Labels background color.
		$this->add_control(
			'handle_style_background_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Handle Color', 'majestic-before-after-image' ),
				'default'   => '#fff',
				'selectors' => array(
					'{{WRAPPER}} .twentytwenty-handle' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:after' => 'background: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:after' => 'background: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-handle .twentytwenty-left-arrow' => 'border-right-color: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-handle .twentytwenty-right-arrow' => 'border-left-color: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-handle .twentytwenty-down-arrow' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-handle .twentytwenty-up-arrow' => 'border-bottom-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Widget instance.
	 */
	protected function render( $instance = array() ) {
		$settings = $this->get_settings();

		$data = array(
			'orientation'          => $settings['slider_orientation'],
			'labels_status'        => $settings['enable_labels'],
			'before_label'         => $settings['before_label'],
			'after_label'          => $settings['after_label'],
			'handle_type'          => $settings['handle_type'],
			'handle_label'         => $settings['handle_label'],
			'handle_offset'        => $settings['handle_offset']['size'],
			'overlay_status'       => ( 'yes' === $settings['enable_overlay'] ) ? true : false,
			'move_slider_on_hover' => ( 'yes' === $settings['move_slider_on_hover'] ) ? true : false,
		);
		?>
		<div class="mbai-before-after-wrap handle-type-<?php echo esc_attr( $settings['handle_type'] ); ?> handle-style-<?php echo absint( $settings['handle_style'] ); ?>" data-mbai='<?php echo wp_json_encode( $data ); ?>'>

			<div class="mbai-before-after-container">

				<?php $this->render_images(); ?>

			</div><!-- .mbai-before-after-container -->

		</div><!-- .mbai-before-after-wrap -->
		<?php
	}

	/**
	 * Render before after images.
	 *
	 * @since 1.0.0
	 */
	protected function render_images() {
		$settings = $this->get_settings();

		$before_image = $settings['before_image'];
		$after_image  = $settings['after_image'];

		$post_thumbnail_size = $settings['post_thumbnail_size'];

		// Before image.
		if ( absint( $before_image['id'] ) > 0 ) {
			echo wp_get_attachment_image( $before_image['id'], $post_thumbnail_size, '', array( 'class' => 'img-before' ) );
		} elseif ( ! empty( $before_image['url'] ) ) {
			echo '<img src="' . esc_url( $before_image['url'] ) . '" class="img-before">';
		}

		// After image.
		if ( absint( $after_image['id'] ) > 0 ) {
			echo wp_get_attachment_image( $after_image['id'], $post_thumbnail_size, '', array( 'class' => 'img-after' ) );
		} elseif ( ! empty( $after_image['url'] ) ) {
			echo '<img src="' . esc_url( $after_image['url'] ) . '" class="img-after">';
		}
	}
}
