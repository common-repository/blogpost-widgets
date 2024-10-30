<?php
/**
 * Posts Slider.
 *
 * @category   Class
 * @package    blogpostWidgets
 * @subpackage WordPress
 */

namespace blogpostWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use blogpostWidgets\Classes\Helper;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * FeaturedGrid widget class.
 *
 * @since 1.0.0
 */
class blogpost_Slider_Posts extends Widget_Base {

	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
        parent::__construct( $data, $args );
        wp_register_style( 'blogpost-posts-slider-style', plugins_url( '/assets/css/posts-slider.css', BLOGPOST_WIDGETS ), array(), '2.3.4' );
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'blogpost_posts_slider';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Slider', 'blogpost-widgets' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'blogpost-icon-slider';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'blogpost-widgets' );
	}
	
	/**
	 * Enqueue styles and scripts.
	 */
	public function get_style_depends() {
		return array( 'blogpost-posts-slider-style', 'blogpost-posts-carousel-owl-style' );
	}
    /* public function get_script_depends() {
        return array( 'blogpost-posts-carousel-js' );
    } */
	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$post_types = Helper::blogpost_get_post_types();
		$taxonomies = get_taxonomies([], 'objects');

		/**
		 * The Layout Tab
		 * 
		 */
		$this->start_controls_section(
			'section_layout',
			array(
				'label' => __( 'Layout', 'blogpost-widgets' ),
			)
        );
        $this->add_control(
			'layout',
			array(
				'label'   => __( 'Slider Layout', 'blogpost-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => __( '1', 'blogpost-widgets' ),
				'options' => ['1' => 'Vertical', '2' => 'Horizontal'],
			)
        );
        $this->add_control(
			'slider_height_1',
			[
				'label' => __( 'Slider Height', 'blogpost-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 400,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 450,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-posts-slider.layout-1 .item' => 'height: {{SIZE}}{{UNIT}};',
				],
                'condition' => [
                    'layout' => '1',
                ],
			]
		);
        $this->add_control(
			'slider_height_2',
			[
				'label' => __( 'Slider Height', 'blogpost-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 250,
						'max' => 1000,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 450,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-posts-slider.layout-2 .item' => 'height: {{SIZE}}{{UNIT}};',
				],
                'condition' => [
                    'layout' => '2',
                ],
			]
		);
        $this->add_control(
			'overlay',
			array(
				'label'   => __( 'Overlay Layout', 'blogpost-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => __( '1', 'blogpost-widgets' ),
                'options' => ['0' => 'Disabled', '1' => 'Full', '2' => 'Title Only'],
			)
        );
        $this->add_control(
			'full_grid_link',
			array(
				'label'   => __( 'Full Item Link', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'ON', 'blogpost-widgets' ),
				'label_off' => __( 'OFF', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'no',
			)
        );
        $this->add_control(
			'show_title',
			array(
				'label'   => __( 'Post Title', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			)
        );
		$this->add_control(
			'show_meta',
			array(
				'label'   => __( 'Post Meta', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
                'default' => 'no',
			)
        );
        $this->add_control(
			'show_term',
			array(
				'label'   => __( 'Post Term', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
                'default' => 'yes',
			)
		);
        $this->add_control(
			'show_excerpt',
			array(
				'label'   => __( 'Post Excerpt', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
                'default' => 'no',
			)
		);
		$this->end_controls_section();

		/**
		 * The Query Tab
		 * 
		 */
		$this->start_controls_section(
			'section_query',
			array(
				'label' => __( 'Query', 'blogpost-widgets' ),
			)
		);

		$this->add_control(
            'post_type',
            [
                'label' => __('Source', 'blogpost-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => $post_types,
                'default' => key($post_types),
            ]
		);
		foreach ($taxonomies as $taxonomy => $object) {
            if (!isset($object->object_type[0]) || !in_array($object->object_type[0], array_keys($post_types))) {
                continue;
            }

            $this->add_control(
                $taxonomy . '_ids',
                [
                    'label' => $object->label,
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'object_type' => $taxonomy,
                    'options' => wp_list_pluck(get_terms($taxonomy), 'name', 'term_id'),
                    'condition' => [
                        'post_type' => $object->object_type,
                    ],
                ]
            );
        }

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'blogpost-widgets'),
                'type' => Controls_Manager::NUMBER,
                'default' => '4',
            ]
        );

        $this->add_control(
            'offset',
            [
                'label' => __('Offset', 'blogpost-widgets'),
                'type' => Controls_Manager::NUMBER,
                'default' => '0',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'blogpost-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => Helper::blogpost_get_post_orderby_options(),
                'default' => 'date',

            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'blogpost-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending',
                ],
                'default' => 'desc',

            ]
        );
		$this->end_controls_section();
        /**
		 * The Query Tab
		 * 
		 */
		$this->start_controls_section(
			'section_slider',
			array(
				'label' => __( 'Slider', 'blogpost-widgets' ),
			)
        );
        $this->add_control(
			'carousel_direction',
			array(
				'label'   => __( 'Direction', 'blogpost-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => __( '1', 'blogpost-widgets' ),
                'options' => ['1' => 'Left', '2' => 'Right'],
			)
        );
        $this->add_control(
			'carousel_autoplay',
			array(
				'label'   => __( 'Autoplay', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'True', 'blogpost-widgets' ),
				'label_off' => __( 'False', 'blogpost-widgets' ),
				'return_value' => 'yes',
                'default' => 'yes',
			)
        );
        $this->add_control(
            'carousel_autoplay_speed',
            [
                'label' => __('Autoplay Speed (milliseconds)', 'blogpost-widgets'),
                'type' => Controls_Manager::NUMBER,
                'default' => '3000',
                'condition' => [
                    'carousel_autoplay' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'carousel_margin',
            [
                'label' => __('Margin Between Items', 'blogpost-widgets'),
                'type' => Controls_Manager::NUMBER,
                'default' => '10',
            ]
        );
        $this->add_control(
			'carousel_loop',
			array(
				'label'   => __( 'Loop', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'True', 'blogpost-widgets' ),
				'label_off' => __( 'False', 'blogpost-widgets' ),
				'return_value' => 'yes',
                'default' => 'yes',
			)
        );
        $this->add_control(
			'carousel_lazyload',
			array(
				'label'   => __( 'LazyLoad', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'True', 'blogpost-widgets' ),
				'label_off' => __( 'False', 'blogpost-widgets' ),
				'return_value' => 'yes',
                'default' => 'yes',
			)
        );
        $this->add_control(
			'carousel_arrownav',
			array(
				'label'   => __( 'Arrow Navigation', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'True', 'blogpost-widgets' ),
				'label_off' => __( 'False', 'blogpost-widgets' ),
				'return_value' => 'yes',
                'default' => 'yes',
			)
        );
        $this->add_control(
			'carousel_dotnav',
			array(
				'label'   => __( 'Dot Navigation', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'True', 'blogpost-widgets' ),
				'label_off' => __( 'False', 'blogpost-widgets' ),
				'return_value' => 'yes',
                'default' => 'yes',
			)
        );
        $this->end_controls_section();
		/**
         * Typography 
         */
        $this->start_controls_section(
            'blogpost_section_typography',
            [
                'label' => __('Typography', 'blogpost-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'blogpost_post_list_title_style',
            [
                'label' => __('Post Content', 'blogpost-widgets'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'blogpost_post_list_title_color',
            [
                'label' => __('Post Title Color', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-posts-slider .blogpost-slider .item .item-meta h3 a' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'blogpost_post_list_title_hover_color',
            [
                'label' => __('Post Title Hover Color', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f6ce2b',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-posts-slider .blogpost-slider .item .item-meta h3 a:hover' => 'color: {{VALUE}};',
                ],

            ]
        );

		$this->add_control(
            'blogpost_post_meta_color',
            [
                'label' => __('Post Meta Color', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#F0F0F0',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-slider .item .extra-meta .meta-info' => 'color: {{VALUE}};',
					'{{WRAPPER}} .blogpost-slider .item .extra-meta .meta-info a' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .blogpost-slider .item .extra-meta .meta-info i' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'blogpost_post_list_title_alignment',
            [
                'label' => __('Text Alignment', 'blogpost-widgets'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'blogpost-widgets'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'blogpost-widgets'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'blogpost-widgets'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
					'{{WRAPPER}} .blogpost-posts-slider .blogpost-slider .item .item-meta h3' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .blogpost-posts-slider .blogpost-slider .item .post-desc' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'blogpost_post_list_title_typography',
                'label' => __('Post Title', 'blogpost-widgets'),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' =>
					'{{WRAPPER}} .blogpost-posts-slider .blogpost-slider .item .item-meta h3 a',
            ]
        );
		$this->add_control(
			'title_spacing',
			[
				'label' => __( 'Spacing', 'blogpost-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-posts-slider.layout-2 .blogpost-slider .item .item-meta h3' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
                'condition' => [
                    'layout' => '2',
                ],
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'blogpost_post_list_title_typography_2',
                'label' => __('Post Excerpt', 'blogpost-widgets'),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .blogpost-posts-slider .blogpost-slider .item .post-desc',
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'blogpost_post_list_title_text_shadow',
				'label' => __( 'Text Shadow', 'blogpost-widgets' ),
				'selector' => '{{WRAPPER}} .blogpost-posts-slider .blogpost-slider .item .item-meta h3 a',
			]
		);
        $this->end_controls_section();
        
		/**
         * Post Term
         */
        $this->start_controls_section(
            'blogpost_section_post_term',
            [
                'label' => __('Post Term', 'blogpost-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
		);
		$this->add_control(
			'blogpost_post_term_icon_bg',
			[
				'label' => __( 'Term Icon Background', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .blogpost-slider .item .grid-post-term span.term-icon' => 'background-color: {{VALUE}}',
				],
				'default' => 'rgba(0, 0, 0, 1)',
			]
		);
		$this->add_control(
			'blogpost_post_term_icon_color',
			[
				'label' => __( 'Term Icon Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .blogpost-slider .item .grid-post-term span.term-icon' => 'color: {{VALUE}}',
				],
				'default' => 'rgba(255, 255, 255, 1)',
			]
		);
		$this->add_control(
			'blogpost_post_term_name_bg',
			[
				'label' => __( 'Term Name Background', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .blogpost-slider .item .grid-post-term span.term-name' => 'background-color: {{VALUE}}',
				],
				'default' => '#f6ce2b',
			]
		);
		$this->add_control(
			'blogpost_post_term_name_color',
			[
				'label' => __( 'Term Name Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .blogpost-slider .item .grid-post-term span.term-name' => 'color: {{VALUE}}',
				],
				'default' => '#000000',
			]
		);
        $this->end_controls_section();

        /**
         * Navigation
         */
        $this->start_controls_section(
            'blogpost_section_carousel_nav',
            [
                'label' => __('Navigation', 'blogpost-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'blogpost_carousel_nav_style_heading',
            [
                'label' => __('Arrow Buttons', 'blogpost-widgets'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs(
			'carousel_nav_style_tabs'
		);

		$this->start_controls_tab(
			'carousel_nav_normal_tab',
			[
				'label' => __( 'Normal', 'blogpost-widgets' ),
			]
		);

		$this->add_control(
			'carousel_nav_icon_color',
			[
				'label' => __( 'Icon Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-slider .owl-prev' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .blogpost-slider .owl-next' => 'color: {{VALUE}} !important',
				],
				'default' => '#FFFFFF',
			]
		);
        $this->add_control(
			'carousel_nav_icon_bg_color',
			[
				'label' => __( 'Background Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-slider .owl-prev' => 'background: {{VALUE}} !important',
                    '{{WRAPPER}} .blogpost-slider .owl-next' => 'background: {{VALUE}} !important',
				],
				'default' => '#000000',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'carousel_nav_hover_tab',
			[
				'label' => __( 'Hover', 'blogpost-widgets' ),
			]
		);
        $this->add_control(
			'carousel_nav_icon_color_hover',
			[
				'label' => __( 'Icon Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-slider .owl-prev:hover' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .blogpost-slider .owl-next:hover' => 'color: {{VALUE}} !important',
				],
				'default' => '#000000',
			]
		);
        $this->add_control(
			'carousel_nav_icon_bg_color_hover',
			[
				'label' => __( 'Background Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-slider .owl-prev:hover' => 'background: {{VALUE}} !important',
                    '{{WRAPPER}} .blogpost-slider .owl-next:hover' => 'background: {{VALUE}} !important',
				],
				'default' => '#f6ce2b',
			]
		);

		$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'carousel_nav_spacing',
			[
				'label' => __( 'Spacing', 'blogpost-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-posts-slider.layout-2 blogpost-slider .owl-prev' => 'top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .blogpost-posts-slider.layout-2 blogpost-slider .owl-next' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'carousel_nav_buttons_radius',
			[
				'label' => __( 'Border Radius', 'blogpost-widgets' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-posts-slider.layout-2 blogpost-slider .owl-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .blogpost-posts-slider.layout-2 blogpost-slider .owl-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
            'blogpost_carousel_dots_style_heading',
            [
                'label' => __('Dots Navigation', 'blogpost-widgets'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
			'carousel_dots_normal_color',
			[
				'label' => __( 'Dot Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-slider .owl-dot' => 'background-color: {{VALUE}}',
				],
				'default' => '#dddddd',
			]
        );
        $this->add_control(
			'carousel_dots_active_color',
			[
				'label' => __( 'Dot Active/Hover', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-slider .owl-dot:hover' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .blogpost-slider .owl-dot.active' => 'background-color: {{VALUE}} !important',
				],
				'default' => '#f6ce2b',
			]
        );
        $this->add_control(
			'carousel_dots_spacing',
			[
				'label' => __( 'Spacing', 'blogpost-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .blogpost-slider .owl-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'layout', 'none' );
		$layout = $settings['layout'];
		$args = Helper::blogpost_get_query_args($settings);
		?>
            <div class="blogpost-posts-slider-container layout-<?php echo esc_attr($layout) ?>">
                <div class="blogpost-posts-slider layout-<?php echo esc_attr($layout) ?>">
                    <div class="blogpost-slider owl-carousel">
                        <?php
                        $list_posts = new \WP_Query($args);
                        if($list_posts->have_posts()) {
                            while($list_posts->have_posts()):
                                $list_posts->the_post();
                                if(has_post_thumbnail()):
                                    if($layout == '1') {
                                        $thumb_uri = get_the_post_thumbnail_url(get_the_ID(), 'blogpost-carousel-thumb');
                                    } else {
                                        $thumb_uri = get_the_post_thumbnail_url(get_the_ID(), 'blogpost-slider-wide');
                                    }
                                    
                                else:
                                    $thumb_uri = BLOGPOST_ASSETS_PATH. 'img/thumb-carousel.png';
                                endif;
                        ?>
                            <div class="item" style="background-image: url('<?php echo esc_url($thumb_uri) ?>') ">
                                <?php
                                    if ( 'yes' === $settings['full_grid_link'] ) { ?>
                                    <a href="<?php the_permalink() ?>" class="grid-link"></a>
                                <?php } ?>
                                <?php
                                    if ( '1' === $settings['overlay'] ) { ?>
                                    <div class="overlay"></div>
                                <?php } ?>
                                <div class="item-meta <?php echo (esc_attr($settings['overlay'] === '2' ? ' meta-overlay' : '') )   ?>">
                                    <?php
                                        if ( 'yes' === $settings['show_term'] ) {
                                            Helper::blogpost_post_term_box();
                                        }
                                    ?>
                                    <?php
                                        if ( 'yes' === $settings['show_title'] ) { ?>
                                            <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
                                    <?php } ?>
                                    
                                    <div class="extra-meta">
                                        <?php
                                            if ( 'yes' === $settings['show_meta'] ) { ?>
                                            <div class="meta-info">
                                                <?php Helper::blogpost_posted_by() ?> <?php Helper::blogpost_posted_on() ?> <?php Helper::blogpost_entry_comments() ?>
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if ( 'yes' === $settings['show_excerpt'] ) { ?>
                                            <p class="post-desc"><?php echo Helper::blogpost_list_excerpt(15); ?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php
						endwhile;
						}
                            \wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
			<script>
				jQuery(document).ready(function($){
					$(".blogpost-slider").owlCarousel({
                        items: 1,
                        margin: <?php echo( esc_attr($settings['carousel_margin']) ) ?>,
                        loop: <?php echo ( esc_attr($settings['carousel_loop'] == 'yes' ? 'true' : 'false') ) ?>,
                        nav: <?php echo ( esc_attr($settings['carousel_arrownav'] == 'yes' ? 'true' : 'false') ) ?>,
                        dots: <?php echo ( esc_attr($settings['carousel_dotnav'] == 'yes' ? 'true' : 'false') ) ?>,
                        rtl: <?php echo ( esc_attr($settings['carousel_direction'] == '2' ? 'true' : 'false') ) ?>,
                        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                        lazyLoad: <?php echo ( esc_attr($settings['carousel_lazyload'] == 'yes' ? 'true' : 'false') ) ?>,
                        autoplay: <?php echo ( esc_attr($settings['carousel_autoplay'] == 'yes' ? 'true' : 'false') ) ?>,
                        autoplayTimeout: <?php echo( esc_attr($settings['carousel_autoplay_speed']) ) ?>,
                        autoplayHoverPause: true
                    });
				});
			</script>
        <?php
	}

}
