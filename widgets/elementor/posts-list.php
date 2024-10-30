<?php
/**
 * Posts List.
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
class blogpost_Posts_List extends Widget_Base {

	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		wp_register_style( 'blogpost-posts-list', plugins_url( '/assets/css/posts-list.css', BLOGPOST_WIDGETS ), array(), '1.0.0' );

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
		return 'blogpost_posts_list';
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
		return __( 'Posts List', 'blogpost-widgets' );
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
		return 'blogpost-icon-posts-list';
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
		return array( 'blogpost-posts-list' );
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
				'label'   => __( 'List Layout', 'blogpost-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => __( '1', 'blogpost-widgets' ),
				'options' => ['1' => 'Layout 1', '2' => 'Layout 2'],
			)
		);
		$this->add_control(
			'show_widget_head',
			array(
				'label'   => __( 'Widget Heading', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
        $this->add_control(
			'widget_head_text',
			array(
				'label'   => __( 'Widget Heading Text', 'blogpost-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Posts List', 'blogpost-widgets' ),
				'condition' => [ 'show_widget_head' => 'yes' ]
			)
		);
		$this->add_control(
			'show_thumb',
			array(
				'label'   => __( 'Post Thumbnail', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->add_control(
			'thumbnail_width',
			[
				'label' => __( 'Thumbmnail Width', 'blogpost-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 500,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 150,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-posts-list.layout-1 .item-thumb' => 'min-width: {{SIZE}}{{UNIT}};',
				],
                'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'show_thumb',
							'operator' => '==',
							'value' => 'yes'
						],
						[
							'name' => 'layout',
							'operator' => '==',
							'value' => '1'
						]
					]
				]
			]
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
			'show_meta',
			array(
				'label'   => __( 'Post Meta', 'blogpost-widgets' ),
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
				'default' => 'yes',
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
                'default' => '5',
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
            'blogpost_post_list_widget_head',
            [
                'label' => __('Widget Head', 'blogpost-widgets'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'blogpost_post_list_widget_head_bg',
            [
                'label' => __('Widget Head Background', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f6ce2b',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-widget-head' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .blogpost-widget-head h3' => 'background-color: {{VALUE}};',
                ],

            ]
        );
        $this->add_control(
            'blogpost_post_list_widget_head_text',
            [
                'label' => __('Widget Head Text Color', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-widget-head h3' => 'color: {{VALUE}};',
                ],

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
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-posts-list .item-meta .post-title a' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .blogpost-posts-list .item-meta .post-title a:hover' => 'color: {{VALUE}};',
                ],

            ]
        );
		$this->add_control(
            'blogpost_post_meta_color',
            [
                'label' => __('Post Meta Color', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#8F8F8F',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-posts-list .list-item .list-meta-info' => 'color: {{VALUE}};',
					'{{WRAPPER}} .blogpost-posts-list .list-item .list-meta-info a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .blogpost-posts-list .list-item .list-meta-info i' => 'color: {{VALUE}};',
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
                'selectors' => [
					'{{WRAPPER}} .blogpost-posts-list .item-meta' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .blogpost-posts-list .item-meta .post-title' => 'text-align: {{VALUE}};',
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
					'{{WRAPPER}} .blogpost-posts-list .item-meta .post-title',
            ]
        );
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'blogpost_post_list_title_typography_2',
                'label' => __('Post Excerpt', 'blogpost-widgets'),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .blogpost-posts-list .item-meta .post-desc',
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'blogpost_post_list_title_text_shadow',
				'label' => __( 'Text Shadow', 'blogpost-widgets' ),
				'selector' => '{{WRAPPER}} .featured-grid-item .featured-meta-inner h3 a',
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
					'{{WRAPPER}} .blogpost-posts-list .list-item .grid-post-term span.term-icon' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .blogpost-posts-list .list-item .grid-post-term span.term-icon' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .blogpost-posts-list .list-item .grid-post-term span.term-name' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .blogpost-posts-list .list-item .grid-post-term span.term-name' => 'color: {{VALUE}}',
				],
				'default' => '#000000',
			]
		);
		
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
            <div class="blogpost-posts-list-container">
				<?php
                if ( 'yes' === $settings['show_widget_head'] ) { ?>
					<div class="blogpost-widget-head">
						<h3><?php echo esc_textarea($settings['widget_head_text']) ?></h3>
					</div>
				<?php } ?>
                <div class="blogpost-posts-list layout-<?php echo esc_attr($layout) ?>">
                    <?php
                    $list_posts = new \WP_Query($args);
                    if($list_posts->have_posts()) {
                        while($list_posts->have_posts()):
                            $list_posts->the_post();
                    ?>
                    <div class="list-item">
						<?php
                		if ( 'yes' === $settings['show_thumb'] ) { ?>
                        <div class="item-thumb">
                            <?php
                            if(has_post_thumbnail()):
                                the_post_thumbnail('blogpost-classic-thumb');
                            else:
                                echo '<img src="'.BLOGPOST_ASSETS_PATH.'img/thumb-classic.png">';
                            endif;
                            ?>
                            <?php
                                if ( 'yes' === $settings['show_term'] ) {
                                    Helper::blogpost_post_term_box();
                                }
                            ?>
						</div>
						<?php } ?>
                        <div class="item-meta">
                            <h4 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                            <p class="post-desc">
                                <?php
                                if ( 'yes' === $settings['show_excerpt'] ) {
                                    echo Helper::blogpost_list_excerpt(15);
                                }
                                
                                ?>
                            </p>
                            <?php
                            if ( 'yes' === $settings['show_meta'] ) { ?>
                                <span class="list-meta-info d-block">
                                    <?php Helper::blogpost_posted_on() ?> <?php Helper::blogpost_entry_comments() ?>
                                </span>
                            <?php } ?>
                        </div>
                    </div>
                    <?php endwhile; }
                        \wp_reset_postdata();
                    ?>
                </div>
                
            </div>
		<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */

}
