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
class blogpost_News_Ticker extends Widget_Base {

	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
        parent::__construct( $data, $args );
        wp_register_style( 'blogpost-news-ticker-style', plugins_url( '/assets/css/news-ticker.css', BLOGPOST_WIDGETS ), array(), '1.3.0' );
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
		return 'blogpost_news_tikcer';
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
		return __( 'News Ticker', 'blogpost-widgets' );
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
		return 'blogpost-icon-ticker';
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
		return array( 'blogpost-news-ticker-style', 'blogpost-posts-carousel-owl-style' );
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
			'show_label',
			array(
				'label'   => __( 'Ticker Label', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			)
        );
        $this->add_control(
			'ticker_label_text',
			array(
				'label'   => __( 'Label Text', 'blogpost-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Breaking', 'blogpost-widgets' ),
				'condition' => [ 'show_label' => 'yes' ]
			)
		);
        $this->add_control(
			'show_news_meta',
			array(
				'label'   => __( 'News Meta', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
                'default' => 'yes',
			)
		);
        $this->add_control(
			'show_term',
			array(
				'label'   => __( 'Category', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_news_meta' => 'yes'
                ]
			)
		);
        $this->add_control(
			'show_time',
			array(
				'label'   => __( 'Time', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'blogpost-widgets' ),
				'label_off' => __( 'Hide', 'blogpost-widgets' ),
				'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_news_meta' => 'yes'
                ]
			)
		);
		$this->add_control(
			'ticker_container_radius',
			[
				'label' => __( 'Border Radius', 'blogpost-widgets' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-news-ticker' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
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
                'label' => __('Posts Limit', 'blogpost-widgets'),
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
			'section_ticker',
			array(
				'label' => __( 'Ticker', 'blogpost-widgets' ),
			)
        );
        $this->add_control(
			'ticker_animation',
			array(
				'label'   => __( 'Ticker Animation', 'blogpost-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => __( '2', 'blogpost-widgets' ),
				'options' => ['1' => 'Slide', '2' => 'Fade', '3' => 'Light Speed', '4' => 'Flip', '5' => 'Zoom', '6' => 'Bounce'],
			)
        );
        $this->add_control(
			'ticker_autoplay',
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
            'ticker_autoplay_timeout',
            [
                'label' => __('Autoplay Timeout (milliseconds)', 'blogpost-widgets'),
                'type' => Controls_Manager::NUMBER,
                'default' => '3000',
                'condition' => [
                    'ticker_autoplay' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'ticker_autoplay_speed',
            [
                'label' => __('Autoplay Speed (milliseconds)', 'blogpost-widgets'),
                'type' => Controls_Manager::NUMBER,
                'default' => '500',
                'condition' => [
                    'ticker_autoplay' => 'yes',
                ],
            ]
        );
        $this->add_control(
			'ticker_loop',
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
			'ticker_arrownav',
			array(
				'label'   => __( 'Arrow Navigation', 'blogpost-widgets' ),
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
            'blogpost_news_ticker_title_style',
            [
                'label' => __('Ticker Content', 'blogpost-widgets'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'blogpost_news_ticker_title_typography',
                'label' => __('News Title', 'blogpost-widgets'),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' =>
					'{{WRAPPER}} .blogpost-ticker .item .news-title h3',
            ]
        );
        $this->add_control(
            'blogpost_news_ticker_title_color',
            [
                'label' => __('News Title Color', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-ticker .item .news-title h3 a' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'blogpost_news_ticker_title_hover_color',
            [
                'label' => __('News Title Hover Color', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f6ce2b',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-ticker .item .news-title h3 a:hover' => 'color: {{VALUE}};',
                ],

            ]
        );
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'blogpost_news_ticker_meta_typography',
                'label' => __('News Meta', 'blogpost-widgets'),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .blogpost-ticker .item .news-meta > span',
            ]
        );
        $this->add_control(
            'blogpost_news_ticker_meta_color',
            [
                'label' => __('News Meta Color', 'blogpost-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .blogpost-ticker .item .news-meta > span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .blogpost-ticker .item .news-meta > span a' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->end_controls_section();
        
		/**
         * Ticker Colors
         */
        $this->start_controls_section(
            'blogpost_section_ticker_colors',
            [
                'label' => __('Ticker Colors', 'blogpost-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
		);
		$this->add_control(
			'blogpost_ticker_label_bg',
			[
				'label' => __( 'Label Background', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .blogpost-news-ticker .ticekr-label' => 'background-color: {{VALUE}}',
				],
				'default' => '#f6ce2b',
			]
		);
		$this->add_control(
			'blogpost_ticker_label_txt_color',
			[
				'label' => __( 'Label Text', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .blogpost-news-ticker .ticekr-label' => 'color: {{VALUE}}',
				],
				'default' => '#222222',
			]
		);
		$this->add_control(
			'blogpost_ticker_body_bg',
			[
				'label' => __( 'Ticker Body Background', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .blogpost-news-ticker .blogpost-ticker' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .blogpost-ticker .owl-nav' => 'background-color: {{VALUE}}',
				],
				'default' => '#f0f0f0',
			]
		);
        $this->end_controls_section();

        /**
         * Navigation
         */
        $this->start_controls_section(
            'blogpost_section_ticker_nav',
            [
                'label' => __('Navigation', 'blogpost-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'blogpost_ticker_nav_style_heading',
            [
                'label' => __('Arrow Buttons', 'blogpost-widgets'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs(
			'ticker_nav_style_tabs'
		);

		$this->start_controls_tab(
			'ticker_nav_normal_tab',
			[
				'label' => __( 'Normal', 'blogpost-widgets' ),
			]
		);

		$this->add_control(
			'ticker_nav_icon_color',
			[
				'label' => __( 'Icon Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-ticker .owl-prev' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .blogpost-ticker .owl-next' => 'color: {{VALUE}} !important',
				],
				'default' => '#FFFFFF',
			]
		);
        $this->add_control(
			'ticker_nav_icon_bg_color',
			[
				'label' => __( 'Background Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-ticker .owl-prev' => 'background: {{VALUE}} !important',
                    '{{WRAPPER}} .blogpost-ticker .owl-next' => 'background: {{VALUE}} !important',
				],
				'default' => '#000000',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'ticker_nav_hover_tab',
			[
				'label' => __( 'Hover', 'blogpost-widgets' ),
			]
		);
        $this->add_control(
			'ticker_nav_icon_color_hover',
			[
				'label' => __( 'Icon Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-ticker .owl-prev:hover' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .blogpost-ticker .owl-next:hover' => 'color: {{VALUE}} !important',
				],
				'default' => '#000000',
			]
		);
        $this->add_control(
			'ticker_nav_icon_bg_color_hover',
			[
				'label' => __( 'Background Color', 'blogpost-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-ticker .owl-prev:hover' => 'background: {{VALUE}} !important',
                    '{{WRAPPER}} .blogpost-ticker .owl-next:hover' => 'background: {{VALUE}} !important',
				],
				'default' => '#f6ce2b',
			]
		);

		$this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
			'ticker_nav_buttons_radius',
			[
				'label' => __( 'Border Radius', 'blogpost-widgets' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
                    '{{WRAPPER}} .blogpost-ticker .owl-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .blogpost-ticker .owl-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		$args = Helper::blogpost_get_query_args($settings);
        $animateIn = "";
        $animateOut = "";
        if($settings['ticker_animation'] == '2') {
            $animateIn = "animate__fadeInUp";
            $animateOut = "animate__fadeOutDown";
        } elseif($settings['ticker_animation'] == '3') {
            $animateIn = "animate__lightSpeedInRight";
            $animateOut = "animate__lightSpeedOutLeft";
        } elseif($settings['ticker_animation'] == '4') {
            $animateIn = "animate__flipInX";
            $animateOut = "";
        } elseif($settings['ticker_animation'] == '5') {
            $animateIn = "animate__zoomIn";
            $animateOut = "animate__zoomOut";
        } elseif($settings['ticker_animation'] == '6') {
            $animateIn = "animate__bounceInLeft";
            $animateOut = "";
        }
		?>
            <div class="blogpost-news-ticker-container">
                <div class="blogpost-news-ticker<?php echo esc_attr(($settings['show_label'] != "yes" ? ' no-label' : '') )?>">
                    <?php if ( 'yes' === $settings['show_label'] ) {?>
                        <div class="ticekr-label"><?php echo  esc_textarea ( $settings['ticker_label_text'] ) ?></div>
                    <?php } ?>
                    <div class="blogpost-ticker owl-carousel">
                        <?php
                        $list_posts = new \WP_Query($args);
                        if($list_posts->have_posts()) {
                            while($list_posts->have_posts()):
                                $list_posts->the_post();
                        ?>
                            <div class="item">
                                <?php if ( 'yes' === $settings['show_news_meta'] ) {?>
                                <div class="news-meta">
                                    <?php if ( 'yes' === $settings['show_term'] ) {?>
                                        <span class="post-term"><?php Helper::blogpost_post_term_box(); ?></span>
                                    <?php } ?>
                                    <?php if ( 'yes' === $settings['show_time'] ) {?>
                                        <span class="ticker-date"><i class="fa fa-clock-o"></i> <?php echo get_the_modified_time() ?></span>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                                <div class="news-title<?php echo (esc_attr($settings['show_term'] != "yes" && $settings['show_date'] != "yes" || $settings['show_news_meta'] != "yes" ? ' no-meta' : '')) ?>">
                                    <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
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
					$(".blogpost-ticker").owlCarousel({
                        items: 1,
                        loop: <?php echo (esc_attr($settings['ticker_loop'] == 'yes' ? 'true' : 'false')) ?>,
                        nav: <?php echo (esc_attr($settings['ticker_arrownav'] == 'yes' ? 'true' : 'false')) ?>,
                        dots: false,
                        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                        autoplay: <?php echo (esc_attr($settings['ticker_autoplay'] == 'yes' ? 'true' : 'false')) ?>,
                        autoplayTimeout: <?php echo( esc_attr($settings['ticker_autoplay_timeout']) ) ?>,
                        autoplaySpeed: <?php echo( esc_attr($settings['ticker_autoplay_speed']) ) ?>,
                        navSpeed: <?php echo( esc_attr($settings['ticker_autoplay_speed']) ) ?>,
                        autoplayHoverPause: true,
                        animateIn: "<?php echo esc_attr($animateIn) ?>",
                        animateOut: "<?php echo esc_attr($animateOut) ?>",
                    });
				});
			</script>
        <?php
	}

}
