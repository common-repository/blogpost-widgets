<?php
/**
 * Author Box.
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
 * Author Box widget class.
 *
 * @since 1.0.0
 */
class blogpost_Author_Box extends Widget_Base {

	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		wp_register_style( 'blogpost-author-box', plugins_url( '/assets/css/author-box.css', BLOGPOST_WIDGETS ), array(), '1.0.0' );

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
		return 'blogpost_author_box';
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
		return __( 'Author Box', 'blogpost-widgets' );
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
		return 'blogpost-icon-author-box';
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
	 * Enqueue styles.
	 */
	public function get_style_depends() {
		return array( 'blogpost-author-box' );
	}

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
				'label'   => __( 'Layout', 'blogpost-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => __( '1', 'blogpost-widgets' ),
				'options' => ['1' => 'Layout 1', '2' => 'Layout 2'],
			)
        );
		$this->add_control(
			'default_shadow',
			array(
				'label'   => __( 'Box Shadow', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'blogpost-widgets' ),
				'label_off' => __( 'No', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->add_control(
			'show_avatar',
			array(
				'label'   => __( 'Author Picture', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->add_control(
			'show_title',
			array(
				'label'   => __( 'Author Title', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->add_control(
			'show_bio',
			array(
				'label'   => __( 'Author Bio', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->add_control(
			'show_social',
			array(
				'label'   => __( 'Social Links', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->add_control(
			'show_articles',
			array(
				'label'   => __( 'Recent Artices', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->add_control(
			'author_id',
			[
				'label' => __( 'Author ID', 'blogpost-widgets' ),
				'description' => __( 'Required to fetch posts of a specific author', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 1,
				'condition' => [
					'show_articles' => 'yes'
				]
			]
		);
		$this->add_control(
			'author_posts_limit',
			[
				'label' => __( 'Number of Posts', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'step' => 1,
				'default' => 5,
				'condition' => [
					'show_articles' => 'yes'
				]
			]
		);
		$this->end_controls_section();
		/**
		 * The Content
		 * 
		 */
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Content', 'blogpost-widgets' ),
			)
        );
		$this->add_control(
			'author_name',
			[
				'label' => __( 'Author Name', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'John Doe.', 'blogpost-widgets' ),
				'placeholder' => __( 'Your Name Here', 'blogpost-widgets' ),
			]
		);
		$this->add_control(
			'author_title',
			[
				'label' => __( 'Job Title', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Founder & CEO', 'blogpost-widgets' ),
				'placeholder' => __( 'Job Title Here', 'blogpost-widgets' ),
				'condition' => [
					'show_title' => 'yes',
				]
			]
		);
		$this->add_control(
			'author_business',
			[
				'label' => __( 'Business/Company Name', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Company', 'blogpost-widgets' ),
				'placeholder' => __( 'Business Name Here', 'blogpost-widgets' ),
				'condition' => [
					'show_title' => 'yes',
				]
			]
		);
		$this->add_control(
			'author_business_url',
			[
				'label' => __( 'Business URL', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-url.com', 'blogpost-widgets' ),
				'show_external' => true,
				'default' => [
					'url' => 'https://your-url.com',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => [
					'show_title' => 'yes',
				]
			]
		);
		$this->add_control(
			'author_bio',
			[
				'label' => __( 'Description (Bio)', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies tellus eget neque congue, id accumsan lectus tincidunt. Maecenas fermentum lobortis nibh at mollis. Pellentesque eget mollis sapien. Phasellus consequat quis neque a pulvinar.', 'blogpost-widgets' ),
				'placeholder' => __( 'Enter author details/bio  here.', 'blogpost-widgets' ),
				'condition' => [
					'show_bio' => 'yes',
				]
			]
		);
		$this->add_control(
			'avatar',
			[
				'label' => __( 'Profile Picture', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'show_avatar' => 'yes',
				],
				'default' => [
					'url' => BLOGPOST_ASSETS_PATH.'img/avatar.png',
				]
			]
		);
		$this->end_controls_section();
		/**
		 * Social Icons Repeater
		 */
		$this->start_controls_section(
			'section_social_links',
			array(
				'label' => __( 'Social Links', 'blogpost-widgets' ),
				'condition' => [
					'show_social' => 'yes',
				]
			)
		);
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'social_link', [
				'label' => __( 'URL', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'blogpost-widgets' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$repeater->add_control(
			'selected_icon',
			[
				'label' => __( 'Icon', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-twitter',
					'library' => 'solid',
				],
			]
		);
		$this->add_control(
			'social_links_list',
			[
				'label' => __( 'Repeater List', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'social_link' => [
                            'url' => 'https://twitter.com',
                            'is_external' => true,
                            'nofollow' => true,
                        ],
						'selected_icon' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
					],
					[
						'social_link' => [
                            'url' => 'https://facebook.com',
                            'is_external' => true,
                            'nofollow' => true,
                        ],
						'selected_icon' => [
							'value' => 'fab fa-facebook',
							'library' => 'fa-brands',
						],
					],
					[
						'social_link' => [
                            'url' => 'https://instagram.com',
                            'is_external' => true,
                            'nofollow' => true,
                        ],
						'selected_icon' => [
							'value' => 'fab fa-instagram',
							'library' => 'fa-brands',
						],
					],
				],
			]
		);
		$this->end_controls_section();
		/**
         * Box Styling 
         */
        $this->start_controls_section(
            'blogpost_section_box_style',
            [
                'label' => __('Box Style', 'blogpost-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'author-box-padding',
            [
                'label' => __('Author Box Padding', 'blogpost-widgets'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .blogpost-author-box ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '50',
					'right' => '30',
					'bottom' => '50',
					'left' => '30',
					'isLinked' => true,
				]
            ]
		);
		$this->add_control(
            'box_background',
            [
                'label' => __('Background Color', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-author-box' => 'background-color: {{VALUE}};',
                ],

            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'author_box_shadow',
				'label' => __( 'Box Shadow', 'blogpost-widgets' ),
				'selector' => '{{WRAPPER}} .blogpost-author-box',
				'condition' => [
					'default_shadow' => 'yes',
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'author_box_border',
				'label' => __( 'Border', 'blogpost-widgets' ),
				'selector' => '{{WRAPPER}} .blogpost-author-box',
			]
		);
		$this->add_responsive_control(
            'author_box_border_radius',
            [
                'label' => __('Border Radius', 'blogpost-widgets'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .blogpost-author-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'isLinked' => true,
				],
            ]
		);
		$this->end_controls_section();

		/**
         * Typography
         */
        $this->start_controls_section(
            'blogpost_section_box_typography',
            [
                'label' => __('Typography', 'blogpost-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'blogpost_authorbox_name',
                'label' => __('Author Name', 'blogpost-widgets'),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .cb-author-name h3',
				'fields_options' => [
					'typography' => ['default' => 'yes'],
					'font_size' => ['default' => ['size' => 32, 'unit' => 'px']],
				],
				'condition' => [
					'layout' => '1',
				]
            ]
        );
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'blogpost_authorbox_name_2',
                'label' => __('Author Name', 'blogpost-widgets'),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .cb-author-name h3',
				'fields_options' => [
					'typography' => ['default' => 'yes'],
					'font_size' => ['default' => ['size' => 48, 'unit' => 'px']],
				],
				'condition' => [
					'layout' => '2',
				]
            ]
        );
		$this->add_control(
            'blogpost_authorbox_name_color',
            [
                'label' => __('Color', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .cb-author-name h3' => 'color: {{VALUE}};',
                ],

            ]
        );
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'blogpost_authorbox_title',
                'label' => __('Author Title', 'blogpost-widgets'),
                'scheme' => Typography::TYPOGRAPHY_3,
                'selectors' => [
					'{{WRAPPER}} .cb-author-title',
					'{{WRAPPER}} .cb-author-title a',
				],
				'fields_options' => [
					'typography' => ['default' => 'yes'],
					'font_size' => ['default' => ['size' => 16]],
				],

            ]
        );
		$this->add_control(
            'blogpost_authorbox_title_color',
            [
                'label' => __('Text Color', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .cb-author-title' => 'color: {{VALUE}};',
                ],

            ]
        );
		$this->add_control(
            'blogpost_authorbox_title_link_color',
            [
                'label' => __('Link Color', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f6ce2b',
                'selectors' => [
                    '{{WRAPPER}} .cb-author-title a' => 'color: {{VALUE}};',
                ],

            ]
        );
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'blogpost_authorbox_bio',
                'label' => __('Author Bio', 'blogpost-widgets'),
                'scheme' => Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .cb-author-bio p',
				'fields_options' => [
					'typography' => ['default' => 'yes'],
					'font_size' => ['default' => ['size' => 13]],
				],

            ]
        );
		$this->add_control(
            'blogpost_authorbox_bio_color',
            [
                'label' => __('Color', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .cb-author-bio p' => 'color: {{VALUE}};',
                ],

            ]
        );
		$this->end_controls_section();

		/**
         * Avatar
         */
        $this->start_controls_section(
            'blogpost_section_box_avatar',
            [
                'label' => __('Avatar', 'blogpost-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'show_avatar_border',
			array(
				'label'   => __( 'Avatar Border', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'avatar_border',
				'label' => __( 'Border', 'blogpost-widgets' ),
				'selector' => '{{WRAPPER}} .blogpost-author-box .cb-avatar img',
				'fields_options' => [
					'border' => ['default' => 'solid'],
					'color' => ['default' => '#f0f0f0'],
				],
				'condition' => [
					'show_avatar_border' => 'yes',
				]
			]
		);
		$this->add_control(
			'avatar_border_hover',
			[
				'label' => __( 'Hover Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .blogpost-author-box:hover .cb-avatar img' => 'border-color: {{VALUE}}',
				],
				'default' => '#f6ce2b',
				'condition' => [
					'show_avatar_border' => 'yes',
				]
			]
		);
		$this->add_responsive_control(
            'avatar_border_radius',
            [
                'label' => __('Border Radius', 'blogpost-widgets'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .cb-avatar img ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '50%',
					'right' => '50%',
					'bottom' => '50%',
					'left' => '50%',
					'isLinked' => true,
				],
            ]
		);
		$this->add_responsive_control(
            'avatar_margin',
            [
                'label' => __('Margin', 'blogpost-widgets'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .cb-avatar ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '0px',
					'right' => '0px',
					'bottom' => '15px',
					'left' => '0px',
					'isLinked' => true,
				],
            ]
		);
		$this->end_controls_section();

		/**
         * Social Icons
         */
		$this->start_controls_section(
            'blogpost_section_box_social',
            [
                'label' => __('Social Icons', 'blogpost-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'icons_size',
			[
				'label' => __( 'Icons Size', 'blogpost-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 24,
				],
				'selectors' => [
					'{{WRAPPER}} .cb-social-links ul li a' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'social_icon_color',
			[
				'label' => __( 'Icon Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .cb-social-links ul li a' => 'color: {{VALUE}}',
				],
				'default' => '#222222'
			]
		);
		$this->add_control(
			'social_icon_hover_color',
			[
				'label' => __( 'Icon Hover Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .cb-social-links ul li a:hover' => 'color: {{VALUE}}',
				],
				'default' => '#f6ce2b'
			]
		);
		$this->add_control(
			'social_icon_scale',
			array(
				'label'   => __( 'Scale Effect on Hover', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'blogpost-widgets' ),
				'label_off' => __( 'No', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->end_controls_section();

		/**
         * Recent Articles
         */
		$this->start_controls_section(
            'blogpost_section_box_articles',
            [
                'label' => __('Recent Articles', 'blogpost-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_articles' => 'yes'
				]
            ]
        );
		$this->add_control(
			'articles_section_heading',
			array(
				'label'   => __( 'Section Heading', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->add_control(
			'articles_heading_text',
			[
				'label' => __( 'Heading Text', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Recent Articles', 'blogpost-widgets' ),
				'placeholder' => __( 'Type your text here', 'blogpost-widgets' ),
				'condition' => [
					'articles_section_heading' => 'yes'
				]
			]
		);
		$this->add_control(
			'popover_toggle',
			[
				'label' => __( 'Posts Colors', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'blogpost-widgets' ),
				'label_on' => __( 'Custom', 'blogpost-widgets' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();
		$this->add_control(
			'posts_normal_color',
			[
				'label' => __( 'Text Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .cb-author-posts a' => 'color: {{VALUE}}',
				],
				'default' => '#666666'
			]
		);
		$this->add_control(
			'posts_normal_bg_color',
			[
				'label' => __( 'Background Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .cb-author-posts a' => 'background-color: {{VALUE}}',
				],
				'default' => '#f0f0f0'
			]
		);
		$this->add_control(
			'posts_hover_color',
			[
				'label' => __( 'Hover Text Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .cb-author-posts a:hover' => 'color: {{VALUE}}',
				],
				'default' => '#f6ce2b'
			]
		);
		$this->add_control(
			'posts_hover_bg_color',
			[
				'label' => __( 'Hover Background Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .cb-author-posts a:hover' => 'background-color: {{VALUE}}',
				],
				'default' => '#222222'
			]
		);
		$this->end_popover();

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
		
		$layout = $settings['layout'];
		if($layout == 1){
			$avatar = wp_get_attachment_image( $settings['avatar']['id'], 'thumbnail' );
		} else {
			$avatar = wp_get_attachment_image( $settings['avatar']['id'], 'cb-author-avatar-md' );
		}

		?>
            <div class="blogpost-author-box-container layout-<?php echo esc_attr ($layout) ?>">
				
				<?php
					if($layout == 1) {
						include 'includes/author_box/layout-1.php';
					}
					elseif($layout == 2) {
						include 'includes/author_box/layout-2.php';
					}
				?>
                
            </div>
		<?php
	}


}
