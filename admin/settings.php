<?php
/**
 * custom option and settings
 */
function blogpost_settings_init() {
    
    // Register new settings for "Page Builders" section.
    register_setting( 'blogpost', 'blogpost_builders_elementor', ['default' => 'on']);
  //  register_setting( 'blogpost', 'blogpost_builders_wordpress', ['default' => 'off']);

    // Register new settings for "Widgets" Section.
    register_setting( 'cb-widgets', 'blogpost_widgets_posts_grid', ['default' => 'on']);
    register_setting( 'cb-widgets', 'blogpost_widgets_posts_list', ['default' => 'on']);
    register_setting( 'cb-widgets', 'blogpost_widgets_posts_carousel', ['default' => 'on']);
    register_setting( 'cb-widgets', 'blogpost_widgets_category_tiles', ['default' => 'on']);
    register_setting( 'cb-widgets', 'blogpost_widgets_posts_classic', ['default' => 'on']);
    register_setting( 'cb-widgets', 'blogpost_widgets_posts_slider', ['default' => 'on']);
    register_setting( 'cb-widgets', 'blogpost_widgets_author_box', ['default' => 'on']);
    register_setting( 'cb-widgets', 'blogpost_widgets_news_ticker', ['default' => 'on']);

   
    

    // Page Builders Section
    add_settings_section(
        'blogpost_section_builders',
        __( 'Page Builders.', 'blogpost-widgets' ),
        'blogpost_section_builders_callback',
        'blogpost'
    );

      // WordPress
    //   add_settings_field(
    //     'blogpost_builders_wordpress',
    //     'WordPress',
    //     'blogpost_builders_wordpress_field_cb',
    //     'blogpost',
    //     'blogpost_section_builders'
    // );


    // Widgets Section
    add_settings_section(
        'blogpost_section_widgets',
        __( 'Widgets.', 'blogpost-widgets' ),
        'blogpost_section_widgets_callback',
        'cb-widgets'
    );

    // Support Section
    add_settings_section(
        'blogpost_section_widgets',
        __( 'Widgets.', 'blogpost-widgets' ),
        'blogpost_section_widgets_callback',
        'cb-widgets'
    );

    // Tools Section
    add_settings_section(
        'blogpost_section_tools',
        __( 'Tools.', 'blogpost-widgets' ),
        'blogpost_section_tools_callback',
        'cb-tools'
    );
    /*
    * Register Setting Fields for Page Builders section
    */

    // Elementor
    add_settings_field(
        'blogpost_builders_elementor',
        'Elementor',
        'blogpost_builders_elementor_field_cb',
        'blogpost',
        'blogpost_section_builders'
    );


    /*
    * Register Setting Fields for Widgets Builders section
    */

    // Posts Grid
    add_settings_field(
        'blogpost_widgets_posts_grid',
        'Posts Grid',
        'blogpost_widgets_posts_grid_field_cb',
        'cb-widgets',
        'blogpost_section_widgets'
    );
    // Posts List
    add_settings_field(
        'blogpost_widgets_posts_list',
        'Posts List',
        'blogpost_widgets_posts_list_field_cb',
        'cb-widgets',
        'blogpost_section_widgets'
    );
    // Posts Carousel
    add_settings_field(
        'blogpost_widgets_posts_carousel',
        'Carousel',
        'blogpost_widgets_posts_carousel_field_cb',
        'cb-widgets',
        'blogpost_section_widgets'
    );
    // Posts Classic
    add_settings_field(
        'blogpost_widgets_posts_classic',
        'Classic Block',
        'blogpost_widgets_posts_classic_field_cb',
        'cb-widgets',
        'blogpost_section_widgets'
    );
    // Category Tiles
    add_settings_field(
        'blogpost_widgets_category_tiles',
        'Categories',
        'blogpost_widgets_category_tiles_field_cb',
        'cb-widgets',
        'blogpost_section_widgets'
    );
    // Posts Slider
    add_settings_field(
        'blogpost_widgets_posts_slider',
        'Slider',
        'blogpost_widgets_posts_slider_field_cb',
        'cb-widgets',
        'blogpost_section_widgets'
    );
    // Author Box
    add_settings_field(
        'blogpost_widgets_author_box',
        'Author Box',
        'blogpost_widgets_author_box_field_cb',
        'cb-widgets',
        'blogpost_section_widgets'
    );
    // News Ticker
    add_settings_field(
        'blogpost_widgets_news_ticker',
        'News Ticker',
        'blogpost_widgets_news_ticker_field_cb',
        'cb-widgets',
        'blogpost_section_widgets'
    );
   
}

/**
 * Register our blogpost_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'blogpost_settings_init' );

/**
 * Section Callback Functions.
 */
function blogpost_section_builders_callback( $args ) {
    return;
}
function blogpost_section_widgets_callback( $args ) {
    return;
}
function blogpost_section_support_callback( $args ) {
    return;
}
function blogpost_section_tools_callback( $args ) {
    return;
}