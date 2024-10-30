<?php
/**
 * Posts Tabs.
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
class blogpost_Category_Tiles extends Widget_Base {

	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		wp_register_style( 'blogpost-category-tiles', plugins_url( '/assets/css/category-tiles.css', BLOGPOST_WIDGETS ), array(), '1.0.0' );

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
		// category-tiles
		return 'blogpost-category-tiles';
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
		return __( 'Category Tiles', 'blogpost-widgets' );
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
		return 'blogpost-icon-categories';
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
		return array( 'blogpost-category-tiles' );
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
		$post_types = Helper::blogpost_get_post_types();
		$categories = Helper::blogpost_get_categories();
		//var_dump($categories);
		$init_tax = 1;
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
				'options' => ['1' => 'Layout 1', '2' => 'Layout 2', '3' => 'Layout 3'],
			)
        );
		$this->add_control(
			'show_icon',
			[
				'label' => __( 'Show Icon', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'layout' => '1'
				]
			]
		);
		$this->add_control(
			'full_box_link',
			[
				'label' => __( 'Full Box Link', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'blogpost-widgets' ),
				'label_off' => __( 'No', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'layout' => '1'
				]
			]
		);
		$this->add_control(
			'show_post_count',
			[
				'label' => __( 'Post Count', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->end_controls_section();

		
		/**
		 * Tiles Builder
		 * 
		 */
		$this->start_controls_section(
			'section_post_tabs',
			array(
				'label' => __( 'Tiles Builder', 'blogpost-widgets' ),
			)
		);
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'category_title', [
				'label' => __( 'Category Name', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Category Name' , 'blogpost-widgets' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'category_id', [
				'label' => __( 'Link Category', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => wp_list_pluck($categories, 'name', 'term_id'),
				'default' => __( '0' , 'blogpost-widgets' ),
				'show_label' => false,
			]
		);
		$repeater->add_control(
			'selected_icon',
			[
				'label' => __( 'Icon', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);
		$repeater->add_control(
            'blogpost_cat_tile_bg_color',
            [
                'label' => __('Background Color', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f6ce2b',
            ]
        );
		$repeater->add_control(
			'tile_bg_image',
			[
				'label' => __( 'Background Image', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'categories_list',
			[
				'label' => __( 'Repeater List', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'category_title' => __( 'Default Category', 'blogpost-widgets' ),
						'category_id' => __( 'Link Category', 'blogpost-widgets' ),
						'selected_icon' => [
							'value' => 'fas fa-box',
							'library' => 'fa-solid',
						],
					],
					[
						'category_title' => __( 'Category #1', 'blogpost-widgets' ),
						'category_id' => __( 'Link Category.', 'blogpost-widgets' ),
						'selected_icon' => [
							'value' => 'fas fa-dove',
							'library' => 'fa-solid',
						],
					],
					[
						'category_title' => __( 'Category #2', 'blogpost-widgets' ),
						'category_id' => __( 'Link Category.', 'blogpost-widgets' ),
						'selected_icon' => [
							'value' => 'fas fa-cogs',
							'library' => 'fa-solid',
						],
					],
				],
				'title_field' => '{{{ category_title }}}',
			]
		);
		$this->end_controls_section();

		/**
         * Typography 
         */
        $this->start_controls_section(
            'blogpost_section_typography',
            [
                'label' => __('Colors & Fonts', 'blogpost-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'blogpost_tile_content_style',
            [
                'label' => __('Tile Content', 'blogpost-widgets'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'blogpost_tile__title_color',
            [
                'label' => __('Category Name', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-category-tile-link' => 'color: {{VALUE}};',
                ],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'layout',
							'operator' => '==',
							'value' => '1'
						],
						[
							'name' => 'layout',
							'operator' => '==',
							'value' => '2'
						]
					]
				]
            ]
			
        );
		$this->add_control(
            'blogpost_tile_title_3_color',
            [
                'label' => __('Category Name', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-category-tile-link' => 'color: {{VALUE}};',
                ],
				'condition' => [
					'layout' => '3'
				]
            ]
			
        );
        $this->add_control(
            'blogpost_tile_title_hover_color',
            [
                'label' => __('Category Name Hover', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-category-tile-link:hover' => 'color: {{VALUE}};',
                ],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'layout',
							'operator' => '==',
							'value' => '1'
						],
						[
							'name' => 'layout',
							'operator' => '==',
							'value' => '2'
						]
					]
				]
            ]
        );
		$this->add_control(
            'blogpost_tile_title_3_hover_color',
            [
                'label' => __('Category Name Hover', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f6ce2b',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-category-tile-link:hover' => 'color: {{VALUE}};',
                ],
				'condition' => [
					'layout' => '3'
				]
            ]
        );
		$this->add_control(
            'blogpost_tile_icon_color',
            [
                'label' => __('Category Icon', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f6ce2b',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-tile-icon' => 'color: {{VALUE}};',
                ],
				'condition' => [
					'layout' => '1'
				]

            ]
        );
		$this->add_control(
            'blogpost_box_icon_color',
            [
                'label' => __('Category Icon', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-box-icon' => 'color: {{VALUE}};',
                ],
				'condition' => [
					'layout' => '2'
				]

            ]
        );
		$this->add_control(
            'blogpost_box_icon_bg_color',
            [
                'label' => __('Category Icon Background', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-box-icon' => 'background-color: {{VALUE}};',
                ],
				'condition' => [
					'layout' => '2'
				]

            ]
        );
		$this->add_control(
            'blogpost_box_icon_border_color',
            [
                'label' => __('Category Icon Border', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.7',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-box-icon' => 'border-color: {{VALUE}};',
                ],
				'condition' => [
					'layout' => '2'
				]

            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'blogpost_tile_title_typography',
                'label' => __('Category Name', 'blogpost-widgets'),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' =>
					'{{WRAPPER}} .blogpost-category-tile-link',
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'blogpost_post_list_title_text_shadow',
				'label' => __( 'Text Shadow', 'blogpost-widgets' ),
				'selector' => '{{WRAPPER}} .blogpost-category-tile-link',
			]
		);
		$this->add_control(
            'blogpost_tile_layout_style',
            [
                'label' => __('Layout & Sizes', 'blogpost-widgets'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
		$this->add_responsive_control(
            'blogpost_tile_title_alignment',
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
                'selectors' => [
					'{{WRAPPER}} .tile-content' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .blogpost-post-count' => 'text-align: {{VALUE}};',
                ],
				'condition' => [
					'layout' => '1'
				]
            ]
        );
		$this->add_control(
			'blogpost_tile_icon_size',
			[
				'label' => __( 'Icon Size', 'blogpost-widgets' ),
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
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .blogpost-tile-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout' => '1'
				]
			]
		);
		$this->add_control(
			'blogpost_tile_icon_size_2',
			[
				'label' => __( 'Icon Size', 'blogpost-widgets' ),
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
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .blogpost-box-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout' => '2'
				]
			]
		);
		$this->add_control(
			'blogpost_tile_height',
			[
				'label' => __( 'Tile Height', 'blogpost-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 600,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 400,
				],
				'selectors' => [
					'{{WRAPPER}} .blogpost-category-tiles.layout-1' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout' => '1'
				]
			]
		);
		$this->add_control(
			'blogpost_icon_container_size',
			[
				'label' => __( 'Icon Container Size', 'blogpost-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 300,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .blogpost-box-icon' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout' => '2'
				]
			]
		);
		$this->add_control(
            'blogpost_tile_3_icon_color',
            [
                'label' => __('Category Icon', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-catlist-icon' => 'color: {{VALUE}};',
                ],
				'condition' => [
					'layout' => '3'
				]

            ]
        );
		$this->add_control(
			'blogpost_catlist_border_size',
			[
				'label' => __( 'Border Width', 'blogpost-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .blogpost-category-list' => 'border-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'layout' => '3'
				]
			]
		);
		$this->add_control(
            'blogpost_catlist_border_color',
            [
                'label' => __('Category Icon', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f0f0f0',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-category-list' => 'border-color: {{VALUE}};',
                ],
				'condition' => [
					'layout' => '3'
				]

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
		?>
            <div class="blogpost-category-tiles-container layout-<?php echo esc_attr($layout) ?>">
				<div class="blogpost-category-tiles layout-<?php echo esc_attr($layout) ?>">
				<?php
					if ( $settings['categories_list'] ) {
						foreach (  $settings['categories_list'] as $item ) {
							$category_url = get_category_link($item['category_id']);
							$category = get_category($item['category_id']);
							if($category == NULL) {
								$post_count = 0;
							} else {
								$post_count = $category->category_count;
								
							}

							if($layout == 1) {
								include BLOGPOST_PLUGIN_PATH .'templates/Category_Tiles/layout-1.php';
							} 
							if($layout == 2) {
								include BLOGPOST_PLUGIN_PATH .'templates/Category_Tiles/layout-2.php';
							}
							if($layout == 3) {
								include BLOGPOST_PLUGIN_PATH .'templates/Category_Tiles/layout-3.php';
							} 
						}
					}
				?>
				</div>
                
            </div>
		<?php
	}


}
